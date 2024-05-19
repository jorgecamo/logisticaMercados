<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localidad_reparto extends Model
{
    use HasFactory;
    protected $table = 'mercado_repartos_localidades';

    protected $primaryKey = ['Id_localidad','Id_mercado'];

    public $incrementing = false;

    public function mercados()
    {
        return $this->belongsTo(Mercado::class, 'Id_mercado');
    }

    public function localidades()
    {
        return $this->belongsTo(Localidad::class, 'Id_localidad');
    }
}
