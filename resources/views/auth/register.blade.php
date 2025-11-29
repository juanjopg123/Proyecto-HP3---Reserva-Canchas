<x-guest-layout>
    <div class="w-full max-w-sm bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white rounded-2xl shadow-2xl p-8 relative overflow-hidden">

        <!-- Logo -->
        <div class="flex justify-center mb-3">
            <img src="{{ asset('images/logo1.png') }}" alt="Logo"
                class="h-24 w-auto rounded-md filter brightness-0 invert" />
        </div>

        <!-- Título -->
        <div class="text-center mb-6">
            <h2 class="text-3xl font-extrabold tracking-wide text-indigo-300">Crear cuenta</h2>
            <p class="text-sm text-gray-400">Regístrate para acceder al sistema</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Nombre -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Nombre completo')" class="text-indigo-300" />
                <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus
                    class="mt-1 block w-full bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400 px-3 py-2 placeholder-gray-400" />
                <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-400" />
            </div>

            <!-- Correo -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Correo electrónico')" class="text-indigo-300" />
                <x-text-input id="email" type="email" name="email" :value="old('email')" required
                    class="mt-1 block w-full bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400 px-3 py-2 placeholder-gray-400" />
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-400" />
            </div>

            <!-- Contraseña -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Contraseña')" class="text-indigo-300" />
                <x-text-input id="password" type="password" name="password" required
                    class="mt-1 block w-full bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400 px-3 py-2 placeholder-gray-400" />
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-400" />
            </div>

            <!-- Confirmar Contraseña -->
            <div class="mb-4">
                <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" class="text-indigo-300" />
                <x-text-input id="password_confirmation" type="password" name="password_confirmation" required
                    class="mt-1 block w-full bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400 px-3 py-2 placeholder-gray-400" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-400" />
            </div>

            <!-- Botón -->
            <div>
                <button type="submit"
                    class="w-full py-3 rounded-lg bg-gradient-to-r from-indigo-500 to-blue-500 hover:from-indigo-400 hover:to-blue-400 transition-all duration-300 font-semibold shadow-lg hover:shadow-indigo-500/30">
                    REGISTRARME
                </button>
            </div>
        </form>

        <!-- Link al login -->
        <p class="text-sm text-center text-gray-400 mt-4">
            ¿Ya tienes cuenta?
            <a href="{{ route('login') }}" class="text-indigo-300 hover:text-indigo-200 transition">Inicia sesión</a>
        </p>
    </div>
</x-guest-layout>
