@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-amber-900 mb-6">Editar Módulo</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('modules.update', $module) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="nombre" class="block text-sm font-semibold text-amber-900 mb-2">Nombre del Módulo</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $module->nombre) }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500"
                    required>
            </div>

            <div class="mb-6">
                <label for="slug" class="block text-sm font-semibold text-amber-900 mb-2">Slug (Identificador)</label>
                <select id="slug" name="slug" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500 bg-white">
                    <option value="">Selecciona una ruta...</option>
                    @foreach ($routePrefixes as $prefix)
                        <option value="{{ $prefix }}" {{ old('slug', $module->slug) == $prefix ? 'selected' : '' }}>{{ $prefix }}</option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-600 mt-1">Selecciona la ruta existente a la que corresponde este módulo</p>
            </div>

            <div class="mb-6">
                <label for="icono" class="block text-sm font-semibold text-amber-900 mb-2">Icono</label>
                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg border border-gray-300">
                    <div class="text-4xl" id="icono-preview"><i class="{{ old('icono', $module->icono) }}"></i></div>
                    <select name="icono" id="icono" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500 bg-white" onchange="document.getElementById('icono-preview').innerHTML = '<i class=\'' + this.value + '\'></i>'">
                        <optgroup label="Gestión">
                            <option value="fas fa-puzzle-piece" {{ old('icono', $module->icono) == 'fas fa-puzzle-piece' ? 'selected' : '' }}>Módulos</option>
                            <option value="fas fa-chart-bar" {{ old('icono', $module->icono) == 'fas fa-chart-bar' ? 'selected' : '' }}>Reportes</option>
                            <option value="fas fa-chart-line" {{ old('icono', $module->icono) == 'fas fa-chart-line' ? 'selected' : '' }}>Estadísticas</option>
                            <option value="fas fa-clipboard-list" {{ old('icono', $module->icono) == 'fas fa-clipboard-list' ? 'selected' : '' }}>Gestión</option>
                            <option value="fas fa-folder-open" {{ old('icono', $module->icono) == 'fas fa-folder-open' ? 'selected' : '' }}>Archivos</option>
                            <option value="fas fa-database" {{ old('icono', $module->icono) == 'fas fa-database' ? 'selected' : '' }}>Registros</option>
                            <option value="fas fa-file-alt" {{ old('icono', $module->icono) == 'fas fa-file-alt' ? 'selected' : '' }}>Formularios</option>
                            <option value="fas fa-file-alt" {{ old('icono', $module->icono) == 'fas fa-file-alt' ? 'selected' : '' }}>Documentos</option>
                        </optgroup>
                        <optgroup label="Usuarios">
                            <option value="fas fa-users" {{ old('icono', $module->icono) == 'fas fa-users' ? 'selected' : '' }}>Usuarios</option>
                            <option value="fas fa-user-tag" {{ old('icono', $module->icono) == 'fas fa-user-tag' ? 'selected' : '' }}>Roles</option>
                            <option value="fas fa-user" {{ old('icono', $module->icono) == 'fas fa-user' ? 'selected' : '' }}>Perfil</option>
                        </optgroup>
                        <optgroup label="Seguridad">
                            <option value="fas fa-shield-alt" {{ old('icono', $module->icono) == 'fas fa-shield-alt' ? 'selected' : '' }}>Permisos</option>
                            <option value="fas fa-key" {{ old('icono', $module->icono) == 'fas fa-key' ? 'selected' : '' }}>Acceso</option>
                            <option value="fas fa-lock" {{ old('icono', $module->icono) == 'fas fa-lock' ? 'selected' : '' }}>Seguridad</option>
                            <option value="fas fa-user-shield" {{ old('icono', $module->icono) == 'fas fa-user-shield' ? 'selected' : '' }}>Auditoría</option>
                        </optgroup>
                        <optgroup label="Comercio">
                            <option value="fas fa-briefcase" {{ old('icono', $module->icono) == 'fas fa-briefcase' ? 'selected' : '' }}>Negocios</option>
                            <option value="fas fa-tags" {{ old('icono', $module->icono) == 'fas fa-tags' ? 'selected' : '' }}>Categorías</option>
                            <option value="fas fa-shopping-cart" {{ old('icono', $module->icono) == 'fas fa-shopping-cart' ? 'selected' : '' }}>Ventas</option>
                            <option value="fas fa-dollar-sign" {{ old('icono', $module->icono) == 'fas fa-dollar-sign' ? 'selected' : '' }}>Finanzas</option>
                        </optgroup>
                        <optgroup label="Tecnología">
                            <option value="fas fa-desktop" {{ old('icono', $module->icono) == 'fas fa-desktop' ? 'selected' : '' }}>Sistema</option>
                            <option value="fas fa-cog" {{ old('icono', $module->icono) == 'fas fa-cog' ? 'selected' : '' }}>Configuración</option>
                            <option value="fas fa-mobile-alt" {{ old('icono', $module->icono) == 'fas fa-mobile-alt' ? 'selected' : '' }}>App</option>
                            <option value="fas fa-wrench" {{ old('icono', $module->icono) == 'fas fa-wrench' ? 'selected' : '' }}>Mantenimiento</option>
                            <option value="fas fa-coffee" {{ old('icono', $module->icono) == 'fas fa-coffee' ? 'selected' : '' }}>Producto</option>
                        </optgroup>
                        <optgroup label="Comunicación">
                            <option value="fas fa-envelope" {{ old('icono', $module->icono) == 'fas fa-envelope' ? 'selected' : '' }}>Correos</option>
                            <option value="fas fa-bullhorn" {{ old('icono', $module->icono) == 'fas fa-bullhorn' ? 'selected' : '' }}>Notificaciones</option>
                            <option value="fas fa-satellite-dish" {{ old('icono', $module->icono) == 'fas fa-satellite-dish' ? 'selected' : '' }}>Conexiones</option>
                            <option value="fas fa-bell" {{ old('icono', $module->icono) == 'fas fa-bell' ? 'selected' : '' }}>Alertas</option>
                        </optgroup>
                        <optgroup label="Diseño">
                            <option value="fas fa-palette" {{ old('icono', $module->icono) == 'fas fa-palette' ? 'selected' : '' }}>Diseño</option>
                            <option value="fas fa-bullseye" {{ old('icono', $module->icono) == 'fas fa-bullseye' ? 'selected' : '' }}>Objetivos</option>
                            <option value="fas fa-book" {{ old('icono', $module->icono) == 'fas fa-book' ? 'selected' : '' }}>Contenido</option>
                            <option value="fas fa-newspaper" {{ old('icono', $module->icono) == 'fas fa-newspaper' ? 'selected' : '' }}>Blog</option>
                        </optgroup>
                    </select>
                </div>
                <p class="text-xs text-gray-600 mt-1">Selecciona un icono para el módulo</p>
            </div>

            <div class="mb-6">
                <label for="descripcion" class="block text-sm font-semibold text-amber-900 mb-2">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500">{{ old('descripcion', $module->descripcion) }}</textarea>
            </div>

            <div class="mb-6">
                <label for="orden" class="block text-sm font-semibold text-amber-900 mb-2">Orden de Visualización</label>
                <input type="number" id="orden" name="orden" value="{{ old('orden', $module->orden) }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500"
                    min="0">
            </div>

            <div class="mb-6">
                <label class="flex items-center">
                    <input type="hidden" name="activo" value="0">
                    <input type="checkbox" name="activo" value="1" {{ old('activo', $module->activo) ? 'checked' : '' }} class="mr-2">
                    <span class="text-sm font-semibold text-amber-900">Módulo activo</span>
                </label>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-amber-900 hover:bg-amber-800 text-white font-bold py-2 px-6 rounded-lg transition">
                    Actualizar Módulo
                </button>
                <a href="{{ route('modules.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
