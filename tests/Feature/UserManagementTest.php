<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_admin_can_create_a_user_manually(): void
    {
        $this->actingAs(User::factory()->admin()->create())
            ->post(route('admin.users.store'), [
                'name' => 'Jonas Claes',
                'username' => 'jonas',
                'email' => 'jonas@example.com',
                'password' => 'Password!321',
                'password_confirmation' => 'Password!321',
                'is_admin' => '1',
            ])
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHasNoErrors();

        $user = User::where('username', 'jonas')->firstOrFail();

        $this->assertTrue($user->is_admin);
        $this->assertTrue(Hash::check('Password!321', $user->password));
    }

    public function test_an_admin_can_promote_and_demote_another_user(): void
    {
        $admin = User::factory()->admin()->create();
        $member = User::factory()->create();

        $this->actingAs($admin)->patch(route('admin.users.role', $member));
        $this->assertTrue($member->refresh()->is_admin);

        $this->actingAs($admin)->patch(route('admin.users.role', $member));
        $this->assertFalse($member->refresh()->is_admin);
    }

    public function test_an_admin_cannot_change_their_own_role(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->from(route('admin.users.index'))
            ->patch(route('admin.users.role', $admin))
            ->assertSessionHas('error');

        $this->assertTrue($admin->refresh()->is_admin);
    }

    public function test_a_member_cannot_promote_anyone(): void
    {
        $member = User::factory()->create();
        $other = User::factory()->create();

        $this->actingAs($member)
            ->patch(route('admin.users.role', $other))
            ->assertForbidden();

        $this->assertFalse($other->refresh()->is_admin);
    }

    public function test_an_admin_can_delete_another_user_but_not_themselves(): void
    {
        $admin = User::factory()->admin()->create();
        $member = User::factory()->create();

        $this->actingAs($admin)->delete(route('admin.users.destroy', $member));
        $this->assertNull($member->fresh());

        $this->actingAs($admin)
            ->from(route('admin.users.index'))
            ->delete(route('admin.users.destroy', $admin))
            ->assertSessionHas('error');

        $this->assertNotNull($admin->fresh());
    }

    public function test_a_username_must_be_unique(): void
    {
        User::factory()->create(['username' => 'lotte']);

        $this->actingAs(User::factory()->admin()->create())
            ->post(route('admin.users.store'), [
                'name' => 'Iemand anders',
                'username' => 'lotte',
                'email' => 'anders@example.com',
                'password' => 'Password!321',
                'password_confirmation' => 'Password!321',
            ])
            ->assertSessionHasErrors('username');
    }
}
