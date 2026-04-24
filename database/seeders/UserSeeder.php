<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // user admin
        User::create([
            'name' => 'Admin',
            'username' => 'adminliterapps',
            'password' => bcrypt('password123'),
            'role' => 'admin'
        ]);

        // user siswa
        User::create([
            'name' => 'Siswa',
            'username' => 'siswaliterapps',
            'password' => bcrypt('password123'),
            'role' => 'siswa'
        ]);
    }
}
