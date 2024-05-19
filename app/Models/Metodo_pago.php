<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metodo_pago extends Model
{
    use HasFactory;
    protected $table = 'metodos_pago';

    protected $primaryKey = 'Id_metodo';

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'Id_metodo_pago');
    }
}
