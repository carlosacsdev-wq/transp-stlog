@extends('adminlte::page')

@section('title', 'Cargas')

@section('content_header')
<h1>Programação</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Cargas programadas</h3>
        @if(auth()->user()->is_admin)
            <div class="card-tools">
                <a href="{{ route('cargas.create') }}" class="btn btn-primary btn-sm">Nova Carga</a>
            </div>
        @endif
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    {{-- <th>ID</th> --}}
                    <th>Motorista</th>
                    <th>Veículo</th>
                    <th>DT</th>
                    <th>Fábrica</th>
                    <th>Data Carreg.</th>
                    <th>Data Agend.</th>
                    <th>Cliente</th>
                    <th>Vr. Frete</th>
                    <th>Status</th>
                    <th style="width: 80px; text-align: center;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cargas as $carga)
                    <tr>
                        {{-- <td>{{ $carga->id }}</td> --}}
                        <td>{{ $carga->motorista->nome ?? 'N/A' }}</td>
                        <td>{{ $carga->veiculo ? $carga->veiculo->placa_cavalo . ' / ' . $carga->veiculo->placa_carreta : 'N/A' }}
                        </td>
                        <td>{{ $carga->numero_dt }}</td>
                        <td>{{ $carga->fabrica ?? 'N/A' }}</td>
                        <td>{{ $carga->data_carregamento ? \Carbon\Carbon::parse($carga->data_carregamento)->format('d/m/Y H:i') : 'N/A' }}
                        </td>
                        <td>{{ $carga->data_agendamento_descarga ? \Carbon\Carbon::parse($carga->data_agendamento_descarga)->format('d/m/Y H:i') : 'N/A' }}
                        </td>
                        <td>{{ $carga->cliente }}</td>
                        <td>R$ {{ number_format($carga->valor_frete, 2, ',', '.') }}</td>
                        <td>
                            @php
                                $badgeClass = match ($carga->status) {
                                    'Comprometida' => 'success',
                                    'Pendente' => 'warning',
                                    'Cancelada' => 'danger',
                                    'Declinada' => 'secondary',
                                    'Retirada' => 'primary',
                                    default => 'info'
                                };
                            @endphp
                            <span class="badge badge-{{ $badgeClass }}">{{ $carga->status }}</span>
                        </td>
                        <td style="text-align: center;">
                            <a href="{{ route('cargas.edit', $carga->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            {{-- <form action="{{ route('cargas.destroy', $carga->id) }}" method="POST"
                                style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')"
                                    title="Excluir">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        {{ $cargas->links() }}
    </div>
</div>
@stop