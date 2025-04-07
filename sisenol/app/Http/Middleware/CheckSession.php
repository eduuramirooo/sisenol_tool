<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSession
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('id')) {
            return redirect('/formulario')->with('error', 'Debes iniciar sesión');
        }

        return $next($request);
    }
}

