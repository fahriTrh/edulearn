<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class MahasiswaSeeder extends Seeder
{
    public function run()
    {
        $mahasiswas = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@edulearn.com',
                'nim' => '231234001',
                'password' => Hash::make('231234001'),
                'role' => 'student',
            ],
            [
                'name' => 'Siti Aisyah',
                'email' => 'siti@edulearn.com',
                'nim' => '231234002',
                'password' => Hash::make('231234002'),
                'role' => 'student',
            ],
            [
                'name' => 'Andi Pratama',
                'email' => 'andi@edulearn.com',
                'nim' => '231234003',
                'password' => Hash::make('231234003'),
                'role' => 'student',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@edulearn.com',
                'nim' => '231234004',
                'password' => Hash::make('231234004'),
                'role' => 'student',
            ],
            [
                'name' => 'Fajar Nugroho',
                'email' => 'fajar@edulearn.com',
                'nim' => '231234005',
                'password' => Hash::make('231234005'),
                'role' => 'student',
            ],
            [
                'name' => 'Mahasiswa',
                'email' => 'mahasiswa@edulearn.com',
                'nim' => 'mahasiswa',
                'password' => Hash::make('mahasiswa'),
                'role' => 'student',
            ],
        ];

        foreach ($mahasiswas as $m) {
            User::create($m);
        }
    }
}
