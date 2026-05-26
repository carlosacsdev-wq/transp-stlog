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
        <form action="{{ route('motoristas.store', ['tenant' => request()->route('tenant')]) }}" method="POST">

            @csrf

            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                       value="{{ old('nome') }}" required>
                @error('nome')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label for="cpf">CPF</label>
                <input type="text" name="cpf" class="form-control @error('cpf') is-invalid @enderror"
                       value="{{ old('cpf') }}" required>
                @error('cpf')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label for="cnh">CNH</label>
                <input type="text" name="cnh" class="form-control @error('cnh') is-invalid @enderror"
                       value="{{ old('cnh') }}">
                @error('cnh')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label for="telefone">Telefone</label>
                <input type="text" name="telefone" class="form-control @error('telefone') is-invalid @enderror"
                       value="{{ old('telefone') }}">
                @error('telefone')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('motoristas.index', ['tenant' => request()->route('tenant')]) }}" class="btn btn-default">Cancelar</a>
        </form>
    </div>
</div>
@stop