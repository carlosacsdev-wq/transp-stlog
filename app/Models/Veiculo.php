<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    use BelongsToTenant;

    protected $fillable = ['motorista_id', 'placa_cavalo', 'placa_carreta', 'modelo', 'marca', 'tenant_id'];

    public function motorista()
    {
        return $this->belongsTo(Motorista::class);
    }}
