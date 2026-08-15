<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * Controleert de authenticatiefunctionaliteit die het project expliciet moet
 * bevatten: in- en uitloggen, 'remember me', registreren, een wachtwoord
 * opnieuw instellen en het bestaan van de vaste beheerder.
 */
class RequiredAuthFeaturesTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_default_admin_exists_with_the_required_credentials(): void
    {
        $this->seed(UserSeeder::class);

        $admin = User::where('email', 'admin@ehb.be')->first();

        $this->assertNotNull($admin, 'De gebruiker admin@ehb.be bestaat niet na het seeden.');
        $this->assertSame('admin', $admin->username);
        $this->assertTrue($admin->is_admin);

        // Het opgelegde wachtwoord moet effectief werken om mee in te loggen.
        $this->assertTrue(Auth::attempt([
            'email' => 'admin@ehb.be',
            'password' => 'Password!321',
        ]));
    }

    public function test_the_default_admin_can_reach_the_admin_panel(): void
    {
        $this->seed(UserSeeder::class);

        $this->post('/login', [
            'email' => 'admin@ehb.be',
            'password' => 'Password!321',
        ])->assertRedirect(route('dashboard', absolute: false));

        $this->get(route('admin.dashboard'))->assertOk();
    }

    public function test_remember_me_keeps_the_user_logged_in(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
            'remember' => 'on',
        ]);

        $this->assertAuthenticated();

        // Laravel plaatst een langlopend cookie en bewaart het bijhorende token
        // op de gebruiker.
        $response->assertCookie(Auth::guard()->getRecallerName());
        $this->assertNotNull($user->refresh()->remember_token);
    }

    public function test_logging_in_without_remember_me_sets_no_recaller_cookie(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertCookieMissing(Auth::guard()->getRecallerName());
    }

    public function test_a_user_can_log_out(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/logout')
            ->assertRedirect('/');

        $this->assertGuest();
    }

    public function test_a_forgotten_password_can_be_reset(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class, function (ResetPassword $notification) use ($user) {
            $this->post('/reset-password', [
                'token' => $notification->token,
                'email' => $user->email,
                'password' => 'NieuwWachtwoord!123',
                'password_confirmation' => 'NieuwWachtwoord!123',
            ])->assertSessionHasNoErrors();

            return true;
        });

        // Het nieuwe wachtwoord werkt, het oude niet meer.
        $this->assertTrue(Auth::attempt(['email' => $user->email, 'password' => 'NieuwWachtwoord!123']));
        $this->assertFalse(Auth::attempt(['email' => $user->email, 'password' => 'password']));
    }
}
