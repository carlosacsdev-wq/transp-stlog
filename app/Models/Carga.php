<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Carga extends Model
{
    use BelongsToTenant;

    protected $casts = [
        'diarias_aprovadas_em' => 'datetime',
    ];

    protected $fillable = [
        'tenant_id',
        'motorista_id', 
        'veiculo_id', 
        'numero_dt', 
        'fabrica', 
        'data_carregamento', 
        'data_agendamento_descarga', 
        'data_hora_chegada', 
        'data_hora_descarga', 
        'diarias',
        'diarias_aprovadas_em',
        'diarias_status_pagamento',
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

    public function getDiariasAttribute($value): int
    {
        if ($value !== null) {
            return (int) $value;
        }

        if ($this->data_hora_chegada === null) {
            return 0;
        }

        $inicioDiaria = Carbon::parse($this->data_hora_chegada)->addHours(24);
        $fimEspera = $this->data_hora_descarga
            ? Carbon::parse($this->data_hora_descarga)
            : now();

        if ($fimEspera->lessThanOrEqualTo($inicioDiaria)) {
            return 0;
        }

        return (int) ceil($inicioDiaria->diffInSeconds($fimEspera) / 86400);
    }
}
