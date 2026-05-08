@extends('adminlte::page')

@section('title', 'Viagens')

@section('content_header')
    <h1>Viagens</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listagem de Viagens</h3>
            <div class="card-tools">
                <a href="{{ route('viagens.create') }}" class="btn btn-primary btn-sm">Nova Viagem</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Motorista</th>
                        <th>Veículo</th>
                        <th>Carregamento</th>
                        <th>Chegada</th>
                        <th>Descarga</th>
                        <th>CTe</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($viagens as $viagem)
                        <tr>
                            <td>{{ $viagem->id }}</td>
                            <td>{{ $viagem->motorista->nome ?? 'N/A' }}</td>
                            <td>{{ $viagem->veiculo ? $viagem->veiculo->placa_cavalo . ' / ' . $viagem->veiculo->placa_carreta : 'N/A' }}</td>
                            <td>{{ $viagem->data_hora_carregamento }}</td>
                            <td>{{ $viagem->data_hora_chegada }}</td>
                            <td>{{ $viagem->data_hora_descarga }}</td>
                            <td>{{ $viagem->cte }}</td>
                            <td>
                                <a href="{{ route('viagens.edit', $viagem->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('viagens.destroy', $viagem->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')" title="Excluir">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
