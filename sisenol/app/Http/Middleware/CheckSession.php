<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSession
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('id')) {
            return redirect('/')->with('error', 'Debes iniciar sesión como administrador para acceder a esta sección.');
        }

        return $next($request);
    }
}

