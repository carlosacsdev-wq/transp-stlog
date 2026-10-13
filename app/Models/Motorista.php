<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Motorista extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'nome', 'apelido', 'data_nascimento', 'nome_mae', 'nome_pai', 'rg', 'data_emissao_rg',
        'cpf', 'cnh', 'endereco', 'bairro', 'cidade', 'estado', 'telefone',
        'contato_pessoal1', 'contato_pessoal2', 'contato_pessoal3',
        'contato_empresa1', 'contato_empresa2', 'contato_empresa3', 'tenant_id',
    ];

    public function veiculos()
    {
        return $this->hasMany(Veiculo::class);
    }

    public function contas()
    {
        return $this->hasMany(Conta::class);
    }
}
