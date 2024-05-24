<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Cliente;
use App\Models\Pedido;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;



class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('cliente/loginCliente');
    }

    public function clienteDashboard($id)
    {
        $cliente = Cliente::findOrFail($id);
        $pedidos = Pedido::where('Id_cliente', $cliente->Id_cliente)
        ->orderBy('fecha_pedido', 'asc')
        ->get();
        return view('cliente/pedidosCliente', compact('cliente','pedidos'));
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

    public function login(Request $request)
    {
        try {
            // Buscar cliente por DNI
            $cliente = Cliente::where('DNI', $request->get('cliente'))->firstOrFail();
            // Verificar la contraseña
            if (Hash::check($request->get('contrasena'), $cliente->contrasenya)) {
                // Si es la contraseña se redirige a la zona de clientes que muestra sus pedidos.
                return redirect()->route('cliente.dashboard', ['id' => $cliente->Id_cliente]);
            } else {
                return redirect()->back()->withErrors(['contrasena' => 'Contraseña incorrecta']);
            }
        } catch (ModelNotFoundException $exception) {
            return redirect()->back()->withErrors(['cliente' => 'Cliente no encontrado']);
        }
    }
}
