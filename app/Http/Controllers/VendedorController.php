<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Pedido;
use Illuminate\Support\Carbon;
use App\Models\Usuario;
use App\Models\Direccion;
use App\Models\Estado_pedido;
use App\Models\Metodo_pago;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


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
        $direccion = Direccion::where('direcciones', $request->get('direccion'))->firstOrFail();
        $pedido->Id_direccion = $direccion->Id_direcciones;
        $estado = Estado_pedido::where('estados', 'Nuevo')->firstOrFail();
        $pedido->Id_estado = $estado->Id_estado;
        $pedido->pagado = $request->has('pagado');

        if ($request->get('pagado') != 'true') {
            // Si no está pagado, agrega el método de pago
            $metodo = Metodo_pago::where('metodo_pago', $request->get('metodo_pago'))->firstOrFail();
            $pedido->Id_metodo_pago = $metodo->Id_metodo;
        } else {
            $pedido->Id_metodo_pago = null;
        }
        $pedido->bultos = $request->get('bultos');
        $pedido->bultos_perecederos = $request->get('bultos_perecederos');
        $horaActual = Carbon::now();
        $inicioPrimeraFranja = Carbon::parse('00:00:00');
        $finPrimeraFranja = Carbon::parse('10:00:00');

        $inicioSegundaFranja = Carbon::parse('10:00:01');
        $finSegundaFranja = Carbon::parse('12:30:00');

        // Obtener la fecha de hoy y la fecha de mañana
        $fechaActual = Carbon::today();
        $fechaManana = Carbon::tomorrow();

        // Obtener el número de bultos por franja horaria para hoy
        $numeroDeBultosPorFranjaHoy = Pedido::select('franja_horaria', DB::raw('SUM(bultos) as total_bultos'))
            ->whereDate('fecha_pedido', $fechaActual)
            ->groupBy('franja_horaria')
            ->get()
            ->keyBy('franja_horaria');

        // Obtener el número de bultos por franja horaria para mañana
        $numeroDeBultosPorFranjaManana = Pedido::select('franja_horaria', DB::raw('SUM(bultos) as total_bultos'))
            ->whereDate('fecha_pedido', $fechaManana)
            ->groupBy('franja_horaria')
            ->get()
            ->keyBy('franja_horaria');

        // Verificar la franja horaria y asignar el pedido según corresponda
        if ($horaActual->isBetween($inicioPrimeraFranja, $finPrimeraFranja)) {
            // Verificar la disponibilidad de la primera franja horaria para hoy
            if (!isset($numeroDeBultosPorFranjaHoy['11:00:00']) || ($numeroDeBultosPorFranjaHoy['11:00:00']->total_bultos + $request->get('bultos')) < 30) {
                $pedido->fecha_pedido = $fechaActual;
                $pedido->franja_horaria = '11:00:00';
            } else {
                // Si la franja horaria de hoy está ocupada, verificar para mañana
                if (!isset($numeroDeBultosPorFranjaManana['11:00:00']) || ($numeroDeBultosPorFranjaManana['11:00:00']->total_bultos + $request->get('bultos')) < 30) {
                    $pedido->fecha_pedido = $fechaManana;
                    $pedido->franja_horaria = '11:00:00';
                } else {
                    // Si la franja horaria para mañana también está ocupada, asignar para el próximo día disponible
                    $pedido->fecha_pedido = Carbon::parse($fechaManana)->addDay()->startOfDay();
                    $pedido->franja_horaria = '11:00:00';
                }
            }
        } elseif ($horaActual->isBetween($inicioSegundaFranja, $finSegundaFranja)) {
            // Verificar la disponibilidad de la segunda franja horaria para hoy
            if (!isset($numeroDeBultosPorFranjaHoy['13:00:00']) || ($numeroDeBultosPorFranjaHoy['13:00:00']->total_bultos + $request->get('bultos')) < 30) {
                $pedido->fecha_pedido = $fechaActual;
                $pedido->franja_horaria = '13:00:00';
            } else {
                // Si la franja horaria de hoy está ocupada, verificar para mañana
                if (!isset($numeroDeBultosPorFranjaManana['13:00:00']) || ($numeroDeBultosPorFranjaManana['13:00:00']->total_bultos + $request->get('bultos')) < 30) {
                    $pedido->fecha_pedido = $fechaManana;
                    $pedido->franja_horaria = '13:00:00';
                } else {
                    // Si la franja horaria para mañana también está ocupada, asignar para el próximo día disponible
                    $pedido->fecha_pedido = Carbon::parse($fechaManana)->addDay()->startOfDay();
                    $pedido->franja_horaria = '11:00:00';
                }
            }
        } else {
            // Si no está en ninguna de las franjas horarias, asignar para mañana
            if (!isset($numeroDeBultosPorFranjaManana['11:00:00']) || ($numeroDeBultosPorFranjaManana['11:00:00']->total_bultos + $request->get('bultos')) < 30) {
                $pedido->fecha_pedido = $fechaManana;
                $pedido->franja_horaria = '11:00:00';
            } else if (!isset($numeroDeBultosPorFranjaManana['13:00:00']) || ($numeroDeBultosPorFranjaManana['13:00:00']->total_bultos + $request->get('bultos')) < 30) {
                $pedido->fecha_pedido = $fechaManana;
                $pedido->franja_horaria = '13:00:00'; 
            } else {
                // Si la franja horaria para mañana también está ocupada, asignar para el próximo día disponible
                $pedido->fecha_pedido = Carbon::parse($fechaManana)->addDay()->startOfDay();
                $pedido->franja_horaria = '11:00:00';
            }
        }
        
        $pedido->total_pedido = $request->get('total_pedido');
        $pedido->save();

        $Id_usuario = $request->get('id_usuario');
        $usuario = Usuario::where('Id_usuario', $Id_usuario)->firstOrFail();
        $clientes = Cliente::where('Id_mercado', $usuario->Id_mercado)->where('baja', false)->get(); //para cargar los clientes en el desplegable del mismo mercado que el usuario
        // Quiero hacer que cuando se inserte en la bbdd en la vsta del vendedor salga el qr que se imprime en el pedido para el conserje, y despues redireccione a la vista vendedor

        return redirect()->route('vendedor.dashboard')->with(compact('clientes', 'Id_usuario'));

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

    public function vendedorIndex(Request $request)
    {
        $clientes = $request->session()->get('clientes');
        $Id_usuario = $request->session()->get('Id_usuario');
        return view('vendedor.vistaVendedor', compact('clientes', 'Id_usuario'));
    }
}
