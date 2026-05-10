<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Motorista extends Model
{
    protected $fillable = ['nome', 'cpf', 'cnh', 'telefone'];

    public function veiculos()
    {
        return $this->hasMany(Veiculo::class);
    }

    public function contas()
    {
        return $this->hasMany(Conta::class);
    }
}
