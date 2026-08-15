<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Gegevens van de club
    |--------------------------------------------------------------------------
    |
    | Deze waarden worden gebruikt in de footer, op de contactpagina en in de
    | uitgaande e-mails. Zo staan ze op één plek in plaats van verspreid over
    | de views.
    |
    */

    'address' => 'Nijverheidskaai 170, 1070 Anderlecht',
    'phone' => '+32 2 555 43 21',
    'email' => 'info@klimclubverticaal.be',

    'opening_hours' => [
        'Maandag tot vrijdag' => '16:00 - 23:00',
        'Zaterdag' => '10:00 - 20:00',
        'Zondag' => '10:00 - 18:00',
    ],

    /*
    |--------------------------------------------------------------------------
    | Ontvanger van het contactformulier
    |--------------------------------------------------------------------------
    |
    | Elk verstuurd contactformulier komt op dit adres toe.
    |
    */

    'admin_mail' => [
        'address' => env('MAIL_ADMIN_ADDRESS', 'admin@ehb.be'),
        'name' => env('MAIL_ADMIN_NAME', 'Beheer Klimclub Verticaal'),
    ],

];
