<?php

namespace App\Http\Controllers;

use App\Models\FaqCategory;
use Illuminate\View\View;

class FaqController extends Controller
{
    /**
     * De publieke FAQ: alle vragen, gegroepeerd per categorie.
     */
    public function index(): View
    {
        return view('faq.index', [
            'categories' => FaqCategory::query()
                ->ordered()
                ->with('faqs')
                ->get(),
        ]);
    }
}
