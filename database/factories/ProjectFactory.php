<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $company_id = Company::all()->pluck('id')->toArray();

        return [
            'name' => fake()->words(2, true),
            'company_id' => $company_id[array_rand($company_id, 1)],
            'create_user_id' => 1
        ];
    }
}
