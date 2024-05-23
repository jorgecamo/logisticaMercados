<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Cliente;


class ClienteController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cliente = Cliente::findOrFail($id);
        // Esto es para sacar las localidades que se encuentran en la tabla relacional para los repartos de los mercados
        $direcciones_reparto = $cliente->mercados->localidadesRepartos->pluck('Id_localidad');
        $direcciones = [];

        // Y aqui guardo las direcciones del cliente que coincidan con las localidades asociadas al mercado del cliente, para mostrarlas al añadir el pedido
        foreach ($direcciones_reparto as $localidad_id_reparto) {
        $direcciones = array_merge($direcciones, $cliente->direcciones->where('Id_localidad', $localidad_id_reparto)->all());
        }

        return compact('direcciones');
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
