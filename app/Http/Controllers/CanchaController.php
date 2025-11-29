<?php

namespace App\Http\Controllers;

use App\Models\Cancha;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CanchaController extends Controller
{
    public function index()
    {
        $canchas = Cancha::all();

        if (auth()->user()->role === 'admin') {
            $reservas = Reserva::with(['user', 'cancha'])
                ->orderBy('fecha', 'desc')
                ->get();

            return view('admin.dashboard', compact('canchas', 'reservas'));
        }

        $reservas = auth()->user()->reservas()
            ->with('cancha')
            ->orderBy('fecha', 'desc')
            ->get();

        return view('usuario.dashboard', compact('canchas', 'reservas'));
    }

    public function edit(Cancha $cancha)
    {
        $canchas = Cancha::all();
        $reservas = Reserva::with(['user', 'cancha'])
            ->orderBy('fecha', 'desc')
            ->get();

        return view('admin.dashboard', compact('canchas', 'reservas', 'cancha'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'          => 'required|string',
            'tipo'            => 'required|string',
            'lugar'           => 'required|string',
            'precio_por_hora' => 'required|numeric',
            'estado'          => 'required|in:disponible,no disponible,mantenimiento',
            'imagen'          => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $this->guardarImagen($request->file('imagen'));
        }

        Cancha::create($validated);

        return redirect()->back()->with('success', '✅ Cancha creada correctamente.');
    }

    public function update(Request $request, Cancha $cancha)
    {
        $validated = $request->validate([
            'nombre'          => 'required|string|max:255',
            'tipo'            => 'required|string|in:futbol,basketball,tenis',
            'estado'          => 'required|in:disponible,no disponible,mantenimiento',
            'precio_por_hora' => 'required|numeric|min:0',
            'lugar'           => 'required|string|max:255',
            'imagen'          => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $this->guardarImagen($request->file('imagen'));
        }

        $cancha->update($validated);

        return redirect()->back()->with('success', '✅ Cancha actualizada correctamente');
    }

    public function destroy(Cancha $cancha)
    {
        $cancha->delete();

        return redirect()->back()->with('success', '🗑️ Cancha eliminada correctamente');
    }

    /**
     * Guardar una imagen en public/images con nombre seguro y sin duplicar.
     */
    private function guardarImagen($file)
    {
        $originalName = $file->getClientOriginalName();
        $filename = Str::slug(pathinfo($originalName, PATHINFO_FILENAME));
        $extension = $file->getClientOriginalExtension();

        $finalName = $filename . '.' . $extension;
        $destinationPath = public_path('images/' . $finalName);

        if (file_exists($destinationPath)) {
            $yaUsada = Cancha::where('imagen', $finalName)->exists();

            if ($yaUsada) {
                return $finalName;
            } else {
                return $finalName;
            }
        }

        $file->move(public_path('images'), $finalName);

        return $finalName;
    }

// ======================
// Admin - Filtros por tipo
// ======================
public function basketball()
{
    $canchas = Cancha::where('tipo', 'basketball')->get();
    $reservas = Reserva::with(['user', 'cancha'])
        ->whereHas('cancha', fn($q) => $q->where('tipo', 'basketball'))
        ->orderBy('fecha', 'desc')
        ->get();

    return view('admin.basketball.dashboard', compact('canchas', 'reservas'));
}

public function futbol()
{
    $canchas = Cancha::where('tipo', 'futbol')->get();
    $reservas = Reserva::with(['user', 'cancha'])
        ->whereHas('cancha', fn($q) => $q->where('tipo', 'futbol'))
        ->orderBy('fecha', 'desc')
        ->get();

    return view('admin.futbol.dashboard', compact('canchas', 'reservas'));
}

public function tenis()
{
    $canchas = Cancha::where('tipo', 'tenis')->get();
    $reservas = Reserva::with(['user', 'cancha'])
        ->whereHas('cancha', fn($q) => $q->where('tipo', 'tenis'))
        ->orderBy('fecha', 'desc')
        ->get();

    return view('admin.tenis.dashboard', compact('canchas', 'reservas'));
}


// ======================
// Usuario - Filtros por tipo
// ======================
    public function userBasketball()
    {
        $canchas = Cancha::where('tipo', 'basketball')->get();

        $reservas = Reserva::where('user_id', auth()->id())
            ->whereHas('cancha', fn($q) => $q->where('tipo', 'basketball'))
            ->with('cancha')
            ->orderBy('fecha', 'desc')
            ->orderBy('hora_inicio', 'desc')
            ->get();

        return view('usuario.basketball.dashboard', compact('canchas', 'reservas'));
    }

    public function userFutbol()
    {
        $canchas = Cancha::where('tipo', 'futbol')->get();

        $reservas = Reserva::where('user_id', auth()->id())
            ->whereHas('cancha', fn($q) => $q->where('tipo', 'futbol'))
            ->with('cancha')
            ->orderBy('fecha', 'desc')
            ->orderBy('hora_inicio', 'desc')
            ->get();

        return view('usuario.futbol.dashboard', compact('canchas', 'reservas'));
    }

    public function userTenis()
    {
        $canchas = Cancha::where('tipo', 'tenis')->get();

        $reservas = Reserva::where('user_id', auth()->id())
            ->whereHas('cancha', fn($q) => $q->where('tipo', 'tenis'))
            ->with('cancha')
            ->orderBy('fecha', 'desc')
            ->orderBy('hora_inicio', 'desc')
            ->get();

        return view('usuario.tenis.dashboard', compact('canchas', 'reservas'));
    }
}