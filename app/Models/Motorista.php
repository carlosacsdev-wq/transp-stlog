<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Motorista extends Model
{
    use BelongsToTenant;

    protected $fillable = ['nome', 'cpf', 'cnh', 'telefone', 'tenant_id'];

    public function veiculos()
    {
        return $this->hasMany(Veiculo::class);
    }

    public function contas()
    {
        return $this->hasMany(Conta::class);
    }
}
