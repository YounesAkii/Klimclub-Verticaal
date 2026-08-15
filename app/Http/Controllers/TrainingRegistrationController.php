<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Beheert de inschrijvingen van een lid op een training. Dit is de kant van de
 * many-to-many relatie tussen users en trainings die de gebruiker zelf bedient.
 */
class TrainingRegistrationController extends Controller
{
    /**
     * Schrijf de ingelogde gebruiker in.
     */
    public function store(Request $request, Training $training): RedirectResponse
    {
        $user = $request->user();

        if ($training->hasStarted()) {
            return back()->with('error', 'Deze training is al gestart, inschrijven kan niet meer.');
        }

        if ($training->hasParticipant($user)) {
            return back()->with('error', 'Je bent al ingeschreven voor deze training.');
        }

        if ($training->isFull()) {
            return back()->with('error', 'Deze training is volzet.');
        }

        // syncWithoutDetaching laat bestaande inschrijvingen ongemoeid en
        // voorkomt een dubbele rij bij een dubbele klik.
        $training->participants()->syncWithoutDetaching([
            $user->id => ['registered_at' => now()],
        ]);

        return back()->with('status', 'Je bent ingeschreven voor "' . $training->title . '".');
    }

    /**
     * Schrijf de ingelogde gebruiker weer uit.
     */
    public function destroy(Request $request, Training $training): RedirectResponse
    {
        if ($training->hasStarted()) {
            return back()->with('error', 'Deze training is al gestart, uitschrijven kan niet meer.');
        }

        $training->participants()->detach($request->user()->id);

        return back()->with('status', 'Je inschrijving voor "' . $training->title . '" is geannuleerd.');
    }
}
