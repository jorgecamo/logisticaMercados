<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    use HasFactory;
    protected $table = 'localidades';

    protected $primaryKey = 'Id_localidad';

    
    public function provincia()
    {
        return $this->belongsTo('App\Models\Provincia', 'Id_provincia');
    }

    public function mercadosRepartos()
    {
        return $this->belongsToMany(Mercado::class, 'mercado_repartos_localidades', 'Id_localidad', 'Id_mercado');
    }

    public function mercados()
    {
        return $this->hasMany(Mercado::class, 'Id_localidad');
    }

    public function direcciones()
    {
        return $this->hasMany(Direccion::class, 'Id_localidad');
    }
}
