<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Company;
use App\Models\Job;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ✅ Tambahkan 1 user login manual (role user)
        User::create([
            'name' => 'Shalu',
            'email' => 'shalu@mail.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        // ✅ Tambahkan 1 user company (kalau mau login sebagai company)
        User::create([
            'name' => 'Perusahaan Hebat',
            'email' => 'company@mail.com',
            'password' => Hash::make('password123'),
            'role' => 'company',
        ]);

        // ✅ Tambahkan 1 user admin (opsional)
        User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Dummy user lainnya
        User::factory(10)->create();

        // Data dummy lainnya
        Category::factory(5)->create();
        Company::factory(5)->create();
        Job::factory(20)->create();
    }
}