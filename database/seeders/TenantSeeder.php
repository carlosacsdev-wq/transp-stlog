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
    }
}
