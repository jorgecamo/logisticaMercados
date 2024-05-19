<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    use HasFactory;
    protected $table = 'provincias';

    protected $primaryKey = 'Id_provincia';

    public function localidades()
    {
        return $this->hasMany(Localidad::class, 'Id_localidad');
    }
}
