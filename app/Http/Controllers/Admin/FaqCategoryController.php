<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FaqCategoryRequest;
use App\Models\FaqCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class FaqCategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.faq-categories.index', [
            'categories' => FaqCategory::query()
                ->ordered()
                ->withCount('faqs')
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.faq-categories.create', [
            'category' => new FaqCategory(['position' => FaqCategory::max('position') + 1]),
        ]);
    }

    public function store(FaqCategoryRequest $request): RedirectResponse
    {
        $category = new FaqCategory($request->validated());
        $category->slug = $this->resolveSlug($request->validated('name'));
        $category->save();

        return redirect()
            ->route('admin.faq-categories.index')
            ->with('status', 'De categorie "' . $category->name . '" is aangemaakt.');
    }

    public function edit(FaqCategory $faqCategory): View
    {
        return view('admin.faq-categories.edit', [
            'category' => $faqCategory,
        ]);
    }

    public function update(FaqCategoryRequest $request, FaqCategory $faqCategory): RedirectResponse
    {
        $faqCategory->fill($request->validated());
        $faqCategory->slug = $this->resolveSlug($request->validated('name'), $faqCategory);
        $faqCategory->save();

        return redirect()
            ->route('admin.faq-categories.index')
            ->with('status', 'De categorie "' . $faqCategory->name . '" is bijgewerkt.');
    }

    public function destroy(FaqCategory $faqCategory): RedirectResponse
    {
        $name = $faqCategory->name;

        // De foreign key staat op cascade: de vragen in deze categorie
        // verdwijnen mee.
        $faqCategory->delete();

        return redirect()
            ->route('admin.faq-categories.index')
            ->with('status', 'De categorie "' . $name . '" en haar vragen zijn verwijderd.');
    }

    private function resolveSlug(string $name, ?FaqCategory $current = null): string
    {
        $base = Str::slug($name);
        $candidate = $base;
        $suffix = 2;

        while (FaqCategory::where('slug', $candidate)->whereKeyNot($current?->id ?? 0)->exists()) {
            $candidate = $base . '-' . $suffix++;
        }

        return $candidate;
    }
}
