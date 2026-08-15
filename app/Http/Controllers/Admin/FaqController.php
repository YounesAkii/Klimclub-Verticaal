<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FaqRequest;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(): View
    {
        return view('admin.faqs.index', [
            'categories' => FaqCategory::query()
                ->ordered()
                ->with('faqs')
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.faqs.create', [
            'faq' => new Faq(['position' => 0]),
            'categories' => FaqCategory::ordered()->get(),
        ]);
    }

    public function store(FaqRequest $request): RedirectResponse
    {
        Faq::create($request->validated());

        return redirect()
            ->route('admin.faqs.index')
            ->with('status', 'De vraag is toegevoegd aan de FAQ.');
    }

    public function edit(Faq $faq): View
    {
        return view('admin.faqs.edit', [
            'faq' => $faq,
            'categories' => FaqCategory::ordered()->get(),
        ]);
    }

    public function update(FaqRequest $request, Faq $faq): RedirectResponse
    {
        $faq->update($request->validated());

        return redirect()
            ->route('admin.faqs.index')
            ->with('status', 'De vraag is bijgewerkt.');
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();

        return redirect()
            ->route('admin.faqs.index')
            ->with('status', 'De vraag is verwijderd.');
    }
}
