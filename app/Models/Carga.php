<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carga extends Model
{
    protected $fillable = ['motorista_id', 'veiculo_id', 'numero_dt', 'data_carregamento', 'data_agendamento_descarga', 'cliente', 'valor_frete'];

    public function motorista()
    {
        return $this->belongsTo(Motorista::class);
    }

    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class);
    }
}
