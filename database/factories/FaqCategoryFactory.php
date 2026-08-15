<?php

namespace Database\Factories;

use App\Models\FaqCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<FaqCategory>
 */
class FaqCategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = rtrim(fake()->words(2, true), '.');

        return [
            'name' => Str::ucfirst($name),
            'slug' => Str::slug($name) . '-' . fake()->unique()->numberBetween(100, 9999),
            'description' => fake()->sentence(),
            'position' => fake()->numberBetween(0, 10),
        ];
    }
}
