<?php

namespace Database\Factories;

use App\Models\NewsItem;
use App\Models\User;
use Database\Seeders\SeedAssets;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<NewsItem>
 */
class NewsItemFactory extends Factory
{
    public function definition(): array
    {
        $title = rtrim(fake()->sentence(6), '.');

        return [
            'user_id' => User::factory()->admin(),
            'title' => $title,
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(100, 9999),
            'image_path' => SeedAssets::newsImage(fake()->randomElement(SeedAssets::NEWS_IMAGES)),
            'excerpt' => fake()->paragraph(2),
            'content' => implode("\n\n", fake()->paragraphs(4)),
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ];
    }

    /** Een item met een publicatiedatum in de toekomst. */
    public function scheduled(): static
    {
        return $this->state(fn (array $attributes) => [
            'published_at' => fake()->dateTimeBetween('+1 week', '+2 months'),
        ]);
    }
}
