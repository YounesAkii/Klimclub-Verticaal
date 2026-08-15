<?php

/*
|--------------------------------------------------------------------------
| Testinstellingen laten winnen van de omgeving
|--------------------------------------------------------------------------
|
| PHPUnit schrijft de waarden uit het <php>-blok van phpunit.xml naar $_ENV en
| naar putenv(), maar niet naar $_SERVER. Laravel leest $_SERVER als eerste bron
| en gebruikt die waarde dus nog steeds. Staat er in je shell bijvoorbeeld een
| DB_CONNECTION, dan draaien de tests op die verbinding in plaats van op de
| SQLite-databank in het geheugen, en wist RefreshDatabase je echte data.
|
| Door de sleutels die phpunit.xml instelt ook in $_SERVER te zetten, winnen de
| testinstellingen altijd.
|
*/

require __DIR__ . '/../vendor/autoload.php';

$testInstellingen = [
    'APP_ENV',
    'APP_MAINTENANCE_DRIVER',
    'BCRYPT_ROUNDS',
    'BROADCAST_CONNECTION',
    'CACHE_STORE',
    'DB_CONNECTION',
    'DB_DATABASE',
    'DB_URL',
    'MAIL_MAILER',
    'QUEUE_CONNECTION',
    'SESSION_DRIVER',
];

foreach ($testInstellingen as $sleutel) {
    if (array_key_exists($sleutel, $_ENV)) {
        $_SERVER[$sleutel] = $_ENV[$sleutel];
    }
}

// De databankgegevens uit .env mogen tijdens het testen helemaal niet meespelen.
foreach (['DB_HOST', 'DB_PORT', 'DB_USERNAME', 'DB_PASSWORD'] as $sleutel) {
    unset($_SERVER[$sleutel], $_ENV[$sleutel]);
    putenv($sleutel);
}
