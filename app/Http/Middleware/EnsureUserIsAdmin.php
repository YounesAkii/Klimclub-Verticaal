<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Laat enkel ingelogde beheerders door. Alle routes van het adminpaneel
 * krijgen deze middleware bovenop 'auth'.
 */
class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->is_admin) {
            abort(403, 'Deze pagina is enkel toegankelijk voor beheerders.');
        }

        return $next($request);
    }
}
