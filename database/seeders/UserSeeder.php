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
        $tenant = Tenant::where('slug', 'cargastruck')->first();

        User::updateOrCreate(
            ['email' => 'carlos@cargastruck.com.br'],
            [
                'name' => 'Carlos',
                'password' => Hash::make('carlos123'),
                'is_admin' => true,
                'tenant_id' => $tenant?->id,
            ]
        );
    }
}
