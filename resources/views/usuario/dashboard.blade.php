<x-app-layout>
<div class="min-h-screen bg-[#1f2937]">
    <div class="p-6 max-w-5xl mx-auto">
<h1 class="text-3xl font-extrabold text-white mb-4 pb-5 pt-5">
    👋 Bienvenido {{ Auth::user()->name }}
</h1>

<h1 class="text-3xl font-extrabold text-white mb-8 border-b-4 border-blue-500 inline-block pb-2">
    Canchas disponibles 🏟️
</h1>

        <!-- Mensaje de éxito -->
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">
    @forelse($canchas as $cancha)
        <div class="bg-white shadow-xl rounded-2xl p-5 flex flex-col items-center text-center 
                    border border-gray-200 hover:shadow-2xl hover:scale-[1.02] transition-all duration-300 ease-in-out">
            
            <!-- Imagen -->
            @if($cancha->imagen)
                <img src="{{ asset('images/' . $cancha->imagen) }}" 
                     alt="Imagen de la cancha" 
                     class="w-full h-48 object-cover rounded-xl mb-4 shadow-md">
            @else
                <div class="w-full h-48 flex items-center justify-center bg-gray-100 rounded-xl mb-4 text-gray-400">
                    📷 Sin imagen
                </div>
            @endif

            <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $cancha->nombre }}</h2>

            <p class="text-gray-600 mb-1">{{ $cancha->tipo }}</p>

            <p class="text-lg font-semibold text-indigo-600 mb-1">
                💲 {{ number_format($cancha->precio_por_hora, 0, ',', '.') }} / hora
            </p>

            <p class="text-gray-500 text-sm mb-3">📍 {{ $cancha->lugar }}</p>

            <p class="text-sm font-medium mb-4">
                Estado: 
                @if($cancha->estado === 'disponible')
                    <span class="text-green-600 font-semibold">Disponible</span>
                @elseif($cancha->estado === 'no disponible')
                    <span class="text-red-600 font-semibold">No disponible</span>
                @elseif($cancha->estado === 'mantenimiento')
                    <span class="text-yellow-600 font-semibold">Mantenimiento</span>
                @else
                    <span>{{ ucfirst($cancha->estado) }}</span>
                @endif
            </p>

            <button onclick="openForm('{{ $cancha->id }}','{{ e($cancha->nombre) }}')" 
                class="w-full px-5 py-2.5 rounded-xl font-semibold text-white 
                       bg-gradient-to-r from-blue-500 to-cyan-500 
                       shadow-md hover:from-green-400 hover:to-emerald-500 
                       transform hover:-translate-y-1 hover:shadow-lg 
                       transition duration-300 ease-in-out">
                Reservar
            </button>
        </div>
    @empty
        <p class="col-span-3 text-center text-gray-600">
            No hay canchas registradas todavía.
        </p>
    @endforelse
</div>


        <!-- Modal reserva -->
<div id="reservaModal" 
     class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white shadow-2xl rounded-2xl p-8 w-full max-w-lg relative animate-fade-in">

        <button 
            type="button" 
            onclick="closeForm()" 
            class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl font-bold">
            ✖
        </button>

        <h2 id="formTitle" class="text-3xl font-extrabold mb-6 text-indigo-600 text-center">Reserva</h2>

        <form action="{{ route('reservas.store') }}" method="POST" class="space-y-5">
            @csrf

            @if ($errors->has('error'))
                <div class="p-3 bg-red-100 text-red-800 rounded-lg">
                    {{ $errors->first('error') }}
                </div>

                <script>
                    window.onload = function () {
                        document.getElementById("reservaModal").classList.remove("hidden");
                    };
                </script>
            @endif

            <input type="hidden" id="canchaSeleccionada" name="cancha_id" value="{{ old('cancha_id') }}">

            <div>
                <label class="block text-gray-700 font-medium mb-1">📅 Fecha</label>
                <input type="date" name="fecha" 
                       class="w-full border-2 border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-400"
                       value="{{ old('fecha') }}" required>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">⏰ Hora</label>
                                <input type="time" name="hora_inicio" 
                                    class="w-full border-2 border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-orange-400"
                                    value="{{ old('hora_inicio') }}" required>
                        </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">⏳ Duración</label>
                <select name="duracion" required
                        class="w-full border-2 border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-400">
                    <option value="1" {{ old('duracion') == 1 ? 'selected' : '' }}>1 hora</option>
                    <option value="2" {{ old('duracion') == 2 ? 'selected' : '' }}>2 horas</option>
                    <option value="3" {{ old('duracion') == 3 ? 'selected' : '' }}>3 horas</option>
                </select>
            </div>

            <div class="flex justify-end gap-4 mt-6">
                <button type="button" onclick="closeForm()"
                        class="bg-gray-400 text-white px-5 py-2 rounded-xl shadow hover:bg-gray-500 transition">
                    Cancelar
                </button>
                <button type="submit"
                        class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-6 py-2 rounded-xl shadow-lg hover:from-indigo-600 hover:to-purple-700 transition">
                    Confirmar ✅
                </button>
            </div>
        </form>
    </div>
</div>

        <div class="mt-12">
            <h1 class="text-3xl font-extrabold text-white mb-8 border-b-4 border-blue-500 inline-block pb-2">Mis Reservas 📝</h1>

            @if($reservas->isEmpty())
                <p class="text-gray-600">No tienes reservas registradas.</p>
            @else
                <div class="overflow-x-auto bg-white shadow-xl rounded-xl">
                    <table class="min-w-full border-collapse">
                        <thead class="bg-gradient-to-r from-indigo-500 to-blue-500 text-white">
                            <tr>
                                <th class="px-6 py-4 text-lg font-semibold">Cancha</th>
                                <th class="px-6 py-4 text-lg font-semibold">Tipo</th>
                                <th class="px-6 py-4 text-lg font-semibold">Fecha</th>
                                <th class="px-6 py-4 text-lg font-semibold">Hora Inicio</th>
                                <th class="px-6 py-4 text-lg font-semibold">Hora Fin</th>
                                <th class="px-6 py-4 text-lg font-semibold">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach($reservas as $reserva)
                                <tr class="border-t hover:bg-indigo-50 transition-colors duration-200">
                                    <td class="px-6 py-4 text-center">{{ $reserva->cancha->nombre }}</td>
                                    <td class="px-6 py-4 text-center">{{ $reserva->cancha->tipo }}</td>
                                    <td class="px-6 py-4 text-center">{{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 text-center">{{ \Carbon\Carbon::parse($reserva->hora_inicio)->format('H:i') }}</td>
                                    <td class="px-6 py-4 text-center">{{ \Carbon\Carbon::parse($reserva->hora_fin)->format('H:i') }}</td>
                                    <td class="px-6 py-4 text-center font-semibold
                                        @if($reserva->estado === 'aprobada') text-green-600
                                        @elseif($reserva->estado === 'pendiente') text-yellow-600
                                        @elseif($reserva->estado === 'cancelada') text-red-600
                                        @else text-gray-600 @endif
                                    ">
                                        {{ ucfirst($reserva->estado) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
    <script>
        function openForm(id, nombre) {
            document.getElementById("reservaModal").classList.remove("hidden");
            document.getElementById("formTitle").innerText = "Reserva de " + nombre;
            document.getElementById("canchaSeleccionada").value = id;

            // Limpiar error al abrir modal
            const errorDiv = document.querySelector('#reservaModal .p-3.bg-red-100');
            if (errorDiv) errorDiv.remove();
        }

        function closeForm() {
            document.getElementById("reservaModal").classList.add("hidden");

            // Limpiar error al cerrar modal
            const errorDiv = document.querySelector('#reservaModal .p-3.bg-red-100');
            if (errorDiv) errorDiv.remove();
        }
    </script>
</x-app-layout>
