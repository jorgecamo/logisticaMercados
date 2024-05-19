<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mercado extends Model
{
    use HasFactory;
    protected $table = 'mercados';

    protected $primaryKey = 'Id_mercado';

    public function localidad()
    {
        return $this->belongsTo(Localidad::class, 'Id_localidad');
    }

    public function localidadesRepartos()
    {
        return $this->belongsToMany(Localidad::class, 'mercado_repartos_localidades', 'Id_mercado', 'Id_localidad');
    }

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'Id_mercado');
    }

    public function clientes()
    {
        return $this->hasMany(Cliente::class, 'Id_mercado');
    }

    public function puestos()
    {
        return $this->hasMany(Puesto::class, 'Id_mercado');
    }
}
