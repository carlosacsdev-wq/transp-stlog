@extends('adminlte::page')

@section('title', 'Diárias')

@section('content_header')
<h1>Diárias</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Conferência de Diárias</h3>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form action="{{ route('financeiro.diarias.index', ['tenant' => request()->route('tenant')]) }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="fabrica">Filtrar por Fábrica</label>
                        <select name="fabrica" id="fabrica" class="form-control" onchange="this.form.submit()">
                            <option value="">Todas as fábricas</option>
                            @foreach(['Alagoinhas', 'Igarassu', 'Benevides', 'Caxias'] as $fabrica)
                                <option value="{{ $fabrica }}" {{ request('fabrica') === $fabrica ? 'selected' : '' }}>
                                    {{ $fabrica }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <div class="form-group">
                        <a href="{{ route('financeiro.diarias.index', ['tenant' => request()->route('tenant')]) }}" class="btn btn-secondary">Limpar</a>
                    </div>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>DT</th>
                        <th>Fábrica</th>
                        <th>Data Carreg.</th>
                        <th>Cliente</th>
                        <th>Veículo</th>
                        <th>Diárias</th>
                        <th>CTe</th>
                        <th>Motorista</th>
                        <th>Aprovação</th>
                        <th>Pagto</th>
                        <th style="min-width: 150px; text-align: center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($viagens as $viagem)
                        <tr>
                            <td>{{ $viagem->numero_dt }}</td>
                            <td>{{ $viagem->fabrica ?? 'N/A' }}</td>
                            <td>{{ $viagem->data_carregamento ? \Carbon\Carbon::parse($viagem->data_carregamento)->format('d/m/Y H:i') : 'N/A' }}</td>
                            <td>{{ $viagem->cliente }}</td>
                            <td>{{ optional($viagem->motorista?->veiculos->firstWhere('tipo', 'cavalo'))->placa ?? 'N/A' }} / {{ optional($viagem->motorista?->veiculos->firstWhere('tipo', 'carreta'))->placa ?? 'N/A' }}</td>
                            <td>{{ $viagem->diarias }}</td>
                            <td>{{ $viagem->cte }}</td>
                            <td>{{ $viagem->motorista->nome ?? 'N/A' }}</td>
                            <td>
                                @if($viagem->diarias_aprovadas_em)
                                    <span class="badge badge-success">Aprovada</span>
                                @else
                                    <span class="badge badge-warning">Pendente</span>
                                @endif
                            </td>
                            <td>
                                @if($viagem->diarias_status_pagamento === 'Pago')
                                    <span class="badge badge-success">Pago</span>
                                @else
                                    <span class="badge badge-secondary">Pendente</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @can('gerenciar-diarias')
                                    @if(!$viagem->diarias_aprovadas_em)
                                        <a href="{{ route('financeiro.diarias.edit', ['tenant' => request()->route('tenant'), 'viagem' => $viagem->id]) }}" class="btn btn-warning btn-sm" title="Editar diárias">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('financeiro.diarias.approve', ['tenant' => request()->route('tenant'), 'viagem' => $viagem->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" title="Aprovar para pagamento" onclick="return confirm('Aprovar {{ $viagem->diarias }} diária(s) para pagamento?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">Aprovada em {{ $viagem->diarias_aprovadas_em->format('d/m/Y H:i') }}</span>
                                        @if($viagem->diarias_status_pagamento !== 'Pago')
                                            <form action="{{ route('financeiro.diarias.pay', ['tenant' => request()->route('tenant'), 'viagem' => $viagem->id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm" title="Marcar diárias como pagas" onclick="return confirm('Marcar as diárias como pagas?')">
                                                    <i class="fas fa-money-bill-wave"></i> Marcar pago
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                @else
                                    <span class="text-muted">—</span>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center">Nenhum registro encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer clearfix">
        {{ $viagens->appends(request()->query())->links() }}
    </div>
</div>
@stop
