<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Het antwoord dat een beheerder vanuit het adminpaneel naar de afzender van
 * een contactbericht stuurt.
 */
class ContactMessageAnswered extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactMessage $contactMessage) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Re: ' . $this->contactMessage->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.contact.answered',
        );
    }
}
