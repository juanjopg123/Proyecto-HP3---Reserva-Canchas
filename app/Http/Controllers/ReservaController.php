<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Cancha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservaController extends Controller
{
    /**
     * Crear una nueva reserva
     */
    public function store(Request $request)
    {
        $request->validate([
            'cancha_id'   => 'required|exists:canchas,id',
            'fecha'       => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'duracion'    => 'required|integer|min:1|max:4',
        ]);

        $fecha = $request->fecha;

        // Convertir hora a Carbon
        $horaInicio = Carbon::createFromFormat('H:i', $request->hora_inicio);
        $horaFin    = (clone $horaInicio)->addHours((int) $request->duracion);

        // ❌ No permitir fechas pasadas
        if ($fecha < date('Y-m-d')) {
            return back()->withErrors(['error' => '⚠️ No puedes reservar una fecha pasada.']);
        }

        // ❌ No permitir horas pasadas si la fecha es hoy
        if ($fecha === date('Y-m-d') && $horaInicio->isPast()) {
            return back()->withErrors(['error' => '⚠️ No puedes reservar una hora pasada del día actual.']);
        }

        // ❌ No permitir que cruce de día
        if ($horaFin->lt($horaInicio)) {
            return back()->withErrors(['error' => '⚠️ No se permiten reservas que crucen de día.']);
        }

        // ❌ Validar que la cancha esté disponible
        $cancha = Cancha::find($request->cancha_id);
        if (!$cancha || $cancha->estado !== 'disponible') {
            return back()->withErrors(['error' => '⚠️ La cancha no está disponible en este momento.']);
        }

        // ❌ Validar que no haya solapamiento
        $existe = Reserva::where('cancha_id', $request->cancha_id)
            ->where('fecha', $fecha)
            ->whereIn('estado', ['pendiente', 'aprobada'])
            ->where(function ($query) use ($horaInicio, $horaFin) {
                $query->whereBetween('hora_inicio', [$horaInicio->format('H:i:s'), $horaFin->format('H:i:s')])
                      ->orWhereBetween('hora_fin', [$horaInicio->format('H:i:s'), $horaFin->format('H:i:s')])
                      ->orWhere(function ($q) use ($horaInicio, $horaFin) {
                          $q->where('hora_inicio', '<=', $horaInicio->format('H:i:s'))
                            ->where('hora_fin', '>=', $horaFin->format('H:i:s'));
                      });
            })
            ->exists();

        if ($existe) {
            return back()->withErrors(['error' => '⚠️ La cancha ya está reservada en ese horario.']);
        }

        // ✅ Crear la reserva
        Reserva::create([
            'user_id'     => Auth::id(),
            'cancha_id'   => $request->cancha_id,
            'fecha'       => $fecha,
            'hora_inicio' => $horaInicio->format('H:i:s'),
            'hora_fin'    => $horaFin->format('H:i:s'),
            'estado'      => 'pendiente',
        ]);

        return back()->with('success', '✅ Reserva creada correctamente.');
    }

    /**
     * Ver reservas del usuario autenticado
     */
    public function misReservas()
    {
        $reservas = Auth::user()->reservas()
            ->with('cancha')
            ->orderBy('fecha', 'desc')
            ->orderBy('hora_inicio', 'desc')
            ->get();

        return view('usuario.reservas.index', compact('reservas'));
    }
}
