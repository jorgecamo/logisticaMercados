<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $usuario = Usuario::where('DNI', $request -> get('usuario'))->firstOrFail();
            // Verificar la contraseña
            if (($request->get('contrasena') == $usuario->contrasenya)) {
                if ($usuario->rol == 'conserje'){
                    return view('conserje/vistaConserje');
                } else {
                    $Id_usuario = $usuario -> Id_usuario;
                    $clientes = Cliente::get(); //para cargar los clientes en el desplegable
                    return view('vendedor/vistaVendedor',compact('clientes','Id_usuario'));
                }
            } else {
                return redirect()->back()->withErrors(['contrasenya' => 'Contraseña incorrecta']);
            }
        } catch (ModelNotFoundException $exception) {
            return redirect()->back()->withErrors(['usuario' => 'Usuario no encontrado']);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
