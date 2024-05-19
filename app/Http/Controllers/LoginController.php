<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\Puesto;
use App\Models\Rol;
use Illuminate\Http\Request;
use App\Models\Usuario;
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
            $rolconserje = Rol::where('rol', 'conserje')->firstOrFail();
            $rolvendedor = Rol::where('rol', 'vendedor')->firstOrFail();


                if ($usuario->Id_rol == $rolconserje -> Id_rol){
                    return view('conserje/vistaConserje');
                } else if($usuario->Id_rol == $rolvendedor -> Id_rol){
                    $Id_usuario = $usuario -> Id_usuario;
                    $clientes = Cliente::where('Id_mercado', $usuario -> Id_mercado)->where('baja',false)->get(); //para cargar los clientes en el desplegable del mismo mercado que el usuario
                    return view('vendedor/vistaVendedor',compact('clientes','Id_usuario'));
                }else{
                    return view('admin/vistaAdmin');
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
