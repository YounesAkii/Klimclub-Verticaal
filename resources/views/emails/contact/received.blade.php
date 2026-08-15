<x-mail::message>
# Nieuw contactbericht

Er is een nieuw bericht binnengekomen via het contactformulier op de website.

<x-mail::panel>
**Van:** {{ $contactMessage->name }} ({{ $contactMessage->email }})
**Onderwerp:** {{ $contactMessage->subject }}
**Ontvangen op:** {{ $contactMessage->created_at->translatedFormat('j F Y \o\m H:i') }}
</x-mail::panel>

{{ $contactMessage->message }}

<x-mail::button :url="route('admin.contact-messages.show', $contactMessage)">
Bekijk en beantwoord in het beheer
</x-mail::button>

Je kan ook rechtstreeks op deze e-mail antwoorden; dat komt terecht bij {{ $contactMessage->email }}.

Groeten,<br>
{{ config('app.name') }}
</x-mail::message>
