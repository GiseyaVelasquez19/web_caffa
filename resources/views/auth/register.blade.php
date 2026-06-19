<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Web Caffa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FAF7F4] min-h-screen flex items-center justify-center">
    <!-- Background Pattern -->
    <div class="fixed inset-0 opacity-5 pointer-events-none">
        <svg viewBox="0 0 400 400" class="w-full h-full">
            <defs>
                <pattern id="coffee-beans" x="0" y="0" width="60" height="60" patternUnits="userSpaceOnUse">
                    <ellipse cx="15" cy="15" rx="8" ry="12" fill="#6F4E37" transform="rotate(30 15 15)"/>
                    <ellipse cx="45" cy="45" rx="8" ry="12" fill="#6F4E37" transform="rotate(-30 45 45)"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#coffee-beans)"/>
        </svg>
    </div>

    <div class="w-full max-w-md px-4">
        <!-- Logo -->
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo_web_caffa.png') }}" alt="Logo Caffa" class="h-20 mx-auto mb-4">
            <h1 class="text-2xl font-bold text-gray-800">Web Caffa</h1>
            <p class="text-gray-500 text-sm">Café en Grano con Sabores</p>
        </div>

        <!-- Register Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Crear Cuenta</h2>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 rounded-lg text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent outline-none transition @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent outline-none transition @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent outline-none transition @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-400 text-xs mt-1">Mínimo 8 caracteres</p>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmar Contraseña</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent outline-none transition">
                </div>

                <button type="submit" class="w-full text-white font-medium py-2.5 px-4 rounded-lg transition" style="background-color: #6F4E37" onmouseover="this.style.backgroundColor='#5A3E2B'" onmouseout="this.style.backgroundColor='#6F4E37'">
                    Crear Cuenta
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-gray-500 text-sm">
                    ¿Ya tienes cuenta?
                    <a href="{{ route('login') }}" class="font-medium hover:underline" style="color: #6F4E37">Inicia sesión</a>
                </p>
            </div>
        </div>

        <!-- Back to home -->
        <div class="mt-6 text-center">
            <a href="/" class="text-gray-500 hover:text-gray-700 text-sm">
                ← Volver al inicio
            </a>
        </div>
    </div>
</body>
</html>
