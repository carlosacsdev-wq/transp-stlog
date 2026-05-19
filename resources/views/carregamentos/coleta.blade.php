<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordem de Coleta</title>
    <style>
        /* Linha com duas colunas — borda preta, sem cor de fundo */
        .row {
            display: flex;
            gap: 0;
            width: 100%;
            box-sizing: border-box;
            align-items: flex-start;
            /* evita que as colunas sejam esticadas para a mesma altura */
        }

        .col {
            border: 1px solid #000;
            /* borda preta */
            padding: 16px;
            box-sizing: border-box;
            background: transparent;
            /* sem cor de fundo */
        }

        /* Modificadores de largura */
        .col-50 {
            flex: 1 1 50%;
        }

        .col-30 {
            flex: 0 0 30%;
            max-width: 30%;
        }

        .col-70 {
            flex: 1 1 70%;
        }

        /* Espaçamento entre linhas via CSS (substitui <br /><br /> e spacer no HTML) */
        .row+.row {
            margin-top: 16px;
            /* ajuste conforme necessário */
        }

        /* Espaçamento entre a última row e o bloco .sixth */
        .row+.sixth {
            margin-top: 16px;
        }

        /* Em telas pequenas, empilha as colunas */
        @media (max-width: 600px) {
            .row {
                flex-direction: column;
            }

            .col-30,
            .col-70,
            .col-50 {
                flex: 1 1 100%;
                max-width: 100%;
            }

            /* quando empilhadas, deixe altura natural */
            .col-short,
            .col-tall {
                height: auto;
            }
        }

        /* Ajustes de altura específicos para a segunda linha — esquerdas mais baixas que direitas */
        .col-short {
            min-height: 30px;
        }

        .col-tall {
            min-height: 60px;
        }

        /* Centralizar o conteúdo da primeira linha (apenas) */
        .row:first-of-type {
            align-items: center;
            /* centraliza verticalmente os itens nessa linha */
        }

        .row:first-of-type .col {
            text-align: center;
            /* centraliza horizontalmente o texto nas colunas dessa linha */
            font-weight: 700;
            /* deixa o conteúdo da primeira linha em negrito */
            font-size: 1.05em;
            /* ligeiro aumento de tamanho somente para a primeira linha */
        }

        /* Seção sexta div: 2 linhas x 3 colunas, conteúdo centralizado, primeira linha em negrito */
        .col-33 {
            flex: 1 1 33.3333%;
            max-width: 33.3333%;
        }

        .sixth {
            display: flex;
            flex-direction: column;
            gap: 8px;
            /* espaço entre as rows internas */
        }

        .sixth .row {
            display: flex;
            width: 100%;
            box-sizing: border-box;
            align-items: center;
            /* centraliza verticalmente os conteúdos */
        }

        .sixth .col {
            text-align: center;
            /* centraliza horizontalmente */
            min-height: 48px;
            /* garante espaço para centralização vertical */
        }

        /* Espaçamento entre as rows internas do bloco .sixth */
        .sixth .row+.row {
            margin-top: 8px;
        }

        /* Diferenciar alturas: primeira linha mais alta que a segunda */
        .sixth .row:first-of-type .col {
            min-height: 56px;
        }

        .sixth .row:nth-of-type(2) .col {
            min-height: 28px;
        }

        .sixth .row:first-of-type .col {
            font-weight: 700;
            /* primeira linha em negrito */
        }

        /* Segunda linha, primeira coluna do bloco .sixth: vermelho vivo, negrito e levemente maior */
        .sixth .row:nth-of-type(2) .col:first-of-type {
            color: #e53935;
            /* vermelho vivo */
            font-weight: 700;
            font-size: 1.1em;
            /* levemente maior */
        }

        /* Segunda linha, segunda coluna do bloco .sixth: texto em branco */
        .sixth .row:nth-of-type(2) .col:nth-of-type(2) {
            color: #ffffff;
        }

        /* Centralização vertical para colunas específicas */
        .vcenter {
            display: flex;
            align-items: center;
        }

        /* Centralizar conteúdo da coluna direita (70%) nas linhas 30/70, exceto quando explicitamente marcado */
        .row[aria-label="linha com 30 por cento e 70 por cento"] .col-70:not(.no-center) {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        /* Centralizar todos os .col-70.col-tall por padrão, exceto .no-center (placas) */
        .col-70.col-tall:not(.no-center) {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        /* Tornar em negrito as colunas à esquerda que usam col-short + vcenter */
        .col-short.vcenter {
            font-weight: 700;
        }

        /* Espaçamento entre .sixth e a última .final */
        .sixth+.final {
            margin-top: 16px;
        }

        /* Última div: alinhar conteúdo à esquerda e espaçar linhas via CSS */
        .final .col {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            /* alinhamento à esquerda */
            justify-content: center;
        }

        .final .col .line-2 {
            margin-top: 8px;
            /* pula o conteúdo para baixo sem usar <br /> */
        }

        /* Utilitários */
        .col-full {
            width: 100%;
        }

        /* Impressão: A4 e ajustes para print */
        @page {
            size: A4;
            margin: 20mm;
        }

        @media print {

            html,
            body {
                height: auto;
            }

            body {
                margin: 0;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            /* reduzir padding para economizar espaço em papel */
            .col {
                padding: 8px;
            }

            /* evitar quebra dentro das linhas */
            .row {
                page-break-inside: avoid;
            }

            /* garantir larguras fixas em impressão */
            .col-30 {
                flex: 0 0 30%;
                max-width: 30%;
            }

            .col-70 {
                flex: 0 0 70%;
                max-width: 70%;
            }

            .col-33 {
                flex: 0 0 33.3333%;
                max-width: 33.3333%;
            }

            /* remover elementos que não devem aparecer */
            .no-print {
                display: none !important;
            }

            /* ajustar alturas para impressão */
            .col-short,
            .col-tall {
                height: auto;
            }

            .sixth .col,
            .final .col {
                min-height: 0;
            }
        }
    </style>
</head>

<body>
    <div class="row" aria-label="linha de duas colunas">
        <div class="col col-50">ST Logistica</div>
        <div class="col col-50">ORDEM DE COLETA</div>
    </div>

    <div class="row" aria-label="linha com 30 por cento e 70 por cento">
        <div class="col col-30 col-short vcenter">REMETENTE</div>
        <div class="col col-70 col-tall">HNK Industria Beb. Ltda -
            {{ $carga->fabrica }}
        </div>
    </div>
    <div class="row" aria-label="linha com 30 por cento e 70 por cento">
        <div class="col col-30 col-short vcenter">DESTINATARIO</div>
        <div class="col col-70 col-tall">{{ $carga->cliente ?? '' }}</div>
    </div>
    <div class="row" aria-label="linha com 30 por cento e 70 por cento">
        <div class="col col-30 col-short vcenter">MOTORISTA</div>
        <div class="col col-70 col-tall">{{ $carga->motorista->nome ?? 'N/A' }} // {{ $carga->motorista->cpf ?? 'N/A' }}
        </div>
    </div>
    <div class="row" aria-label="linha com 30 por cento e 70 por cento">
        <div class="col col-30 col-short vcenter">VEICULO</div>
        <div class="col col-70 col-tall no-center">Placa cavalo: {{ $carga->veiculo->placa_cavalo ?? 'N/A' }}<br />
            Placa carreta: {{ $carga->veiculo->placa_carreta ?? 'N/A' }}</div>
    </div>

    <!-- Sexta div: 2 linhas x 3 colunas -->
    <div class="sixth" aria-label="sexto bloco 2x3">
        <div class="row">
            <div class="col col-33">DT</div>
            <div class="col col-33">CÓDIGO DO CLIENTE</div>
            <div class="col col-33">MERCADORIA</div>
        </div>
        <div class="row">
            <div class="col col-33">{{ $carga->numero_dt }}</div>
            <div class="col col-33">XXXXXXX</div>
            <div class="col col-33">BEBIDAS</div>
        </div>
    </div>
    <div class="final" aria-label="ultima div">
        <div class="row">
            <div class="col col-full">
                <div class="line-1">Data carreg.:
                    {{ $carga->data_carregamento ? \Carbon\Carbon::parse($carga->data_carregamento)->format('d/m/Y') : 'N/A' }}
                </div>
                <div class="line-2">Hora carreg.:
                    {{ $carga->data_carregamento ? \Carbon\Carbon::parse($carga->data_carregamento)->format('H:i') : 'N/A' }}
                </div>
            </div>
        </div>
    </div>

    <script>
        window.onload = function () {
            window.print();
        }
    </script>
</body>

</html>