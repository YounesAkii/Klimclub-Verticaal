<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

/**
 * Kopieert de meegeleverde voorbeeldafbeeldingen naar de publieke storage-disk.
 *
 * De afbeeldingen staan in database/seeders/assets en worden bij het seeden naar
 * storage/app/public gekopieerd. Zo bevat een verse installatie meteen echte
 * bestanden op de server, precies zoals bij een upload door een gebruiker.
 */
class SeedAssets
{
    /** Bestandsnamen van de nieuwsafbeeldingen, zonder extensie. */
    public const NEWS_IMAGES = [
        'herfstcompetitie',
        'nieuwe-boulderzaal',
        'jeugdwerking',
        'materiaalcheck',
        'clubreis-fontainebleau',
        'nieuwe-routes',
    ];

    /** Bestandsnamen van de profielfoto's, zonder extensie. */
    public const AVATARS = [
        'admin',
        'aya',
        'sven',
        'lotte',
        'mehdi',
        'nora',
        'jonas',
    ];

    /**
     * Zet alle voorbeeldbestanden klaar op de 'public' disk en ruim de
     * bestanden van een vorige seed op.
     */
    public static function publish(): void
    {
        $disk = Storage::disk('public');

        foreach (['news', 'avatars'] as $folder) {
            $disk->deleteDirectory($folder);
            $disk->makeDirectory($folder);

            foreach (File::files(database_path("seeders/assets/{$folder}")) as $file) {
                $disk->put("{$folder}/{$file->getFilename()}", $file->getContents());
            }
        }
    }

    /** Het pad van een nieuwsafbeelding zoals het in de databank bewaard wordt. */
    public static function newsImage(string $name): string
    {
        return "news/{$name}.jpg";
    }

    /** Het pad van een profielfoto zoals het in de databank bewaard wordt. */
    public static function avatar(string $name): string
    {
        return "avatars/{$name}.jpg";
    }
}
