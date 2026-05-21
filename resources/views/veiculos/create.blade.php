@extends('adminlte::page')

@section('title', 'Novo Veículo')

@section('content_header')
<h1>Novo Veículo</h1>
<p style="font-size: 12px; color: rgb(200, 10, 10);">Trata-se de um cadastro minimalista, contendo apenas os dados
    necessarios para fins demonstrativos.</p>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('veiculos.store') }}" method="POST">
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
                <label for="placa_cavalo">Placa Cavalo</label>
                <input type="text" name="placa_cavalo" class="form-control" id="placa_cavalo" placeholder="ABC-1234"
                    required>
            </div>
            <div class="form-group">
                <label for="placa_carreta">Placa Carreta</label>
                <input type="text" name="placa_carreta" class="form-control" id="placa_carreta" placeholder="XYZ-5678"
                    required>
            </div>
            <div class="form-group">
                <label for="modelo">Modelo</label>
                <input type="text" name="modelo" class="form-control" id="modelo" placeholder="Modelo do veículo">
            </div>
            <div class="form-group">
                <label for="marca">Marca</label>
                <input type="text" name="marca" class="form-control" id="marca" placeholder="Marca do veículo">
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('veiculos.index') }}" class="btn btn-default">Cancelar</a>
        </form>
    </div>
</div>
@stop