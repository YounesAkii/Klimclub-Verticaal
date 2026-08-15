<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

/**
 * Layout van het adminpaneel: zijbalk met de beheersecties in plaats van de
 * publieke navigatie.
 */
class AdminLayout extends Component
{
    public function __construct(
        public string $title = 'Beheer',
    ) {}

    public function render(): View
    {
        return view('layouts.admin');
    }
}
