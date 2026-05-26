@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
<h1>Usuários</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Relação de Usuários do Sistema</h3>

        <div class="card-tools">
            <a href="{{ url('/' . request()->route('tenant') . '/users/create') }}" class="btn btn-primary btn-sm">Novo Usuário</a>
        </div>
    </div>
    {{-- <p style="font-size: 12px;color: red;margin-left: 20px; margin-right: 20px;margin-top: 5px;">Em caso de
        desligamento do usuário,
        deve-se excluir o mesmo
        no
        cadastro
        de usuários.
    </p> --}}
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th style="width: 100px; text-align: center;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td style="text-align: center; white-space: nowrap;">
                            <a href="{{ route('users.edit', ['tenant' => request()->route('tenant'), 'user' => $user->id]) }}" class="btn btn-warning btn-sm" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('users.destroy', ['tenant' => request()->route('tenant'), 'user' => $user->id]) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')"
                                    title="Excluir">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Nenhum registro encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        {{ $users->links() }}
    </div>
</div>
@stop