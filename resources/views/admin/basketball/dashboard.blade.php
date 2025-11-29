<x-app-layout>
    @php
        // Filtrar únicamente las canchas de tipo "basketball"
        $canchas = ($canchas ?? collect())->where('tipo', 'basketball');
        // Filtrar reservas que tengan cancha tipo "basketball"
        $reservas = ($reservas ?? collect())->filter(fn($r) => $r->cancha->tipo === 'basketball');
    @endphp

<div class="min-h-screen bg-[#1f2937]">
    <div class="min-h-screen p-6 max-w-6xl mx-auto" x-data="{ canchaEdit: null, open: false }">
        <h1 class="text-3xl font-extrabold text-white mb-8 border-b-4 border-orange-500 inline-block pb-2">
            Panel de Administración ⚙️ (Solo Basketball 🏀)
        </h1>

            <!-- Mensajes de éxito o error -->
            @if (session('success'))
                <div x-data="{ show: true }" 
                     x-show="show" 
                     x-transition.opacity.duration.500ms
                     class="mb-6 p-4 rounded-xl bg-green-100 border border-green-300 text-green-800 font-semibold shadow">
                    {{ session('success') }}
                    <button @click="show = false" class="float-right text-green-700 font-bold">✖</button>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-100 border border-red-300 text-red-800 font-semibold shadow">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>⚠️ {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        <!-- ======================= -->
        <!-- Sección: Canchas Basketball -->
        <!-- ======================= -->
        <h2 class="text-2xl font-semibold text-white mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 2a10 10 0 100 20 10 10 0 000-20z" />
            </svg>
            Canchas de Basketball
        </h2>

        <!-- Botón abrir modal nueva cancha -->
        <div x-data="{ open: false }" class="mt-6 pb-5">
            <button 
                @click="open = true" 
                class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-6 py-3 rounded-xl shadow-lg font-semibold hover:from-indigo-600 hover:to-purple-700 transition">
                ➕ Agregar nueva cancha
            </button>

            <!-- Modal -->
            <div 
                x-show="open" 
                x-transition.opacity
                class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
            >
                <div class="bg-white shadow-2xl rounded-2xl p-8 w-full max-w-2xl relative animate-fade-in">
                    <!-- Botón cerrar -->
                    <button 
                        @click="open = false"
                        class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl font-bold"
                    >✖</button>

                    <h3 class="text-3xl font-extrabold mb-6 text-indigo-600">Nueva Cancha</h3>
                    <form action="{{ route('admin.canchas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Imagen</label>
                            <input type="file" name="imagen" accept="image/*" 
                                class="w-full border-2 border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-400">
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Nombre de cancha</label>
                            <input type="text" name="nombre" placeholder="Ej: Cancha de Basketball #1" required
                                class="w-full border-2 border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-400">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Tipo</label>
                                <select name="tipo" required
                                    class="w-full border-2 border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-400">
                                    <option value="basketball" selected>Basketball</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Lugar</label>
                                <input type="text" name="lugar" required
                                    class="w-full border-2 border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-400">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Precio por hora</label>
                                <input type="number" name="precio_por_hora" required
                                    class="w-full border-2 border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-400">
                            </div>

                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Estado</label>
                                <select name="estado" required
                                    class="w-full border-2 border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-400">
                                    <option value="disponible">Disponible</option>
                                    <option value="no disponible">No disponible</option>
                                    <option value="mantenimiento">Mantenimiento</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end gap-4 mt-6">
                            <button type="button" @click="open = false"
                                class="bg-gray-400 text-white px-5 py-2 rounded-xl shadow hover:bg-gray-500 transition">
                                Cancelar
                            </button>
                            <button type="submit"
                                class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-6 py-2 rounded-xl shadow-lg hover:from-indigo-600 hover:to-purple-700 transition">
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">
    @forelse($canchas as $cancha)
        <div class="bg-gradient-to-br from-white to-gray-50 shadow-xl rounded-2xl p-6 text-center flex flex-col justify-between h-full border border-gray-200 hover:shadow-2xl hover:-translate-y-1 transition-transform duration-300">
            
            <!-- Imagen -->
            @if($cancha->imagen)
                <img src="{{ asset('images/' . $cancha->imagen) }}" 
                    alt="Imagen de la cancha" 
                    class="w-full h-48 object-cover rounded-xl mb-4 shadow-md">
            @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500 rounded-xl mb-4">
                    Sin imagen
                </div>
            @endif

            <!-- Nombre y detalles -->
            <h3 class="text-xl font-bold text-gray-800">{{ $cancha->nombre }}</h3>
            <p class="text-gray-500">{{ ucfirst($cancha->tipo) }} • {{ $cancha->lugar }}</p>
            
            <p class="text-lg font-semibold text-indigo-600 mt-2">
                💲 {{ number_format($cancha->precio_por_hora, 0, ',', '.') }} / hora
            </p>

            <!-- Estado -->
            <div class="mt-3 flex justify-center">
                <span class="inline-block text-sm font-semibold px-3 py-1 rounded-full shadow-sm
                    {{ $cancha->estado === 'disponible' ? 'bg-green-100 text-green-700' :
                    ($cancha->estado === 'no disponible' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                    {{ ucfirst($cancha->estado) }}
                </span>
            </div>

            <!-- Botones -->
            <div class="flex justify-center gap-3 mt-5">
                <!-- Botón Editar -->
                <button
                    @click="canchaEdit = {{ $cancha->toJson() }}"
                    class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-white px-4 py-2 rounded-xl shadow hover:from-yellow-500 hover:to-yellow-600 transition">
                    ✏️ Editar
                </button>

                <!-- Botón Eliminar -->
                <form action="{{ route('admin.canchas.destroy', $cancha->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta cancha?');">
                    @csrf
                    @method('DELETE')
                    <button 
                        type="button"
                        @click="$dispatch('open-delete', { id: {{ $cancha->id }} })"
                        class="bg-gradient-to-r from-red-500 to-red-600 text-white px-4 py-2 rounded-xl shadow hover:from-red-600 hover:to-red-700 transition">
                        🗑️ Eliminar
                    </button>
                </form>
            </div>
        </div>
    @empty
        <p class="col-span-3 text-center text-gray-500">No hay canchas de basketball registradas.</p>
    @endforelse
</div>

    <!-- 🔹 Modal Confirmación Eliminar -->
    <div 
        x-data="{ open: false, canchaId: null }"
        x-on:open-delete.window="open = true; canchaId = $event.detail.id"
        x-show="open"
        x-transition.opacity
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
    >
        <div class="bg-white shadow-2xl rounded-2xl p-8 w-full max-w-md relative">
            <!-- Botón cerrar -->
            <button 
                @click="open = false"
                class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl font-bold"
            >✖</button>

            <h3 class="text-2xl font-extrabold text-red-600 mb-4">¿Eliminar cancha?</h3>
            <p class="text-gray-600 mb-6">Esta acción no se puede deshacer. ¿Deseas continuar?</p>

            <div class="flex justify-end gap-4">
                <button 
                    @click="open = false"
                    class="bg-gray-400 text-white px-5 py-2 rounded-xl shadow hover:bg-gray-500 transition">
                    Cancelar
                </button>
                <form 
                    :action="'/admin/canchas/' + canchaId" 
                    method="POST"
                    class="inline"
                >
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-2 rounded-xl shadow-lg hover:from-red-600 hover:to-red-700 transition">
                        Sí, eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Cancha -->
    <div x-show="canchaEdit" 
        x-transition.opacity
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">

        <div class="bg-white shadow-2xl rounded-2xl p-8 w-full max-w-2xl relative animate-fade-in"
            @click.away="canchaEdit = null">

            <!-- Botón cerrar -->
            <button @click="canchaEdit = null"
                class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl font-bold">
                ✖
            </button>

            <h3 class="text-3xl font-extrabold mb-6 text-indigo-600"
                x-text="'Editar Cancha: ' + canchaEdit.nombre">
            </h3>

            <form :action="'/admin/canchas/' + canchaEdit.id" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- Imagen actual -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Imagen actual</label>
                    <template x-if="canchaEdit.imagen">
                        <img :src="'/images/' + canchaEdit.imagen" 
                            alt="Imagen de la cancha" 
                            class="w-40 h-28 object-cover rounded-xl border-2 border-gray-300 shadow-md mb-3">
                    </template>
                    <p x-show="!canchaEdit.imagen" class="text-gray-500 italic">Sin imagen</p>
                </div>

                <!-- Cambiar imagen -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Cambiar imagen</label>
                    <input type="file" name="imagen" accept="image/*"
                        class="w-full border-2 border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-400">
                </div>

                <!-- Nombre -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Nombre de cancha</label>
                    <input type="text" name="nombre" required
                        class="w-full border-2 border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-400"
                        :value="canchaEdit.nombre">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Tipo -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Tipo</label>
                        <select name="tipo" required
                            class="w-full border-2 border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-400">
                            <option value="basketball" selected>Basketball</option>
                        </select>
                    </div>

                    <!-- Lugar -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Lugar</label>
                        <input type="text" name="lugar" required
                            class="w-full border-2 border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-400"
                            :value="canchaEdit.lugar">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Precio -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Precio por hora</label>
                        <input type="number" name="precio_por_hora" required
                            class="w-full border-2 border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-400"
                            :value="canchaEdit.precio_por_hora">
                    </div>

                    <!-- Estado -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Estado</label>
                        <select name="estado" required
                            class="w-full border-2 border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-400">
                            <option value="disponible" :selected="canchaEdit.estado === 'disponible'">Disponible</option>
                            <option value="no disponible" :selected="canchaEdit.estado === 'no disponible'">No disponible</option>
                            <option value="mantenimiento" :selected="canchaEdit.estado === 'mantenimiento'">Mantenimiento</option>
                        </select>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex justify-end gap-4 mt-6">
                    <button type="button" @click="canchaEdit = null"
                        class="bg-gray-400 text-white px-5 py-2 rounded-xl shadow hover:bg-gray-500 transition">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-6 py-2 rounded-xl shadow-lg hover:from-indigo-600 hover:to-purple-700 transition">
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>

        <!-- ======================= -->
        <!-- Sección: Reservas Basketball -->
        <!-- ======================= -->
        <div class="mt-12">
            <h2 class="text-3xl font-extrabold text-white mb-6 border-b-4 border-orange-500 inline-block pb-2">
                Reservas de Basketball 📝
            </h2>

            @if($reservas->isEmpty())
                <p class="text-gray-600">No hay reservas de basketball registradas.</p>
            @else
                <div class="overflow-x-auto bg-white shadow-xl rounded-xl">
                    <table class="min-w-full border-collapse">
                        <thead class="bg-gradient-to-r from-orange-500 to-red-500 text-white">
                            <tr>
                                <th class="px-6 py-4 text-lg font-semibold">Usuario</th>
                                <th class="px-6 py-4 text-lg font-semibold">Cancha</th>
                                <th class="px-6 py-4 text-lg font-semibold">Tipo</th>
                                <th class="px-6 py-4 text-lg font-semibold">Fecha</th>
                                <th class="px-6 py-4 text-lg font-semibold">Hora</th>
                                <th class="px-6 py-4 text-lg font-semibold">Estado</th>
                                <th class="px-6 py-4 text-lg font-semibold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach($reservas as $reserva)
                                <tr class="border-t hover:bg-orange-50 transition-colors duration-200">
                                    <td class="px-6 py-4 text-center">{{ $reserva->user->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-center">{{ $reserva->cancha->nombre ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-center">{{ $reserva->cancha->tipo }}</td>
                                    <td class="px-6 py-4 text-center">{{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 text-center">{{ \Carbon\Carbon::parse($reserva->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($reserva->hora_fin)->format('H:i') }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2 py-1 rounded-full text-sm
                                            @if($reserva->estado === 'aprobada') bg-green-100 text-green-700 
                                            @elseif($reserva->estado === 'rechazada') bg-red-100 text-red-700
                                            @else bg-yellow-100 text-yellow-700 @endif">
                                            {{ ucfirst($reserva->estado) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('admin.reservas.updateEstado', $reserva->id) }}" method="POST" class="flex justify-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="estado" class="border rounded-lg px-2 py-1 text-sm">
                                                <option value="pendiente" {{ $reserva->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                                <option value="aprobada" {{ $reserva->estado === 'aprobada' ? 'selected' : '' }}>Aprobada</option>
                                                <option value="rechazada" {{ $reserva->estado === 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                                            </select>
                                            <button type="submit" class="bg-indigo-500 text-white px-3 py-1 rounded-lg shadow hover:bg-indigo-600 transition text-sm">Actualizar</button>
                                        </form>
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
</x-app-layout>

<script src="//unpkg.com/alpinejs" defer></script>
