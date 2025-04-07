@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-[60vh]">
    <div class="bg-white p-10 rounded-2xl shadow-2xl w-[480px] transition duration-300 ease-in-out border border-[#DCE1DE]">
        <div class="flex justify-center mb-6">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" style="max-width: 160px; height: auto;">
        </div>
        <h4 class="text-center text-xl font-semibold mb-6 text-[#292727]">Inicia sesión para gestionar tus productos</h4>

        @if(session('error'))
            <div class="mb-4 text-red-600 bg-red-100 border border-red-300 px-4 py-2 rounded">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login.recibir') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label for="username" class="block text-sm font-medium text-[#292727]">Usuario:</label>
                <input type="text" id="username" name="username" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#49A078] focus:border-[#49A078] transition duration-300">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-[#292727]">Contraseña:</label>
                <input type="password" id="password" name="password" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#49A078] focus:border-[#49A078] transition duration-300">
            </div>
            <div class="flex flex-col space-y-2">
                <button type="submit"
                    class="w-full bg-[#216869] text-white py-2 rounded-md hover:bg-[#49A078] transition-all duration-300">Iniciar sesión</button>
                <a href="#" class="text-center text-[#216869] hover:underline transition duration-300">Recuperar contraseña</a>
            </div>
        </form>
    </div>
</div>
@endsection

