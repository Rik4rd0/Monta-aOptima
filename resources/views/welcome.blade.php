<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Montaña Optima</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|montserrat:400,600,700" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
                /* Base styles - keeping the core styles from Laravel */
            </style>
        @endif

        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        
        <style>
            body {
                font-family: 'Montserrat', sans-serif;
                background: linear-gradient(to bottom right, #f7fafc, #edf2f7);
                min-height: 100vh;
            }
            .hero-section {
                background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1519904981063-b0cf448d479e?ixlib=rb-4.0.3');
                background-size: cover;
                background-position: center;
                height: 60vh;
            }
            .glow-button {
                position: relative;
                z-index: 1;
                overflow: hidden;
                transition: all 0.3s ease;
            }
            .glow-button::before {
                content: "";
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0) 70%);
                transform: scale(0);
                transition: transform 0.6s ease-out;
                z-index: -1;
            }
            .glow-button:hover::before {
                transform: scale(1);
            }
            .mountain-icon {
                animation: float 3s ease-in-out infinite;
            }
            @keyframes float {
                0% {
                    transform: translateY(0px);
                }
                50% {
                    transform: translateY(-10px);
                }
                100% {
                    transform: translateY(0px);
                }
            }
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body x-data="{ showGreeting: false }">
        <header class="bg-gradient-to-r from-blue-800 to-indigo-900 text-white shadow-lg">
            <div class="container mx-auto py-4 px-6 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <svg class="h-8 w-8 text-yellow-400 mountain-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <h1 class="text-2xl font-bold">Montaña Óptima</h1>
                </div>
                
                @if (Route::has('login'))
                    <nav class="flex items-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm hover:underline transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm hover:underline transition">Iniciar sesión</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-sm bg-white text-blue-800 px-4 py-2 rounded-md hover:bg-blue-100 transition">Registrarse</a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </header>

        <section class="hero-section flex flex-col items-center justify-center text-center text-white px-6">
            <div x-data="{ show: false }" 
                x-init="setTimeout(() => show = true, 300)" 
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 transform -translate-y-12"
                x-transition:enter-end="opacity-100 transform translate-y-0">
                <h1 class="text-4xl md:text-5xl font-bold mb-4" 
                    x-bind:class="{ 'opacity-100': show, 'opacity-0': !show }">Optimizador de Equipamiento para Excursionistas</h1>
                <p class="text-xl md:text-2xl max-w-3xl mx-auto" 
                    x-bind:class="{ 'opacity-100': show, 'opacity-0': !show }">
                    Encuentra la combinación perfecta de elementos basada en calorías y peso
                </p>
            </div>
        </section>

        <main class="container mx-auto py-16 px-6">
            <div class="grid md:grid-cols-2 gap-12 items-center max-w-6xl mx-auto">
                <div class="space-y-6" 
                    x-data="{ show: false }" 
                    x-init="setTimeout(() => show = true, 600)" 
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 transform translate-x-12"
                    x-transition:enter-end="opacity-100 transform translate-x-0">
                    <h2 class="text-3xl font-bold text-gray-800">¿Qué es Montaña Óptima?</h2>
                    <p class="text-gray-600 text-lg">
                        Montaña Óptima es una herramienta avanzada para excursionistas que desean calcular la combinación ideal de elementos para llevar en sus aventuras, considerando el peso máximo que pueden cargar y las calorías mínimas necesarias.
                    </p>
                    <p class="text-gray-600 text-lg">
                        Nuestro algoritmo de optimización encuentra la combinación perfecta de elementos para maximizar tus calorías mientras minimizas el peso de tu equipo.
                    </p>
                    <div class="mt-8">
                        <a href="{{ url('/optimizador') }}" 
                           class="glow-button bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-bold py-3 px-8 rounded-lg text-lg shadow-lg transform hover:scale-105 transition-all duration-300 inline-flex items-center">
                            <span>Comenzar ahora</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-200" 
                    x-data="{ show: false }" 
                    x-init="setTimeout(() => show = true, 900)" 
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 transform -translate-x-12"
                    x-transition:enter-end="opacity-100 transform translate-x-0">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Características principales</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-gray-700">Algoritmo avanzado de optimización</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-gray-700">Interfaz intuitiva y amigable</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-gray-700">Personalización de elementos</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-gray-700">Resultados visuales claros</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-20 text-center max-w-3xl mx-auto"
                x-data="{ showGreeting: false }"
                x-init="setTimeout(() => showGreeting = true, 1500)"
                x-cloak>
                <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-800 p-6 rounded-lg shadow-md"
                    x-show="showGreeting"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 transform translate-y-12"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 transform translate-y-0"
                    x-transition:leave-end="opacity-0 transform translate-y-12">
                    <h3 class="text-xl font-bold mb-2">¡Bienvenido a Montaña Óptima!</h3>
                    <p class="text-blue-700">
                        Estamos emocionados de ayudarte a optimizar tu próxima aventura. 
                        Haz clic en el botón "Comenzar ahora" para encontrar la combinación perfecta de elementos.
                    </p>
                    <div class="mt-4">
                        <button @click="showGreeting = false" class="text-blue-600 hover:text-blue-800 underline font-medium">
                            Entendido
                        </button>
                    </div>
                </div>
            </div>
        </main>

        <section class="bg-gray-100 py-16 px-6">
            <div class="container mx-auto text-center">
                <h2 class="text-3xl font-bold text-gray-800 mb-8">¿Listo para optimizar tu equipo?</h2>
                <a href="{{ url('/optimizador') }}" 
                   class="glow-button bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-bold py-4 px-10 rounded-lg text-lg shadow-lg transform hover:scale-105 transition-all duration-300 inline-flex items-center">
                    <span>Ir al Optimizador</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </section>

        <footer class="bg-gray-800 text-white py-10 px-6">
            <div class="container mx-auto">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-6 md:mb-0">
                        <div class="flex items-center gap-3">
                            <svg class="h-6 w-6 text-yellow-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-lg font-bold">Montaña Óptima</span>
                        </div>
                        <p class="text-gray-400 mt-2">© {{ date('Y') }} Todos los derechos reservados.</p>
                    </div>
                    <div>
                        <ul class="flex space-x-6">
                            <li>
                                <a href="#" class="text-gray-300 hover:text-white transition">Acerca de</a>
                            </li>
                            <li>
                                <a href="#" class="text-gray-300 hover:text-white transition">Contacto</a>
                            </li>
                            <li>
                                <a href="#" class="text-gray-300 hover:text-white transition">Términos</a>
                            </li>
                            <li>
                                <a href="#" class="text-gray-300 hover:text-white transition">Privacidad</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
