@extends('adminlte::page')

@section('title', 'Carregamentos')

@section('content_header')
<h1>Carregamentos</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Controle de carregamentos</h3>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Motorista</th>
                    <th>Veículo</th>
                    <th>DT</th>
                    <th>Carregamento</th>
                    <th>Descarga Agendada</th>
                    <th>Cliente</th>
                    <th>CT-e</th>
                    <th>MDF-e</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cargas as $carga)
                    <tr>
                        <td>{{ $carga->motorista->nome ?? 'N/A' }}</td>
                        <td>{{ $carga->veiculo ? $carga->veiculo->placa_cavalo . ' / ' . $carga->veiculo->placa_carreta : 'N/A' }}
                        </td>
                        <td>{{ $carga->numero_dt }}</td>
                        <td>{{ $carga->data_carregamento ? \Carbon\Carbon::parse($carga->data_carregamento)->format('d/m/Y H:i') : 'N/A' }}</td>
                        <td>{{ $carga->data_agendamento_descarga ? \Carbon\Carbon::parse($carga->data_agendamento_descarga)->format('d/m/Y H:i') : 'N/A' }}</td>
                        <td>{{ $carga->cliente }}</td>
                        <td>{{ $carga->cte ?: 'Pendente' }}</td>
                        <td>{{ $carga->mdfe ?: 'Pendente' }}</td>
                        <td>
                            <a href="{{ route('carregamentos.edit', $carga->id) }}" class="btn btn-warning btn-sm"
                                title="Editar Carregamento">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        {{ $cargas->links() }}
    </div>
</div>
@stop