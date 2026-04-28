<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carga extends Model
{
    protected $fillable = ['numero_dt', 'data_carregamento', 'data_agendamento_descarga', 'cliente', 'valor_frete'];}
