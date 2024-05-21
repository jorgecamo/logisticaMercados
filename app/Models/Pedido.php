<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $table = 'pedidos';

    protected $primaryKey = 'Id_pedido';

    protected $fillable = ['Id_usuario', 'Id_cliente', 'Id_direccion', 'direccion','Id_estado','pagado','Id_metodo_pago','bultos','bultos_perecederos','fecha_pedido','total_pedido','franja_horaria'];

    public function usuario()
    {
        return $this->belongsTo('App\Models\Usuario', 'Id_usuario');
    }

    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente', 'Id_cliente');
    }

    public function direccion_pedido()
    {
        return $this->belongsTo('App\Models\Direccion', 'Id_direccion');
    }

    public function estado_pedido()
    {
        return $this->belongsTo('App\Models\Estado_pedido', 'Id_estado');
    }

    public function metodo_pago()
    {
        return $this->belongsTo('App\Models\Metodo_pago', 'Id_metodo_pago');
    }
}
