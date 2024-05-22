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
        $guards = [
            'administrador' => 'administrador_id',
            'vendedor' => 'vendedor_id',
            'conserje' => 'conserje_id'
        ];
        foreach ($roles as $rol ) {
            if (isset($guards[$rol]) && $request->session()->has($guards[$rol])) {
                $userId = $request->session()->get($guards[$rol]);
                $user = Auth::loginUsingId($userId); 
                if ($user && $user->rol->rol === $rol) {
                    Log::debug('User rol:', [$user->rol->rol]);
                    Log::debug('Session:', $request->session()->all());
                    return $next($request);
                }
            }

        }
        return redirect('/access-denied');
    }
}
