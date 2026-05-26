@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')

<!-- Filtros -->
<div class="card card-outline card-primary mb-4">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-filter"></i> Filtros do Dashboard</h3>
    </div>
    <div class="card-body">
        <form action="{{ url()->current() }}" method="GET">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Data Início (Carregamento)</label>
                        <input type="date" name="data_inicio" class="form-control" value="{{ request('data_inicio') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Data Fim (Carregamento)</label>
                        <input type="date" name="data_fim" class="form-control" value="{{ request('data_fim') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Fábrica</label>
                        <select name="fabrica" class="form-control">
                            <option value="">Todas as Fábricas</option>
                            @foreach($fabricas as $fabrica)
                                <option value="{{ $fabrica }}" {{ request('fabrica') == $fabrica ? 'selected' : '' }}>{{ $fabrica }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <div class="form-group w-100">
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Filtrar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $atendidas }}</h3>
                <p>Cargas Atendidas</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <a href="{{ url('/' . request()->route('tenant') . '/viagens') }}" class="small-box-footer">Ver mais <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $canceladas }}</h3>
                <p>Cargas Canceladas</p>
            </div>
            <div class="icon">
                <i class="fas fa-times-circle"></i>
            </div>
            <a href="{{ url('/' . request()->route('tenant') . '/cargas') }}" class="small-box-footer">Ver mais <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>{{ $declinadas }}</h3>
                <p>Cargas Declinadas</p>
            </div>
            <div class="icon">
                <i class="fas fa-minus-circle"></i>
            </div>
            <a href="{{ url('/' . request()->route('tenant') . '/cargas') }}" class="small-box-footer">Ver mais <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $retiradas }}</h3>
                <p>Retirada</p>
            </div>
            <div class="icon">
                <i class="fas fa-truck-loading"></i>
            </div>
            <a href="{{ url('/' . request()->route('tenant') . '/cargas') }}" class="small-box-footer">Ver mais <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Gráfico de Linha (Cargas Atendidas por Mês) -->
    <div class="col-md-8">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Cargas Atendidas por Mês</h3>
            </div>
            <div class="card-body">
                <div class="chart">
                    <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfico de Rosca (Status das Cargas) -->
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Distribuição de Status</h3>
            </div>
            <div class="card-body">
                <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(function () {
        // --- Gráfico de Linha ---
        var ctxLine = document.getElementById('lineChart').getContext('2d');
        var mesesData = @json($meses);
        
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                datasets: [
                    {
                        label: 'Cargas Atendidas',
                        backgroundColor: 'rgba(40, 167, 69, 0.2)',
                        borderColor: 'rgba(40, 167, 69, 1)',
                        pointRadius: false,
                        pointColor: '#28a745',
                        pointStrokeColor: 'rgba(40, 167, 69, 1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(40, 167, 69, 1)',
                        data: mesesData,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // --- Gráfico de Rosca ---
        var ctxDonut = document.getElementById('donutChart').getContext('2d');
        var donutData = {
            labels: [
                'Atendidas',
                'Canceladas',
                'Declinadas',
                'Retiradas'
            ],
            datasets: [
                {
                    data: [{{ $atendidas }}, {{ $canceladas }}, {{ $declinadas }}, {{ $retiradas }}],
                    backgroundColor: ['#28a745', '#dc3545', '#6c757d', '#17a2b8'],
                }
            ]
        }

        new Chart(ctxDonut, {
            type: 'doughnut',
            data: donutData,
            options: {
                maintainAspectRatio: false,
                responsive: true,
            }
        });
    });
</script>
@stop
