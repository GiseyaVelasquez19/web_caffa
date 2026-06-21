<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Web Caffa - Café en Grano')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#FAF7F4]" x-data="{ sidebarOpen: window.innerWidth >= 768 }" x-cloak @keydown.escape="sidebarOpen = false">
    @auth
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-72 md:w-64 flex flex-col text-white shadow-xl transform transition-transform duration-300 ease-in-out md:translate-x-0"
             style="background: linear-gradient(180deg, #6F4E37 0%, #5A3E2B 100%)"
             :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
             @click.away="if(window.innerWidth < 768) sidebarOpen = false">

            <!-- Logo -->
            <div class="p-4 md:p-5 border-b border-white/20">
                <a href="{{ route('dashboard') }}" class="flex items-center justify-center">
                    <img src="{{ asset('images/logo_nuevo.png') }}" alt="Logo Caffa" class="h-24 md:h-28 w-auto">
                </a>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 md:px-4 py-4 md:py-6 space-y-1 overflow-y-auto">
                @php
                    $modules = \App\Models\Module::where('activo', true)->orderBy('orden')->get();
                @endphp

                {{-- Main Menu --}}
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-3 md:px-4 py-2.5 rounded-lg hover:bg-white/10 transition text-white/90 hover:text-white">
                    <span class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center text-sm text-white"><i class="fas fa-chart-pie"></i></span>
                    <span class="text-sm">Dashboard</span>
                </a>

                {{-- Client Links --}}
                <a href="{{ route('products.catalog') }}" class="flex items-center space-x-3 px-3 md:px-4 py-2.5 rounded-lg hover:bg-white/10 transition text-white/90 hover:text-white">
                    <span class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center text-sm text-white"><i class="fas fa-mug-hot"></i></span>
                    <span class="text-sm">Catálogo</span>
                </a>
                <a href="{{ route('cart.index') }}" class="flex items-center space-x-3 px-3 md:px-4 py-2.5 rounded-lg hover:bg-white/10 transition text-white/90 hover:text-white">
                    <span class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center text-sm text-white"><i class="fas fa-shopping-cart"></i></span>
                    <span class="text-sm">Carrito</span>
                </a>
                <a href="{{ route('orders.my') }}" class="flex items-center space-x-3 px-3 md:px-4 py-2.5 rounded-lg hover:bg-white/10 transition text-white/90 hover:text-white">
                    <span class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center text-sm text-white"><i class="fas fa-box"></i></span>
                    <span class="text-sm">Mis Pedidos</span>
                </a>

                {{-- Admin Modules --}}
                @foreach ($modules as $module)
                    @can($module->slug . ' view')
                        <a href="{{ route($module->slug . '.index') }}" class="flex items-center space-x-3 px-3 md:px-4 py-2.5 rounded-lg hover:bg-white/10 transition text-white/90 hover:text-white" title="{{ $module->descripcion }}">
                            <span class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center text-sm text-white"><i class="{{ $module->icono }}"></i></span>
                            <span class="text-sm">{{ $module->nombre }}</span>
                        </a>
                    @endcan
                @endforeach

                {{-- Orders (Vendedor/Admin) --}}
                @can('orders view')
                    <a href="{{ route('orders.index') }}" class="flex items-center space-x-3 px-3 md:px-4 py-2.5 rounded-lg hover:bg-white/10 transition text-white/90 hover:text-white">
                        <span class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center text-sm text-white"><i class="fas fa-receipt"></i></span>
                        <span class="text-sm">Pedidos</span>
                    </a>
                @endcan
            </nav>

            <!-- User Section -->
            <div class="border-t border-white/20 p-3 md:p-4">
                <div class="flex items-center space-x-3 mb-3 px-2">
                    <div class="w-9 h-9 bg-white/20 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-white/60 truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center space-x-2 px-4 py-2 rounded-lg bg-white/10 hover:bg-red-500/80 transition text-sm">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Cerrar Sesión</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Mobile Toggle Button -->
        <button @click="sidebarOpen = !sidebarOpen" class="fixed bottom-6 right-6 z-40 md:hidden text-white p-4 rounded-full shadow-lg hover:opacity-90 transition" style="background-color: #6F4E37">
            <i class="fas" :class="sidebarOpen ? 'fa-times' : 'fa-bars'"></i>
        </button>

        <!-- Overlay -->
        <div class="fixed inset-0 z-40 bg-black/50 transition-opacity md:hidden"
             :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'"
             @click="sidebarOpen = false"></div>

        <!-- Main Content -->
        <div class="md:ml-64 min-h-screen flex flex-col">
            <!-- Top Bar -->
            <div class="bg-white border-b border-gray-200 px-4 md:px-6 py-3 flex items-center justify-between sticky top-0 z-30">
                <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-500 hover:text-gray-700 p-2">
                    <i class="fas fa-bars text-lg"></i>
                </button>
                <h2 class="text-sm md:text-lg font-semibold text-gray-700 truncate flex-1 text-center md:text-left md:ml-0">@yield('title', 'Web Caffa')</h2>
                <div class="w-10"></div>
            </div>

            <!-- Main Content Area -->
            <main class="flex-grow px-4 md:px-6 py-4 md:py-6">
                @if ($errors->any())
                    <div class="mb-4 p-3 md:p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-4 p-3 md:p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 p-3 md:p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white text-gray-400 text-center py-3 md:py-4 border-t border-gray-200">
                <p class="text-xs">&copy; 2026 Web Caffa - Café en Grano. Todos los derechos reservados.</p>
            </footer>
        </div>
    @endauth

    @guest
        <div class="min-h-screen" style="background: linear-gradient(135deg, #FAF7F4 0%, #F0E6DB 100%)">
            <main class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-6 md:py-12">
                @if ($errors->any())
                    <div class="mb-4 p-3 md:p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-4 p-3 md:p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>

            <footer class="text-center py-4 md:py-6 border-t border-white/20" style="background-color: #5A3E2B">
                <p class="text-xs text-white/70">&copy; 2026 Web Caffa - Café en Grano. Todos los derechos reservados.</p>
            </footer>
        </div>
    @endguest
</body>
</html>
