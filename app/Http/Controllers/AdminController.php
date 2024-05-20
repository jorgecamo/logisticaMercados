<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Mercado;
use App\Models\Puesto;
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
        return view('admin.vistaAdminMercados', compact('mercados'));
    }

    public function usuarios()
    {
        $usuarios = Usuario::get();
        return view('admin.vistaAdminUsuarios', compact('usuarios'));
    }

    public function puestos()
    {
        $puestos = Puesto::get();
        return view('admin.vistaAdminPuestos', compact('puestos'));
    }
}
