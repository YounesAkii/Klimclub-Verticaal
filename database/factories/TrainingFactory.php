<?php

namespace Database\Factories;

use App\Models\Training;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Training>
 */
class TrainingFactory extends Factory
{
    public function definition(): array
    {
        $title = Str::ucfirst(rtrim(fake()->words(3, true), '.'));
        $startsAt = fake()->dateTimeBetween('-1 month', '+2 months');

        return [
            'instructor_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(100, 9999),
            'description' => implode("\n\n", fake()->paragraphs(2)),
            'location' => fake()->randomElement(['Hoofdzaal', 'Boulderzaal', 'Buitenmuur', 'Clublokaal']),
            'level' => fake()->randomElement(['beginner', 'gevorderd', 'alle niveaus']),
            'capacity' => fake()->numberBetween(6, 20),
            'starts_at' => $startsAt,
            'ends_at' => (clone $startsAt)->modify('+2 hours'),
        ];
    }

    /** Een training die nog moet plaatsvinden. */
    public function upcoming(): static
    {
        return $this->state(function (array $attributes) {
            $startsAt = fake()->dateTimeBetween('+3 days', '+3 months');

            return [
                'starts_at' => $startsAt,
                'ends_at' => (clone $startsAt)->modify('+2 hours'),
            ];
        });
    }
}
