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
                // Iniciar sesión manualmente
                Auth::login($usuario);

                // Obtener roles
                $rolconserje = Rol::where('rol', 'conserje')->firstOrFail();
                $rolvendedor = Rol::where('rol', 'vendedor')->firstOrFail();

                // Redirigir según el rol del usuario
                if ($usuario->Id_rol == $rolconserje->Id_rol) {
                    return redirect()->route('conserje.dashboard');
                } elseif ($usuario->Id_rol == $rolvendedor->Id_rol) {
                    $Id_usuario = $usuario->Id_usuario;
                    $clientes = Cliente::where('Id_mercado', $usuario->Id_mercado)->where('baja', false)->get();
                    return redirect()->route('vendedor.dashboard')->with(compact('clientes', 'Id_usuario'));
                } else {
                    $clientes = Cliente::get();
                    return view('admin/vistaAdmin', compact('clientes'));
                }
            } else {
                return redirect()->back()->withErrors(['contrasena' => 'Contraseña incorrecta']);
            }
        } catch (ModelNotFoundException $exception) {
            return redirect()->back()->withErrors(['usuario' => 'Usuario no encontrado']);
        }
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        // Limpiar el localStorage
        Auth::logout();
        return redirect('/login');
    }
}
