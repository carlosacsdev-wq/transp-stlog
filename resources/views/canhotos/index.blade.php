@extends('adminlte::page')

@section('title', 'Canhotos')

@section('content_header')
    <h1>Canhotos (Comprovantes de Entrega)</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Acompanhamento de entrega documentação</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>CTe</th>
                        <th>DT</th>
                        <th>Motorista</th>
                        <th>Veículo</th>
                        {{-- <th>Data Descarga</th> --}}
                        <th>Status Canhoto</th>
                        <th style="width: 80px; text-align: center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($canhotos as $carga)
                        <tr>
                            <td>{{ $carga->cte ?? 'N/A' }}</td>
                            <td>{{ $carga->numero_dt }}</td>
                            <td>{{ $carga->motorista->nome ?? 'N/A' }}</td>
                            <td>{{ $carga->veiculo ? $carga->veiculo->placa_cavalo . ' / ' . $carga->veiculo->placa_carreta : 'N/A' }}</td>
                            {{-- <td>{{ $carga->data_hora_descarga ? \Carbon\Carbon::parse($carga->data_hora_descarga)->format('d/m/Y H:i') : '-' }}</td> --}}
                            <td style="text-align: center;">
                                @if($carga->status_canhoto == 'Entregue')
                                    <span class="badge badge-success">Entregue</span>
                                @else
                                    <span class="badge badge-warning">Pendente</span>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <a href="{{ route('canhotos.edit', $carga->id) }}" class="btn btn-warning btn-sm" title="Editar Status">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Nenhum registro encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $canhotos->links() }}
        </div>
    </div>
@stop
