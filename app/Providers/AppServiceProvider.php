<?php

namespace App\Providers;

use Illuminate\Foundation\Console\ServeCommand;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->allowFileUploadsThroughArtisanServe();
    }

    /**
     * "php artisan serve" start de ingebouwde webserver van PHP op met een
     * beperkte set omgevingsvariabelen. TMP en TEMP zitten daar niet bij, en
     * net die heeft PHP op Windows nodig om de tijdelijke map te bepalen waarin
     * een upload eerst geschreven wordt.
     *
     * Zonder deze twee variabelen mislukt elke upload met foutcode
     * UPLOAD_ERR_NO_TMP_DIR, en ziet de gebruiker enkel dat het uploaden niet
     * gelukt is. Door ze alsnog door te geven werken de profielfoto's en de
     * nieuwsafbeeldingen ook via "php artisan serve".
     */
    private function allowFileUploadsThroughArtisanServe(): void
    {
        if (! $this->app->runningInConsole() || ! class_exists(ServeCommand::class)) {
            return;
        }

        foreach (['TMP', 'TEMP'] as $variable) {
            if (! in_array($variable, ServeCommand::$passthroughVariables, true)) {
                ServeCommand::$passthroughVariables[] = $variable;
            }
        }
    }
}
