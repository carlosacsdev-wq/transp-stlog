<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $conversations = Conversation::query()
            ->where('tenant_id', $user->tenant_id)
            ->where('user_id', $user->id)
            ->orderByDesc('updated_at')
            ->get();

        return response()->json($conversations);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $conversation = Conversation::query()
            ->where('tenant_id', $user->tenant_id)
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        if (! $conversation) {
            $conversation = Conversation::create([
                'tenant_id' => $user->tenant_id,
                'user_id' => $user->id,
                'title' => 'Chat principal',
                'status' => 'active',
            ]);
        }

        return response()->json($conversation, 201);
    }

    public function show(Conversation $conversation)
    {
        $this->ensureConversationBelongsToCurrentUser($conversation);

        return response()->json($conversation->load('messages'));
    }

    public function messages(Conversation $conversation)
    {
        $this->ensureConversationBelongsToCurrentUser($conversation);

        return response()->json(
            $conversation->messages()->get()->map(fn ($message) => [
                'id' => $message->id,
                'conversation_id' => $message->conversation_id,
                'role' => $message->role,
                'content' => $message->content,
                'metadata' => $message->metadata,
                'created_at' => $message->created_at,
                'updated_at' => $message->updated_at,
            ])
        );
    }

    public function sendMessage(Request $request, Conversation $conversation)
    {
        $this->ensureConversationBelongsToCurrentUser($conversation);

        $validated = $request->validate([
            'message' => ['required', 'string', 'max:20000'],
        ]);

        $userMessage = $conversation->messages()->create([
            'role' => 'user',
            'content' => trim($validated['message']),
            'metadata' => [
                'source' => 'web',
            ],
        ]);

        $assistantReply = $this->forwardToN8n($conversation, $userMessage);

        $conversation->touch();

        return response()->json([
            'conversation_id' => $conversation->id,
            'message' => [
                'id' => $userMessage->id,
                'content' => $userMessage->content,
                'role' => $userMessage->role,
            ],
            'reply' => [
                'id' => $assistantReply['id'],
                'content' => $assistantReply['content'],
                'role' => $assistantReply['role'],
            ],
            'output' => $assistantReply['content'],
        ]);
    }

    protected function ensureConversationBelongsToCurrentUser(Conversation $conversation): void
    {
        $user = auth()->user();

        if (! $user) {
            abort(401, 'Não autenticado.');
        }

        if ($conversation->tenant_id !== $user->tenant_id || $conversation->user_id !== $user->id) {
            abort(403, 'Esta conversa não pertence a este usuário.');
        }
    }

    protected function forwardToN8n(Conversation $conversation, ChatMessage $userMessage): array
    {
        $webhookUrl = config('services.n8n.webhook_url');

        if (empty($webhookUrl)) {
            return [
                'id' => null,
                'role' => 'assistant',
                'content' => 'O assistente não está configurado no backend. Defina N8N_WEBHOOK_URL.',
            ];
        }

        try {
            $response = Http::timeout(30)->post($webhookUrl, [
                'conversation_id' => $conversation->id,
                'chatId' => $conversation->id,
                'tenant_id' => $conversation->tenant_id,
                'user_id' => $conversation->user_id,
                'route' => 'general',
                'message' => $userMessage->content,
            ]);

            $payload = $response->json();
            $answer = $payload['output'] ?? $payload['response'] ?? $payload['message'] ?? $payload['answer'] ?? 'Não foi possível obter resposta do assistente.';

            $assistantMessage = $conversation->messages()->create([
                'role' => 'assistant',
                'content' => (string) $answer,
                'metadata' => [
                    'provider' => 'n8n',
                    'payload' => $payload,
                ],
            ]);

            return [
                'id' => $assistantMessage->id,
                'role' => $assistantMessage->role,
                'content' => $assistantMessage->content,
            ];
        } catch (\Throwable $e) {
            Log::error('Erro ao comunicar com n8n no chat', [
                'conversation_id' => $conversation->id,
                'message' => $userMessage->content,
                'exception' => $e->getMessage(),
            ]);

            $assistantMessage = $conversation->messages()->create([
                'role' => 'assistant',
                'content' => 'Não foi possível processar sua mensagem no momento. Tente novamente em alguns instantes.',
                'metadata' => [
                    'provider' => 'n8n',
                    'error' => $e->getMessage(),
                ],
            ]);

            return [
                'id' => $assistantMessage->id,
                'role' => $assistantMessage->role,
                'content' => $assistantMessage->content,
            ];
        }
    }
}
