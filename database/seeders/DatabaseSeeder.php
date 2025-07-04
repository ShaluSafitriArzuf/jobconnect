<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Job;
use App\Models\Company;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 1. Hapus data lama dengan urutan yang benar
        DB::table('shalu_applications')->truncate();
        DB::table('shalu_jobs')->truncate();
        DB::table('shalu_companies')->truncate();
        DB::table('shalu_categories')->truncate();
        DB::table('shalu_users')->truncate();

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Seed Users (menggunakan tabel shalu_users)
        $adminUser = DB::table('shalu_users')->insertGetId([
            'name' => 'Admin Sistem',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $companyUser = DB::table('shalu_users')->insertGetId([
            'name' => 'Perusahaan ABC',
            'email' => 'company@mail.com',
            'password' => Hash::make('password123'),
            'role' => 'company',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $regularUser = DB::table('shalu_users')->insertGetId([
            'name' => 'User Biasa',
            'email' => 'user@mail.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // 3. Seed Categories (menggunakan tabel shalu_categories)
        $categories = [
            ['name' => 'IT', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Finance', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Design', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Marketing', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'HR', 'created_at' => now(), 'updated_at' => now()]
        ];
        DB::table('shalu_categories')->insert($categories);

        // 4. Seed Companies (menggunakan tabel shalu_companies) dengan relasi ke user
        DB::table('shalu_companies')->insert([
            [
                'shalu_user_id' => $companyUser,
                'name' => 'Tech Corp',
                'email' => 'info@techcorp.com',
                'location' => 'Jakarta',
                'description' => 'Perusahaan teknologi terkemuka',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'shalu_user_id' => $adminUser,
                'name' => 'Admin Corp',
                'email' => 'admin@admincorp.com',
                'location' => 'Surabaya',
                'description' => 'Perusahaan milik admin',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // 5. Seed Jobs (menggunakan tabel shalu_jobs)
        // 5. Seed Jobs (menggunakan tabel shalu_jobs)
        DB::table('shalu_jobs')->insert([
            [
                'shalu_company_id' => 1,
                'shalu_category_id' => 1,
                'title' => 'Laravel Developer',
                'description' => 'Membangun aplikasi dengan Laravel',
                'location' => 'Bandung',
                'job_type' => 'Full-Time',
                'deadline' => now()->addMonth(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'shalu_company_id' => 2,
                'shalu_category_id' => 2,
                'title' => 'Financial Analyst',
                'description' => 'Analisis keuangan perusahaan',
                'location' => 'Jakarta',
                'job_type' => 'Contract',
                'deadline' => now()->addWeeks(2),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // 6. Seed Applications (opsional)
        DB::table('shalu_applications')->insert([
            [
                'shalu_user_id' => $regularUser,
                'shalu_job_id' => 1,
                'status' => 'pending',
                'cover_letter' => 'Saya tertarik dengan posisi ini',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}