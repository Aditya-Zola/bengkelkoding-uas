<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $users = [
            [
                'nama' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'),
                'role' => 'admin',
                'alamat' => 'Kantor Pusat',
                'no_ktp' => '1111111111111111',
                'no_hp' => '081111111111',
            ],
            [
                'nama' => 'Dokter',
                'email' => 'dokter@gmail.com',
                'password' => Hash::make('dokter'),
                'role' => 'dokter',
                'alamat' => 'Klinik A',
                'no_ktp' => '2222222222222222',
                'no_hp' => '082222222222',
            ],
            [
                'nama' => 'Pasien',
                'email' => 'pasien@gmail.com',
                'password' => Hash::make('pasien'),
                'role' => 'pasien',
                'alamat' => 'Alamat Pasien',
                'no_ktp' => '3333333333333333',
                'no_hp' => '083333333333',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
