@extends('adminlte::page')

@section('title', 'Detalhes para Pagamento')

@section('content_header')
    <h1>Detalhes do Motorista para Pagamento</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Dados do Motorista</h3>
                    <div class="card-tools">
                        @if($pagamento->status_pagamento == 'Pendente')
                            <span class="badge badge-secondary">Pendente</span>
                        @elseif(str_contains($pagamento->status_pagamento, 'Solicitado'))
                            <span class="badge badge-warning">{{ $pagamento->status_pagamento }}</span>
                        @elseif($pagamento->status_pagamento == 'Finalizado')
                            <span class="badge badge-success">Pago (Total)</span>
                        @else
                            <span class="badge badge-info">{{ $pagamento->status_pagamento }}</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <p><strong>Motorista:</strong><br>{{ $pagamento->motorista->nome ?? 'N/A' }}</p>
                            <p><strong>CPF:</strong><br>{{ $pagamento->motorista->cpf ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>CTe:</strong><br>{{ $pagamento->cte }}</p>
                            <p><strong>DT:</strong><br>{{ $pagamento->numero_dt }}</p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Valor Frete:</strong><br>R$ {{ number_format($pagamento->valor_frete, 2, ',', '.') }}</p>
                            <p><strong>Data Pagamento:</strong><br>{{ $pagamento->data_pagamento ? \Carbon\Carbon::parse($pagamento->data_pagamento)->format('d/m/Y') : '-' }}</p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Adiantamento:</strong><br>R$ {{ $pagamento->valor_adiantamento ? number_format($pagamento->valor_adiantamento, 2, ',', '.') : '0,00' }}</p>
                            <p><strong>Saldo Restante:</strong><br>R$ {{ $pagamento->valor_saldo ? number_format($pagamento->valor_saldo, 2, ',', '.') : '0,00' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Contas Bancárias / PIX</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Titular</th>
                                <th>CPF/CNPJ</th>
                                <th>Banco</th>
                                <th>Agência</th>
                                <th>Conta</th>
                                <th>Tipo Chave</th>
                                <th>Chave PIX</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pagamento->motorista->contas as $conta)
                                <tr>
                                    <td>{{ $conta->titular }}</td>
                                    <td>{{ $conta->cpf_cnpj_titular }}</td>
                                    <td>{{ $conta->banco }}</td>
                                    <td>{{ $conta->agencia }}</td>
                                    <td>{{ $conta->nro_conta }} ({{ $conta->tipo_conta }})</td>
                                    <td>{{ $conta->tipo_chave }}</td>
                                    <td>{{ $conta->chave_pix }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Nenhuma conta bancária cadastrada para este motorista.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <a href="{{ route('pagamentos.index') }}" class="btn btn-default">Voltar</a>
        </div>
    </div>
@stop
