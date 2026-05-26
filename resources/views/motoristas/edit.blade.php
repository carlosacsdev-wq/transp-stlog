@extends('adminlte::page')

@section('title', 'Editar Motorista')

@section('content_header')
    <h1>Editar Motorista</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('motoristas.update', ['tenant' => request()->route('tenant'), 'motorista' => $motorista->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" class="form-control" id="nome" value="{{ $motorista->nome }}" required>
                </div>
                <div class="form-group">
                    <label for="cpf">CPF</label>
                    <input type="text" name="cpf" class="form-control" id="cpf" value="{{ $motorista->cpf }}" required>
                </div>
                <div class="form-group">
                    <label for="cnh">CNH</label>
                    <input type="text" name="cnh" class="form-control" id="cnh" value="{{ $motorista->cnh }}">
                </div>
                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="text" name="telefone" class="form-control" id="telefone" value="{{ $motorista->telefone }}">
                </div>
                <button type="submit" class="btn btn-primary">Atualizar</button>
                <a href="{{ route('motoristas.index', ['tenant' => request()->route('tenant')]) }}" class="btn btn-default">Cancelar</a>
            </form>
        </div>
    </div>
@stop
