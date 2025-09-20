<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario autenticado tiene el rol 'admin'
        if (Auth::check() && Auth::user()->role !== 'admin') {
            // Si no es admin, redirigir al dashboard o cualquier otra página
            return redirect()->route('dashboard')->with('error', 'Acceso denegado');
        }

        // Si es admin, permitir que pase
        return $next($request);
    }
}
