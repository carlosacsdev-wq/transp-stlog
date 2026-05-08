<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Viagem extends Model
{
    protected $table = 'viagens';
    protected $fillable = ['motorista_id', 'veiculo_id', 'data_hora_carregamento', 'data_hora_chegada', 'data_hora_descarga', 'cte'];

    public function motorista()
    {
        return $this->belongsTo(Motorista::class);
    }

    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class);
    }
}
