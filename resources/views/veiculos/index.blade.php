@extends('adminlte::page')

@section('title', 'Veículos')

@section('content_header')
<h1>Veículos</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Relação de Veículos</h3>
        <div class="card-tools">
            <a href="{{ url('/' . request()->route('tenant') . '/veiculos/create') }}" class="btn btn-primary btn-sm">Novo Veículo</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    {{-- <th>ID</th> --}}
                    <th>Motorista</th>
                    <th>Placa Cavalo</th>
                    <th>Placa Carreta</th>
                    <!-- <th>Proprietário</th> -->
                    <!-- <th>Endereço do Proprietário</th> -->
                    <!-- <th>Cidade</th> -->
                    <!-- <th>UF</th> -->
                    <!-- <th>Modelo</th> -->
                    <!-- <th>Marca</th> -->
                    <!-- <th>Chassi</th> -->
                    <!-- <th>Renavam</th> -->
                    <!-- <th>Ano de Fabricação</th> -->
                    <!-- <th>Ano do Modelo</th> -->
                    <!-- <th>Cidade de Emissão</th> -->
                    <!-- <th>UF de Emissão</th> -->
                    <th style="width: 80px; text-align: center;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($veiculos as $veiculo)
                    <tr>
                        {{-- <td>{{ $veiculo->id }}</td> --}}
                        <td>{{ $veiculo->motorista->nome }}</td>
                        <td>{{ $veiculo->placa_cavalo }}</td>
                        <td>{{ $veiculo->placa_carreta }}</td>
                        <td style="text-align: center;">
                            <a href="{{ route('veiculos.edit', ['tenant' => request()->route('tenant'), 'veiculo' => $veiculo->id]) }}" class="btn btn-warning btn-sm"
                                title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            {{-- <form action="{{ route('veiculos.destroy', $veiculo->id) }}" method="POST"
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
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Nenhum registro encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        {{ $veiculos->links() }}
    </div>
</div>
@stop