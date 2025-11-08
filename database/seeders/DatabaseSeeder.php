<?php

namespace Database\Seeders;

use App\Models\Instructor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin Utama',
            'email' => 'admin',
            'password' => Hash::make('admin'),
            'role' => 'admin'
        ]);

        User::factory()->create([
            'name' => 'Dr. Sandhika Setiawan',
            'email' => 'dosen',
            'password' => Hash::make('dosen'),
            'role' => 'instructor'
        ]);

        Instructor::create([
            'user_id' => 2,
            'specialization' => 'Programming',
            'description' => 'ini adalah deskripsi'
        ]);


        $this->call([
            MahasiswaSeeder::class,
            // Seeder lain bisa ditambahkan di sini
        ]);
    }
}
