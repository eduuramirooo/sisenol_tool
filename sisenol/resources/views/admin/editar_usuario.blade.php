@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10 p-6 bg-white shadow rounded">
    <h2 class="text-lg font-semibold mb-4 text-center">Editar Usuario</h2>

    @if(session('error'))
        <div class="mb-4 text-red-600 bg-red-100 border border-red-300 px-4 py-2 rounded">
            {{ session('error') }}
        </div>
    @endif
    @if(session('success'))
        <div class="mb-4 text-green-600 bg-green-100 border border-green-300 px-4 py-2 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.actualizarUsuario', $usuario->id) }}">
        @csrf
        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700">Usuario</label>
            <input type="text" name="username" value="{{ $usuario->username }}" class="w-full border px-4 py-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700">Alias</label>
            <input type="text" name="alias" value="{{ $usuario->alias }}" class="w-full border px-4 py-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700">Contraseña nueva (opcional)</label>
            <input type="password" name="password" class="w-full border px-4 py-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700">Tipo</label>
            <select name="tipo" class="w-full border px-4 py-2 rounded">
                <option value="user" {{ $usuario->tipo === 'user' ? 'selected' : '' }}>Usuario</option>
                <option value="admin" {{ $usuario->tipo === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-black text-white px-6 py-2 rounded hover:bg-gray-800 transition w-full">
                Actualizar Usuario
            </button>
        </div>
    </form>
</div>
@endsection
