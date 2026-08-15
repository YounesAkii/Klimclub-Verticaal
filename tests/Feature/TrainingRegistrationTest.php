<?php

namespace Tests\Feature;

use App\Models\Training;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests rond de many-to-many relatie tussen gebruikers en trainingen.
 */
class TrainingRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_member_can_register_and_unregister(): void
    {
        $user = User::factory()->create();
        $training = Training::factory()->upcoming()->create(['capacity' => 5]);

        $this->actingAs($user)
            ->from(route('trainings.show', $training))
            ->post(route('trainings.register', $training))
            ->assertRedirect(route('trainings.show', $training));

        $this->assertDatabaseHas('training_user', [
            'user_id' => $user->id,
            'training_id' => $training->id,
        ]);

        $this->actingAs($user)
            ->from(route('trainings.show', $training))
            ->delete(route('trainings.unregister', $training));

        $this->assertDatabaseMissing('training_user', [
            'user_id' => $user->id,
            'training_id' => $training->id,
        ]);
    }

    public function test_registering_twice_does_not_create_a_second_row(): void
    {
        $user = User::factory()->create();
        $training = Training::factory()->upcoming()->create(['capacity' => 5]);

        $this->actingAs($user)->post(route('trainings.register', $training));
        $this->actingAs($user)->post(route('trainings.register', $training));

        $this->assertSame(1, $training->participants()->count());
    }

    public function test_a_full_training_refuses_new_registrations(): void
    {
        $training = Training::factory()->upcoming()->create(['capacity' => 1]);
        $training->participants()->attach(User::factory()->create()->id, ['registered_at' => now()]);

        $latecomer = User::factory()->create();

        $this->actingAs($latecomer)
            ->from(route('trainings.show', $training))
            ->post(route('trainings.register', $training))
            ->assertSessionHas('error');

        $this->assertSame(1, $training->participants()->count());
    }

    public function test_a_started_training_cannot_be_joined(): void
    {
        $training = Training::factory()->create([
            'starts_at' => now()->subDay(),
            'ends_at' => now()->subDay()->addHours(2),
        ]);

        $this->actingAs(User::factory()->create())
            ->from(route('trainings.show', $training))
            ->post(route('trainings.register', $training))
            ->assertSessionHas('error');

        $this->assertSame(0, $training->participants()->count());
    }

    public function test_visitors_must_log_in_first(): void
    {
        $training = Training::factory()->upcoming()->create();

        $this->post(route('trainings.register', $training))->assertRedirect(route('login'));
    }
}
