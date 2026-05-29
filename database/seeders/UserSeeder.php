<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tenant;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::query()->where('slug', 'cargastruck')->first();

        User::updateOrCreate(
            ['email' => 'carlos@cargastruck.com.br'],
            [
                'name' => 'Carlos',
                'password' => Hash::make('carlos123'),
                'is_admin' => true,
                'tenant_id' => $tenant?->id,
            ]
        );

        // Exemplo de como criar o usuário administrador para o novo cliente criado no TenantSeeder
        $clienteExemplo = Tenant::query()->where('slug', 'clienteexemplo')->first();
        
        if ($clienteExemplo) {
            User::updateOrCreate(
                ['email' => 'admin@clienteexemplo.com.br'], // Login do usuário
                [
                    'name' => 'Administrador', // Nome do usuário
                    'password' => Hash::make('senha123'), // Senha (será criptografada)
                    'is_admin' => true, // Define que é administrador
                    'tenant_id' => $clienteExemplo->id, // Vincula o usuário ao cliente
                ]
            );
        }

        // Exemplo de como criar o usuário administrador para o novo cliente criado no TenantSeeder
        $stlog = Tenant::query()->where('slug', 'stlog')->first();
        
        if ($stlog) {
            User::updateOrCreate(
                ['email' => 'admin@stlog.com.br'], // Login do usuário
                [
                    'name' => 'Administrador', // Nome do usuário
                    'password' => Hash::make('senha123'), // Senha (será criptografada)
                    'is_admin' => true, // Define que é administrador
                    'tenant_id' => $stlog->id, // Vincula o usuário ao cliente
                ]
            );
        }
    }
}
