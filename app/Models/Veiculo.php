<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'motorista_id', 'tipo', 'placa', 'nome_proprietario', 'endereco_proprietario',
        'cidade', 'uf', 'modelo', 'marca', 'chassi', 'renavam', 'ano_fabricacao', 'ano_modelo',
        'cidade_emissao', 'uf_emissao', 'tenant_id',
    ];

    public function motorista()
    {
        return $this->belongsTo(Motorista::class);
    }}
