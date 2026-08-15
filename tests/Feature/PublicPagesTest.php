<?php

namespace Tests\Feature;

use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\NewsItem;
use App\Models\Training;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_public_pages_are_reachable_without_an_account(): void
    {
        foreach (['/', '/nieuws', '/trainingen', '/leden', '/faq', '/contact'] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_the_news_overview_shows_published_items(): void
    {
        $published = NewsItem::factory()->create(['title' => 'Nieuwe boulderzaal']);
        $scheduled = NewsItem::factory()->scheduled()->create(['title' => 'Kerstsluiting']);

        $this->get('/nieuws')
            ->assertOk()
            ->assertSee($published->title)
            ->assertDontSee($scheduled->title);
    }

    public function test_a_scheduled_news_item_is_hidden_for_visitors_but_visible_for_admins(): void
    {
        $scheduled = NewsItem::factory()->scheduled()->create();

        $this->get(route('news.show', $scheduled))->assertNotFound();

        $this->actingAs(User::factory()->admin()->create())
            ->get(route('news.show', $scheduled))
            ->assertOk();
    }

    public function test_the_faq_groups_questions_per_category(): void
    {
        $category = FaqCategory::factory()->create(['name' => 'Beginnen met klimmen']);
        $faq = Faq::factory()->create([
            'faq_category_id' => $category->id,
            'question' => 'Heb ik ervaring nodig om te starten?',
        ]);

        $this->get('/faq')
            ->assertOk()
            ->assertSee($category->name)
            ->assertSee($faq->question);
    }

    public function test_a_profile_page_is_public(): void
    {
        $user = User::factory()->create(['username' => 'lotte', 'bio' => 'Klimt sinds vorig jaar.']);

        $this->get(route('users.show', $user))
            ->assertOk()
            ->assertSee('lotte')
            ->assertSee('Klimt sinds vorig jaar.');
    }

    public function test_the_training_overview_can_be_filtered_by_level(): void
    {
        $beginner = Training::factory()->upcoming()->create(['level' => 'beginner', 'title' => 'Initiatie touwklimmen']);
        $advanced = Training::factory()->upcoming()->create(['level' => 'gevorderd', 'title' => 'Voorklimcursus avond een']);

        $this->get('/trainingen?niveau=beginner')
            ->assertOk()
            ->assertSee($beginner->title)
            ->assertDontSee($advanced->title);
    }
}
