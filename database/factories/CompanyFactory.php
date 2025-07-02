<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => $this->faker->company,
            'email'       => $this->faker->unique()->safeEmail, // ✅ WAJIB DITAMBAH
            'location'    => $this->faker->city,
            'description' => $this->faker->paragraph,
            'logo'        => null, // opsional
        ];
    }
}
