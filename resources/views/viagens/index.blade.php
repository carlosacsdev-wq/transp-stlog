@extends('adminlte::page')

@section('title', 'Viagens')

@section('content_header')
<h1>Viagens</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Listagem de Viagens</h3>
        <div class="card-tools">
            <a href="{{ route('viagens.create') }}" class="btn btn-primary btn-sm">Nova Viagem</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    {{-- <th>ID</th> --}}
                    <th>DT</th>
                    <th>Carregamento</th>
                    <th>Cliente</th>
                    <th>Veículo</th>
                    <th>Chegada</th>
                    <th>Descarga</th>
                    {{-- <th>Valor Frete</th> --}}
                    <th>CTe</th>
                    <th>Motorista</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($viagens as $viagem)
                    <tr>
                        {{-- <td>{{ $viagem->id }}</td> --}}
                        <td>{{ $viagem->numero_dt }}</td>
                        <td>{{ $viagem->data_carregamento ? \Carbon\Carbon::parse($viagem->data_carregamento)->format('d/m/Y H:i') : 'N/A' }}
                        </td>
                        <td>{{ $viagem->cliente }}</td>

                        <td>{{ $viagem->veiculo ? $viagem->veiculo->placa_cavalo . ' / ' . $viagem->veiculo->placa_carreta : 'N/A' }}
                        </td>
                        <td>{{ $viagem->data_hora_chegada ? \Carbon\Carbon::parse($viagem->data_hora_chegada)->format('d/m/Y H:i') : 'Pendente' }}
                        </td>
                        <td>{{ $viagem->data_hora_descarga ? \Carbon\Carbon::parse($viagem->data_hora_descarga)->format('d/m/Y H:i') : 'Pendente' }}
                        </td>

                        {{-- <td>R$ {{ number_format($viagem->valor_frete, 2, ',', '.') }}</td> --}}
                        <td>{{ $viagem->cte }}</td>
                        <td>{{ $viagem->motorista->nome ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('viagens.edit', $viagem->id) }}" class="btn btn-warning btn-sm"
                                title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            {{-- <form action="{{ route('viagens.destroy', $viagem->id) }}" method="POST"
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
        {{ $viagens->links() }}
    </div>
</div>
@stop