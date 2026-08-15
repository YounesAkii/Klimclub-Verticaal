<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitors_are_sent_to_the_login_page(): void
    {
        $this->get('/beheer')->assertRedirect(route('login'));
    }

    public function test_a_regular_member_gets_a_403(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/beheer')
            ->assertForbidden();
    }

    public function test_an_admin_reaches_every_section_of_the_admin_panel(): void
    {
        $admin = User::factory()->admin()->create();

        $sections = [
            route('admin.dashboard'),
            route('admin.news.index'),
            route('admin.news.create'),
            route('admin.faq-categories.index'),
            route('admin.faq-categories.create'),
            route('admin.faqs.index'),
            route('admin.faqs.create'),
            route('admin.trainings.index'),
            route('admin.trainings.create'),
            route('admin.users.index'),
            route('admin.users.create'),
            route('admin.contact-messages.index'),
        ];

        foreach ($sections as $url) {
            $this->actingAs($admin)->get($url)->assertOk();
        }
    }
}
