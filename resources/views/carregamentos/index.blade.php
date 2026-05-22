@extends('adminlte::page')

@section('title', 'Carregamentos')

@section('content_header')
<h1>Carregamentos</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Controle de carregamentos</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('carregamentos.index') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="fabrica">Filtrar por Fábrica</label>
                        <select name="fabrica" id="fabrica" class="form-control" onchange="this.form.submit()">
                            <option value="">Todas as fábricas</option>
                            <option value="Alagoinhas" {{ request('fabrica') == 'Alagoinhas' ? 'selected' : '' }}>
                                Alagoinhas
                            </option>
                            <option value="Igarassu" {{ request('fabrica') == 'Igarassu' ? 'selected' : '' }}>Igarassu
                            </option>
                            <option value="Benevides" {{ request('fabrica') == 'Benevides' ? 'selected' : '' }}>Benevides
                            </option>
                            <option value="Caxias" {{ request('fabrica') == 'Caxias' ? 'selected' : '' }}>Caxias</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <div class="form-group">
                        <a href="{{ route('carregamentos.index') }}" class="btn btn-secondary">Limpar</a>
                    </div>
                </div>
            </div>
        </form>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Motorista</th>
                    <th>Veículo</th>
                    <th>DT</th>
                    <th>Data Carreg.</th>
                    <th>Data Agend.</th>
                    <th>Cliente</th>
                    <th>CT-e</th>
                    <th>MDF-e</th>
                    <th style="width: 80px; text-align: center;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cargas as $carga)
                    <tr>
                        <td>{{ $carga->motorista->nome ?? 'N/A' }}</td>
                        <td>{{ $carga->veiculo ? $carga->veiculo->placa_cavalo . ' / ' . $carga->veiculo->placa_carreta : 'N/A' }}
                        </td>
                        <td>{{ $carga->numero_dt }}</td>
                        <td>{{ $carga->data_carregamento ? \Carbon\Carbon::parse($carga->data_carregamento)->format('d/m/Y H:i') : 'N/A' }}
                        </td>
                        <td>{{ $carga->data_agendamento_descarga ? \Carbon\Carbon::parse($carga->data_agendamento_descarga)->format('d/m/Y H:i') : 'N/A' }}
                        </td>
                        <td>{{ $carga->cliente }}</td>
                        <td>{{ $carga->cte ?: 'Pendente' }}</td>
                        <td>{{ $carga->mdfe ?: 'Pendente' }}</td>
                        <td style="text-align: center;">
                            <a href="{{ route('carregamentos.coleta', $carga->id) }}" target="_blank"
                                class="btn btn-info btn-sm" title="Gerar Ordem de Coleta">
                                <i class="fas fa-print"></i>
                            </a>
                            <a href="{{ route('carregamentos.edit', $carga->id) }}" class="btn btn-warning btn-sm"
                                title="Editar Carregamento">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">Nenhum registro encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        {{ $cargas->appends(request()->query())->links() }}
    </div>
</div>
@stop