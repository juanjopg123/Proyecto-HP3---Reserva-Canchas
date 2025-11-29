<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancha extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'tipo',
        'estado',
        'precio_por_hora',
        'lugar',
        'imagen',
    ];

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}
