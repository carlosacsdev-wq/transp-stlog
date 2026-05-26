<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = ['name', 'slug', 'domain', 'email', 'phone', 'is_active', 'settings'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'settings' => 'array',
        ];
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function motoristas()
    {
        return $this->hasMany(Motorista::class);
    }

    public function veiculos()
    {
        return $this->hasMany(Veiculo::class);
    }

    public function cargas()
    {
        return $this->hasMany(Carga::class);
    }

    public function contas()
    {
        return $this->hasMany(Conta::class);
    }
}
