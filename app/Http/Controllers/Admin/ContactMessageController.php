<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactReplyRequest;
use App\Mail\ContactMessageAnswered;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

/**
 * De inbox van het adminpaneel: alle ingevulde contactformulieren, met de
 * mogelijkheid om er rechtstreeks op te antwoorden.
 */
class ContactMessageController extends Controller
{
    public function index(Request $request): View
    {
        $filter = $request->query('status');

        return view('admin.contact-messages.index', [
            'messages' => ContactMessage::query()
                ->when($filter === 'open', fn ($query) => $query->unanswered())
                ->when($filter === 'beantwoord', fn ($query) => $query->whereNotNull('replied_at'))
                ->latest()
                ->paginate(15)
                ->withQueryString(),
            'filter' => $filter,
            'openCount' => ContactMessage::unanswered()->count(),
        ]);
    }

    public function show(ContactMessage $contactMessage): View
    {
        return view('admin.contact-messages.show', [
            'message' => $contactMessage->load('repliedBy'),
        ]);
    }

    /**
     * Bewaar het antwoord en mail het naar de afzender.
     */
    public function reply(ContactReplyRequest $request, ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->forceFill([
            'reply' => $request->validated('reply'),
            'replied_at' => now(),
            'replied_by' => $request->user()->id,
        ])->save();

        Mail::to($contactMessage->email, $contactMessage->name)
            ->send(new ContactMessageAnswered($contactMessage));

        return redirect()
            ->route('admin.contact-messages.show', $contactMessage)
            ->with('status', 'Het antwoord is verstuurd naar ' . $contactMessage->email . '.');
    }

    public function destroy(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->delete();

        return redirect()
            ->route('admin.contact-messages.index')
            ->with('status', 'Het bericht is verwijderd.');
    }
}
