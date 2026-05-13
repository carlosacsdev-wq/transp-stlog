@extends('adminlte::page')

@section('title', 'Pagamentos')

@section('content_header')
    <h1>Pagamentos</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listagem de Pagamentos (Cargas com CTe)</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Motorista</th>
                        <th>Veículo</th>
                        <th>CTe</th>
                        <th>DT</th>
                        <th>Status</th>
                        <th>Data Pagto</th>
                        <th>Valor Frete</th>
                        <th>Adiantamento</th>
                        <th>Saldo</th>
                        <th style="width: 120px; text-align: center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pagamentos as $pagamento)
                        <tr>
                            <td>{{ $pagamento->motorista->nome ?? 'N/A' }}</td>
                            <td>{{ $pagamento->veiculo ? $pagamento->veiculo->placa_cavalo . ' / ' . $pagamento->veiculo->placa_carreta : 'N/A' }}</td>
                            <td>{{ $pagamento->cte }}</td>
                            <td>{{ $pagamento->numero_dt }}</td>
                            <td style="text-align: center;">
                                @if($pagamento->status_pagamento == 'Pendente')
                                    <span class="badge badge-secondary">Pendente</span>
                                @elseif(str_contains($pagamento->status_pagamento, 'Solicitado'))
                                    <span class="badge badge-warning">{{ $pagamento->status_pagamento }}</span>
                                @elseif($pagamento->status_pagamento == 'Finalizado')
                                    <span class="badge badge-success">Pago</span>
                                @else
                                    <span class="badge badge-info">{{ $pagamento->status_pagamento }}</span>
                                @endif
                            </td>
                            <td>{{ $pagamento->data_pagamento ? \Carbon\Carbon::parse($pagamento->data_pagamento)->format('d/m/Y') : '-' }}</td>
                            <td>R$ {{ number_format($pagamento->valor_frete, 2, ',', '.') }}</td>
                            <td>R$ {{ $pagamento->valor_adiantamento ? number_format($pagamento->valor_adiantamento, 2, ',', '.') : '-' }}</td>
                            <td>R$ {{ $pagamento->valor_saldo ? number_format($pagamento->valor_saldo, 2, ',', '.') : '-' }}</td>
                            <td style="text-align: center;">
                                <a href="{{ route('pagamentos.show', $pagamento->id) }}" class="btn btn-info btn-sm" title="Detalhes Bancários">
                                    <i class="fas fa-university"></i>
                                </a>
                                <a href="{{ route('pagamentos.edit', $pagamento->id) }}" class="btn btn-warning btn-sm" title="Editar Pagamento">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $pagamentos->links() }}
        </div>
    </div>
@stop
