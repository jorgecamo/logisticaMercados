<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Puesto;
use App\Models\Usuario;
use App\Models\Cliente;
use App\Models\Estado_pedido;
use App\Models\Metodo_pago;
use Illuminate\Support\Facades\Log;



class ConserjeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('conserje/vistaConserje');
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

        $estadoPedido = Estado_pedido::where('Id_estado', $pedidoPorId->Id_estado)->first();
        $datosCliente = Cliente::where('Id_cliente', $pedidoPorId->Id_cliente)->first();
        $usuarioQueRealizaElPedido = Usuario::where('Id_usuario', $pedidoPorId->Id_usuario)->first();
        if ($pedidoPorId->Id_metodo_pago) {
            $metodoPagoPedido = Metodo_pago::where('Id_metodo', $pedidoPorId->Id_metodo_pago)->first();
            return compact('pedidoPorId', 'datosCliente', 'usuarioQueRealizaElPedido', 'estadoPedido', 'metodoPagoPedido');
        } else {
            return compact('pedidoPorId', 'datosCliente', 'usuarioQueRealizaElPedido', 'estadoPedido');
        }
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
        $pedidosfecha = Pedido::where('fecha_pedido', $request->fecha)
            ->orderBy('Id_usuario', 'asc')
            ->get();
        return view('conserje/vistaConserje', compact('pedidosfecha'));
    }

    public function actualizarEstado($id, Request $request)
    {
        $pedido = Pedido::where('Id_pedido', $id)->firstOrFail();
        $pedido->Id_estado = $request->estado;
        $pedido->save();
        return response()->json(['success' => true, 'message' => 'Estado del pedido actualizado correctamente']);
    }

    public function ordenarPorPuesto(Request $request)
    {
        $orden = $request->input('orden', 'desc');
        $pedidosfecha = Pedido::where('fecha_pedido', $request->fecha)
            ->join('usuarios', 'pedidos.Id_usuario', '=', 'usuarios.Id_usuario')
            ->orderBy('usuarios.nombre', $orden)
            ->select('pedidos.*')
            ->get();
        return view('conserje/vistaConserje', compact('pedidosfecha'));
    }

    public function ordenarPorCliente(Request $request)
    {
        $orden = $request->input('orden', 'desc');
        $pedidosfecha = Pedido::where('fecha_pedido', $request->fecha)
            ->join('clientes', 'pedidos.Id_cliente', '=', 'clientes.Id_cliente')
            ->orderBy('clientes.nombre', $orden)
            ->select('pedidos.*')
            ->get();
        return view('conserje/vistaConserje', compact('pedidosfecha'));
    }
}
