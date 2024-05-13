<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $table = 'pedidos';

    protected $fillable = ['Id_usuario', 'Id_cliente', 'direccion','estado','pagado','metodo_pago','perecedero','fecha_pedido','total_pedido'];


    public function reglas()
    {
        return [
            'estado' => 'required|in:Nuevo,En_preparación,Entregado,Cancelado',
        ];
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
