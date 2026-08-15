<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactMessageRequest;
use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function create(): View
    {
        return view('contact.create');
    }

    /**
     * Bewaart het bericht en stuurt het door naar de beheerder.
     */
    public function store(ContactMessageRequest $request): RedirectResponse
    {
        $contactMessage = ContactMessage::create($request->validated());

        Mail::to(config('klimclub.admin_mail.address'), config('klimclub.admin_mail.name'))
            ->send(new ContactMessageReceived($contactMessage));

        return redirect()
            ->route('contact.create')
            ->with('status', 'Bedankt voor je bericht. We nemen zo snel mogelijk contact met je op.');
    }
}
