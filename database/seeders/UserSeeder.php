<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::factory()->create([
        //     'name' => 'Admin Gudang',
        //     'email' => 'admingudang@eam.com',
        //     'nohp' => '123123',
        //     'alamat' => 'Jl. Raya Singaraja, Bungkulan, Kec. Sawan, Kabupaten Buleleng, Bali 81171',
        //     'jk' => 'L',
        //     'role' => 'ADMIN_GUDANG',
        //     'password' => Hash::make('123123'),
        // ]);
        // User::factory()->create([
        //     'name' => 'Admin Mekanik',
        //     'email' => 'adminmekanik@eam.com',
        //     'nohp' => '321321',
        //     'alamat' => 'Jl. Raya Singaraja, Bungkulan, Kec. Sawan, Kabupaten Buleleng, Bali 81171',
        //     'jk' => 'L',
        //     'role' => 'ADMIN_MEKANIK',
        //     'password' => Hash::make('123123'),
        // ]);

        User::factory()->create([
            'name' => 'Arik Suparta',
            'email' => 'arik@eam.com',
            'nohp' => '123456',
            'alamat' => 'Singaraja',
            'jk' => 'L',
            'role' => 'USER',
            'password' => Hash::make('123123'),
        ]);
    }
}
