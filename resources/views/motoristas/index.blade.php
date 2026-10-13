@extends('adminlte::page')

@section('title', 'Motoristas')

@section('content_header')
<h1>Motoristas</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Relação de Motoristas</h3>
        <div class="card-tools">
            <a href="{{ url('/' . request()->route('tenant') . '/motoristas/create') }}" class="btn btn-primary btn-sm">Novo Motorista</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    {{-- <th>ID</th> --}}
                    <th>Nome</th>
                    <!-- <th>Apelido</th> -->
                    <!-- <th>Data de Nascimento</th> -->
                    <!-- <th>Nome da Mãe</th> -->
                    <!-- <th>Nome do Pai</th> -->
                    <!-- <th>RG</th> -->
                    <!-- <th>Data de Emissão do RG</th> -->
                    <th>CPF</th>
                    <!-- <th>CNH</th> -->
                    <!-- <th>Endereço</th> -->
                    <!-- <th>Bairro</th> -->
                    <!-- <th>Cidade</th> -->
                    <!-- <th>Estado</th> -->
                    <th>Telefone</th>
                    <!-- <th>Contato Pessoal 1</th> -->
                    <!-- <th>Contato Pessoal 2</th> -->
                    <!-- <th>Contato Pessoal 3</th> -->
                    <!-- <th>Contato Empresa 1</th> -->
                    <!-- <th>Contato Empresa 2</th> -->
                    <!-- <th>Contato Empresa 3</th> -->
                    <th style="width: 80px; text-align: center;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($motoristas as $motorista)
                    <tr>
                        {{-- <td>{{ $motorista->id }}</td> --}}
                        <td>{{ $motorista->nome }}</td>
                        <td>{{ $motorista->cpf }}</td>
                        <td>{{ $motorista->telefone }}</td>
                        <td style="text-align: center;">
                            <a href="{{ route('motoristas.edit', ['tenant' => request()->route('tenant'), 'motorista' => $motorista->id]) }}" class="btn btn-warning btn-sm"
                                title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            {{-- <form action="{{ route('motoristas.destroy', $motorista->id) }}" method="POST"
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
        {{ $motoristas->links() }}
    </div>
</div>
@stop