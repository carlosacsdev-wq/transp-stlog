@extends('adminlte::page')

@section('title', 'Editar Pagamento')

@section('content_header')
    <h1>Editar Pagamento</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('pagamentos.update', $pagamento->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="motorista_id">Motorista</label>
                    <select name="motorista_id" class="form-control" id="motorista_id" required>
                        <option value="">Selecione um motorista</option>
                        @foreach($motoristas as $motorista)
                            <option value="{{ $motorista->id }}" {{ $pagamento->motorista_id == $motorista->id ? 'selected' : '' }}>
                                {{ $motorista->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="veiculo_id">Veículo</label>
                    <select name="veiculo_id" class="form-control" id="veiculo_id" required>
                        <option value="">Selecione um veículo</option>
                        @foreach($veiculos as $veiculo)
                            <option value="{{ $veiculo->id }}" {{ $pagamento->veiculo_id == $veiculo->id ? 'selected' : '' }}>
                                {{ $veiculo->placa_cavalo }} / {{ $veiculo->placa_carreta }} ({{ $veiculo->motorista->nome }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="cte">CTe</label>
                    <input type="text" name="cte" class="form-control" id="cte" value="{{ $pagamento->cte }}" required>
                </div>
                <div class="form-group">
                    <label for="dt">DT</label>
                    <input type="text" name="dt" class="form-control" id="dt" value="{{ $pagamento->dt }}" required>
                </div>
                <div class="form-group">
                    <label for="data_pagamento">Data de Pagamento</label>
                    <input type="date" name="data_pagamento" class="form-control" id="data_pagamento" value="{{ $pagamento->data_pagamento }}" required>
                </div>
                <div class="form-group">
                    <label for="valor_frete">Valor do Frete</label>
                    <input type="number" step="0.01" name="valor_frete" class="form-control" id="valor_frete" value="{{ $pagamento->valor_frete }}" required>
                </div>
                <div class="form-group">
                    <label for="valor_adiantamento">Valor do Adiantamento</label>
                    <input type="number" step="0.01" name="valor_adiantamento" class="form-control" id="valor_adiantamento" value="{{ $pagamento->valor_adiantamento }}">
                </div>
                <div class="form-group">
                    <label for="saldo_frete">Saldo de Frete</label>
                    <input type="number" step="0.01" name="saldo_frete" class="form-control" id="saldo_frete" value="{{ $pagamento->saldo_frete }}">
                </div>
                <button type="submit" class="btn btn-primary">Atualizar</button>
                <a href="{{ route('pagamentos.index') }}" class="btn btn-default">Cancelar</a>
            </form>
        </div>
    </div>
@stop
