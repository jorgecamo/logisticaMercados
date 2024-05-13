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
}
