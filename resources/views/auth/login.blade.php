<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Web Caffa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-amber-900 via-amber-800 to-amber-700 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-lg shadow-2xl p-8">
            <div class="text-center mb-8">
                <div class="text-5xl mb-2">☕</div>
                <h1 class="text-3xl font-bold text-amber-900">Web Caffa</h1>
                <p class="text-amber-600 text-sm">Café en Grano con Sabores</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent outline-none transition">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent outline-none transition">
                </div>

                <button type="submit" class="w-full bg-amber-900 hover:bg-amber-800 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                    Iniciar Sesión
                </button>
            </form>

            <div class="mt-6 p-4 bg-amber-50 rounded-lg text-sm text-gray-600">
                <p class="font-semibold text-amber-900 mb-2">Credenciales de Prueba:</p>
                <p><strong>Email:</strong> admin@caffa.com</p>
                <p><strong>Contraseña:</strong> password</p>
            </div>
        </div>
    </div>
</body>
</html>
