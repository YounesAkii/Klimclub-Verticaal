<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * De profielpagina moet een profielfoto bevatten die op de webserver bewaard
 * wordt. Deze tests controleren dat het bestand er effectief komt te staan.
 */
class ProfilePhotoTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_member_can_upload_a_profile_photo_that_lands_on_the_server(): void
    {
        Storage::fake('public');

        $user = User::factory()->create(['avatar_path' => null]);

        $this->actingAs($user)->patch('/profiel', [
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'avatar' => UploadedFile::fake()->image('pasfoto.jpg', 400, 400),
        ])->assertSessionHasNoErrors();

        $user->refresh();

        $this->assertNotNull($user->avatar_path);
        Storage::disk('public')->assertExists($user->avatar_path);
        $this->assertStringStartsWith('avatars/', $user->avatar_path);
    }

    public function test_uploading_a_new_photo_removes_the_previous_file(): void
    {
        Storage::fake('public');

        $user = User::factory()->create(['avatar_path' => null]);

        $this->actingAs($user)->patch('/profiel', [
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'avatar' => UploadedFile::fake()->image('eerste.jpg'),
        ]);

        $eerste = $user->refresh()->avatar_path;

        $this->actingAs($user)->patch('/profiel', [
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'avatar' => UploadedFile::fake()->image('tweede.jpg'),
        ]);

        $tweede = $user->refresh()->avatar_path;

        $this->assertNotSame($eerste, $tweede);
        Storage::disk('public')->assertMissing($eerste);
        Storage::disk('public')->assertExists($tweede);
    }

    public function test_a_non_image_is_refused(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $this->actingAs($user)->patch('/profiel', [
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'avatar' => UploadedFile::fake()->create('virus.exe', 100),
        ])->assertSessionHasErrors('avatar');
    }

    public function test_the_public_profile_shows_all_required_fields(): void
    {
        $user = User::factory()->create([
            'username' => 'lotte',
            'birthday' => '2001-06-30',
            'bio' => 'Sinds vorig jaar lid en ondertussen niet meer weg te slaan.',
        ]);

        // De profielpagina is bereikbaar zonder in te loggen.
        $this->get(route('users.show', $user))
            ->assertOk()
            ->assertSee('lotte')
            ->assertSee('30 juni')
            ->assertSee('Sinds vorig jaar lid en ondertussen niet meer weg te slaan.');
    }
}
