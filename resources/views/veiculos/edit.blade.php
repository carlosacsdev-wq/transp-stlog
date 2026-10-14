@extends('adminlte::page')

@section('title', 'Editar Veículo')

@section('content_header')
    <h1>Editar Veículo</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('veiculos.update', ['tenant' => request()->route('tenant'), 'veiculo' => $veiculo->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="motorista_id">Motorista</label>
                    <select name="motorista_id" class="form-control" id="motorista_id" required>
                        @foreach($motoristas as $motorista)
                            <option value="{{ $motorista->id }}" {{ old('motorista_id', $veiculo->motorista_id) == $motorista->id ? 'selected' : '' }}>
                                {{ $motorista->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="tipo">Tipo de Veículo</label>
                    <select name="tipo" class="form-control" id="tipo" required>
                        <option value="cavalo" {{ old('tipo', $veiculo->tipo) == 'cavalo' ? 'selected' : '' }}>Cavalo</option>
                        <option value="carreta" {{ old('tipo', $veiculo->tipo) == 'carreta' ? 'selected' : '' }}>Carreta</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="placa">Placa</label>
                    <input type="text" name="placa" class="form-control" id="placa" value="{{ old('placa', $veiculo->placa) }}" required>
                </div>
                <div class="form-group">
                    <label for="nome_proprietario">Nome do Proprietário</label>
                    <input type="text" name="nome_proprietario" class="form-control" id="nome_proprietario" value="{{ old('nome_proprietario', $veiculo->nome_proprietario) }}">
                </div>
                <div class="form-group">
                    <label for="endereco_proprietario">Endereço do Proprietário</label>
                    <input type="text" name="endereco_proprietario" class="form-control" id="endereco_proprietario" value="{{ old('endereco_proprietario', $veiculo->endereco_proprietario) }}">
                </div>
                <div class="form-group">
                    <label for="cidade">Cidade</label>
                    <input type="text" name="cidade" class="form-control" id="cidade" value="{{ old('cidade', $veiculo->cidade) }}">
                </div>
                <div class="form-group">
                    <label for="uf">UF</label>
                    <input type="text" name="uf" class="form-control" id="uf" value="{{ old('uf', $veiculo->uf) }}">
                </div>
                <div class="form-group">
                    <label for="modelo">Modelo</label>
                    <input type="text" name="modelo" class="form-control" id="modelo" value="{{ old('modelo', $veiculo->modelo) }}">
                </div>
                <div class="form-group">
                    <label for="marca">Marca</label>
                    <input type="text" name="marca" class="form-control" id="marca" value="{{ old('marca', $veiculo->marca) }}">
                </div>
                <div class="form-group">
                    <label for="chassi">Chassi</label>
                    <input type="text" name="chassi" class="form-control" id="chassi" value="{{ old('chassi', $veiculo->chassi) }}">
                </div>
                <div class="form-group">
                    <label for="renavam">Renavam</label>
                    <input type="text" name="renavam" class="form-control" id="renavam" value="{{ old('renavam', $veiculo->renavam) }}">
                </div>
                <div class="form-group">
                    <label for="ano_fabricacao">Ano de Fabricação</label>
                    <input type="number" name="ano_fabricacao" class="form-control" id="ano_fabricacao" min="1900" max="2155" value="{{ old('ano_fabricacao', $veiculo->ano_fabricacao) }}">
                </div>
                <div class="form-group">
                    <label for="ano_modelo">Ano do Modelo</label>
                    <input type="number" name="ano_modelo" class="form-control" id="ano_modelo" min="1900" max="2155" value="{{ old('ano_modelo', $veiculo->ano_modelo) }}">
                </div>
                <div class="form-group">
                    <label for="cidade_emissao">Cidade de Emissão</label>
                    <input type="text" name="cidade_emissao" class="form-control" id="cidade_emissao" value="{{ old('cidade_emissao', $veiculo->cidade_emissao) }}">
                </div>
                <div class="form-group">
                    <label for="uf_emissao">UF de Emissão</label>
                    <input type="text" name="uf_emissao" class="form-control" id="uf_emissao" value="{{ old('uf_emissao', $veiculo->uf_emissao) }}">
                </div>
                <button type="submit" class="btn btn-primary">Atualizar</button>
                <a href="{{ route('veiculos.index', ['tenant' => request()->route('tenant')]) }}" class="btn btn-default">Cancelar</a>
            </form>
        </div>
    </div>
@stop
