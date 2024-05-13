<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    use HasFactory;
    protected $table = 'direcciones';

    public function clientes()
    {
        return $this->belongsTo(Cliente::class, 'Id_cliente');
    }
}