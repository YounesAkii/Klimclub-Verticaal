<?php

namespace Tests\Feature;

use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\NewsItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Invoer van gebruikers mag nooit als HTML uitgevoerd worden. Deze tests voeren
 * echte aanvalspogingen uit en controleren dat het script geëscaped op de
 * pagina belandt in plaats van uitgevoerd te worden.
 */
class XssProtectionTest extends TestCase
{
    use RefreshDatabase;

    private const AANVAL = '<script>alert("xss")</script>';

    public function test_a_script_tag_in_a_comment_is_escaped(): void
    {
        $newsItem = NewsItem::factory()->create();

        $this->actingAs(User::factory()->create())
            ->post(route('comments.store', $newsItem), ['body' => self::AANVAL]);

        $response = $this->get(route('news.show', $newsItem));

        $response->assertOk();
        $response->assertDontSee(self::AANVAL, escape: false);
        $response->assertSee('&lt;script&gt;', escape: false);
    }

    public function test_a_script_tag_in_a_bio_is_escaped_on_the_public_profile(): void
    {
        // De bio gaat door de x-rich-text component, die nl2br(e()) gebruikt.
        $user = User::factory()->create(['bio' => self::AANVAL]);

        $response = $this->get(route('users.show', $user));

        $response->assertOk();
        $response->assertDontSee(self::AANVAL, escape: false);
        $response->assertSee('&lt;script&gt;', escape: false);
    }

    public function test_a_script_tag_in_a_faq_answer_is_escaped(): void
    {
        $category = FaqCategory::factory()->create();
        Faq::factory()->create([
            'faq_category_id' => $category->id,
            'answer' => self::AANVAL,
        ]);

        $response = $this->get('/faq');

        $response->assertOk();
        $response->assertDontSee(self::AANVAL, escape: false);
        $response->assertSee('&lt;script&gt;', escape: false);
    }

    public function test_a_script_tag_in_a_news_title_is_escaped(): void
    {
        NewsItem::factory()->create(['title' => 'Nieuws ' . self::AANVAL]);

        $response = $this->get('/nieuws');

        $response->assertOk();
        $response->assertDontSee(self::AANVAL, escape: false);
    }
}
