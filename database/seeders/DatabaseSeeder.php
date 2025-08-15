<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat akun user biasa
        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        // 2. Buat admin
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin Sistem',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // 3. Buat guru
        $guru1 = User::updateOrCreate(
            ['email' => 'guru1@example.com'],
            [
                'name' => 'Ali',
                'password' => Hash::make('guru123'),
                'role' => 'guru',
                'sekolah_id' => 2, // pastikan sekolah_id ini ada
            ]
        );

        $guru2 = User::updateOrCreate(
            ['email' => 'guru2@example.com'],
            [
                'name' => 'Budi',
                'password' => Hash::make('guru1234'),
                'role' => 'guru',
                'sekolah_id' => 3, // pastikan sekolah_id ini ada
            ]
        );

        // 4. Buat orang tua
        $ortu1 = User::updateOrCreate(
            ['email' => 'ortu1@example.com'],
            [
                'name' => 'Ortu Siswa 1',
                'password' => Hash::make('ortu123'),
                'role' => 'ortu',
            ]
        );

        $ortu2 = User::updateOrCreate(
            ['email' => 'ortu2@example.com'],
            [
                'name' => 'Ortu Siswa 2',
                'password' => Hash::make('ortu123'),
                'role' => 'ortu',
            ]
        );

            User::updateOrCreate(
            ['email' => 'budi@example.com'],
            [
                'name' => 'bapak budibuds',
                'password' => Hash::make('ortu123'),
                'role' => 'orangtua',
                'sekolah_id' => 2, // sesuaikan dengan sekolah_id guru
            ]
        );
    }
}
