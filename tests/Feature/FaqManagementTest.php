<?php

namespace Tests\Feature;

use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * De opgave vraagt dat admins zowel de categorieën als de vraag/antwoord-paren
 * kunnen toevoegen, wijzigen en verwijderen, en dat elke bezoeker de FAQ ziet.
 */
class FaqManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_admin_can_create_update_and_delete_a_category(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post(route('admin.faq-categories.store'), [
            'name' => 'Beginnen met klimmen',
            'description' => 'Alles voor je eerste keer in de zaal.',
            'position' => 0,
        ])->assertRedirect(route('admin.faq-categories.index'))->assertSessionHasNoErrors();

        $category = FaqCategory::firstOrFail();
        $this->assertSame('beginnen-met-klimmen', $category->slug);

        $this->actingAs($admin)->put(route('admin.faq-categories.update', $category), [
            'name' => 'Starten met klimmen',
            'description' => $category->description,
            'position' => 1,
        ])->assertSessionHasNoErrors();

        $this->assertSame('Starten met klimmen', $category->refresh()->name);

        $this->actingAs($admin)->delete(route('admin.faq-categories.destroy', $category));
        $this->assertSame(0, FaqCategory::count());
    }

    public function test_deleting_a_category_also_removes_its_questions(): void
    {
        $category = FaqCategory::factory()->create();
        Faq::factory()->count(3)->create(['faq_category_id' => $category->id]);

        $this->actingAs(User::factory()->admin()->create())
            ->delete(route('admin.faq-categories.destroy', $category));

        $this->assertSame(0, Faq::count());
    }

    public function test_an_admin_can_create_update_and_delete_a_question(): void
    {
        $admin = User::factory()->admin()->create();
        $category = FaqCategory::factory()->create();

        $this->actingAs($admin)->post(route('admin.faqs.store'), [
            'faq_category_id' => $category->id,
            'question' => 'Heb ik ervaring nodig om te starten?',
            'answer' => 'Nee, je kan zonder enige ervaring langskomen tijdens een initiatiemoment.',
            'position' => 0,
        ])->assertRedirect(route('admin.faqs.index'))->assertSessionHasNoErrors();

        $faq = Faq::firstOrFail();

        $this->actingAs($admin)->put(route('admin.faqs.update', $faq), [
            'faq_category_id' => $category->id,
            'question' => 'Moet ik al kunnen klimmen om te starten?',
            'answer' => $faq->answer,
            'position' => 2,
        ])->assertSessionHasNoErrors();

        $this->assertSame('Moet ik al kunnen klimmen om te starten?', $faq->refresh()->question);

        $this->actingAs($admin)->delete(route('admin.faqs.destroy', $faq));
        $this->assertSame(0, Faq::count());
    }

    public function test_a_member_cannot_touch_the_faq(): void
    {
        $member = User::factory()->create();
        $category = FaqCategory::factory()->create();

        $this->actingAs($member)->post(route('admin.faq-categories.store'), [])->assertForbidden();
        $this->actingAs($member)->post(route('admin.faqs.store'), [])->assertForbidden();
        $this->actingAs($member)->delete(route('admin.faq-categories.destroy', $category))->assertForbidden();

        $this->assertSame(1, FaqCategory::count());
    }

    public function test_the_faq_is_grouped_per_category_for_every_visitor(): void
    {
        $eerste = FaqCategory::factory()->create(['name' => 'Lidmaatschap', 'position' => 0]);
        $tweede = FaqCategory::factory()->create(['name' => 'Veiligheid', 'position' => 1]);

        Faq::factory()->create(['faq_category_id' => $eerste->id, 'question' => 'Wat kost een lidmaatschap?']);
        Faq::factory()->create(['faq_category_id' => $tweede->id, 'question' => 'Heb ik een brevet nodig?']);

        $this->get('/faq')
            ->assertOk()
            ->assertSeeInOrder(['Lidmaatschap', 'Wat kost een lidmaatschap?', 'Veiligheid', 'Heb ik een brevet nodig?']);
    }
}
