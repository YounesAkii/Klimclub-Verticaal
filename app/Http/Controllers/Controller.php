<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller
{
    // Maakt $this->authorize() beschikbaar in alle controllers, zodat de
    // policies vanuit de controller aangeroepen kunnen worden.
    use AuthorizesRequests;
}
