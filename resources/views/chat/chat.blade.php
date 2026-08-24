@extends('adminlte::page')

@section('title', 'Chat')

@section('css')
    <style>
        #chat-widget-container {
            position: fixed;
            right: 20px;
            bottom: 20px;
            width: 350px;
            height: 500px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
            display: flex;
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

        #chat-widget-body p strong {
            color: #1a5928;
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

@section('content')
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
            <input
                type="text"
                id="chat-widget-input"
                placeholder="Digite sua mensagem aqui..."
            />
            <button id="chat-widget-send" type="button">Enviar</button>
        </div>
    </div>
@stop

@push('js')
    <script>
        function closeChatWidget() {
            document.getElementById('chat-widget-container').style.display = 'none';
        }

        function getChatId() {
            let chatId = sessionStorage.getItem('chatId');
            if (!chatId) {
                chatId = 'chat_' + Math.random().toString(36).substr(2, 9);
                sessionStorage.setItem('chatId', chatId);
            }
            return chatId;
        }

        document.getElementById('chat-widget-send').addEventListener('click', function () {
            let message = document.getElementById('chat-widget-input').value;
            if (message.trim() === '') return;

            let chatBody = document.getElementById('chat-widget-body');
            let newMessage = document.createElement('p');
            newMessage.textContent = message;
            newMessage.style.color = '#333';
            newMessage.style.background = '#f1f1f1';
            chatBody.appendChild(newMessage);

            let chatId = getChatId();

            fetch(window.ChatWidgetConfig && window.ChatWidgetConfig.webhook && window.ChatWidgetConfig.webhook.url || '', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    chatId: chatId,
                    message: message,
                    route: 'general',
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

            document.getElementById('chat-widget-input').value = '';
        });

        document.getElementById('chat-widget-input').addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                document.getElementById('chat-widget-send').click();
            }
        });
    </script>
@endpush
