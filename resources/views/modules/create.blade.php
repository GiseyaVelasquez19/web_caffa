@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-amber-900 mb-6">Crear Nuevo Módulo</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('modules.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label for="nombre" class="block text-sm font-semibold text-amber-900 mb-2">Nombre del Módulo</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500"
                    placeholder="ej: Productos, Clientes, Reportes"
                    required>
                <p class="text-xs text-gray-600 mt-1">Nombre descriptivo del módulo</p>
            </div>

            <div class="mb-6">
                <label for="slug" class="block text-sm font-semibold text-amber-900 mb-2">Slug (Identificador)</label>
                <select id="slug" name="slug" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500 bg-white">
                    <option value="">Selecciona una ruta...</option>
                    @foreach ($routePrefixes as $prefix)
                        <option value="{{ $prefix }}" {{ old('slug') == $prefix ? 'selected' : '' }}>{{ $prefix }}</option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-600 mt-1">Selecciona la ruta existente a la que corresponde este módulo. Se usará para crear permisos automáticamente</p>
            </div>

            <div class="mb-6">
                <label for="icono" class="block text-sm font-semibold text-amber-900 mb-2">Icono</label>
                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg border border-gray-300">
                    <div class="text-4xl" id="icono-preview">{{ old('icono', '📦') }}</div>
                    <select name="icono" id="icono" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500 bg-white" onchange="document.getElementById('icono-preview').textContent = this.value">
                        <optgroup label="Gestión">
                            <option value="📦" {{ old('icono') == '📦' ? 'selected' : '' }}>📦 Módulos</option>
                            <option value="📊" {{ old('icono') == '📊' ? 'selected' : '' }}>📊 Reportes</option>
                            <option value="📈" {{ old('icono') == '📈' ? 'selected' : '' }}>📈 Estadísticas</option>
                            <option value="📋" {{ old('icono') == '📋' ? 'selected' : '' }}>📋 Gestión</option>
                            <option value="📂" {{ old('icono') == '📂' ? 'selected' : '' }}>📂 Archivos</option>
                            <option value="🗂️" {{ old('icono') == '🗂️' ? 'selected' : '' }}>🗂️ Registros</option>
                            <option value="📝" {{ old('icono') == '📝' ? 'selected' : '' }}>📝 Formularios</option>
                            <option value="📑" {{ old('icono') == '📑' ? 'selected' : '' }}>📑 Documentos</option>
                        </optgroup>
                        <optgroup label="Usuarios">
                            <option value="👥" {{ old('icono') == '👥' ? 'selected' : '' }}>👥 Usuarios</option>
                            <option value="🎭" {{ old('icono') == '🎭' ? 'selected' : '' }}>🎭 Roles</option>
                            <option value="👤" {{ old('icono') == '👤' ? 'selected' : '' }}>👤 Perfil</option>
                        </optgroup>
                        <optgroup label="Seguridad">
                            <option value="🔐" {{ old('icono') == '🔐' ? 'selected' : '' }}>🔐 Permisos</option>
                            <option value="🔑" {{ old('icono') == '🔑' ? 'selected' : '' }}>🔑 Acceso</option>
                            <option value="🛡️" {{ old('icono') == '🛡️' ? 'selected' : '' }}>🛡️ Seguridad</option>
                            <option value="🔒" {{ old('icono') == '🔒' ? 'selected' : '' }}>🔒 Auditoría</option>
                        </optgroup>
                        <optgroup label="Comercio">
                            <option value="💼" {{ old('icono') == '💼' ? 'selected' : '' }}>💼 Negocios</option>
                            <option value="🏷️" {{ old('icono') == '🏷️' ? 'selected' : '' }}>🏷️ Categorías</option>
                            <option value="🛒" {{ old('icono') == '🛒' ? 'selected' : '' }}>🛒 Ventas</option>
                            <option value="💰" {{ old('icono') == '💰' ? 'selected' : '' }}>💰 Finanzas</option>
                        </optgroup>
                        <optgroup label="Tecnología">
                            <option value="💻" {{ old('icono') == '💻' ? 'selected' : '' }}>💻 Sistema</option>
                            <option value="⚙️" {{ old('icono') == '⚙️' ? 'selected' : '' }}>⚙️ Configuración</option>
                            <option value="📱" {{ old('icono') == '📱' ? 'selected' : '' }}>📱 App</option>
                            <option value="🔧" {{ old('icono') == '🔧' ? 'selected' : '' }}>🔧 Mantenimiento</option>
                            <option value="☕" {{ old('icono') == '☕' ? 'selected' : '' }}>☕ Producto</option>
                        </optgroup>
                        <optgroup label="Comunicación">
                            <option value="📧" {{ old('icono') == '📧' ? 'selected' : '' }}>📧 Correos</option>
                            <option value="📢" {{ old('icono') == '📢' ? 'selected' : '' }}>📢 Notificaciones</option>
                            <option value="📡" {{ old('icono') == '📡' ? 'selected' : '' }}>📡 Conexiones</option>
                            <option value="🔔" {{ old('icono') == '🔔' ? 'selected' : '' }}>🔔 Alertas</option>
                        </optgroup>
                        <optgroup label="Diseño">
                            <option value="🎨" {{ old('icono') == '🎨' ? 'selected' : '' }}>🎨 Diseño</option>
                            <option value="🎯" {{ old('icono') == '🎯' ? 'selected' : '' }}>🎯 Objetivos</option>
                            <option value="📚" {{ old('icono') == '📚' ? 'selected' : '' }}>📚 Contenido</option>
                            <option value="📰" {{ old('icono') == '📰' ? 'selected' : '' }}>📰 Blog</option>
                        </optgroup>
                    </select>
                </div>
                <p class="text-xs text-gray-600 mt-1">Selecciona un icono para el módulo</p>
            </div>

            <div class="mb-6">
                <label for="descripcion" class="block text-sm font-semibold text-amber-900 mb-2">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500"
                    placeholder="Describe qué hace este módulo">{{ old('descripcion') }}</textarea>
            </div>

            <div class="mb-6">
                <label for="orden" class="block text-sm font-semibold text-amber-900 mb-2">Orden de Visualización</label>
                <input type="number" id="orden" name="orden" value="{{ old('orden', 0) }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500"
                    min="0">
                <p class="text-xs text-gray-600 mt-1">Número para ordenar los módulos en el menú (menor = primero)</p>
            </div>

            <div class="mb-6">
                <label class="flex items-center">
                    <input type="hidden" name="activo" value="0">
                    <input type="checkbox" name="activo" value="1" {{ old('activo', true) ? 'checked' : '' }} class="mr-2">
                    <span class="text-sm font-semibold text-amber-900">Activar módulo inmediatamente</span>
                </label>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-blue-900">
                    <strong>ℹ️ Nota:</strong> Al crear este módulo, se crearán automáticamente 4 permisos:
                    <code class="bg-white px-2 py-1 rounded text-xs">{{ old('slug', 'slug') }} view</code>,
                    <code class="bg-white px-2 py-1 rounded text-xs">{{ old('slug', 'slug') }} create</code>,
                    <code class="bg-white px-2 py-1 rounded text-xs">{{ old('slug', 'slug') }} edit</code>,
                    <code class="bg-white px-2 py-1 rounded text-xs">{{ old('slug', 'slug') }} delete</code>
                </p>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-amber-900 hover:bg-amber-800 text-white font-bold py-2 px-6 rounded-lg transition">
                    Crear Módulo
                </button>
                <a href="{{ route('modules.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
