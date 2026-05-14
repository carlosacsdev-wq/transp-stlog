@extends('adminlte::page')

@section('title', 'Informar Pagamento')

@section('content_header')
    <h1>Informar Dados de Pagamento</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Resumo da Carga</h3>
                </div>
                <div class="card-body">
                    <p><strong>Motorista:</strong> {{ $pagamento->motorista->nome ?? 'N/A' }}</p>
                    <p><strong>Veículo:</strong> {{ $pagamento->veiculo ? $pagamento->veiculo->placa_cavalo : 'N/A' }}</p>
                    <p><strong>CTe:</strong> {{ $pagamento->cte }}</p>
                    <p><strong>DT:</strong> {{ $pagamento->numero_dt }}</p>
                    <p><strong>Valor Frete:</strong> R$ {{ number_format($pagamento->valor_frete, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Dados Financeiros</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('pagamentos.update', $pagamento->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="tipo_solicitacao">O que está sendo solicitado?</label>
                            <select name="tipo_solicitacao" class="form-control @error('tipo_solicitacao') is-invalid @enderror" id="tipo_solicitacao" required>
                                <option value="">Selecione...</option>
                                <option value="Adiantamento" {{ $pagamento->tipo_solicitacao == 'Adiantamento' ? 'selected' : '' }}>Adiantamento</option>
                                <option value="Saldo" {{ $pagamento->tipo_solicitacao == 'Saldo' ? 'selected' : '' }}>Saldo Restante</option>
                                <option value="Ambos" {{ $pagamento->tipo_solicitacao == 'Ambos' ? 'selected' : '' }}>Ambos (Total)</option>
                                <option value="Pago" {{ $pagamento->tipo_solicitacao == 'Pago' ? 'selected' : '' }}>Marcar como PAGO (Finalizado)</option>
                            </select>
                            @error('tipo_solicitacao')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <div class="mt-2">
                                <strong>Status do Canhoto:</strong> 
                                @if($pagamento->status_canhoto == 'Entregue')
                                    <span class="badge badge-success">Entregue</span>
                                @else
                                    <span class="badge badge-warning">Pendente</span>
                                    <small class="text-danger d-block mt-1"><i class="fas fa-exclamation-triangle"></i> O Saldo não pode ser solicitado até que o canhoto seja entregue.</small>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="data_pagamento">Data de Pagamento</label>
                            <input type="date" name="data_pagamento" class="form-control" id="data_pagamento" value="{{ $pagamento->data_pagamento }}" required>
                        </div>

                        <div class="form-group">
                            <label for="valor_adiantamento">Valor do Adiantamento</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">R$</span>
                                </div>
                                <input type="number" step="0.01" name="valor_adiantamento" class="form-control" id="valor_adiantamento" value="{{ $pagamento->valor_adiantamento }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="valor_saldo">Saldo de Frete</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">R$</span>
                                </div>
                                <input type="number" step="0.01" name="valor_saldo" class="form-control" id="valor_saldo" value="{{ $pagamento->valor_saldo }}">
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Salvar Informações</button>
                            <a href="{{ route('pagamentos.index') }}" class="btn btn-default">Voltar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
