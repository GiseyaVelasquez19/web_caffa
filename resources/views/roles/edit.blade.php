@extends('layouts.app')

@section('title', 'Editar Rol - Caffa')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-amber-900 mb-6">Editar Rol</h1>

        <div class="bg-white rounded-lg shadow p-8">
            <form method="POST" action="{{ route('roles.update', $role) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Rol</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $role->name) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent outline-none transition @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Permisos</label>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach ($permissions as $permission)
                            <label class="flex items-center p-2 border border-gray-200 rounded hover:bg-gray-50">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                    @if (in_array($permission->id, $rolePermissions)) checked @endif
                                    class="rounded border-gray-300">
                                <span class="ml-2 text-sm text-gray-700">{{ $permission->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="bg-amber-900 hover:bg-amber-800 text-white font-bold py-2 px-6 rounded-lg transition">
                        Actualizar Rol
                    </button>
                    <a href="{{ route('roles.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-lg transition">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
