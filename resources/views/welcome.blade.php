<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reserva de Canchas</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo1.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-gray-900 text-white">
    <div class="min-h-screen flex flex-col justify-between">
<!-- HEADER -->
<header class="sticky top-0 z-50 bg-gradient-to-r from-blue-800/90 to-indigo-700/90 backdrop-blur-lg shadow-lg">
    <div class="max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">
        
        <!-- Logo + Texto -->
        <div class="flex items-center space-x-4">
            <img src="{{ asset('images/logo1.png') }}" alt="Logo" 
                 class="h-16 w-auto rounded-md filter brightness-0 invert" />
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-wide text-white">
                Reserva de Canchas
            </h1>
        </div>

        <!-- Navegación -->
        <nav class="space-x-4">
            @auth
                <a href="{{ url('/dashboard') }}" class="text-gray-200 hover:text-white transition">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl bg-blue-500 hover:bg-blue-600 shadow-md transition">Iniciar sesión</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="px-4 py-2 rounded-xl bg-green-500 hover:bg-green-600 shadow-md transition">Registrarse</a>
                @endif
            @endauth
        </nav>
    </div>
</header>


        <!-- HERO -->
        <main class="flex-grow">
            <section class="relative text-center py-20 px-6 bg-gradient-to-r from-indigo-900 via-blue-800 to-blue-600 overflow-hidden">
                <div class="absolute inset-0 bg-[url('/images/pattern.svg')] opacity-20"></div>
                <h2 class="text-5xl font-extrabold mb-4 animate-fade-in">Sistema de Reserva de Canchas</h2>
                <p class="text-lg text-gray-200 max-w-2xl mx-auto mb-6">
                    Administra tus reservas de fútbol, baloncesto y tenis de forma rápida, moderna y sencilla.
                </p>
            </section>

            <!-- MÓDULOS -->
            <section id="modulos" class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto px-6 py-16">
                <div class="bg-gray-800/60 backdrop-blur-lg rounded-2xl p-8 shadow-lg hover:scale-105 transition">
                    <h3 class="text-2xl font-semibold mb-3 text-center">⚽ Fútbol</h3>
                    <p class="text-gray-300 text-center">Reserva tu cancha y organiza partidos inolvidables con tus amigos.</p>
                </div>
                <div class="bg-gray-800/60 backdrop-blur-lg rounded-2xl p-8 shadow-lg hover:scale-105 transition">
                    <h3 class="text-2xl font-semibold mb-3 text-center">🏀 Baloncesto</h3>
                    <p class="text-gray-300 text-center">Consulta la disponibilidad y arma torneos fácilmente.</p>
                </div>
                <div class="bg-gray-800/60 backdrop-blur-lg rounded-2xl p-8 shadow-lg hover:scale-105 transition">
                    <h3 class="text-2xl font-semibold mb-3 text-center">🎾 Tenis</h3>
                    <p class="text-gray-300 text-center">Reserva tu cancha de tenis y entrena sin complicaciones.</p>
                </div>
            </section>

            <section class="bg-gray-900 py-16 text-center">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                    <div>
                        <h4 class="text-4xl font-bold text-blue-400">+200</h4>
                        <p class="text-gray-400">Reservas realizadas</p>
                    </div>
                    <div>
                        <h4 class="text-4xl font-bold text-green-400">+50</h4>
                        <p class="text-gray-400">Usuarios activos</p>
                    </div>
                    <div>
                        <h4 class="text-4xl font-bold text-yellow-400">+30</h4>
                        <p class="text-gray-400">Canchas disponibles</p>
                    </div>
                </div>
            </section>

            <!-- EQUIPO -->
            <section class="text-center py-20 bg-gray-800">
                <h3 class="text-3xl font-bold mb-10">👨‍💻 Equipo de Desarrollo</h3>
                <div class="flex flex-wrap justify-center gap-10">
                    <div class="flex flex-col items-center bg-gray-700/70 backdrop-blur-lg rounded-2xl px-8 py-8 shadow-lg w-72 hover:scale-105 transition">
                        <img src="/fotos/juan.jpg" alt="" class="rounded-full w-32 h-32 object-cover mb-4 border-4 border-blue-500 shadow-lg">
                        <p class="font-semibold text-white text-lg">Juan José Ramos</p>
                        <span class="text-gray-400 text-sm">Fullstack Developer</span>
                    </div>
                    <div class="flex flex-col items-center bg-gray-700/70 backdrop-blur-lg rounded-2xl px-8 py-8 shadow-lg w-72 hover:scale-105 transition">
                        <img src="/fotos/estiven.jpg" alt="" class="rounded-full w-32 h-32 object-cover mb-4 border-4 border-green-500 shadow-lg">
                        <p class="font-semibold text-white text-lg">Estiven Mosquera</p>
                        <span class="text-gray-400 text-sm">Backend Developer</span>
                    </div>
                </div>
            </section>
        </main>

        <!-- FOOTER (igual que lo tenías) -->
        <footer class="bg-[#1f2937] border-t border-gray-600 text-white py-10 mt-6">
            <div class="max-w-7xl mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 text-sm text-center">
                    <div>
                        <h3 class="text-lg font-bold mb-4">CONTACTO</h3>
                        <p class="pb-2">Juan José Ramos</p>
                        <p class="pb-2">juan.ramos586@pascualbravo.edu.co</p>
                        <p class="pb-2">Estiven Mosquera</p>
                        <p class="pb-2">estiven.mosquera900@pascualbravo.edu.co</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold mb-4">TELÉFONOS</h3>
                        <p class="pb-2">Juan José Ramos: +57 312 778 80 47</p>
                        <p class="pb-2">Estiven Mosquera: +57 302 223 70 25</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold mb-4">GITHUB</h3>
                        <p class="pb-2"><a href="https://github.com/juanjopg123" target="_blank" class="text-blue-400">Juan José Ramos</a></p>
                        <p class="pb-2"><a href="https://github.com/estivenmosquera900-hub" target="_blank" class="text-blue-400">Estiven Mosquera</a></p>
                    </div>
                </div>
                <div class="border-t border-gray-600 mt-10 pt-4 text-center text-xs text-gray-400">
                    <p>
                        © {{ date('Y') }} Reserva de Canchas. Todos los derechos reservados | 
                        <span class="text-blue-400 font-semibold">The Providers</span>
                    </p>
                </div>
            </div>
        </footer>

    </div>
</body>
</html>
