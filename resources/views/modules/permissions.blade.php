@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <div class="flex items-center gap-3 mb-6">
            <span class="text-4xl">{{ $module->icon ?? '📦' }}</span>
            <div>
                <h1 class="text-3xl font-bold text-amber-900">Permisos del Módulo: {{ $module->name }}</h1>
                <p class="text-gray-600">Slug: <code class="bg-gray-100 px-2 py-1 rounded">{{ $module->slug }}</code></p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($actions as $action)
                @php
                    $permission = $permissions->firstWhere('name', $module->slug . ' ' . $action);
                @endphp
                <div class="border border-gray-200 rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-amber-900 capitalize">{{ $action }}</h3>
                        @if ($permission)
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">Creado</span>
                        @else
                            <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">No existe</span>
                        @endif
                    </div>
                    
                    @if ($permission)
                        <p class="text-sm text-gray-600 mb-4">
                            <strong>ID:</strong> {{ $permission->id }}<br>
                            <strong>Nombre:</strong> <code class="bg-gray-100 px-2 py-1 rounded">{{ $permission->name }}</code><br>
                            <strong>Guard:</strong> {{ $permission->guard_name }}<br>
                            <strong>Creado:</strong> {{ $permission->created_at->format('d/m/Y H:i') }}
                        </p>

                        <div class="bg-blue-50 border border-blue-200 rounded p-3 text-xs text-blue-900">
                            <strong>Uso en controlador:</strong><br>
                            <code>auth()->user()->can('{{ $permission->name }}') ?: abort(403);</code>
                        </div>

                        <div class="bg-purple-50 border border-purple-200 rounded p-3 text-xs text-purple-900 mt-3">
                            <strong>Uso en vista:</strong><br>
                            <code>@can('{{ $permission->name }}') ... @endcan</code>
                        </div>
                    @else
                        <p class="text-sm text-gray-600 mb-4">
                            Este permiso no existe aún. Puede ser que se haya eliminado manualmente.
                        </p>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-yellow-900 mb-3">⚠️ Información Importante</h3>
            <ul class="text-sm text-yellow-800 space-y-2">
                <li>✓ Los permisos se crean automáticamente al crear el módulo</li>
                <li>✓ No elimines estos permisos manualmente a menos que desactives el módulo</li>
                <li>✓ Asigna estos permisos a los roles que necesiten acceso a este módulo</li>
                <li>✓ Usa los nombres de permisos exactos en tu código</li>
            </ul>
        </div>

        <div class="mt-6">
            <a href="{{ route('modules.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg transition">
                Volver a Módulos
            </a>
        </div>
    </div>
</div>
@endsection
