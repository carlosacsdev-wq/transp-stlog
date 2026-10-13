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
                <label for="apelido">Apelido</label>
                <input type="text" name="apelido" id="apelido" class="form-control" value="{{ old('apelido') }}">
            </div>
            <div class="form-group">
                <label for="data_nascimento">Data de Nascimento</label>
                <input type="date" name="data_nascimento" id="data_nascimento" class="form-control" value="{{ old('data_nascimento') }}">
            </div>
            <div class="form-group">
                <label for="nome_mae">Nome da Mãe</label>
                <input type="text" name="nome_mae" id="nome_mae" class="form-control" value="{{ old('nome_mae') }}" required>
            </div>
            <div class="form-group">
                <label for="nome_pai">Nome do Pai</label>
                <input type="text" name="nome_pai" id="nome_pai" class="form-control" value="{{ old('nome_pai') }}">
            </div>
            <div class="form-group">
                <label for="rg">RG</label>
                <input type="text" name="rg" id="rg" class="form-control" value="{{ old('rg') }}">
            </div>
            <div class="form-group">
                <label for="data_emissao_rg">Data de Emissão do RG</label>
                <input type="date" name="data_emissao_rg" id="data_emissao_rg" class="form-control" value="{{ old('data_emissao_rg') }}">
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
                <label for="endereco">Endereço</label>
                <input type="text" name="endereco" id="endereco" class="form-control" value="{{ old('endereco') }}">
            </div>
            <div class="form-group">
                <label for="bairro">Bairro</label>
                <input type="text" name="bairro" id="bairro" class="form-control" value="{{ old('bairro') }}">
            </div>
            <div class="form-group">
                <label for="cidade">Cidade</label>
                <input type="text" name="cidade" id="cidade" class="form-control" value="{{ old('cidade') }}">
            </div>
            <div class="form-group">
                <label for="estado">Estado</label>
                <input type="text" name="estado" id="estado" class="form-control" value="{{ old('estado') }}">
            </div>

            <div class="form-group">
                <label for="telefone">Telefone</label>
                <input type="text" name="telefone" class="form-control @error('telefone') is-invalid @enderror"
                       value="{{ old('telefone') }}">
                @error('telefone')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label for="contato_pessoal1">Contato Pessoal 1</label>
                <input type="text" name="contato_pessoal1" id="contato_pessoal1" class="form-control" value="{{ old('contato_pessoal1') }}">
            </div>
            <div class="form-group">
                <label for="contato_pessoal2">Contato Pessoal 2</label>
                <input type="text" name="contato_pessoal2" id="contato_pessoal2" class="form-control" value="{{ old('contato_pessoal2') }}">
            </div>
            <div class="form-group">
                <label for="contato_pessoal3">Contato Pessoal 3</label>
                <input type="text" name="contato_pessoal3" id="contato_pessoal3" class="form-control" value="{{ old('contato_pessoal3') }}">
            </div>
            <div class="form-group">
                <label for="contato_empresa1">Contato Empresa 1</label>
                <input type="text" name="contato_empresa1" id="contato_empresa1" class="form-control" value="{{ old('contato_empresa1') }}">
            </div>
            <div class="form-group">
                <label for="contato_empresa2">Contato Empresa 2</label>
                <input type="text" name="contato_empresa2" id="contato_empresa2" class="form-control" value="{{ old('contato_empresa2') }}">
            </div>
            <div class="form-group">
                <label for="contato_empresa3">Contato Empresa 3</label>
                <input type="text" name="contato_empresa3" id="contato_empresa3" class="form-control" value="{{ old('contato_empresa3') }}">
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('motoristas.index', ['tenant' => request()->route('tenant')]) }}" class="btn btn-default">Cancelar</a>
        </form>
    </div>
</div>
@stop