<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        Tenant::updateOrCreate(
            ['slug' => 'cargastruck'],
            [
                'name' => 'Cargas Truck',
                'domain' => 'cargastruck.localhost',
                'email' => 'admin@cargastruck.com.br',
                'phone' => '(11) 99999-9999',
                'is_active' => true,
            ]
        );

        // Exemplo de como criar um novo cliente (Tenant)
        // Basta copiar o bloco abaixo e alterar os dados para o novo cliente
        Tenant::updateOrCreate(
            ['slug' => 'clienteexemplo'], // Identificador único (URL amigável)
            [
                'name' => 'Cliente Exemplo LTDA', // Nome da empresa
                'domain' => 'clienteexemplo.localhost', // Domínio de acesso
                'email' => 'admin@clienteexemplo.com.br', // E-mail de contato
                'phone' => '(11) 88888-8888', // Telefone
                'is_active' => true, // Status
            ]
        );

        // Exemplo de como criar um novo cliente (Tenant)
        // Basta copiar o bloco abaixo e alterar os dados para o novo cliente
        Tenant::updateOrCreate(
            ['slug' => 'stlog'], // Identificador único (URL amigável)
            [
                'name' => 'Stlog', // Nome da empresa
                'domain' => 'stlog.localhost', // Domínio de acesso
                'email' => 'admin@stlog.com.br', // E-mail de contato
                'phone' => '(11) 99201-6365', // Telefone
                'is_active' => true, // Status
            ]
        );
    }
}
