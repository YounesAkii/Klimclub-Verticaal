<?php

namespace Tests\Feature;

use App\Mail\ContactMessageAnswered;
use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_visitor_can_send_a_message_and_the_admin_receives_a_mail(): void
    {
        Mail::fake();

        $response = $this->post(route('contact.store'), [
            'name' => 'Karen Vandenberghe',
            'email' => 'karen@example.com',
            'subject' => 'Verjaardagsfeestje',
            'message' => 'Organiseren jullie verjaardagsfeestjes voor kinderen van een jaar of tien?',
        ]);

        $response->assertRedirect(route('contact.create'))->assertSessionHasNoErrors();

        $this->assertDatabaseHas('contact_messages', ['email' => 'karen@example.com']);

        Mail::assertSent(ContactMessageReceived::class, function (ContactMessageReceived $mail) {
            return $mail->hasTo(config('klimclub.admin_mail.address'));
        });
    }

    public function test_the_contact_form_validates_its_input(): void
    {
        $this->post(route('contact.store'), [
            'name' => 'A',
            'email' => 'geen-adres',
            'subject' => '',
            'message' => 'te kort',
        ])->assertSessionHasErrors(['name', 'email', 'subject', 'message']);
    }

    public function test_an_admin_can_reply_and_the_sender_receives_the_answer(): void
    {
        Mail::fake();

        $admin = User::factory()->admin()->create();
        $message = ContactMessage::factory()->create(['email' => 'karen@example.com']);

        $this->actingAs($admin)
            ->post(route('admin.contact-messages.reply', $message), [
                'reply' => 'Dat kan zeker. We werken met een formule van twee uur begeleide initiatie.',
            ])
            ->assertRedirect(route('admin.contact-messages.show', $message))
            ->assertSessionHasNoErrors();

        $message->refresh();

        $this->assertNotNull($message->replied_at);
        $this->assertSame($admin->id, $message->replied_by);

        Mail::assertSent(ContactMessageAnswered::class, fn ($mail) => $mail->hasTo('karen@example.com'));
    }

    public function test_a_member_cannot_open_the_inbox(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.contact-messages.index'))
            ->assertForbidden();
    }
}
