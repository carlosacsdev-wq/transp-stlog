@extends('adminlte::page')

@section('title', 'Motoristas')

@section('content_header')
    <h1>Motoristas</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listagem de Motoristas</h3>
            <div class="card-tools">
                <a href="{{ route('motoristas.create') }}" class="btn btn-primary btn-sm">Novo Motorista</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>CNH</th>
                        <th>Telefone</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($motoristas as $motorista)
                        <tr>
                            <td>{{ $motorista->id }}</td>
                            <td>{{ $motorista->nome }}</td>
                            <td>{{ $motorista->cpf }}</td>
                            <td>{{ $motorista->cnh }}</td>
                            <td>{{ $motorista->telefone }}</td>
                            <td>
                                <a href="{{ route('motoristas.edit', $motorista->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('motoristas.destroy', $motorista->id) }}" method="POST" style="display:inline">
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
