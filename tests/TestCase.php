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
     * Deze controle stopt de suite meteen met een duidelijke melding wanneer de
     * testinstellingen niet aangekomen zijn.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $connection = config('database.default');
        $database = config("database.connections.{$connection}.database");

        if ($connection !== 'sqlite' || $database !== ':memory:') {
            throw new RuntimeException(
                'De tests draaien niet op de testdatabank maar op de verbinding '
                . "[{$connection}] met databank [{$database}]. De instellingen uit "
                . 'phpunit.xml zijn niet aangekomen. Draai "php artisan config:clear" '
                . 'en controleer of er geen DB_CONNECTION of APP_ENV in je '
                . 'omgevingsvariabelen staat. De testrun is gestopt om te '
                . 'voorkomen dat je echte databank leeggemaakt wordt.'
            );
        }
    }
}
