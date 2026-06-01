<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Web Caffa - Café en Grano')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50" x-data="{ sidebarOpen: window.innerWidth >= 768 }" x-cloak @keydown.escape="sidebarOpen = false">
    @auth
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 bg-amber-900 text-white shadow-lg transform transition-transform duration-300 ease-in-out md:translate-x-0"
             :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
             @click.away="if(window.innerWidth < 768) sidebarOpen = false">
            
            <!-- Logo -->
            <div class="p-6 border-b border-amber-800">
                <div class="flex items-center space-x-3">
                    <div class="text-3xl">☕</div>
                    <div>
                        <h1 class="text-xl font-bold">Web Caffa</h1>
                        <p class="text-xs text-amber-200">Café en Grano</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-amber-800 transition">
                    <span class="text-xl">📊</span>
                    <span>Dashboard</span>
                </a>

                @php
                    $modules = \App\Models\Module::where('activo', true)->orderBy('orden')->get();
                @endphp
                
                @foreach ($modules as $module)
                    @can($module->slug . ' view')
                        <a href="{{ route($module->slug . '.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-amber-800 transition" title="{{ $module->descripcion }}">
                            <span class="text-xl">{{ $module->icono }}</span>
                            <span>{{ $module->nombre }}</span>
                        </a>
                    @endcan
                @endforeach
            </nav>

            <!-- User Section -->
            <div class="border-t border-amber-800 p-4 space-y-3">
                <div class="px-4 py-2 bg-amber-800 rounded-lg">
                    <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-amber-200">{{ auth()->user()->email }}</p>
                </div>
                
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-red-700 transition bg-red-600">
                        <span class="text-xl">🚪</span>
                        <span>Cerrar Sesión</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Mobile Toggle Button -->
        <button @click="sidebarOpen = !sidebarOpen" class="fixed bottom-6 right-6 z-40 md:hidden bg-amber-900 text-white p-4 rounded-full shadow-lg hover:bg-amber-800 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <!-- Overlay -->
        <div class="fixed inset-0 z-40 bg-black opacity-50 transition-opacity md:hidden"
             :class="sidebarOpen ? 'opacity-50' : 'opacity-0 pointer-events-none'"
             @click="sidebarOpen = false"></div>

        <!-- Main Content -->
        <div class="md:ml-64 min-h-screen flex flex-col">
            <!-- Top Bar -->
            <div class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                <button @click="sidebarOpen = !sidebarOpen" class="hidden md:hidden text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <h2 class="text-2xl font-bold text-amber-900">@yield('title', 'Web Caffa')</h2>
                <div class="w-6"></div>
            </div>

            <!-- Main Content Area -->
            <main class="flex-grow px-6 py-8">
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-amber-900 text-white text-center py-4 border-t border-amber-800">
                <p class="text-sm">&copy; 2026 Web Caffa - Café en Grano. Todos los derechos reservados.</p>
            </footer>
        </div>
    @endauth

    @guest
        <main class="flex-grow max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="bg-amber-900 text-white text-center py-6 border-t border-amber-800">
            <p>&copy; 2026 Web Caffa - Café en Grano. Todos los derechos reservados.</p>
        </footer>
    @endguest
</body>
</html>
