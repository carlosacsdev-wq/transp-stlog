@extends('adminlte::page')

@section('title', 'Editar Conta')

@section('content_header')
    <h1>Editar Conta Bancária</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('contas.update', ['tenant' => request()->route('tenant'), 'conta' => $conta->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Motorista</label>
                        <select name="motorista_id" class="form-control" required>
                            <option value="">Selecione um Motorista</option>
                            @foreach($motoristas as $motorista)
                                <option value="{{ $motorista->id }}" {{ (old('motorista_id') ?? $conta->motorista_id) == $motorista->id ? 'selected' : '' }}>
                                    {{ $motorista->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Titular</label>
                        <input type="text" name="titular" class="form-control" value="{{ old('titular') ?? $conta->titular }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>CPF/CNPJ do Titular</label>
                        <input type="text" name="cpf_cnpj_titular" class="form-control" value="{{ old('cpf_cnpj_titular') ?? $conta->cpf_cnpj_titular }}" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Banco</label>
                        <input type="text" name="banco" class="form-control" value="{{ old('banco') ?? $conta->banco }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Agência</label>
                        <input type="text" name="agencia" class="form-control" value="{{ old('agencia') ?? $conta->agencia }}" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Tipo de Conta</label>
                        <input type="text" name="tipo_conta" class="form-control" value="{{ old('tipo_conta') ?? $conta->tipo_conta }}" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Número da Conta</label>
                        <input type="text" name="nro_conta" class="form-control" value="{{ old('nro_conta') ?? $conta->nro_conta }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Tipo de Chave PIX</label>
                        <input type="text" name="tipo_chave" class="form-control" value="{{ old('tipo_chave') ?? $conta->tipo_chave }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Chave PIX</label>
                        <input type="text" name="chave_pix" class="form-control" value="{{ old('chave_pix') ?? $conta->chave_pix }}">
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Atualizar</button>
                <a href="{{ route('contas.index', ['tenant' => request()->route('tenant')]) }}" class="btn btn-default">Cancelar</a>
            </form>
        </div>
    </div>
@stop
