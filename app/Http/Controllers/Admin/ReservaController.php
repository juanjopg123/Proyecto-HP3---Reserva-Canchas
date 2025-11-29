<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use App\Models\Cancha;
use Illuminate\Http\Request; // 👈 AQUI FALTABA

class ReservaController extends Controller
{
    public function index(Request $request)
    {
        $reservas = Reserva::with(['user', 'cancha'])->orderBy('fecha', 'desc')->get();
        $canchas = Cancha::all();

        $cancha = null;
        if ($request->has('cancha')) {
            $cancha = Cancha::find($request->get('cancha'));
        }

        return view('admin.dashboard', compact('reservas', 'canchas', 'cancha'));
    }

    public function updateEstado(Request $request, $id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->estado = $request->input('estado');
        $reserva->save();

        return redirect()->back()->with('success', 'Estado de la reserva actualizado correctamente');
    }
}
