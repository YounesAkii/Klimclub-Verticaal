<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * De publieke trainingsagenda. Het beheer zit in
 * App\Http\Controllers\Admin\TrainingController.
 */
class TrainingController extends Controller
{
    public function index(Request $request): View
    {
        $level = $request->query('niveau');
        $showPast = $request->query('periode') === 'voorbij';

        $trainings = Training::query()
            ->when($showPast, fn ($query) => $query->past(), fn ($query) => $query->upcoming())
            ->when(
                in_array($level, ['beginner', 'gevorderd', 'alle niveaus'], true),
                fn ($query) => $query->where('level', $level)
            )
            ->with(['instructor', 'participants'])
            ->withCount('participants')
            ->paginate(9)
            ->withQueryString();

        return view('trainings.index', [
            'trainings' => $trainings,
            'level' => $level,
            'showPast' => $showPast,
        ]);
    }

    public function show(Training $training): View
    {
        $training->load(['instructor', 'participants']);
        $training->loadCount('participants');

        return view('trainings.show', [
            'training' => $training,
        ]);
    }
}
