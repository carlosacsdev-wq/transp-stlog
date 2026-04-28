@extends('adminlte::page')

@section('title', 'Nova Carga')

@section('content_header')
    <h1>Nova Carga</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('cargas.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="numero_dt">Número do DT</label>
                    <input type="text" name="numero_dt" class="form-control" id="numero_dt" placeholder="Número do DT" required>
                </div>
                <div class="form-group">
                    <label for="data_carregamento">Data de Carregamento</label>
                    <input type="date" name="data_carregamento" class="form-control" id="data_carregamento" required>
                </div>
                <div class="form-group">
                    <label for="data_agendamento_descarga">Data de Agendamento de Descarga</label>
                    <input type="date" name="data_agendamento_descarga" class="form-control" id="data_agendamento_descarga" required>
                </div>
                <div class="form-group">
                    <label for="cliente">Nome do Cliente</label>
                    <input type="text" name="cliente" class="form-control" id="cliente" placeholder="Nome do cliente" required>
                </div>
                <div class="form-group">
                    <label for="valor_frete">Valor do Frete (Motorista)</label>
                    <input type="number" step="0.01" name="valor_frete" class="form-control" id="valor_frete" placeholder="0.00" required>
                </div>
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ route('cargas.index') }}" class="btn btn-default">Cancelar</a>
            </form>
        </div>
    </div>
@stop
