<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $table = 'pedidos';

    protected $primaryKey = 'Id_pedido';

    protected $fillable = ['Id_usuario', 'Id_cliente', 'direccion','estado','pagado','metodo_pago','perecedero','fecha_pedido','total_pedido'];


    public function reglas()
    {
        return [
            'estado' => 'required|in:Nuevo,Preparacion,Entregado,Cancelado',
        ];
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente', 'Id_cliente');
    }
}
