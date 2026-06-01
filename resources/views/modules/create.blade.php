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
                <input type="text" id="slug" name="slug" value="{{ old('slug') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500"
                    placeholder="ej: products, customers, reports"
                    pattern="^[a-z0-9_]+$"
                    required>
                <p class="text-xs text-gray-600 mt-1">Solo minúsculas, números y guiones bajos. Se usará para crear permisos automáticamente</p>
            </div>

            <div class="mb-6">
                <label for="icono" class="block text-sm font-semibold text-amber-900 mb-2">Icono (Selecciona un emoji)</label>
                <div class="grid grid-cols-8 gap-2 mb-4 p-4 bg-gray-50 rounded-lg border border-gray-300">
                    @php
                        $emojis = ['📦', '👥', '🎭', '🔐', '☕', '📊', '📈', '💼', '🛠️', '⚙️', '🔧', '📝', '📋', '📂', '🗂️', '💾', '🔍', '🔎', '📱', '💻', '🖥️', '⌨️', '🖱️', '🎨', '🎯', '🎪', '🎭', '🎬', '🎤', '🎧', '🎵', '🎶', '📚', '📖', '📕', '📗', '📘', '📙', '📓', '📔', '📒', '📑', '🧾', '📄', '📃', '📜', '📰', '🗞️', '📡', '📢', '📣', '📯', '📻', '📺', '📷', '📸', '📹', '🎥', '🎞️', '📽️', '🎬', '📲', '☎️', '📞', '📟', '📠', '🔔', '🔕', '📧', '📨', '📩', '📤', '📥', '📦', '🏷️', '🧷', '📪', '📫', '📬', '📭', '📮', '✉️', '✏️', '✒️', '🖋️', '🖊️', '🖌️', '🖍️', '📝'];
                    @endphp
                    @foreach ($emojis as $emoji)
                        <label class="flex items-center justify-center p-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-amber-500 hover:bg-amber-50 transition">
                            <input type="radio" name="icono" value="{{ $emoji }}" {{ old('icono') == $emoji ? 'checked' : '' }} class="hidden">
                            <span class="text-3xl">{{ $emoji }}</span>
                        </label>
                    @endforeach
                </div>
                <input type="hidden" id="icono" name="icono" value="{{ old('icono') }}">
                <p class="text-xs text-gray-600 mt-1">Selecciona un emoji haciendo clic en él</p>
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
