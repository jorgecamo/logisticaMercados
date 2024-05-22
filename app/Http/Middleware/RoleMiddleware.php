<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (Auth::check()) {
            $user = Auth::user();
            Log::debug($user->rol->rol);
            // Log::debug($request->session()->all());
            if (in_array($user->rol->rol, $roles)) {
                return $next($request);
            }
        }

        return redirect('/access-denied');
    }
}
