<x-mail::message>
# Dag {{ $contactMessage->name }}

Bedankt voor je bericht aan Klimclub Verticaal. Hierbij ons antwoord.

{{ $contactMessage->reply }}

<x-mail::panel>
**Je oorspronkelijke bericht van {{ $contactMessage->created_at->translatedFormat('j F Y') }}:**

{{ $contactMessage->message }}
</x-mail::panel>

Heb je nog vragen? Antwoord gerust op deze e-mail of gebruik opnieuw het
[contactformulier]({{ route('contact.create') }}).

Met vriendelijke groeten,<br>
{{ config('app.name') }}
</x-mail::message>
