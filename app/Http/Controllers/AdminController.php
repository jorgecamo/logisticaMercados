<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Localidad;
use App\Models\Mercado;
use App\Models\Puesto;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return view('admin.vistaAdminMercados', compact('mercados', 'localidades'));
    }
    public function darBajaMercados(string $id)
    {
        $mercadoPorId = Mercado::where('Id_mercado', $id)->firstOrFail();
        //Transaccion para actualizar el campo baja de todos los usuarios, puestos y clientes asociados a ese mercado
        DB::transaction(function () use ($mercadoPorId) {
            //Actualizar baja de mercado
            $mercadoPorId->baja = $mercadoPorId->baja == 0 ? 1 : 0;
            $mercadoPorId->save();
            //Acutaliza el campo baja de las siguientes tablas
            Puesto::where('Id_mercado', $mercadoPorId->Id_mercado)->update(['baja' => $mercadoPorId->baja]);
            Usuario::where('Id_mercado', $mercadoPorId->Id_mercado)->update(['baja' => $mercadoPorId->baja]);
            Cliente::where('Id_mercado', $mercadoPorId->Id_mercado)->update(['baja' => $mercadoPorId->baja]);
        });
        return redirect()->route('admin.mercados')->with('success', 'El estado de baja del mercado ha sido actualizado.');
    }


    public function anyadirMercados(Request $request)
    {
        $mercado = new Mercado();
        $mercado->nombre = $request->get('nombre');
        $mercado->Id_localidad = $request->get('localidad');
        $mercado->direccion = $request->get('direccion');
        $mercado->baja = 0;
        $mercado->save();

        return redirect()->route('admin.mercados')->with('success', 'Se ha añadido el mercado correctamente');
    }

    public function usuarios()
    {
        $usuarios = Usuario::get();
        $mercados = Mercado::where('baja', 0)->get();
        $roles = Rol::get();

        return view('admin/vistaAdminUsuarios', compact('usuarios', 'mercados', 'roles'));
    }

    public function darBajaUsuarios(string $id)
    {
        $usuarioPorId = Usuario::where('Id_usuario', $id)->firstOrFail();
        $mercadoAsociadoAlUsuario = Mercado::where('Id_mercado', $usuarioPorId->Id_mercado)->firstOrFail();
        if ($mercadoAsociadoAlUsuario->baja == 1) {
            return redirect()->route('admin.usuarios')->with('error', 'No se puede dar de alta un usuario cuyo mercado está dado de baja.');
        }
        //Transaccion para actualizar el campo baja de todos los puestos asociados a ese usuario
        DB::transaction(function () use ($usuarioPorId) {

            //Actualizar baja de usuario
            $usuarioPorId->baja = $usuarioPorId->baja == 0 ? 1 : 0;
            $usuarioPorId->save();
            //Acutaliza el campo baja de las siguientes tablas
            if ($usuarioPorId->rol->rol == 'vendedor') {
                Puesto::where('Id_usuario', $usuarioPorId->Id_usuario)->update(['baja' => $usuarioPorId->baja]);
            }
        });
        return redirect()->route('admin.usuarios')->with('success', 'El estado de baja del usuario ha sido actualizado.');
    }


    public function anyadirUsuarios(Request $request)
    {
        $usuario = new Usuario();
        $usuario->DNI = $request->get('DNI');
        $usuario->nombre = $request->get('nombre');
        $usuario->Id_rol = $request->get('Id_rol');
        $usuario->telefono = $request->get('telefono');
        $usuario->contrasenya = $request->get('contrasenya');
        $usuario->Id_mercado = $request->get('Id_mercado');
        $usuario->baja = 0;
        $usuario->save();

        return redirect()->route('admin.usuarios')->with('success', 'Se ha añadido el usuario correctamente');
    }

    public function puestos()
    {
        $puestos = Puesto::get();
        $usuarios = Usuario::where('baja', 0)->get();
        $mercados = Mercado::where('baja', 0)->get();
        return view('admin.vistaAdminPuestos', compact('puestos', 'usuarios', 'mercados'));
    }
    public function darBajaPuestos(string $id)
    {
        $puestoPorId = Puesto::where('Id_puesto', $id)->firstOrFail();
        $usuarioAsociadoAlPuesto = Usuario::where('Id_usuario', $puestoPorId->Id_usuario)->firstOrFail();
        $mercadoAsociadoAlPuesto = Mercado::where('Id_mercado', $puestoPorId->Id_mercado)->firstOrFail();

        if ($usuarioAsociadoAlPuesto->baja == 1 || $mercadoAsociadoAlPuesto->baja == 1) {
            return redirect()->route('admin.puestos')->with('error', 'No se puede dar de alta un puesto cuyo usuario o mercado está dado de baja.');
        } else {
            $puestoPorId->baja = $puestoPorId->baja == 0 ? 1 : 0;
            $puestoPorId->save();
            return redirect()->route('admin.puestos')->with('success', 'El estado de baja del puesto ha sido actualizado.');
        }
    }


    public function anyadirPuestos(Request $request)
    {
        $puesto = new Puesto();
        $puesto->nombre = $request->get('nombre');
        $puesto->Id_usuario = $request->get('Id_usuario');
        $puesto->Id_mercado = $request->get('Id_mercado');
        $puesto->baja = 0;
        $puesto->save();

        return redirect()->route('admin.puestos')->with('success', 'Se ha añadido el puesto correctamente');
    }
}
