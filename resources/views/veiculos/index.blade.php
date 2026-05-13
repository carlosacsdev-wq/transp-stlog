@extends('adminlte::page')

@section('title', 'Veículos')

@section('content_header')
    <h1>Veículos</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listagem de Veículos</h3>
            <div class="card-tools">
                <a href="{{ route('veiculos.create') }}" class="btn btn-primary btn-sm">Novo Veículo</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Motorista</th>
                        <th>Placa Cavalo</th>
                        <th>Placa Carreta</th>
                        <th>Modelo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($veiculos as $veiculo)
                        <tr>
                            <td>{{ $veiculo->id }}</td>
                            <td>{{ $veiculo->motorista->nome }}</td>
                            <td>{{ $veiculo->placa_cavalo }}</td>
                            <td>{{ $veiculo->placa_carreta }}</td>
                            <td>{{ $veiculo->modelo }}</td>
                            <td>
                                <a href="{{ route('veiculos.edit', $veiculo->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('veiculos.destroy', $veiculo->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
