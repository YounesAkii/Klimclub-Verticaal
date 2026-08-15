<?php

/*
|--------------------------------------------------------------------------
| Nederlandstalige validatieberichten
|--------------------------------------------------------------------------
|
| Laravel levert enkel Engelse berichten mee. Dit bestand bevat de Nederlandse
| vertaling van de regels die in dit project gebruikt worden. Regels die hier
| ontbreken vallen terug op het Engels (APP_FALLBACK_LOCALE).
|
*/

return [

    'accepted' => ':attribute moet aanvaard worden.',
    'after' => ':attribute moet een datum na :date zijn.',
    'after_or_equal' => ':attribute moet een datum vanaf :date zijn.',
    'alpha' => ':attribute mag enkel letters bevatten.',
    'alpha_dash' => ':attribute mag enkel letters, cijfers, koppeltekens en underscores bevatten.',
    'alpha_num' => ':attribute mag enkel letters en cijfers bevatten.',
    'array' => ':attribute moet een lijst zijn.',
    'before' => ':attribute moet een datum voor :date zijn.',
    'before_or_equal' => ':attribute moet een datum tot en met :date zijn.',
    'between' => [
        'array' => ':attribute moet tussen :min en :max items bevatten.',
        'file' => ':attribute moet tussen :min en :max kilobytes groot zijn.',
        'numeric' => ':attribute moet tussen :min en :max liggen.',
        'string' => ':attribute moet tussen :min en :max tekens lang zijn.',
    ],
    'boolean' => ':attribute moet ja of nee zijn.',
    'confirmed' => 'De bevestiging van :attribute komt niet overeen.',
    'current_password' => 'Het opgegeven wachtwoord is niet correct.',
    'date' => ':attribute is geen geldige datum.',
    'date_format' => ':attribute komt niet overeen met het formaat :format.',
    'different' => ':attribute en :other moeten verschillend zijn.',
    'digits' => ':attribute moet :digits cijfers bevatten.',
    'digits_between' => ':attribute moet tussen :min en :max cijfers bevatten.',
    'dimensions' => ':attribute heeft ongeldige afmetingen.',
    'email' => ':attribute moet een geldig e-mailadres zijn.',
    'ends_with' => ':attribute moet eindigen op een van de volgende: :values.',
    'exists' => 'De geselecteerde :attribute bestaat niet.',
    'file' => ':attribute moet een bestand zijn.',
    'filled' => ':attribute moet ingevuld zijn.',
    'gt' => [
        'file' => ':attribute moet groter zijn dan :value kilobytes.',
        'numeric' => ':attribute moet groter zijn dan :value.',
        'string' => ':attribute moet langer zijn dan :value tekens.',
    ],
    'gte' => [
        'file' => ':attribute moet minstens :value kilobytes groot zijn.',
        'numeric' => ':attribute moet minstens :value zijn.',
        'string' => ':attribute moet minstens :value tekens lang zijn.',
    ],
    'image' => ':attribute moet een afbeelding zijn.',
    'in' => 'De geselecteerde :attribute is ongeldig.',
    'integer' => ':attribute moet een geheel getal zijn.',
    'lowercase' => ':attribute mag enkel kleine letters bevatten.',
    'lt' => [
        'file' => ':attribute moet kleiner zijn dan :value kilobytes.',
        'numeric' => ':attribute moet kleiner zijn dan :value.',
        'string' => ':attribute moet korter zijn dan :value tekens.',
    ],
    'lte' => [
        'file' => ':attribute mag maximaal :value kilobytes groot zijn.',
        'numeric' => ':attribute mag maximaal :value zijn.',
        'string' => ':attribute mag maximaal :value tekens lang zijn.',
    ],
    'max' => [
        'array' => ':attribute mag maximaal :max items bevatten.',
        'file' => ':attribute mag maximaal :max kilobytes groot zijn.',
        'numeric' => ':attribute mag maximaal :max zijn.',
        'string' => ':attribute mag maximaal :max tekens lang zijn.',
    ],
    'mimes' => ':attribute moet een bestand zijn van het type: :values.',
    'mimetypes' => ':attribute moet een bestand zijn van het type: :values.',
    'min' => [
        'array' => ':attribute moet minstens :min items bevatten.',
        'file' => ':attribute moet minstens :min kilobytes groot zijn.',
        'numeric' => ':attribute moet minstens :min zijn.',
        'string' => ':attribute moet minstens :min tekens lang zijn.',
    ],
    'not_in' => 'De geselecteerde :attribute is ongeldig.',
    'numeric' => ':attribute moet een getal zijn.',
    'present' => ':attribute moet aanwezig zijn.',
    'regex' => 'Het formaat van :attribute is ongeldig.',
    'required' => ':attribute is verplicht.',
    'required_if' => ':attribute is verplicht wanneer :other gelijk is aan :value.',
    'required_with' => ':attribute is verplicht wanneer :values ingevuld is.',
    'required_without' => ':attribute is verplicht wanneer :values niet ingevuld is.',
    'same' => ':attribute en :other moeten overeenkomen.',
    'size' => [
        'array' => ':attribute moet :size items bevatten.',
        'file' => ':attribute moet :size kilobytes groot zijn.',
        'numeric' => ':attribute moet :size zijn.',
        'string' => ':attribute moet :size tekens lang zijn.',
    ],
    'starts_with' => ':attribute moet beginnen met een van de volgende: :values.',
    'string' => ':attribute moet tekst zijn.',
    'unique' => ':attribute is al in gebruik.',
    // Deze regel slaat aan wanneer PHP het bestand al geweigerd heeft, meestal
    // omdat het groter is dan upload_max_filesize in php.ini.
    'uploaded' => 'Het uploaden van :attribute is mislukt. Het bestand is waarschijnlijk te groot voor de server.',
    'url' => ':attribute moet een geldige URL zijn.',

    'password' => [
        'letters' => ':attribute moet minstens één letter bevatten.',
        'mixed' => ':attribute moet minstens één hoofdletter en één kleine letter bevatten.',
        'numbers' => ':attribute moet minstens één cijfer bevatten.',
        'symbols' => ':attribute moet minstens één symbool bevatten.',
        'uncompromised' => ':attribute komt voor in een datalek. Kies een ander wachtwoord.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Eigen validatieberichten
    |--------------------------------------------------------------------------
    */

    'custom' => [
        'password' => [
            'confirmed' => 'De twee wachtwoorden komen niet overeen.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Namen van de velden
    |--------------------------------------------------------------------------
    |
    | De meeste form requests geven zelf een Nederlandse naam mee via
    | attributes(); dit zijn de terugvalwaarden.
    |
    */

    'attributes' => [
        'name' => 'naam',
        'username' => 'gebruikersnaam',
        'email' => 'e-mailadres',
        'password' => 'wachtwoord',
        'password_confirmation' => 'wachtwoordbevestiging',
        'current_password' => 'huidig wachtwoord',
        'birthday' => 'verjaardag',
        'bio' => 'over mij',
        'avatar' => 'profielfoto',
        'title' => 'titel',
        'content' => 'inhoud',
        'excerpt' => 'samenvatting',
        'image' => 'afbeelding',
        'published_at' => 'publicatiedatum',
        'question' => 'vraag',
        'answer' => 'antwoord',
        'subject' => 'onderwerp',
        'message' => 'bericht',
        'reply' => 'antwoord',
        'body' => 'reactie',
        'location' => 'locatie',
        'level' => 'niveau',
        'capacity' => 'maximum aantal deelnemers',
        'starts_at' => 'startmoment',
        'ends_at' => 'eindmoment',
        'position' => 'volgorde',
        'description' => 'omschrijving',
        'faq_category_id' => 'categorie',
        'instructor_id' => 'lesgever',
    ],

];
