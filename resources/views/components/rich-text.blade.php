@props(['text'])

{{-- Toont tekst uit de databank als alinea's. De inhoud gaat door e() voordat
     nl2br() de regeleindes omzet, zodat HTML in de invoer nooit uitgevoerd
     wordt (XSS-bescherming). --}}
<div {{ $attributes->merge(['class' => 'prose-club']) }}>
    @foreach (preg_split('/\R{2,}/', trim((string) $text)) as $paragraph)
        <p>{!! nl2br(e($paragraph)) !!}</p>
    @endforeach
</div>
