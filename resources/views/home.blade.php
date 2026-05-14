@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')
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
            <a href="{{ route('viagens.index') }}" class="small-box-footer">Ver mais <i class="fas fa-arrow-circle-right"></i></a>
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
            <a href="{{ route('cargas.index') }}" class="small-box-footer">Ver mais <i class="fas fa-arrow-circle-right"></i></a>
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
            <a href="{{ route('cargas.index') }}" class="small-box-footer">Ver mais <i class="fas fa-arrow-circle-right"></i></a>
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
            <a href="{{ route('cargas.index') }}" class="small-box-footer">Ver mais <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Cargas Truck</h3>
            </div>
            <div class="card-body">
                <p>Bem-vindo ao sistema de gestão de transportes!</p>
            </div>
        </div>
    </div>
</div>
@stop
