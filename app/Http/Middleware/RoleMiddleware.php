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
    public function handle($request, Closure $next, $rol)
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        //Usuario admin tiene acceso a todas la rutas.
        if ($user->rol->rol == 'administrador') {
            return $next($request);
        }

        // Verificar si el usuario tiene alguno de los roles requeridos
        if ($user->rol->rol == $rol) {
            return $next($request);
        }

        // Si el usuario no tiene ninguno de los roles requeridos, redirigir o responder con un error
        return redirect('/access-denied');
    }
}
