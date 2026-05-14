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
            ['email' => 'brunojorge@cargastruck.com.br'],
            [
                'name' => 'Bruno Jorge',
                'password' => Hash::make('brunojorge123'),
                'is_admin' => true,
            ]
        );

        // User::updateOrCreate(
        //     ['email' => 'operacional@cargastruck.com.br'],
        //     [
        //         'name' => 'Operacional',
        //         'password' => Hash::make('operacional123'),
        //         'is_admin' => false,
        //     ]
        // );
    }
}
