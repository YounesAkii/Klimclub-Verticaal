<?php

namespace Tests\Feature;

use App\Models\NewsItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class NewsManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_admin_can_create_a_news_item_with_an_image(): void
    {
        Storage::fake('public');

        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('admin.news.store'), [
            'title' => 'De nieuwe boulderzaal opent',
            'excerpt' => 'Na vier maanden verbouwen gaan de deuren opnieuw open voor iedereen.',
            'content' => str_repeat('De zaal is uitgebreid met 180 vierkante meter klimoppervlak. ', 3),
            'published_at' => now()->format('Y-m-d H:i:s'),
            'image' => UploadedFile::fake()->image('zaal.jpg', 1200, 800),
        ]);

        $response->assertRedirect(route('admin.news.index'))->assertSessionHasNoErrors();

        $newsItem = NewsItem::firstOrFail();

        $this->assertSame('de-nieuwe-boulderzaal-opent', $newsItem->slug);
        $this->assertSame($admin->id, $newsItem->user_id);
        Storage::disk('public')->assertExists($newsItem->image_path);
    }

    public function test_a_member_cannot_create_a_news_item(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('admin.news.store'), [])
            ->assertForbidden();

        $this->assertSame(0, NewsItem::count());
    }

    public function test_creating_a_news_item_requires_valid_input(): void
    {
        $this->actingAs(User::factory()->admin()->create())
            ->post(route('admin.news.store'), ['title' => 'kort'])
            ->assertSessionHasErrors(['title', 'excerpt', 'content', 'published_at', 'image']);
    }

    public function test_an_admin_can_update_and_delete_a_news_item(): void
    {
        Storage::fake('public');

        $admin = User::factory()->admin()->create();
        $newsItem = NewsItem::factory()->create(['title' => 'Oude titel']);

        $this->actingAs($admin)->put(route('admin.news.update', $newsItem), [
            'title' => 'Bijgewerkte titel voor het bericht',
            'excerpt' => $newsItem->excerpt,
            'content' => $newsItem->content,
            'published_at' => $newsItem->published_at->format('Y-m-d H:i:s'),
        ])->assertRedirect(route('admin.news.index'))->assertSessionHasNoErrors();

        $this->assertSame('Bijgewerkte titel voor het bericht', $newsItem->refresh()->title);

        $this->actingAs($admin)
            ->delete(route('admin.news.destroy', $newsItem))
            ->assertRedirect(route('admin.news.index'));

        $this->assertSame(0, NewsItem::count());
    }
}
