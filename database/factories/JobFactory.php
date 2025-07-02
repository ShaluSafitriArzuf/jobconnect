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
   public function definition(): array
    {
        return [
            'title' => $this->faker->jobTitle,
            'company_id' => Company::factory(),
            'category_id' => Category::factory(),
            'location' => $this->faker->city,
            'description' => $this->faker->paragraph,
            'job_type' => $this->faker->randomElement(['Full-time', 'Part-time', 'Remote']),
            'deadline' => now()->addDays(rand(10, 30)),
        ];
    }

}
