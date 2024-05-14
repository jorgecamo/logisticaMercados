<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Puesto;
use App\Models\Usuario;
use App\Models\Cliente;
use Illuminate\Support\Facades\Log;



class ConserjeController extends Controller
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
        $pedidoPorId = Pedido::where('Id_pedido', $id)->first();
        $datosCliente = Cliente::where('Id_cliente', $pedidoPorId->Id_cliente)->first();
        $puestoQueRealizaElPedido = Puesto::where('Id_usuario', $pedidoPorId->Id_usuario)->first();
        return compact('pedidoPorId', 'datosCliente', 'puestoQueRealizaElPedido');
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

    public function filtrarPorFecha(Request $request)
    {
        $fecha = $request->input('fecha');
        $pedidosfecha = Pedido::whereDate('fecha_pedido', $fecha)->get();
        return view('conserje/vistaConserje', compact('pedidosfecha'));
    }

    public function actualizarEstado($id, Request $request)
    {
        $pedido = Pedido::where('Id_pedido', $id)->firstOrFail();
        $pedido->estado = $request->estado;
        $pedido->save();
        return response()->json(['success' => true, 'message' => 'Estado del pedido actualizado correctamente']);
    }
}
