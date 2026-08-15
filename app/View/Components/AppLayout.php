<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

/**
 * Layout van de publieke website: navigatie bovenaan, footer onderaan.
 */
class AppLayout extends Component
{
    public function __construct(
        public ?string $title = null,
        public ?string $description = null,
    ) {}

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.app');
    }
}
