<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
    /** @use HasFactory<\Database\Factories\ContaFactory> */
    use HasFactory;

    protected $fillable = [
        'motorista_id',
        'titular',
        'cpf_cnpj_titular',
        'banco',
        'agencia',
        'tipo_conta',
        'nro_conta',
        'tipo_chave',
        'chave_pix',
    ];

    public function motorista()
    {
        return $this->belongsTo(Motorista::class);
    }
}
