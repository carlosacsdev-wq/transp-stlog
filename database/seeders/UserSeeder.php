<?php
 
namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
 
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@cargastruck.com.br'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
            ]
        );
    }
}
