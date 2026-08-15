<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use RuntimeException;

abstract class TestCase extends BaseTestCase
{
    /**
     * De tests gebruiken RefreshDatabase, wat alle tabellen leegmaakt. Draaien
     * ze per ongeluk op de gewone databank uit .env in plaats van op de SQLite-
     * databank uit phpunit.xml, dan wist een testrun dus alle echte data.
     *
     * De controle staat bewust in refreshApplication(): Laravel roept die aan
     * nadat de applicatie gemaakt is, maar nog voor setUpTraits() de databank
     * migreert. Zou de controle pas in setUp() staan, dan was de data al weg
     * tegen de tijd dat de melding verschijnt.
     */
    protected function refreshApplication(): void
    {
        parent::refreshApplication();

        $connection = config('database.default');
        $database = config("database.connections.{$connection}.database");

        if ($connection !== 'sqlite' || $database !== ':memory:') {
            throw new RuntimeException($this->explainWrongDatabase($connection, $database));
        }
    }

    /**
     * Bouwt een foutmelding die meteen laat zien waar de verkeerde instelling
     * vandaan komt, zodat de oorzaak niet geraden hoeft te worden.
     */
    private function explainWrongDatabase(?string $connection, ?string $database): string
    {
        $herkomst = function (string $sleutel): string {
            $bronnen = [];

            if (array_key_exists($sleutel, $_SERVER)) {
                $bronnen[] = '$_SERVER=' . var_export($_SERVER[$sleutel], true);
            }
            if (array_key_exists($sleutel, $_ENV)) {
                $bronnen[] = '$_ENV=' . var_export($_ENV[$sleutel], true);
            }
            if (($getenv = getenv($sleutel)) !== false) {
                $bronnen[] = 'getenv=' . var_export($getenv, true);
            }

            return $bronnen === [] ? 'nergens gezet' : implode(', ', $bronnen);
        };

        return implode(PHP_EOL, [
            'De tests draaien niet op de testdatabank.',
            "  verbinding      : {$connection} (verwacht: sqlite)",
            "  databank        : {$database} (verwacht: :memory:)",
            '  APP_ENV         : ' . config('app.env') . ' (verwacht: testing)',
            '  config gecachet : ' . (file_exists(base_path('bootstrap/cache/config.php')) ? 'JA - dit is de oorzaak' : 'nee'),
            '  DB_CONNECTION   : ' . $herkomst('DB_CONNECTION'),
            '  APP_ENV bron    : ' . $herkomst('APP_ENV'),
            '',
            'De testrun is gestopt voordat er iets gemigreerd of gewist werd.',
            'Los op met "php artisan config:clear", of verwijder de omgevingsvariabele',
            'die hierboven getoond wordt.',
        ]);
    }
}
