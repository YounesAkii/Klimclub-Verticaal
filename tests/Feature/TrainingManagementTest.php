<?php

namespace Tests\Feature;

use App\Models\Training;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrainingManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_admin_can_create_update_and_delete_a_training(): void
    {
        $admin = User::factory()->admin()->create();
        $instructor = User::factory()->create();

        $this->actingAs($admin)->post(route('admin.trainings.store'), [
            'title' => 'Initiatie touwklimmen',
            'description' => 'Een eerste kennismaking met touwklimmen voor wie nog nooit in een gordel hing.',
            'location' => 'Hoofdzaal',
            'level' => 'beginner',
            'capacity' => 10,
            'starts_at' => now()->addWeek()->format('Y-m-d H:i:s'),
            'ends_at' => now()->addWeek()->addHours(2)->format('Y-m-d H:i:s'),
            'instructor_id' => $instructor->id,
        ])->assertRedirect(route('admin.trainings.index'))->assertSessionHasNoErrors();

        $training = Training::firstOrFail();

        $this->assertSame('initiatie-touwklimmen', $training->slug);
        $this->assertSame($instructor->id, $training->instructor_id);

        $this->actingAs($admin)->put(route('admin.trainings.update', $training), [
            'title' => 'Initiatie bouldering',
            'description' => $training->description,
            'location' => 'Boulderzaal',
            'level' => 'alle niveaus',
            'capacity' => 16,
            'starts_at' => $training->starts_at->format('Y-m-d H:i:s'),
            'ends_at' => $training->ends_at->format('Y-m-d H:i:s'),
        ])->assertSessionHasNoErrors();

        $training->refresh();
        $this->assertSame('Initiatie bouldering', $training->title);
        $this->assertSame(16, $training->capacity);

        $this->actingAs($admin)->delete(route('admin.trainings.destroy', $training));
        $this->assertSame(0, Training::count());
    }

    public function test_the_end_time_must_come_after_the_start_time(): void
    {
        $this->actingAs(User::factory()->admin()->create())
            ->post(route('admin.trainings.store'), [
                'title' => 'Onmogelijke training',
                'description' => 'Deze training eindigt voor ze begint, dat mag niet aanvaard worden.',
                'location' => 'Hoofdzaal',
                'level' => 'beginner',
                'capacity' => 10,
                'starts_at' => now()->addWeek()->format('Y-m-d H:i:s'),
                'ends_at' => now()->addDays(3)->format('Y-m-d H:i:s'),
            ])
            ->assertSessionHasErrors('ends_at');
    }

    public function test_deleting_a_training_removes_its_registrations(): void
    {
        $training = Training::factory()->upcoming()->create();
        $training->participants()->attach(User::factory()->create()->id, ['registered_at' => now()]);

        $this->actingAs(User::factory()->admin()->create())
            ->delete(route('admin.trainings.destroy', $training));

        $this->assertDatabaseEmpty('training_user');
    }

    public function test_an_admin_sees_the_participant_list(): void
    {
        $training = Training::factory()->upcoming()->create();
        $participant = User::factory()->create(['username' => 'lotte']);
        $training->participants()->attach($participant->id, ['registered_at' => now()]);

        $this->actingAs(User::factory()->admin()->create())
            ->get(route('admin.trainings.show', $training))
            ->assertOk()
            ->assertSee('lotte')
            ->assertSee($participant->email);
    }

    public function test_a_member_cannot_manage_trainings(): void
    {
        $training = Training::factory()->upcoming()->create();

        $this->actingAs(User::factory()->create())
            ->delete(route('admin.trainings.destroy', $training))
            ->assertForbidden();

        $this->assertSame(1, Training::count());
    }
}
