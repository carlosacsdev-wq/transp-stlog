<?php

namespace Tests\Feature;

use App\Models\Conversation;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ChatConversationIsolationTest extends TestCase
{
    use RefreshDatabase;

    protected function makeTenant(string $slug): Tenant
    {
        return Tenant::create([
            'name' => ucfirst($slug),
            'slug' => $slug,
            'domain' => $slug . '.example.test',
            'email' => $slug . '@example.test',
            'phone' => '11999999999',
            'is_active' => true,
            'settings' => [],
        ]);
    }

    protected function makeUser(Tenant $tenant, string $email, string $name = 'User'): User
    {
        return User::factory()->create([
            'tenant_id' => $tenant->id,
            'email' => $email,
            'name' => $name,
        ]);
    }

    protected function makeConversation(User $user, Tenant $tenant, string $title = 'Chat principal'): Conversation
    {
        return Conversation::create([
            'tenant_id' => $tenant->id,
            'user_id' => $user->id,
            'title' => $title,
            'status' => 'active',
        ]);
    }

    protected function configureN8nWebhook(): void
    {
        config(['services.n8n.webhook_url' => 'https://n8n.example.test/webhook/chat']);
    }

    public function test_usuario_autenticado_consegue_criar_e_obter_sua_propria_conversa(): void
    {
        $tenant = $this->makeTenant('tenant-a');
        $user = $this->makeUser($tenant, 'carlos@tenant-a.test', 'Carlos');

        $createResponse = $this->actingAs($user)->postJson('/api/chat/conversations', [
            'title' => 'Chat principal',
        ]);

        $createResponse->assertStatus(201)
            ->assertJsonPath('tenant_id', $tenant->id)
            ->assertJsonPath('user_id', $user->id)
            ->assertJsonPath('status', 'active');

        $conversation = Conversation::query()->where('user_id', $user->id)->firstOrFail();

        $this->actingAs($user)
            ->getJson('/api/chat/conversations/' . $conversation->id)
            ->assertOk()
            ->assertJsonPath('id', $conversation->id)
            ->assertJsonPath('tenant_id', $tenant->id)
            ->assertJsonPath('user_id', $user->id);
    }

    public function test_usuario_autenticado_lista_somente_suas_conversas(): void
    {
        $tenant = $this->makeTenant('tenant-a');
        $user = $this->makeUser($tenant, 'carlos@tenant-a.test', 'Carlos');
        $otherUser = $this->makeUser($tenant, 'joao@tenant-a.test', 'Joao');

        $this->makeConversation($user, $tenant, 'Chat de Carlos');
        $this->makeConversation($user, $tenant, 'Chat de Carlos 2');
        $this->makeConversation($otherUser, $tenant, 'Chat de Joao');

        $this->actingAs($user)
            ->getJson('/api/chat/conversations')
            ->assertOk()
            ->assertJsonCount(2)
            ->assertJsonMissing(['user_id' => $otherUser->id]);
    }

    public function test_usuario_a_nao_consegue_visualizar_conversa_do_usuario_b(): void
    {
        $tenant = $this->makeTenant('tenant-a');
        $userA = $this->makeUser($tenant, 'a@tenant-a.test', 'User A');
        $userB = $this->makeUser($tenant, 'b@tenant-a.test', 'User B');
        $conversationB = $this->makeConversation($userB, $tenant, 'Conversa de B');

        $this->actingAs($userA)
            ->getJson('/api/chat/conversations/' . $conversationB->id)
            ->assertForbidden();
    }

    public function test_usuario_a_nao_consegue_visualizar_mensagens_da_conversa_do_usuario_b(): void
    {
        $tenant = $this->makeTenant('tenant-a');
        $userA = $this->makeUser($tenant, 'a@tenant-a.test', 'User A');
        $userB = $this->makeUser($tenant, 'b@tenant-a.test', 'User B');
        $conversationB = $this->makeConversation($userB, $tenant, 'Conversa de B');
        $conversationB->messages()->create([
            'role' => 'user',
            'content' => 'Mensagem privada de B',
            'metadata' => ['source' => 'manual'],
        ]);

        $this->actingAs($userA)
            ->getJson('/api/chat/conversations/' . $conversationB->id . '/messages')
            ->assertForbidden();
    }

    public function test_usuario_a_nao_consegue_enviar_mensagem_na_conversa_do_usuario_b(): void
    {
        $tenant = $this->makeTenant('tenant-a');
        $userA = $this->makeUser($tenant, 'a@tenant-a.test', 'User A');
        $userB = $this->makeUser($tenant, 'b@tenant-a.test', 'User B');
        $conversationB = $this->makeConversation($userB, $tenant, 'Conversa de B');

        $this->actingAs($userA)
            ->postJson('/api/chat/conversations/' . $conversationB->id . '/messages', [
                'message' => 'Mensagem indevida',
            ])
            ->assertForbidden();

        $this->assertDatabaseMissing('chat_messages', [
            'conversation_id' => $conversationB->id,
            'content' => 'Mensagem indevida',
        ]);
    }

    public function test_nao_existem_rotas_de_update_ou_delete_para_conversas_ajenas(): void
    {
        $routes = collect(Route::getRoutes()->getRoutes())
            ->filter(fn ($route) => str_starts_with($route->uri(), 'api/chat/conversations'))
            ->map(fn ($route) => strtoupper(implode('|', $route->methods())));

        $this->assertFalse($routes->contains(fn ($routeMethods) => str_contains($routeMethods, 'PATCH')));
        $this->assertFalse($routes->contains(fn ($routeMethods) => str_contains($routeMethods, 'PUT')));
        $this->assertFalse($routes->contains(fn ($routeMethods) => str_contains($routeMethods, 'DELETE')));
    }

    public function test_tenant_a_nao_consegue_acessar_conversas_do_tenant_b(): void
    {
        $tenantA = $this->makeTenant('tenant-a');
        $tenantB = $this->makeTenant('tenant-b');
        $userA = $this->makeUser($tenantA, 'a@tenant-a.test', 'User A');
        $userB = $this->makeUser($tenantB, 'b@tenant-b.test', 'User B');
        $conversationB = $this->makeConversation($userB, $tenantB, 'Conversa de Tenant B');

        $this->actingAs($userA)
            ->getJson('/api/chat/conversations/' . $conversationB->id)
            ->assertForbidden();
    }

    public function test_manipulacao_direta_de_conversation_id_e_bloqueada(): void
    {
        $tenant = $this->makeTenant('tenant-a');
        $userA = $this->makeUser($tenant, 'a@tenant-a.test', 'User A');
        $userB = $this->makeUser($tenant, 'b@tenant-a.test', 'User B');
        $conversationA = $this->makeConversation($userA, $tenant, 'Chat A');
        $conversationB = $this->makeConversation($userB, $tenant, 'Chat B');

        $this->actingAs($userA)
            ->postJson('/api/chat/conversations/' . $conversationA->id . '/messages', [
                'conversation_id' => $conversationB->id,
                'message' => 'Mensagem manipulada',
            ])
            ->assertOk();

        $this->assertDatabaseHas('chat_messages', [
            'conversation_id' => $conversationA->id,
            'content' => 'Mensagem manipulada',
            'role' => 'user',
        ]);

        $this->assertDatabaseMissing('chat_messages', [
            'conversation_id' => $conversationB->id,
            'content' => 'Mensagem manipulada',
        ]);
    }

    public function test_mensagem_enviada_pelo_usuario_e_associada_corretamente_a_conversa_autenticada(): void
    {
        $this->configureN8nWebhook();

        $tenant = $this->makeTenant('tenant-a');
        $user = $this->makeUser($tenant, 'carlos@tenant-a.test', 'Carlos');
        $conversation = $this->makeConversation($user, $tenant, 'Chat principal');

        Http::fake([
            'https://n8n.example.test/webhook/chat' => Http::response(['output' => 'Resposta do assistente'], 200),
        ]);

        $response = $this->actingAs($user)
            ->postJson('/api/chat/conversations/' . $conversation->id . '/messages', [
                'message' => 'Olá, assistente!',
            ]);

        $response->assertOk()
            ->assertJsonPath('conversation_id', $conversation->id)
            ->assertJsonPath('message.role', 'user')
            ->assertJsonPath('message.content', 'Olá, assistente!')
            ->assertJsonPath('reply.content', 'Resposta do assistente')
            ->assertJsonPath('output', 'Resposta do assistente');

        Http::assertSent(function (Request $request) use ($conversation) {
            return $request->url() === 'https://n8n.example.test/webhook/chat'
                && $request['conversation_id'] == $conversation->id
                && $request['tenant_id'] == $conversation->tenant_id
                && $request['user_id'] == $conversation->user_id
                && $request['message'] === 'Olá, assistente!';
        });

        $this->assertDatabaseHas('chat_messages', [
            'conversation_id' => $conversation->id,
            'role' => 'user',
            'content' => 'Olá, assistente!',
        ]);

        $this->assertDatabaseHas('chat_messages', [
            'conversation_id' => $conversation->id,
            'role' => 'assistant',
            'content' => 'Resposta do assistente',
        ]);
    }

    public function test_resposta_do_n8n_e_associada_a_mesma_conversa(): void
    {
        $this->configureN8nWebhook();

        $tenant = $this->makeTenant('tenant-a');
        $user = $this->makeUser($tenant, 'carlos@tenant-a.test', 'Carlos');
        $conversation = $this->makeConversation($user, $tenant, 'Chat principal');

        Http::fake([
            'https://n8n.example.test/webhook/chat' => Http::response(['output' => 'Resposta contextualizada'], 200),
        ]);

        $response = $this->actingAs($user)
            ->postJson('/api/chat/conversations/' . $conversation->id . '/messages', [
                'message' => 'Pergunta ao assistente',
            ]);

        $response->assertOk()
            ->assertJsonPath('conversation_id', $conversation->id)
            ->assertJsonPath('reply.content', 'Resposta contextualizada')
            ->assertJsonPath('output', 'Resposta contextualizada');

        Http::assertSent(function (Request $request) use ($conversation) {
            return $request->url() === 'https://n8n.example.test/webhook/chat'
                && $request['conversation_id'] == $conversation->id
                && $request['message'] === 'Pergunta ao assistente';
        });

        $this->assertDatabaseHas('chat_messages', [
            'conversation_id' => $conversation->id,
            'role' => 'assistant',
            'content' => 'Resposta contextualizada',
        ]);

        $this->assertDatabaseHas('chat_messages', [
            'conversation_id' => $conversation->id,
            'role' => 'user',
            'content' => 'Pergunta ao assistente',
        ]);
    }

    public function test_erro_do_n8n_e_tratado_corretamente(): void
    {
        $this->configureN8nWebhook();

        $tenant = $this->makeTenant('tenant-a');
        $user = $this->makeUser($tenant, 'carlos@tenant-a.test', 'Carlos');
        $conversation = $this->makeConversation($user, $tenant, 'Chat principal');

        Http::fake(function (Request $request) {
            throw new \RuntimeException('timeout do n8n');
        });

        $response = $this->actingAs($user)
            ->postJson('/api/chat/conversations/' . $conversation->id . '/messages', [
                'message' => 'Mensagem que falha no n8n',
            ]);

        $response->assertOk()
            ->assertJsonPath('conversation_id', $conversation->id)
            ->assertJsonPath('output', 'Não foi possível processar sua mensagem no momento. Tente novamente em alguns instantes.')
            ->assertJsonPath('reply.content', 'Não foi possível processar sua mensagem no momento. Tente novamente em alguns instantes.');

        $this->assertStringNotContainsString('timeout do n8n', $response->getContent());

        $this->assertDatabaseHas('chat_messages', [
            'conversation_id' => $conversation->id,
            'role' => 'assistant',
            'content' => 'Não foi possível processar sua mensagem no momento. Tente novamente em alguns instantes.',
        ]);

        $this->assertDatabaseHas('chat_messages', [
            'conversation_id' => $conversation->id,
            'role' => 'user',
            'content' => 'Mensagem que falha no n8n',
        ]);
    }

    public function test_validacao_do_campo_message(): void
    {
        $tenant = $this->makeTenant('tenant-a');
        $user = $this->makeUser($tenant, 'carlos@tenant-a.test', 'Carlos');
        $conversation = $this->makeConversation($user, $tenant, 'Chat principal');

        $this->actingAs($user)
            ->postJson('/api/chat/conversations/' . $conversation->id . '/messages', [
                'message' => '',
            ])
            ->assertStatus(422);
    }

    public function test_usuario_nao_autenticado_nao_acessa_endpoints_protegidos(): void
    {
        $this->withHeaders(['Accept' => 'application/json'])
            ->get('/api/chat/conversations')
            ->assertUnauthorized();

        $this->withHeaders(['Accept' => 'application/json'])
            ->post('/api/chat/conversations')
            ->assertUnauthorized();
    }

    public function test_historico_de_mensagens_retorna_apenas_mensagens_da_conversa_autenticada(): void
    {
        $tenant = $this->makeTenant('tenant-a');
        $user = $this->makeUser($tenant, 'carlos@tenant-a.test', 'Carlos');
        $conversation = $this->makeConversation($user, $tenant, 'Chat principal');

        $conversation->messages()->create([
            'role' => 'user',
            'content' => 'Primeira mensagem',
            'metadata' => ['source' => 'manual'],
        ]);

        $conversation->messages()->create([
            'role' => 'assistant',
            'content' => 'Resposta do assistente',
            'metadata' => ['provider' => 'n8n'],
        ]);

        $this->actingAs($user)
            ->getJson('/api/chat/conversations/' . $conversation->id . '/messages')
            ->assertOk()
            ->assertJsonCount(2)
            ->assertJsonFragment(['content' => 'Primeira mensagem'])
            ->assertJsonFragment(['content' => 'Resposta do assistente']);
    }
}
