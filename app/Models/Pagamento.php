<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    protected $fillable = ['cte', 'dt', 'data_pagamento', 'valor_frete', 'nome_motorista', 'valor_adiantamento', 'saldo_frete'];}
