@extends('adminlte::page')

@section('title', 'Informar Documentos')

@section('content_header')
    <h1>Informar Documentos Fiscais</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Carga DT: {{ $carregamento->numero_dt }}</h3>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row mb-4">
                <div class="col-md-4">
                    <strong>Motorista:</strong> {{ $carregamento->motorista->nome ?? 'N/A' }}
                </div>
                <div class="col-md-4">
                    <strong>Veículo:</strong> {{ $carregamento->veiculo ? $carregamento->veiculo->placa_cavalo . ' / ' . $carregamento->veiculo->placa_carreta : 'N/A' }}
                </div>
                <div class="col-md-4">
                    <strong>Cliente:</strong> {{ $carregamento->cliente }}
                </div>
            </div>

            <form action="{{ route('carregamentos.update', $carregamento->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="data_carregamento">Data/Hora Efetiva de Carregamento</label>
                    <input type="datetime-local" name="data_carregamento" class="form-control" id="data_carregamento"
                        value="{{ old('data_carregamento') ?? ($carregamento->data_carregamento ? date('Y-m-d\TH:i', strtotime($carregamento->data_carregamento)) : '') }}" required>
                    <small class="text-muted">Informe a data e hora em que o carregamento foi concluído.</small>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="cte">Número do CTE</label>
                        <input type="text" name="cte" class="form-control" id="cte" value="{{ old('cte') ?? $carregamento->cte }}" placeholder="Digite o número do CTE">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="mdfe">Número do MDFE</label>
                        <input type="text" name="mdfe" class="form-control" id="mdfe" value="{{ old('mdfe') ?? $carregamento->mdfe }}" placeholder="Digite o número do MDFE">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Salvar Documentos</button>
                <a href="{{ route('carregamentos.index') }}" class="btn btn-default">Voltar</a>
            </form>
        </div>
    </div>
@stop
