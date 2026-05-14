<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carga extends Model
{
    protected $fillable = [
        'motorista_id', 
        'veiculo_id', 
        'numero_dt', 
        'fabrica', 
        'data_carregamento', 
        'data_agendamento_descarga', 
        'data_hora_chegada', 
        'data_hora_descarga', 
        'cliente', 
        'valor_frete', 
        'status', 
        'cte', 
        'mdfe', 
        'data_pagamento', 
        'valor_adiantamento', 
        'valor_saldo', 
        'status_pagamento', 
        'tipo_solicitacao', 
        'status_canhoto'
    ];

    public function motorista()
    {
        return $this->belongsTo(Motorista::class);
    }

    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class);
    }
}
