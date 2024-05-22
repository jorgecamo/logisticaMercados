<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\Puesto;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;


class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('inicio');
    }

    /**
     * Handle the login request.
     */
    public function login(Request $request)
    {
        try {
            // Buscar usuario por DNI
            $usuario = Usuario::where('DNI', $request->get('usuario'))->firstOrFail();
            // Verificar la contraseña
            if (Hash::check($request->get('contrasena'), $usuario->contrasenya)) {
                // Obtener roles
                $rolconserje = Rol::where('rol', 'conserje')->firstOrFail();
                $rolvendedor = Rol::where('rol', 'vendedor')->firstOrFail();
                $roladministrador = Rol::where('rol', 'administrador')->firstOrFail();


                // Redirigir según el rol del usuario
                if ($usuario->Id_rol == $rolconserje->Id_rol) {
                    $this->registrarseComo($request, $usuario, 'conserje_id');

                    return redirect()->route('conserje.dashboard');
                } elseif ($usuario->Id_rol == $rolvendedor->Id_rol) {
                    $this->registrarseComo($request, $usuario, 'vendedor_id');

                    return redirect()->route('vendedor.dashboard');
                } elseif ($usuario->Id_rol == $roladministrador->Id_rol) {
                    $this->registrarseComo($request, $usuario, 'administrador_id');
                    return redirect()->route('admin.dashboard');
                }
            } else {
                return redirect()->back()->withErrors(['contrasena' => 'Contraseña incorrecta']);
            }
        } catch (ModelNotFoundException $exception) {
            return redirect()->back()->withErrors(['usuario' => 'Usuario no encontrado']);
        }
    }

    private function registrarseComo(Request $request, $usuario, $roleKey)
    {
        Auth::login($usuario);
        $user = Auth::user();
        $request->session()->put($roleKey, $user->Id_usuario);
    }

    public function logout(Request $request)
    {
        // Limpiar borrar sesion
        Auth::logout();
        return redirect('/login');
    }
}
