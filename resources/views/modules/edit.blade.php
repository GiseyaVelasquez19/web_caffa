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
                    <div class="text-4xl" id="icono-preview">{{ old('icono', $module->icono) }}</div>
                    <select name="icono" id="icono" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500 bg-white" onchange="document.getElementById('icono-preview').textContent = this.value">
                        <optgroup label="Gestión">
                            <option value="📦" {{ old('icono', $module->icono) == '📦' ? 'selected' : '' }}>📦 Módulos</option>
                            <option value="📊" {{ old('icono', $module->icono) == '📊' ? 'selected' : '' }}>📊 Reportes</option>
                            <option value="📈" {{ old('icono', $module->icono) == '📈' ? 'selected' : '' }}>📈 Estadísticas</option>
                            <option value="📋" {{ old('icono', $module->icono) == '📋' ? 'selected' : '' }}>📋 Gestión</option>
                            <option value="📂" {{ old('icono', $module->icono) == '📂' ? 'selected' : '' }}>📂 Archivos</option>
                            <option value="🗂️" {{ old('icono', $module->icono) == '🗂️' ? 'selected' : '' }}>🗂️ Registros</option>
                            <option value="📝" {{ old('icono', $module->icono) == '📝' ? 'selected' : '' }}>📝 Formularios</option>
                            <option value="📑" {{ old('icono', $module->icono) == '📑' ? 'selected' : '' }}>📑 Documentos</option>
                        </optgroup>
                        <optgroup label="Usuarios">
                            <option value="👥" {{ old('icono', $module->icono) == '👥' ? 'selected' : '' }}>👥 Usuarios</option>
                            <option value="🎭" {{ old('icono', $module->icono) == '🎭' ? 'selected' : '' }}>🎭 Roles</option>
                            <option value="👤" {{ old('icono', $module->icono) == '👤' ? 'selected' : '' }}>👤 Perfil</option>
                        </optgroup>
                        <optgroup label="Seguridad">
                            <option value="🔐" {{ old('icono', $module->icono) == '🔐' ? 'selected' : '' }}>🔐 Permisos</option>
                            <option value="🔑" {{ old('icono', $module->icono) == '🔑' ? 'selected' : '' }}>🔑 Acceso</option>
                            <option value="🛡️" {{ old('icono', $module->icono) == '🛡️' ? 'selected' : '' }}>🛡️ Seguridad</option>
                            <option value="🔒" {{ old('icono', $module->icono) == '🔒' ? 'selected' : '' }}>🔒 Auditoría</option>
                        </optgroup>
                        <optgroup label="Comercio">
                            <option value="💼" {{ old('icono', $module->icono) == '💼' ? 'selected' : '' }}>💼 Negocios</option>
                            <option value="🏷️" {{ old('icono', $module->icono) == '🏷️' ? 'selected' : '' }}>🏷️ Categorías</option>
                            <option value="🛒" {{ old('icono', $module->icono) == '🛒' ? 'selected' : '' }}>🛒 Ventas</option>
                            <option value="💰" {{ old('icono', $module->icono) == '💰' ? 'selected' : '' }}>💰 Finanzas</option>
                        </optgroup>
                        <optgroup label="Tecnología">
                            <option value="💻" {{ old('icono', $module->icono) == '💻' ? 'selected' : '' }}>💻 Sistema</option>
                            <option value="⚙️" {{ old('icono', $module->icono) == '⚙️' ? 'selected' : '' }}>⚙️ Configuración</option>
                            <option value="📱" {{ old('icono', $module->icono) == '📱' ? 'selected' : '' }}>📱 App</option>
                            <option value="🔧" {{ old('icono', $module->icono) == '🔧' ? 'selected' : '' }}>🔧 Mantenimiento</option>
                            <option value="☕" {{ old('icono', $module->icono) == '☕' ? 'selected' : '' }}>☕ Producto</option>
                        </optgroup>
                        <optgroup label="Comunicación">
                            <option value="📧" {{ old('icono', $module->icono) == '📧' ? 'selected' : '' }}>📧 Correos</option>
                            <option value="📢" {{ old('icono', $module->icono) == '📢' ? 'selected' : '' }}>📢 Notificaciones</option>
                            <option value="📡" {{ old('icono', $module->icono) == '📡' ? 'selected' : '' }}>📡 Conexiones</option>
                            <option value="🔔" {{ old('icono', $module->icono) == '🔔' ? 'selected' : '' }}>🔔 Alertas</option>
                        </optgroup>
                        <optgroup label="Diseño">
                            <option value="🎨" {{ old('icono', $module->icono) == '🎨' ? 'selected' : '' }}>🎨 Diseño</option>
                            <option value="🎯" {{ old('icono', $module->icono) == '🎯' ? 'selected' : '' }}>🎯 Objetivos</option>
                            <option value="📚" {{ old('icono', $module->icono) == '📚' ? 'selected' : '' }}>📚 Contenido</option>
                            <option value="📰" {{ old('icono', $module->icono) == '📰' ? 'selected' : '' }}>📰 Blog</option>
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
