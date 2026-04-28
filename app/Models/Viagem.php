<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Viagem extends Model
{
    protected $table = 'viagens';
    protected $fillable = ['data_hora_carregamento', 'data_hora_chegada', 'data_hora_descarga', 'nome_motorista', 'cte'];}
