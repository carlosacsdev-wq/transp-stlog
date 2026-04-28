<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    protected $fillable = ['motorista_id', 'placa_cavalo', 'placa_carreta', 'modelo', 'marca'];

    public function motorista()
    {
        return $this->belongsTo(Motorista::class);
    }}
