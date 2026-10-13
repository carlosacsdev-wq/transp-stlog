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
                    <input type="text" name="nome" class="form-control" id="nome" value="{{ old('nome', $motorista->nome) }}" required>
                </div>
                <div class="form-group">
                    <label for="apelido">Apelido</label>
                    <input type="text" name="apelido" class="form-control" id="apelido" value="{{ old('apelido', $motorista->apelido) }}">
                </div>
                <div class="form-group">
                    <label for="data_nascimento">Data de Nascimento</label>
                    <input type="date" name="data_nascimento" class="form-control" id="data_nascimento" value="{{ old('data_nascimento', $motorista->data_nascimento) }}">
                </div>
                <div class="form-group">
                    <label for="nome_mae">Nome da Mãe</label>
                    <input type="text" name="nome_mae" class="form-control" id="nome_mae" value="{{ old('nome_mae', $motorista->nome_mae) }}" required>
                </div>
                <div class="form-group">
                    <label for="nome_pai">Nome do Pai</label>
                    <input type="text" name="nome_pai" class="form-control" id="nome_pai" value="{{ old('nome_pai', $motorista->nome_pai) }}">
                </div>
                <div class="form-group">
                    <label for="rg">RG</label>
                    <input type="text" name="rg" class="form-control" id="rg" value="{{ old('rg', $motorista->rg) }}">
                </div>
                <div class="form-group">
                    <label for="data_emissao_rg">Data de Emissão do RG</label>
                    <input type="date" name="data_emissao_rg" class="form-control" id="data_emissao_rg" value="{{ old('data_emissao_rg', $motorista->data_emissao_rg) }}">
                </div>
                <div class="form-group">
                    <label for="cpf">CPF</label>
                    <input type="text" name="cpf" class="form-control" id="cpf" value="{{ old('cpf', $motorista->cpf) }}" required>
                </div>
                <div class="form-group">
                    <label for="cnh">CNH</label>
                    <input type="text" name="cnh" class="form-control" id="cnh" value="{{ old('cnh', $motorista->cnh) }}">
                </div>
                <div class="form-group">
                    <label for="endereco">Endereço</label>
                    <input type="text" name="endereco" class="form-control" id="endereco" value="{{ old('endereco', $motorista->endereco) }}">
                </div>
                <div class="form-group">
                    <label for="bairro">Bairro</label>
                    <input type="text" name="bairro" class="form-control" id="bairro" value="{{ old('bairro', $motorista->bairro) }}">
                </div>
                <div class="form-group">
                    <label for="cidade">Cidade</label>
                    <input type="text" name="cidade" class="form-control" id="cidade" value="{{ old('cidade', $motorista->cidade) }}">
                </div>
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <input type="text" name="estado" class="form-control" id="estado" value="{{ old('estado', $motorista->estado) }}">
                </div>
                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="text" name="telefone" class="form-control" id="telefone" value="{{ old('telefone', $motorista->telefone) }}">
                </div>
                <div class="form-group">
                    <label for="contato_pessoal1">Contato Pessoal 1</label>
                    <input type="text" name="contato_pessoal1" class="form-control" id="contato_pessoal1" value="{{ old('contato_pessoal1', $motorista->contato_pessoal1) }}">
                </div>
                <div class="form-group">
                    <label for="contato_pessoal2">Contato Pessoal 2</label>
                    <input type="text" name="contato_pessoal2" class="form-control" id="contato_pessoal2" value="{{ old('contato_pessoal2', $motorista->contato_pessoal2) }}">
                </div>
                <div class="form-group">
                    <label for="contato_pessoal3">Contato Pessoal 3</label>
                    <input type="text" name="contato_pessoal3" class="form-control" id="contato_pessoal3" value="{{ old('contato_pessoal3', $motorista->contato_pessoal3) }}">
                </div>
                <div class="form-group">
                    <label for="contato_empresa1">Contato Empresa 1</label>
                    <input type="text" name="contato_empresa1" class="form-control" id="contato_empresa1" value="{{ old('contato_empresa1', $motorista->contato_empresa1) }}">
                </div>
                <div class="form-group">
                    <label for="contato_empresa2">Contato Empresa 2</label>
                    <input type="text" name="contato_empresa2" class="form-control" id="contato_empresa2" value="{{ old('contato_empresa2', $motorista->contato_empresa2) }}">
                </div>
                <div class="form-group">
                    <label for="contato_empresa3">Contato Empresa 3</label>
                    <input type="text" name="contato_empresa3" class="form-control" id="contato_empresa3" value="{{ old('contato_empresa3', $motorista->contato_empresa3) }}">
                </div>
                <button type="submit" class="btn btn-primary">Atualizar</button>
                <a href="{{ route('motoristas.index', ['tenant' => request()->route('tenant')]) }}" class="btn btn-default">Cancelar</a>
            </form>
        </div>
    </div>
@stop
