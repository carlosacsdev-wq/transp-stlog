@extends('adminlte::page')

@section('title', 'Editar Canhoto')

@section('content_header')
    <h1>Atualizar Status do Canhoto</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Carga: {{ $canhoto->cte }} / DT: {{ $canhoto->numero_dt }}</h3>
                </div>
                <form action="{{ route('canhotos.update', ['tenant' => request()->route('tenant'), 'canhoto' => $canhoto->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>CTe</label>
                                    <input type="text" class="form-control" value="{{ $canhoto->cte ?? 'N/A' }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>DT</label>
                                    <input type="text" class="form-control" value="{{ $canhoto->numero_dt ?? 'N/A' }}" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Motorista</label>
                            <input type="text" class="form-control" value="{{ $canhoto->motorista->nome ?? 'N/A' }}" disabled>
                        </div>

                        <div class="form-group">
                            <label>Veículo</label>
                            <input type="text" class="form-control" value="{{ $canhoto->veiculo ? ucfirst($canhoto->veiculo->tipo) . ' - ' . $canhoto->veiculo->placa : 'N/A' }}" disabled>
                        </div>
                        
                        <div class="form-group">
                            <label for="status_canhoto">Status do Canhoto</label>
                            <select name="status_canhoto" id="status_canhoto" class="form-control @error('status_canhoto') is-invalid @enderror">
                                <option value="Pendente" {{ $canhoto->status_canhoto == 'Pendente' ? 'selected' : '' }}>Pendente</option>
                                <option value="Entregue" {{ $canhoto->status_canhoto == 'Entregue' ? 'selected' : '' }}>Entregue</option>
                            </select>
                            @error('status_canhoto')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <h5><i class="icon fas fa-info"></i> Atenção!</h5>
                            O pagamento do saldo só será liberado no módulo financeiro após o canhoto ser marcado como <strong>Entregue</strong>.
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <a href="{{ route('canhotos.index', ['tenant' => request()->route('tenant')]) }}" class="btn btn-default">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
