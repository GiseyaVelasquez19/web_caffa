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
                    <div class="text-4xl" id="icono-preview"><i class="{{ old('icono', 'fas fa-puzzle-piece') }}"></i></div>
                    <select name="icono" id="icono" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500 bg-white" onchange="document.getElementById('icono-preview').innerHTML = '<i class=\'' + this.value + '\'></i>'">
                        <optgroup label="Gestión">
                            <option value="fas fa-puzzle-piece" {{ old('icono') == 'fas fa-puzzle-piece' ? 'selected' : '' }}>Módulos</option>
                            <option value="fas fa-chart-bar" {{ old('icono') == 'fas fa-chart-bar' ? 'selected' : '' }}>Reportes</option>
                            <option value="fas fa-chart-line" {{ old('icono') == 'fas fa-chart-line' ? 'selected' : '' }}>Estadísticas</option>
                            <option value="fas fa-clipboard-list" {{ old('icono') == 'fas fa-clipboard-list' ? 'selected' : '' }}>Gestión</option>
                            <option value="fas fa-folder-open" {{ old('icono') == 'fas fa-folder-open' ? 'selected' : '' }}>Archivos</option>
                            <option value="fas fa-database" {{ old('icono') == 'fas fa-database' ? 'selected' : '' }}>Registros</option>
                            <option value="fas fa-file-alt" {{ old('icono') == 'fas fa-file-alt' ? 'selected' : '' }}>Formularios</option>
                            <option value="fas fa-file-alt" {{ old('icono') == 'fas fa-file-alt' ? 'selected' : '' }}>Documentos</option>
                        </optgroup>
                        <optgroup label="Usuarios">
                            <option value="fas fa-users" {{ old('icono') == 'fas fa-users' ? 'selected' : '' }}>Usuarios</option>
                            <option value="fas fa-user-tag" {{ old('icono') == 'fas fa-user-tag' ? 'selected' : '' }}>Roles</option>
                            <option value="fas fa-user" {{ old('icono') == 'fas fa-user' ? 'selected' : '' }}>Perfil</option>
                        </optgroup>
                        <optgroup label="Seguridad">
                            <option value="fas fa-shield-alt" {{ old('icono') == 'fas fa-shield-alt' ? 'selected' : '' }}>Permisos</option>
                            <option value="fas fa-key" {{ old('icono') == 'fas fa-key' ? 'selected' : '' }}>Acceso</option>
                            <option value="fas fa-lock" {{ old('icono') == 'fas fa-lock' ? 'selected' : '' }}>Seguridad</option>
                            <option value="fas fa-user-shield" {{ old('icono') == 'fas fa-user-shield' ? 'selected' : '' }}>Auditoría</option>
                        </optgroup>
                        <optgroup label="Comercio">
                            <option value="fas fa-briefcase" {{ old('icono') == 'fas fa-briefcase' ? 'selected' : '' }}>Negocios</option>
                            <option value="fas fa-tags" {{ old('icono') == 'fas fa-tags' ? 'selected' : '' }}>Categorías</option>
                            <option value="fas fa-shopping-cart" {{ old('icono') == 'fas fa-shopping-cart' ? 'selected' : '' }}>Ventas</option>
                            <option value="fas fa-dollar-sign" {{ old('icono') == 'fas fa-dollar-sign' ? 'selected' : '' }}>Finanzas</option>
                        </optgroup>
                        <optgroup label="Tecnología">
                            <option value="fas fa-desktop" {{ old('icono') == 'fas fa-desktop' ? 'selected' : '' }}>Sistema</option>
                            <option value="fas fa-cog" {{ old('icono') == 'fas fa-cog' ? 'selected' : '' }}>Configuración</option>
                            <option value="fas fa-mobile-alt" {{ old('icono') == 'fas fa-mobile-alt' ? 'selected' : '' }}>App</option>
                            <option value="fas fa-wrench" {{ old('icono') == 'fas fa-wrench' ? 'selected' : '' }}>Mantenimiento</option>
                            <option value="fas fa-coffee" {{ old('icono') == 'fas fa-coffee' ? 'selected' : '' }}>Producto</option>
                        </optgroup>
                        <optgroup label="Comunicación">
                            <option value="fas fa-envelope" {{ old('icono') == 'fas fa-envelope' ? 'selected' : '' }}>Correos</option>
                            <option value="fas fa-bullhorn" {{ old('icono') == 'fas fa-bullhorn' ? 'selected' : '' }}>Notificaciones</option>
                            <option value="fas fa-satellite-dish" {{ old('icono') == 'fas fa-satellite-dish' ? 'selected' : '' }}>Conexiones</option>
                            <option value="fas fa-bell" {{ old('icono') == 'fas fa-bell' ? 'selected' : '' }}>Alertas</option>
                        </optgroup>
                        <optgroup label="Diseño">
                            <option value="fas fa-palette" {{ old('icono') == 'fas fa-palette' ? 'selected' : '' }}>Diseño</option>
                            <option value="fas fa-bullseye" {{ old('icono') == 'fas fa-bullseye' ? 'selected' : '' }}>Objetivos</option>
                            <option value="fas fa-book" {{ old('icono') == 'fas fa-book' ? 'selected' : '' }}>Contenido</option>
                            <option value="fas fa-newspaper" {{ old('icono') == 'fas fa-newspaper' ? 'selected' : '' }}>Blog</option>
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
