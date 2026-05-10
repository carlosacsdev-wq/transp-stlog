@extends('adminlte::page')

@section('title', 'Editar Carga')

@section('content_header')
    <h1>Editar Carga</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('cargas.update', $carga->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="motorista_id">Motorista</label>
                    <select name="motorista_id" class="form-control" id="motorista_id">
                        <option value="">Selecione um motorista</option>
                        @foreach($motoristas as $motorista)
                            <option value="{{ $motorista->id }}" {{ $carga->motorista_id == $motorista->id ? 'selected' : '' }}>
                                {{ $motorista->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="veiculo_id">Veículo</label>
                    <select name="veiculo_id" class="form-control" id="veiculo_id">
                        <option value="">Selecione um veículo</option>
                        @foreach($veiculos as $veiculo)
                            <option value="{{ $veiculo->id }}" {{ $carga->veiculo_id == $veiculo->id ? 'selected' : '' }}>
                                {{ $veiculo->placa_cavalo }} / {{ $veiculo->placa_carreta }} ({{ $veiculo->motorista->nome }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="numero_dt">Número do DT</label>
                    <input type="text" name="numero_dt" class="form-control" id="numero_dt" value="{{ $carga->numero_dt }}" required>
                </div>
                <div class="form-group">
                    <label for="data_carregamento">Data de Carregamento</label>
                    <input type="date" name="data_carregamento" class="form-control" id="data_carregamento" value="{{ $carga->data_carregamento }}" required>
                </div>
                <div class="form-group">
                    <label for="data_agendamento_descarga">Data de Agendamento de Descarga</label>
                    <input type="date" name="data_agendamento_descarga" class="form-control" id="data_agendamento_descarga" value="{{ $carga->data_agendamento_descarga }}" required>
                </div>
                <div class="form-group">
                    <label for="status">Status da Carga</label>
                    <select name="status" class="form-control" id="status" required>
                        <option value="Pendente" {{ $carga->status == 'Pendente' ? 'selected' : '' }}>Pendente</option>
                        <option value="Comprometida" {{ $carga->status == 'Comprometida' ? 'selected' : '' }}>Comprometida</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="cliente">Nome do Cliente</label>
                    <input type="text" name="cliente" class="form-control" id="cliente" value="{{ $carga->cliente }}" required>
                </div>
                <div class="form-group">
                    <label for="valor_frete">Valor do Frete (Motorista)</label>
                    <input type="number" step="0.01" name="valor_frete" class="form-control" id="valor_frete" value="{{ $carga->valor_frete }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Atualizar</button>
                <a href="{{ route('cargas.index') }}" class="btn btn-default">Cancelar</a>
            </form>
        </div>
    </div>
@stop
