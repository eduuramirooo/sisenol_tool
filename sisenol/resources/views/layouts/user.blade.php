<!-- Esta es la vista del usuario -->

@extends('layouts.app')

@section('content')
@if(session('error'))
    <div class="mb-4 text-red-600 bg-red-100 border border-red-300 px-4 py-2 rounded">
        {{ session('error') }}
    </div>
@endif
<div class="max-w-7xl mx-auto mt-2 px-4 relative" id="main-container">
    <!-- Botones de navegación -->
    <div class="sm:hidden flex justify-end mb-4">
        <button onclick="toggleMenu()" class="text-[#216869] focus:outline-none">
            &#9776; Menú
        </button>
    </div>
    <!-- Mensaje de bienvenida -->
    <div class="mb-4 text-green-600 bg-green-100 border border-green-300 px-4 py-2 rounded" id="welcome-message">
        Hola, {{ session('alias') }}
    </div>
    <div id="menu-buttons" class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-center hidden sm:grid">
        <button onclick="mostrarSeccion('productos')" class="bg-white border rounded shadow hover:bg-[#DCE1DE] py-4 font-medium w-full transition transform hover:scale-105 duration-300">Ver productos</button>
        <button onclick="mostrarSeccion('instalacion')" class="bg-white border rounded shadow hover:bg-[#DCE1DE] py-4 font-medium w-full transition transform hover:scale-105 duration-300">Ver documentacion</button>
        <button onclick="mostrarSeccion('notas')" class="bg-white border rounded shadow hover:bg-[#DCE1DE] py-4 font-medium w-full transition transform hover:scale-105 duration-300">Ver notas</button>
    </div>

    <!-- Contenido dinámico -->
    <div class="mt-8 space-y-6 text-sm text-[#292727]">
        <!-- Productos -->
        <div id="seccion-productos" class="transition-opacity duration-500 opacity-100">
            <h2 class="text-lg font-semibold">Tus productos</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach ($productos as $producto)
                    <div class="bg-white p-4 rounded shadow text-center">
                        <img src="{{ $producto->imagen }}" alt="{{ $producto->nombre }}" class="mx-auto h-24 mb-2">
                        <h3 class="font-semibold">{{ $producto->nombre }}</h3>
                        <p class="text-sm text-gray-600">{{ $producto->descripcion }}</p>
                        <a href="{{ route('producto.descargar', ['id' => $producto->id]) }}" class="text-indigo-600 hover:underline block mt-2">Descargar manual</a>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Instalación -->
        <div id="seccion-instalacion" class="hidden opacity-0 transition-opacity duration-500">
        <h2 class="text-lg font-semibold mb-4">Documentos de instalación de {{ $proyecto->nombre ?? 'tu proyecto' }}</h2>


    @if(count($archivos) > 0)
        <ul class="bg-white rounded shadow divide-y divide-gray-200">
            @foreach($archivos as $archivo)
    <li class="flex items-center justify-between px-4 py-3 hover:bg-[#F0F4F3] transition">
        <a href="{{ route('descargar.ruta', ['ruta' => $archivo['ruta_real']]) }}" class="text-[#216869] font-medium hover:underline">
            {{ $archivo['nombre'] }}
        </a>
        <span class="text-sm text-gray-500">{{ $archivo['peso'] }} KB</span>
    </li>
@endforeach

        </ul>
    @else
        <p class="text-gray-500 text-center">No hay archivos disponibles.</p>
    @endif
</div>

    </div>
</div>


<!-- Notas -->
<div id="seccion-notas" class="hidden opacity-0 transition-opacity duration-500">
    <h2 class="text-lg font-semibold">Notas del instalador</h2>

    {{-- Notas desde base de datos --}}
    @foreach ($notas as $nota)
        <div class="bg-[#DCE1DE] p-4 rounded-md shadow-sm">
            {{ $nota->contenido }}
        </div>
    @endforeach

{{-- Documentos en la carpeta proyecto/notes --}}
@if (!empty($notasDocs))
    <h3 class="text-md font-medium mt-6 mb-2">Archivos adjuntos</h3>
    <ul class="space-y-2">
        @foreach ($notasDocs as $doc)
            <li class="flex justify-between items-center bg-white border p-3 rounded shadow-sm hover:bg-gray-50">
                <a href="{{ route('descargar.ruta', ['ruta' => urlencode($doc['ruta'])]) }}"
                   class="text-[#216869] font-medium hover:underline">
                    {{ $doc['nombre'] }}
                </a>
                <span class="text-sm text-gray-500">{{ $doc['peso'] }} KB</span>
            </li>
        @endforeach
    </ul>
@endif

</div>



<script src="{{ asset('js/dashboard.js') }}" defer></script>


@endsection
