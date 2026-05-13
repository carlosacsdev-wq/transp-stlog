@extends('adminlte::page')

@section('title', 'Pagamentos')

@section('content_header')
    <h1>Pagamentos</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listagem de Pagamentos</h3>
            <div class="card-tools">
                <a href="{{ route('pagamentos.create') }}" class="btn btn-primary btn-sm">Novo Pagamento</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        {{-- <th>ID</th> --}}
                        <th>Motorista</th>
                        <th>Veículo</th>
                        <th>CTe</th>
                        <th>DT</th>
                        <th>Data Pagamento</th>
                        <th>Valor Frete</th>
                        <th>Adiantamento</th>
                        <th>Saldo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pagamentos as $pagamento)
                        <tr>
                            {{-- <td>{{ $pagamento->id }}</td> --}}
                            <td>{{ $pagamento->motorista->nome ?? 'N/A' }}</td>
                            <td>{{ $pagamento->veiculo ? $pagamento->veiculo->placa_cavalo . ' / ' . $pagamento->veiculo->placa_carreta : 'N/A' }}</td>
                            <td>{{ $pagamento->cte }}</td>
                            <td>{{ $pagamento->dt }}</td>
                            <td>{{ $pagamento->data_pagamento }}</td>
                            <td>R$ {{ number_format($pagamento->valor_frete, 2, ',', '.') }}</td>
                            <td>R$ {{ number_format($pagamento->valor_adiantamento, 2, ',', '.') }}</td>
                            <td>R$ {{ number_format($pagamento->saldo_frete, 2, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('pagamentos.edit', $pagamento->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                {{-- <form action="{{ route('pagamentos.destroy', $pagamento->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')" title="Excluir">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form> --}}
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
