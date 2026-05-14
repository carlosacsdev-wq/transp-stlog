@extends('adminlte::page')
 
@section('title', 'Editar Usuário')
 
@section('content_header')
    <h1>Editar Usuário</h1>
@stop
 
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Alterar Dados</h3>
            </div>
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Nome</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Nome completo" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="E-mail de acesso" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="password">Senha (deixe em branco para não alterar)</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Mínimo 8 caracteres">
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirmar Senha</label>
                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Repita a senha">
                    </div>
                </div>
 
                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">Atualizar</button>
                    <a href="{{ route('users.index') }}" class="btn btn-default float-right">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
