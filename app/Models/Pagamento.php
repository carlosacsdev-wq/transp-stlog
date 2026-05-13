<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    protected $fillable = ['motorista_id', 'veiculo_id', 'cte', 'dt', 'data_pagamento', 'valor_frete', 'valor_adiantamento', 'saldo_frete'];

    public function motorista()
    {
        return $this->belongsTo(Motorista::class);
    }

    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class);
    }
}
