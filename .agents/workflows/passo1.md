---
description: Inicio do projeto
---

crie um projeto usando laravel sail (api) e (web) nome do banco pode ser transporte

use adminlte-v3 abaixo tenho a documentação do template

https://jeroennoten.github.io/Laravel-AdminLTE/sections/overview/installation.html

e como integrar as views ao template

https://jeroennoten.github.io/Laravel-AdminLTE/sections/overview/usage.html

Teremos as migrations

motoristas

- (dados do motorista)

veiculos

- (dados do veiculo) o veiculo tem chave estrangeira com motoristas geralmente o motorista tem duas placas atreladas a ele (carreta e cavalo)

cargas

- (programação de cargas disponivel para ser atendida com campos numero do DT, Data de carregamento na fábrica, Data de agendamento de descarga no cliente, Nome do cliente, Valor do frete pago ao motorista )

pagamentos (pagamento dos fretes dos motoristas)

- (dados para controle dos pagamentos dos fretes como (cte, dt, data_pagamento, valor do frete, nome do motorista, valor do adiantamento, saldo de frete)

viagens

- (dados das viagens importantes para acompanhamento dia e hora de carregamento, data e hora de chegada no cliente, data e hora de descarga no cliente, nome do motorista, CTe da carga)

crie as migrations, e o CRUD completo delas crie as views em config tem o arquivo adminlte.php lá inclua menu operacional (motoristas, veiculos, cargas) menu Ocorrencia (Viagem) e menu Financeiro (Pagamento)
