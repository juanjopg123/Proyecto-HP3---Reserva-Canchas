<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cancha_id',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'estado',
    ];

public function user()
{
    return $this->belongsTo(User::class, 'user_id', 'id');
}

public function cancha()
{
    return $this->belongsTo(Cancha::class, 'cancha_id', 'id');
}


}
