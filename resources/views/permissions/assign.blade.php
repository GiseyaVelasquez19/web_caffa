@extends('layouts.app')

@section('title', 'Asignar Permisos - Caffa')

@section('content')
    <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold text-amber-900 mb-2">Asignar Permisos a Rol</h1>
        <p class="text-gray-600 mb-6">Rol: <span class="font-semibold">{{ $role->name }}</span></p>

        <div class="bg-white rounded-lg shadow p-8">
            <form method="POST" action="{{ route('roles.update', $role) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-4">Selecciona los Permisos</label>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach ($permissions as $permission)
                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-amber-50 cursor-pointer">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                    @if (in_array($permission->id, $rolePermissions)) checked @endif
                                    class="rounded border-gray-300 w-4 h-4">
                                <span class="ml-3 text-sm text-gray-700">{{ $permission->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="bg-amber-900 hover:bg-amber-800 text-white font-bold py-2 px-6 rounded-lg transition">
                        Guardar Permisos
                    </button>
                    <a href="{{ route('roles.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-lg transition">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
