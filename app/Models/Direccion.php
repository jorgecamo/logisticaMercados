<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    use HasFactory;
    protected $table = 'direcciones';
    protected $primaryKey = 'Id_direccion';

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'Id_cliente');
    }

    public function localidad()
    {
        return $this->belongsTo(Localidad::class, 'Id_localidad');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'Id_direccion');
    }
}
