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

        function closeChatWidget() {
            const widget = document.getElementById('chat-widget-container');
            const button = document.getElementById('chat-floating-button');
            if (widget) widget.style.display = 'none';
            if (button) button.style.display = 'flex';
        }

        function getChatId() {
            let chatId = sessionStorage.getItem('chatId');
            if (!chatId) {
                chatId = 'chat_' + Math.random().toString(36).substr(2, 9);
                sessionStorage.setItem('chatId', chatId);
            }
            return chatId;
        }

        document.addEventListener('DOMContentLoaded', function () {
            const chatButton = document.getElementById('chat-floating-button');
            const widget = document.getElementById('chat-widget-container');
            const input = document.getElementById('chat-widget-input');
            const send = document.getElementById('chat-widget-send');

            if (chatButton && widget) {
                chatButton.addEventListener('click', function () {
                    widget.style.display = 'flex';
                    chatButton.style.display = 'none';
                    if (input) input.focus();
                });
            }

            if (send) {
                send.addEventListener('click', function () {
                    let message = input ? input.value : '';
                    if (message.trim() === '') return;

                    let chatBody = document.getElementById('chat-widget-body');
                    if (!chatBody) return;

                    let newMessage = document.createElement('p');
                    newMessage.textContent = message;
                    newMessage.style.color = '#333';
                    newMessage.style.background = '#f1f1f1';
                    chatBody.appendChild(newMessage);

                    let chatId = getChatId();
                    const webhookUrl = window.ChatWidgetConfig?.webhook?.url || '';
                    const webhookRoute = window.ChatWidgetConfig?.webhook?.route || 'general';

                    fetch(webhookUrl, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            chatId: chatId,
                            message: message,
                            route: webhookRoute,
                        }),
                    })
                        .then((response) => response.json())
                        .then((data) => {
                            let botMessage = document.createElement('p');
                            botMessage.innerHTML = data.output || "Sorry, I couldn't understand that.";
                            botMessage.style.color = '#fff';
                            botMessage.style.background = '#1a5928';
                            botMessage.style.marginTop = '10px';
                            chatBody.appendChild(botMessage);
                        })
                        .catch((error) => console.error('Error:', error));

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
        });
    </script>
@stop
