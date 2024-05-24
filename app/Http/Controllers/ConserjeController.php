<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Puesto;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Usuario;
use App\Models\Cliente;
use App\Models\Direccion;
use App\Models\Estado_pedido;
use App\Models\Localidad;
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
            ->orderBy('franja_horaria', 'asc')
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
        $franjaHoraria = $request->input('franja_horaria');

        $pedidosfecha = Pedido::where('fecha_pedido', $request->fecha)
            ->join('usuarios', 'pedidos.Id_usuario', '=', 'usuarios.Id_usuario')
            ->orderBy('usuarios.nombre', 'asc')
            ->select('pedidos.*')
            ->get();
            return view('conserje/vistaConserje', compact('pedidosfecha', 'franjaHoraria'));
        }

    public function ordenarPorCliente(Request $request)
    {
        $orden = $request->input('orden', 'desc');
        $franjaHoraria = $request->input('franja_horaria');

        $pedidosfecha = Pedido::where('fecha_pedido', $request->fecha)
            ->join('clientes', 'pedidos.Id_cliente', '=', 'clientes.Id_cliente')
            ->orderBy('clientes.nombre', 'desc')
            ->select('pedidos.*')
            ->get();
            return view('conserje/vistaConserje', compact('pedidosfecha', 'franjaHoraria'));
        }

    public function clientes()
    {
        $conserje = auth()->user();
        $Id_mercado = $conserje->Id_mercado;
        return view('conserje/conserjeAnyadirClientes',compact('Id_mercado'));
    }

    public function anyadirClientes(Request $request)
    {
        $cliente = new Cliente();
        $cliente->DNI = $request->get('DNI');
        $cliente->nombre = $request->get('nombre');
        $cliente->correo = $request->get('correo');
        $cliente->telefono = $request->get('telefono');
        $cliente->contrasenya = $request->get('contrasenya');
        $cliente->puntos = 0;
        $cliente->Id_mercado = $request->get('Id_mercado');
        $cliente->baja = 0;
        $cliente->save();

        return redirect()->route('conserje.direcciones', ['Id_cliente' => $cliente->Id_cliente])->with('success', 'Se ha añadido el cliente correctamente');
    }

    public function direcciones(Request $request)
    {
        $conserje = auth()->user();
        $Id_mercado = $conserje->Id_mercado;
        $localidades = Localidad::get();
        $clientes = Cliente::where('baja', 0)->where('Id_mercado', $Id_mercado)->get();
        $Id_cliente = $request->query('Id_cliente', null);

        return view('conserje/conserjeAnyadirDirecciones', compact('Id_cliente','localidades','clientes'));
    }

    public function anyadirDirecciones(Request $request)
    {
        $direccion = new Direccion();
        $direccion->direcciones = $request->get('direcciones');
        $direccion->Id_cliente = $request->get('id_cliente');
        $direccion->Id_localidad = $request->get('localidad');
        $direccion->save();

        return redirect()->route('conserje.direcciones')->with('success', 'Se ha añadido la direccion correctamente');
    }

    public function actuaizarEstadoPedidoQR($id){
        $pedido = Pedido::where('Id_pedido', $id)->firstOrFail();
        if ($pedido->estado_pedido->estados == 'Nuevo') {
            $pedido->Id_estado = 2;
            $pedido->save();

        }else if ($pedido->estado_pedido->estados == 'En_preparacion') {
            $pedido->Id_estado = 3;
            $pedido->save();
        }
        $qrCodeData = route('conserje.actualizarEstadoQR', ['id' => $pedido->Id_pedido]);
        $qrCodePath = public_path('qrcodes/pedido_' . $pedido->Id_pedido . '.png');
        QrCode::format('png')->size(200)->generate($qrCodeData, $qrCodePath);

        return redirect()->back()->with('success', 'Estado del pedido y QR actualizados correctamente.');
    }
}
