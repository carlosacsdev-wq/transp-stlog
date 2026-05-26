@extends('adminlte::page')

@section('title', 'Contas')

@section('content_header')
<h1>Contas Bancárias</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Relação das Contas dos Motoristas</h3>
        <div class="card-tools">
            <a href="{{ url('/' . request()->route('tenant') . '/contas/create') }}" class="btn btn-primary btn-sm">Nova Conta</a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    {{-- <th>ID</th> --}}
                    <th>Motorista</th>
                    <th>Banco</th>
                    <th>Agência</th>
                    <th>Conta</th>
                    <th>Chave PIX</th>
                    <th style="width: 80px; text-align: center;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contas as $conta)
                    <tr>
                        {{-- <td>{{ $conta->id }}</td> --}}
                        <td>{{ $conta->motorista->nome ?? 'N/A' }}</td>
                        <td>{{ $conta->banco }}</td>
                        <td>{{ $conta->agencia }}</td>
                        <td>{{ $conta->nro_conta }}</td>
                        <td>{{ $conta->chave_pix }}</td>
                        <td style="text-align: center;">
                            <a href="{{ route('contas.edit', ['tenant' => request()->route('tenant'), 'conta' => $conta->id]) }}" class="btn btn-warning btn-sm" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            {{-- <form action="{{ route('contas.destroy', $conta->id) }}" method="POST"
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
                        <td colspan="6" class="text-center">Nenhum registro encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        {{ $contas->links() }}
    </div>
</div>
@stop