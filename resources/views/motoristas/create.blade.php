@extends('adminlte::page')

@section('title', 'Novo Motorista')

@section('content_header')
<h1>Novo Motorista</h1>
{{-- <p style="font-size: 12px; color: rgb(200, 10, 10);">Trata-se de um cadastro minimalista, contendo apenas os dados
    necessarios para fins
    demonstrativos.</p> --}}
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('motoristas.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" name="nome" class="form-control" id="nome" placeholder="Nome completo" required>
            </div>
            <div class="form-group">
                <label for="cpf">CPF</label>
                <input type="text" name="cpf" class="form-control" id="cpf" placeholder="000.000.000-00" required>
            </div>
            <div class="form-group">
                <label for="cnh">CNH</label>
                <input type="text" name="cnh" class="form-control" id="cnh" placeholder="Número da CNH">
            </div>
            <div class="form-group">
                <label for="telefone">Telefone</label>
                <input type="text" name="telefone" class="form-control" id="telefone" placeholder="(00) 00000-0000">
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('motoristas.index') }}" class="btn btn-default">Cancelar</a>
        </form>
    </div>
</div>
@stop