<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrainingRequest;
use App\Models\Training;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TrainingController extends Controller
{
    public function index(): View
    {
        return view('admin.trainings.index', [
            'trainings' => Training::query()
                ->orderByDesc('starts_at')
                ->with('instructor')
                ->withCount('participants')
                ->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.trainings.create', [
            'training' => new Training([
                'level' => 'alle niveaus',
                'capacity' => 12,
                'starts_at' => now()->addWeek()->setTime(19, 0),
                'ends_at' => now()->addWeek()->setTime(21, 0),
            ]),
            'instructors' => $this->instructors(),
        ]);
    }

    public function store(TrainingRequest $request): RedirectResponse
    {
        $training = new Training($request->safe()->except('slug'));
        $training->slug = $this->resolveSlug($request->validated('slug'), $request->validated('title'));
        $training->save();

        return redirect()
            ->route('admin.trainings.index')
            ->with('status', 'De training "' . $training->title . '" is aangemaakt.');
    }

    public function show(Training $training): View
    {
        $training->load(['instructor', 'participants']);

        return view('admin.trainings.show', [
            'training' => $training,
        ]);
    }

    public function edit(Training $training): View
    {
        return view('admin.trainings.edit', [
            'training' => $training,
            'instructors' => $this->instructors(),
        ]);
    }

    public function update(TrainingRequest $request, Training $training): RedirectResponse
    {
        $training->fill($request->safe()->except('slug'));
        $training->slug = $this->resolveSlug($request->validated('slug'), $request->validated('title'), $training);
        $training->save();

        return redirect()
            ->route('admin.trainings.index')
            ->with('status', 'De training "' . $training->title . '" is bijgewerkt.');
    }

    public function destroy(Training $training): RedirectResponse
    {
        $title = $training->title;

        // De inschrijvingen in de koppeltabel verdwijnen mee via de cascade.
        $training->delete();

        return redirect()
            ->route('admin.trainings.index')
            ->with('status', 'De training "' . $title . '" is verwijderd.');
    }

    /**
     * Alle gebruikers komen in aanmerking als lesgever; in de praktijk kiest de
     * beheerder hier een trainer uit.
     */
    private function instructors()
    {
        return User::orderBy('username')->get(['id', 'username', 'name']);
    }

    private function resolveSlug(?string $slug, string $title, ?Training $current = null): string
    {
        $base = Str::slug($slug ?: $title);
        $candidate = $base;
        $suffix = 2;

        while (Training::where('slug', $candidate)->whereKeyNot($current?->id ?? 0)->exists()) {
            $candidate = $base . '-' . $suffix++;
        }

        return $candidate;
    }
}
