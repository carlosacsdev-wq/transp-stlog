@extends('adminlte::page')

@section('title', 'Nova Viagem')

@section('content_header')
    <h1>Nova Viagem</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('viagens.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="data_hora_carregamento">Data/Hora Carregamento</label>
                    <input type="datetime-local" name="data_hora_carregamento" class="form-control" id="data_hora_carregamento" required>
                </div>
                <div class="form-group">
                    <label for="data_hora_chegada">Data/Hora Chegada Cliente</label>
                    <input type="datetime-local" name="data_hora_chegada" class="form-control" id="data_hora_chegada">
                </div>
                <div class="form-group">
                    <label for="data_hora_descarga">Data/Hora Descarga Cliente</label>
                    <input type="datetime-local" name="data_hora_descarga" class="form-control" id="data_hora_descarga">
                </div>
                <div class="form-group">
                    <label for="nome_motorista">Nome do Motorista</label>
                    <input type="text" name="nome_motorista" class="form-control" id="nome_motorista" placeholder="Nome do motorista" required>
                </div>
                <div class="form-group">
                    <label for="cte">CTe da Carga</label>
                    <input type="text" name="cte" class="form-control" id="cte" placeholder="Número do CTe" required>
                </div>
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ route('viagens.index') }}" class="btn btn-default">Cancelar</a>
            </form>
        </div>
    </div>
@stop
