<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobConnectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run()
{
    \App\Models\Company::factory(10)->create()->each(function($company) {
        $company->jobs()->createMany(
            \App\Models\Job::factory(5)->make([
                'shalu_company_id' => $company->id // Pastikan menggunakan shalu_company_id
            ])->toArray()
        );
    });
}
}
