@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-amber-900 mb-6">Editar Permiso</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('permissions.update', $permission) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="name" class="block text-sm font-semibold text-amber-900 mb-2">Nombre del Permiso</label>
                <input type="text" id="name" name="name" value="{{ old('name', $permission->name) }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500"
                    required>
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-semibold text-amber-900 mb-2">Descripción (Opcional)</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500">{{ old('description', $permission->description ?? '') }}</textarea>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-amber-900 hover:bg-amber-800 text-white font-bold py-2 px-6 rounded-lg transition">
                    Actualizar Permiso
                </button>
                <a href="{{ route('permissions.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
