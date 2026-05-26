@extends('adminlte::page')

@section('title', 'Novo Pagamento')

@section('content_header')
    <h1>Novo Pagamento</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('pagamentos.store', ['tenant' => request()->route('tenant')]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="motorista_id">Motorista</label>
                    <select name="motorista_id" class="form-control" id="motorista_id" required>
                        <option value="">Selecione um motorista</option>
                        @foreach($motoristas as $motorista)
                            <option value="{{ $motorista->id }}">{{ $motorista->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="veiculo_id">Veículo</label>
                    <select name="veiculo_id" class="form-control" id="veiculo_id" required>
                        <option value="">Selecione um veículo</option>
                        @foreach($veiculos as $veiculo)
                            <option value="{{ $veiculo->id }}">{{ $veiculo->placa_cavalo }} / {{ $veiculo->placa_carreta }} ({{ $veiculo->motorista->nome }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="cte">CTe</label>
                    <input type="text" name="cte" class="form-control" id="cte" placeholder="Número do CTe" required>
                </div>
                <div class="form-group">
                    <label for="dt">DT</label>
                    <input type="text" name="dt" class="form-control" id="dt" placeholder="Número do DT" required>
                </div>
                <div class="form-group">
                    <label for="data_pagamento">Data de Pagamento</label>
                    <input type="date" name="data_pagamento" class="form-control" id="data_pagamento" required>
                </div>
                <div class="form-group">
                    <label for="valor_frete">Valor do Frete</label>
                    <input type="number" step="0.01" name="valor_frete" class="form-control" id="valor_frete" placeholder="0.00" required>
                </div>
                <div class="form-group">
                    <label for="valor_adiantamento">Valor do Adiantamento</label>
                    <input type="number" step="0.01" name="valor_adiantamento" class="form-control" id="valor_adiantamento" placeholder="0.00">
                </div>
                <div class="form-group">
                    <label for="saldo_frete">Saldo de Frete</label>
                    <input type="number" step="0.01" name="saldo_frete" class="form-control" id="saldo_frete" placeholder="0.00">
                </div>
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ route('pagamentos.index', ['tenant' => request()->route('tenant')]) }}" class="btn btn-default">Cancelar</a>
            </form>
        </div>
    </div>
@stop
