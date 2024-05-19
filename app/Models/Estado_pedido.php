<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado_pedido extends Model
{
    use HasFactory;
    protected $table = 'estados_pedido';

    protected $primaryKey = 'Id_estado';

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'Id_estado_pedido');
    }
}
