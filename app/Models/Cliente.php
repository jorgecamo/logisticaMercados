<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'clientes';
    protected $primaryKey = 'Id_cliente';

    public function direcciones()
    {
        return $this->hasMany(Direccion::class, 'Id_cliente');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'Id_cliente');
    }

    public function mercados()
    {
        return $this->belongsTo('App\Models\Mercado', 'Id_mercado');
    }
}
