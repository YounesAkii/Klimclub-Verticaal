<?php

namespace Database\Factories;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Faq>
 */
class FaqFactory extends Factory
{
    public function definition(): array
    {
        return [
            'faq_category_id' => FaqCategory::factory(),
            'question' => rtrim(fake()->sentence(7), '.') . '?',
            'answer' => fake()->paragraph(3),
            'position' => fake()->numberBetween(0, 10),
        ];
    }
}
