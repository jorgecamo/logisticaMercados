<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Localidad;
use App\Models\Mercado;
use App\Models\Puesto;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::get();
        return view('admin/vistaAdmin', compact('clientes'));
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
        //
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
        $clientePorId = Cliente::where('Id_cliente', $id)->firstOrFail();
        $clientePorId->baja = $clientePorId->baja == 0 ? 1 : 0;
        $clientePorId->save();
        return redirect()->route('admin.index')->with('success', 'El estado de baja del cliente ha sido actualizado.');
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

    public function mercados()
    {
        $mercados = Mercado::get();
        $localidades = Localidad::get();
        return view('admin.vistaAdminMercados', compact('mercados','localidades'));
    }
    public function darBajaMercados(string $id)
    {
        $mercadoPorId = Mercado::where('Id_mercado', $id)->firstOrFail();
        $mercadoPorId->baja = $mercadoPorId->baja == 0 ? 1 : 0;
        $mercadoPorId->save();
        return redirect()->route('admin.mercados')->with('success', 'El estado de baja del mercado ha sido actualizado.');
    }

    
    public function anyadirMercados(Request $request)
    {
        $mercado = new Mercado();
        $mercado->nombre = $request -> get('nombre');
        $mercado->Id_localidad = $request -> get('localidad');
        $mercado->direccion = $request -> get('direccion');
        $mercado->baja = 0;
        $mercado->save();
        
        return redirect()->route('admin.mercados')->with('success', 'Se ha añadido el mercado correctamente');
    }

    public function usuarios()
    {
        $usuarios = Usuario::get();
        $mercados = Mercado::get();
        $roles = Rol::get();

        return view('admin/vistaAdminUsuarios', compact('usuarios','mercados','roles'));
    }

    public function darBajaUsuarios(string $id)
    {
        $usuarioPorId = Usuario::where('Id_usuario', $id)->firstOrFail();
        $usuarioPorId->baja = $usuarioPorId->baja == 0 ? 1 : 0;
        $usuarioPorId->save();
        return redirect()->route('admin.usuarios')->with('success', 'El estado de baja del usuario ha sido actualizado.');
    }

    
    public function anyadirUsuarios(Request $request)
    {
        $usuario = new Usuario();
        $usuario->DNI = $request -> get('DNI');
        $usuario->nombre = $request -> get('nombre');
        $usuario->Id_rol = $request -> get('Id_rol');
        $usuario->telefono = $request -> get('telefono');
        $usuario->contrasenya = $request -> get('contrasenya');
        $usuario->Id_mercado = $request -> get('Id_mercado');
        $usuario->baja = 0;
        $usuario->save();

        return redirect()->route('admin.usuarios')->with('success', 'Se ha añadido el usuario correctamente');
    }

    public function puestos()
    {
        $puestos = Puesto::get();
        $usuarios = Usuario::get();
        $mercados = Mercado::get();
        return view('admin.vistaAdminPuestos', compact('puestos','usuarios','mercados'));
    }
    public function darBajaPuestos(string $id)
    {
        $puestoPorId = Puesto::where('Id_puesto', $id)->firstOrFail();
        $puestoPorId->baja = $puestoPorId->baja == 0 ? 1 : 0;
        $puestoPorId->save();
        return redirect()->route('admin.puestos')->with('success', 'El estado de baja del puesto ha sido actualizado.');
    }

    
    public function anyadirPuestos(Request $request)
    {
        $puesto = new Puesto();
        $puesto->nombre = $request -> get('nombre');
        $puesto->Id_usuario = $request -> get('Id_usuario');
        $puesto->Id_mercado = $request -> get('Id_mercado');
        $puesto->baja = 0;
        $puesto->save();
        
        return redirect()->route('admin.puestos')->with('success', 'Se ha añadido el puesto correctamente');
    }
}
