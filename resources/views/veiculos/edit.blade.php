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
                            <option value="{{ $motorista->id }}" {{ $veiculo->motorista_id == $motorista->id ? 'selected' : '' }}>
                                {{ $motorista->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="placa_cavalo">Placa Cavalo</label>
                    <input type="text" name="placa_cavalo" class="form-control" id="placa_cavalo" value="{{ $veiculo->placa_cavalo }}" required>
                </div>
                <div class="form-group">
                    <label for="placa_carreta">Placa Carreta</label>
                    <input type="text" name="placa_carreta" class="form-control" id="placa_carreta" value="{{ $veiculo->placa_carreta }}" required>
                </div>
                <div class="form-group">
                    <label for="modelo">Modelo</label>
                    <input type="text" name="modelo" class="form-control" id="modelo" value="{{ $veiculo->modelo }}">
                </div>
                <div class="form-group">
                    <label for="marca">Marca</label>
                    <input type="text" name="marca" class="form-control" id="marca" value="{{ $veiculo->marca }}">
                </div>
                <button type="submit" class="btn btn-primary">Atualizar</button>
                <a href="{{ route('veiculos.index', ['tenant' => request()->route('tenant')]) }}" class="btn btn-default">Cancelar</a>
            </form>
        </div>
    </div>
@stop
