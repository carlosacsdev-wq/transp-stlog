## Proximo passo

Criar campos da migration conta e programacao
Criar relacionamentos entre as tabelas
Criar CRUD completo de conta e programacao
Incluir no Dashboard: - Filtro por Fabrica_Carreg - Filtro por Cidade_Destino - Filtro por Agend_Descarreg - Filtro por Motorista - Filtro por Status - Filtro por Data_Carreg - Filtro por Data_Descarreg - Filtro por DT - Filtro por Cliente_Destino

1. Criar banco de dados
2. Inserir as tabelas
3. Criar os models
4. Criar os controllers
5. Criar os views
6. Criar os routes
7. Criar os seeds
8. Criar os factories
9. Criar os policies

sail artisan make:model Conta -a
sail artisan make:model Conta -c
sail artisan make:model Conta -r
sail artisan make:model Conta -m
sail artisan make:model Conta -p
sail artisan make:model Conta -seeder
sail artisan make:model Conta -factory
sail artisan make:model Conta -policy
sail artisan make:model Conta -request
./vendor/bin/sail artisan db:seed --class=TenantSeeder
./vendor/bin/sail artisan db:seed --class=UserSeeder
./vendor/bin/sail artisan make:seeder TenantSeeder
./vendor/bin/sail artisan make:seeder UserSeeder

## arquivos que foram criados para o chat 

carlos@debian:~/projetos/transp-stlog$ git status
On branch chat
Changes not staged for commit:
  (use "git add <file>..." to update what will be committed)
  (use "git restore <file>..." to discard changes in working directory)
        modified:   app/Models/Tenant.php
        modified:   app/Models/User.php
        modified:   config/app.php
        modified:   config/services.php
        modified:   resources/views/chat/chat.blade.php
        modified:   resources/views/vendor/adminlte/page.blade.php
        modified:   routes/web.php

Untracked files:
  (use "git add <file>..." to include in what will be committed)
        app/Http/Controllers/ChatController.php
        app/Models/ChatMessage.php
        app/Models/Conversation.php
        database/migrations/2026_08_28_000001_create_chat_conversations_table.php
        database/migrations/2026_08_28_000002_create_chat_messages_table.php
        tests/Feature/ChatConversationIsolationTest.php
