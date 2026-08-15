<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Bundelt het opslaan en verwijderen van geüploade afbeeldingen op de publieke
 * disk (storage/app/public, bereikbaar via de symlink public/storage).
 *
 * Zowel de profielfoto's als de nieuwsafbeeldingen gebruiken deze klasse, zodat
 * de uploadlogica op één plek staat.
 */
class ImageUploader
{
    /**
     * Bewaart het bestand in de opgegeven map en geeft het relatieve pad terug
     * zoals het in de databank bewaard wordt. Laravel genereert zelf een unieke
     * bestandsnaam, waardoor een geüploade naam nooit een bestaand bestand kan
     * overschrijven.
     */
    public function store(UploadedFile $file, string $folder): string
    {
        return $file->store($folder, 'public');
    }

    /**
     * Verwijdert een bestand van de publieke disk. Doet niets wanneer er geen
     * pad meegegeven wordt of het bestand al weg is.
     */
    public function delete(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
