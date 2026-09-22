@extends('adminlte::master')

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\PreloaderHelper')

@section('adminlte_css')
    @stack('css')
    @yield('css')
    <style>
        #chat-floating-button {
            position: fixed;
            right: 20px;
            bottom: 20px;
            width: 56px;
            height: 56px;
            border: none;
            border-radius: 50%;
            background: #1a5928;
            color: #fff;
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 18px rgba(26, 89, 40, 0.35);
            cursor: pointer;
            z-index: 1050;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        #chat-floating-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 22px rgba(26, 89, 40, 0.4);
            background: #13421e;
        }

        #chat-floating-button:focus {
            outline: 3px solid rgba(26, 89, 40, 0.25);
            outline-offset: 2px;
        }

        #chat-widget-container {
            position: fixed;
            right: 92px;
            bottom: 20px;
            width: 350px;
            height: 500px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.15);
            display: none;
            flex-direction: column;
            overflow: hidden;
            z-index: 1049;
        }

        #chat-widget-header {
            background: #1a5928;
            color: white;
            padding: 18px 16px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 18px;
        }

        #chat-widget-header button {
            background: transparent;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
        }

        #chat-widget-body {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background: #f8f9fa;
        }

        #chat-widget-body p {
            margin-bottom: 15px;
            padding: 12px;
            border-radius: 8px;
            font-size: 14px;
            word-wrap: break-word;
        }

        #chat-widget-footer {
            padding: 12px;
            border-top: 1px solid #ddd;
            display: flex;
            gap: 10px;
            background: white;
        }

        #chat-widget-input {
            flex: 1;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 8px;
            outline: none;
        }

        #chat-widget-input:focus {
            border-color: #1a5928;
            box-shadow: 0 0 0 2px rgba(26, 89, 40, 0.12);
        }

        #chat-widget-send {
            background: #1a5928;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
        }

        #chat-widget-send:hover {
            background: #13421e;
        }
    </style>
@stop

@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())

@section('body')
    <div class="wrapper">

        @if($preloaderHelper->isPreloaderEnabled())
            @include('adminlte::partials.common.preloader')
        @endif

        @if($layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.navbar.navbar-layout-topnav')
        @else
            @include('adminlte::partials.navbar.navbar')
        @endif

        @if(!$layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.sidebar.left-sidebar')
        @endif

        @empty($iFrameEnabled)
            @include('adminlte::partials.cwrapper.cwrapper-default')
        @else
            @include('adminlte::partials.cwrapper.cwrapper-iframe')
        @endempty

        @hasSection('footer')
            @include('adminlte::partials.footer.footer')
        @endif

        @if($layoutHelper->isRightSidebarEnabled())
            @include('adminlte::partials.sidebar.right-sidebar')
        @endif

        <button id="chat-floating-button" type="button" aria-label="Abrir chat">💬</button>

        <div id="chat-widget-container" aria-live="polite">
            <div id="chat-widget-header">
                <span>Chat</span>
                <button type="button" onclick="closeChatWidget()" aria-label="Fechar chat">✖</button>
            </div>

            <div id="chat-widget-body">
                <p style="margin-bottom: 20px">
                    <strong>Olá 👋, como podemos te ajudar?</strong>
                </p>
            </div>

            <div id="chat-widget-footer">
                <input type="text" id="chat-widget-input" placeholder="Digite sua mensagem aqui..." />
                <button id="chat-widget-send" type="button">Enviar</button>
            </div>
        </div>
    </div>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
    <script>
        window.ChatWidgetConfig = {
            webhook: {
                url: 'YOUR-URL-HERE',
                route: 'general',
            }
        };

        function getCsrfToken() {
            return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        }

        function appendMessage(content, role = 'user') {
            const chatBody = document.getElementById('chat-widget-body');
            if (!chatBody) return;

            const messageElement = document.createElement('p');
            messageElement.textContent = content;
            messageElement.style.whiteSpace = 'pre-wrap';

            if (role === 'assistant') {
                messageElement.style.color = '#fff';
                messageElement.style.background = '#1a5928';
                messageElement.style.marginTop = '10px';
            } else {
                messageElement.style.color = '#333';
                messageElement.style.background = '#f1f1f1';
            }

            chatBody.appendChild(messageElement);
            // Rola automaticamente para a última mensagem
            chatBody.scrollTop = chatBody.scrollHeight;
        }

        async function ensureConversation() {
            const response = await fetch('/api/chat/conversations', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken(),
                }
            });

            if (!response.ok) {
                throw new Error('Não foi possível carregar a conversa do usuário.');
            }

            const conversations = await response.json();
            if (conversations && conversations.length > 0) {
                return conversations[0].id;
            }

            const createResponse = await fetch('/api/chat/conversations', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken(),
                },
                body: JSON.stringify({ title: 'Chat principal' }),
            });

            if (!createResponse.ok) {
                throw new Error('Não foi possível criar a conversa do usuário.');
            }

            const createdConversation = await createResponse.json();
            return createdConversation.id;
        }

        async function loadConversationMessages(conversationId) {
            const response = await fetch(`/api/chat/conversations/${conversationId}/messages`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken(),
                }
            });

            if (!response.ok) {
                return;
            }

            const messages = await response.json();
            const chatBody = document.getElementById('chat-widget-body');
            if (!chatBody) return;

            chatBody.innerHTML = '<p style="margin-bottom: 20px"><strong>Olá 👋, como podemos te ajudar?</strong></p>';

            messages.forEach((message) => {
                if (!message || !message.content) return;
                appendMessage(message.content, message.role === 'assistant' ? 'assistant' : 'user');
            });
        }

        function closeChatWidget() {
            const widget = document.getElementById('chat-widget-container');
            const button = document.getElementById('chat-floating-button');
            if (widget) widget.style.display = 'none';
            if (button) button.style.display = 'flex';
        }

        document.addEventListener('DOMContentLoaded', function () {
            const chatButton = document.getElementById('chat-floating-button');
            const widget = document.getElementById('chat-widget-container');
            const input = document.getElementById('chat-widget-input');
            const send = document.getElementById('chat-widget-send');
            let currentConversationId = null;

            async function initializeChat() {
                try {
                    currentConversationId = await ensureConversation();
                    await loadConversationMessages(currentConversationId);
                } catch (error) {
                    console.error(error);
                }
            }

            if (chatButton && widget) {
                chatButton.addEventListener('click', function () {
                    widget.style.display = 'flex';
                    chatButton.style.display = 'none';
                    if (input) input.focus();
                    if (!currentConversationId) {
                        initializeChat();
                    }
                });
            }

            if (send) {
                send.addEventListener('click', async function () {
                    let message = input ? input.value : '';
                    if (message.trim() === '') return;

                    if (!currentConversationId) {
                        currentConversationId = await ensureConversation();
                    }

                    appendMessage(message, 'user');

                    const response = await fetch(`/api/chat/conversations/${currentConversationId}/messages`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': getCsrfToken(),
                        },
                        body: JSON.stringify({ message: message }),
                    });

                    if (!response.ok) {
                        throw new Error('Não foi possível enviar a mensagem para o assistente.');
                    }

                    const data = await response.json();
                    if (data.output) {
                        appendMessage(data.output, 'assistant');
                    }

                    if (input) input.value = '';
                });
            }

            if (input) {
                input.addEventListener('keydown', function (event) {
                    if (event.key === 'Enter' && send) {
                        send.click();
                    }
                });
            }

            initializeChat();
        });
    </script>
@stop
