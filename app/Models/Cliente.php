<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;


class Cliente extends Model
{
    use HasFactory;
    protected $table = 'clientes';
    protected $primaryKey = 'Id_cliente';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'contrasenya',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'contrasenya' => 'hashed',
        ];
    }


    /**
     * Hash the user's password.
     *
     * @param  string  $value
     * @return void
     */

    public function setContrasenyaAttribute($value)
    {
        $this->attributes['contrasenya'] = Hash::make($value);
    }

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
