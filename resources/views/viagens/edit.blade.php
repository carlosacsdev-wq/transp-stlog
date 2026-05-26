@extends('adminlte::page')

@section('title', 'Editar Viagem')

@section('content_header')
<h1>Editar Viagem</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('viagens.update', ['tenant' => request()->route('tenant'), 'viagem' => $viagem->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="motorista_id">Motorista</label>
                <select name="motorista_id" class="form-control" id="motorista_id" required>
                    <option value="">Selecione um motorista</option>
                    @foreach($motoristas as $motorista)
                        <option value="{{ $motorista->id }}" {{ $viagem->motorista_id == $motorista->id ? 'selected' : '' }}>
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
                        <option value="{{ $veiculo->id }}" {{ $viagem->veiculo_id == $veiculo->id ? 'selected' : '' }}>
                            {{ $veiculo->placa_cavalo }} / {{ $veiculo->placa_carreta }} ({{ $veiculo->motorista->nome }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="data_carregamento">Data de Carreg.</label>
                <input type="datetime-local" name="data_carregamento" class="form-control" id="data_carregamento"
                    value="{{ $viagem->data_carregamento ? date('Y-m-d\TH:i', strtotime($viagem->data_carregamento)) : '' }}"
                    required>
            </div>
            <div class="form-group">
                <label for="data_hora_chegada">Data de Cheg.</label>
                <input type="datetime-local" name="data_hora_chegada" class="form-control" id="data_hora_chegada"
                    value="{{ $viagem->data_hora_chegada ? date('Y-m-d\TH:i', strtotime($viagem->data_hora_chegada)) : '' }}">
            </div>
            <div class="form-group">
                <label for="data_hora_descarga">Data de Descarga.</label>
                <input type="datetime-local" name="data_hora_descarga" class="form-control" id="data_hora_descarga"
                    value="{{ $viagem->data_hora_descarga ? date('Y-m-d\TH:i', strtotime($viagem->data_hora_descarga)) : '' }}">
            </div>
            <div class="form-group">
                <label for="cte">CTe da Carga</label>
                <input type="text" name="cte" class="form-control" id="cte" value="{{ $viagem->cte }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('viagens.index', ['tenant' => request()->route('tenant')]) }}" class="btn btn-default">Cancelar</a>
        </form>
    </div>
</div>
@stop