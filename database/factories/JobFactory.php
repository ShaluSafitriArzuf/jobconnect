<?php

namespace Database\Factories;
use App\Models\Company;
use App\Models\Category;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   public function definition()
{
    return [
        'title' => $this->faker->jobTitle,
        'shalu_company_id' => Company::factory(), // Ubah dari company_id
        'shalu_category_id' => Category::factory(),
        'location' => $this->faker->city,
        'description' => $this->faker->paragraph,
        'job_type' => $this->faker->randomElement(['Full-Time', 'Part-Time']),
        'deadline' => $this->faker->dateTimeBetween('now', '+1 year'),
    ];
}
}
