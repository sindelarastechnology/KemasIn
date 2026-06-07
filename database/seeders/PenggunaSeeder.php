<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    public function run(): void
    {
        Pengguna::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'nama_lengkap' => 'Administrator',
            'role' => 'admin',
        ]);

        Pengguna::create([
            'username' => 'pemilik',
            'password' => Hash::make('pemilik123'),
            'nama_lengkap' => 'Pemilik UMKM',
            'role' => 'pemilik',
        ]);

        Pengguna::create([
            'username' => 'operator1',
            'password' => Hash::make('operator123'),
            'nama_lengkap' => 'Operator Satu',
            'role' => 'operator',
        ]);
    }
}
