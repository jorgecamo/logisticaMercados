<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable, HasFactory;
    protected $table = 'usuarios';
    protected $primaryKey = 'Id_usuario';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'DNI',
        'rol',
        'telefono',
        'contrasenya',
        'baja'
    ];

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

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'Id_rol');
    }

    public function mercado()
    {
        return $this->belongsTo(Mercado::class, 'Id_mercado');
    }

    public function puesto()
    {
        return $this->hasOne(Puesto::class, 'Id_usuario');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'Id_pedido');
    }

}
