@extends('adminlte::page')

@section('title', 'Editar Diárias')

@section('content_header')
<h1>Editar Diárias</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Conferência da viagem {{ $viagem->numero_dt }}</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4"><p><strong>Fábrica:</strong> {{ $viagem->fabrica ?? 'N/A' }}</p></div>
            <div class="col-md-4"><p><strong>Cliente:</strong> {{ $viagem->cliente }}</p></div>
            <div class="col-md-4"><p><strong>CTe:</strong> {{ $viagem->cte }}</p></div>
            <div class="col-md-4"><p><strong>Motorista:</strong> {{ $viagem->motorista->nome ?? 'N/A' }}</p></div>
            <div class="col-md-4"><p><strong>Veículo:</strong> {{ optional($viagem->motorista?->veiculos->firstWhere('tipo', 'cavalo'))->placa ?? 'N/A' }} / {{ optional($viagem->motorista?->veiculos->firstWhere('tipo', 'carreta'))->placa ?? 'N/A' }}</p></div>
            <div class="col-md-4"><p><strong>Data Carreg.:</strong> {{ $viagem->data_carregamento ? \Carbon\Carbon::parse($viagem->data_carregamento)->format('d/m/Y H:i') : 'N/A' }}</p></div>
            <div class="col-md-4"><p><strong>Data Chegada:</strong> {{ $viagem->data_hora_chegada ? \Carbon\Carbon::parse($viagem->data_hora_chegada)->format('d/m/Y H:i') : 'Pendente' }}</p></div>
            <div class="col-md-4"><p><strong>Data Descarga:</strong> {{ $viagem->data_hora_descarga ? \Carbon\Carbon::parse($viagem->data_hora_descarga)->format('d/m/Y H:i') : 'Pendente' }}</p></div>
        </div>
        <form action="{{ route('financeiro.diarias.update', ['tenant' => request()->route('tenant'), 'viagem' => $viagem->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="diarias">Quantidade de diárias</label>
                <input type="number" name="diarias" id="diarias" class="form-control @error('diarias') is-invalid @enderror" min="0" step="1" value="{{ old('diarias', $viagem->diarias) }}" required>
                @error('diarias')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Salvar diárias</button>
            <a href="{{ route('financeiro.diarias.index', ['tenant' => request()->route('tenant')]) }}" class="btn btn-default">Cancelar</a>
        </form>
    </div>
</div>
@stop
