<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\NewsItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_logged_in_member_can_comment(): void
    {
        $user = User::factory()->create();
        $newsItem = NewsItem::factory()->create();

        $this->actingAs($user)
            ->post(route('comments.store', $newsItem), ['body' => 'Top nieuws, ik ben er zeker bij!'])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('comments', [
            'news_item_id' => $newsItem->id,
            'user_id' => $user->id,
            'body' => 'Top nieuws, ik ben er zeker bij!',
        ]);
    }

    public function test_a_visitor_cannot_comment(): void
    {
        $newsItem = NewsItem::factory()->create();

        $this->post(route('comments.store', $newsItem), ['body' => 'Leuk!'])
            ->assertRedirect(route('login'));
    }

    public function test_an_author_can_delete_their_own_comment(): void
    {
        $comment = Comment::factory()->create();

        $this->actingAs($comment->author)
            ->delete(route('comments.destroy', $comment))
            ->assertSessionHasNoErrors();

        $this->assertSame(0, Comment::count());
    }

    public function test_an_admin_can_delete_any_comment(): void
    {
        $comment = Comment::factory()->create();

        $this->actingAs(User::factory()->admin()->create())
            ->delete(route('comments.destroy', $comment));

        $this->assertSame(0, Comment::count());
    }

    public function test_another_member_cannot_delete_someone_elses_comment(): void
    {
        $comment = Comment::factory()->create();

        $this->actingAs(User::factory()->create())
            ->delete(route('comments.destroy', $comment))
            ->assertForbidden();

        $this->assertSame(1, Comment::count());
    }
}
