<?php

namespace App\Http\Controllers;
use App\Models\Cliente;
use App\Models\Pedido;

use Illuminate\Http\Request;

class VendedorController extends Controller
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
        $pedido = new Pedido();
        $pedido->Id_usuario = $request->get('id_usuario');
        $pedido->Id_cliente = $request->get('id_cliente');
        $pedido->direccion = $request->get('direccion');
        $pedido->estado = 'Nuevo';
        $pedido->pagado = $request->has('pagado');

        if ($request->get('pagado') != 'true') {
            // Si no está pagado, agrega el método de pago
            $pedido->metodo_pago = $request->get('metodo_pago');
        }else {
            $pedido->metodo_pago = null;
        }
        $pedido->perecedero = $request->has('perecedero');
        $pedido->fecha_pedido = now();
        $pedido->total_pedido = $request->get('total_pedido');

        $pedido->save();
        $Id_usuario = $request -> get('id_usuario');
        $clientes = Cliente::get(); //para cargar los clientes en el desplegable
        // Quiero hacer que cuando se inserte en la bbdd en la vsta del vendedor salga el qr que se imprime en el pedido para el conserje, y despues redireccione a la vista vendedor
        return view('vendedor/vistaVendedor',compact('clientes','Id_usuario'));
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
