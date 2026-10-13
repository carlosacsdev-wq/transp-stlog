@extends('adminlte::page')

@section('title', 'Novo Veículo')

@section('content_header')
<h1>Novo Veículo</h1>
{{-- <p style="font-size: 12px; color: rgb(200, 10, 10);">Trata-se de um cadastro minimalista, contendo apenas os dados
    necessarios para fins demonstrativos.</p> --}}
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('veiculos.store', ['tenant' => request()->route('tenant')]) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="motorista_id">Motorista</label>
                <select name="motorista_id" class="form-control" id="motorista_id" required>
                    <option value="">Selecione um motorista</option>
                    @foreach($motoristas as $motorista)
                        <option value="{{ $motorista->id }}" {{ old('motorista_id') == $motorista->id ? 'selected' : '' }}>{{ $motorista->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="placa_cavalo">Placa Cavalo</label>
                <input type="text" name="placa_cavalo" class="form-control" id="placa_cavalo" placeholder="ABC-1234"
                    value="{{ old('placa_cavalo') }}" required>
            </div>
            <div class="form-group">
                <label for="placa_carreta">Placa Carreta</label>
                <input type="text" name="placa_carreta" class="form-control" id="placa_carreta" placeholder="XYZ-5678"
                    value="{{ old('placa_carreta') }}" required>
            </div>
            <div class="form-group">
                <label for="nome_proprietario">Nome do Proprietário</label>
                <input type="text" name="nome_proprietario" class="form-control" id="nome_proprietario" value="{{ old('nome_proprietario') }}">
            </div>
            <div class="form-group">
                <label for="endereco_proprietario">Endereço do Proprietário</label>
                <input type="text" name="endereco_proprietario" class="form-control" id="endereco_proprietario" value="{{ old('endereco_proprietario') }}">
            </div>
            <div class="form-group">
                <label for="cidade">Cidade</label>
                <input type="text" name="cidade" class="form-control" id="cidade" value="{{ old('cidade') }}">
            </div>
            <div class="form-group">
                <label for="uf">UF</label>
                <input type="text" name="uf" class="form-control" id="uf" value="{{ old('uf') }}">
            </div>
            <div class="form-group">
                <label for="modelo">Modelo</label>
                <input type="text" name="modelo" class="form-control" id="modelo" placeholder="Modelo do veículo" value="{{ old('modelo') }}">
            </div>
            <div class="form-group">
                <label for="marca">Marca</label>
                <input type="text" name="marca" class="form-control" id="marca" placeholder="Marca do veículo" value="{{ old('marca') }}">
            </div>
            <div class="form-group">
                <label for="chassi">Chassi</label>
                <input type="text" name="chassi" class="form-control" id="chassi" value="{{ old('chassi') }}">
            </div>
            <div class="form-group">
                <label for="renavam">Renavam</label>
                <input type="text" name="renavam" class="form-control" id="renavam" value="{{ old('renavam') }}">
            </div>
            <div class="form-group">
                <label for="ano_fabricacao">Ano de Fabricação</label>
                <input type="number" name="ano_fabricacao" class="form-control" id="ano_fabricacao" min="1900" max="2155" value="{{ old('ano_fabricacao') }}">
            </div>
            <div class="form-group">
                <label for="ano_modelo">Ano do Modelo</label>
                <input type="number" name="ano_modelo" class="form-control" id="ano_modelo" min="1900" max="2155" value="{{ old('ano_modelo') }}">
            </div>
            <div class="form-group">
                <label for="cidade_emissao">Cidade de Emissão</label>
                <input type="text" name="cidade_emissao" class="form-control" id="cidade_emissao" value="{{ old('cidade_emissao') }}">
            </div>
            <div class="form-group">
                <label for="uf_emissao">UF de Emissão</label>
                <input type="text" name="uf_emissao" class="form-control" id="uf_emissao" value="{{ old('uf_emissao') }}">
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('veiculos.index', ['tenant' => request()->route('tenant')]) }}" class="btn btn-default">Cancelar</a>
        </form>
    </div>
</div>
@stop