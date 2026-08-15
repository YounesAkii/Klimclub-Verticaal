<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Throwable;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->ensureStorageLink();

        // De voorbeeldafbeeldingen moeten op de disk staan voor de seeders die
        // ernaar verwijzen beginnen.
        SeedAssets::publish();

        $this->call([
            UserSeeder::class,
            NewsSeeder::class,
            FaqSeeder::class,
            TrainingSeeder::class,
            ContactMessageSeeder::class,
        ]);
    }

    /**
     * Zorgt ervoor dat public/storage bestaat, zodat de geseede afbeeldingen
     * meteen zichtbaar zijn na een verse installatie. Normaal draai je hiervoor
     * "php artisan storage:link"; deze controle voorkomt gebroken afbeeldingen
     * wanneer die stap vergeten wordt.
     */
    private function ensureStorageLink(): void
    {
        if (File::exists(public_path('storage'))) {
            return;
        }

        // Mislukt het aanmaken van de link (bijvoorbeeld door beperkte rechten
        // op het bestandssysteem), dan mag het seeden daar niet op stuklopen.
        // De data komt er dan gewoon in, enkel de afbeeldingen ontbreken tot
        // "php artisan storage:link" handmatig gedraaid wordt.
        try {
            Artisan::call('storage:link');
            $this->command?->info('public/storage aangemaakt (storage:link).');
        } catch (Throwable $e) {
            $this->command?->warn(
                'Kon public/storage niet aanmaken: ' . $e->getMessage()
                . ' Draai "php artisan storage:link" handmatig om de afbeeldingen te tonen.'
            );
        }
    }
}
