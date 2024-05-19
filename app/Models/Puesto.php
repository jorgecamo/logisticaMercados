<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    use HasFactory;
    protected $table = 'puestos';
    protected $primaryKey = 'Id_puesto';
    
    public function mercado()
    {
        return $this->belongsTo('App\Models\Mercado', 'Id_mercado');
    }

    public function usuario()
    {
        return $this->belongsTo('App\Models\Usuario', 'Id_usuario');
    }
}
