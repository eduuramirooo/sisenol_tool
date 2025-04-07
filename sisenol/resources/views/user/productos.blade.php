@extends('layouts.user')

@section('content')
<h1 class="text-xl font-semibold text-[#292727] mb-6">Tus productos</h1>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    @foreach ($productos as $producto)
        <div class="bg-white p-4 rounded shadow text-center">
            <img src="{{ $producto->imagen }}" alt="{{ $producto->nombre }}" class="mx-auto h-24 mb-2">
            <h2 class="font-semibold">{{ $producto->nombre }}</h2>
            <p class="text-sm text-gray-600">{{ $producto->descripcion }}</p>
            <a href="{{ route('producto.descargar', ['id' => $producto->id]) }}"
               class="text-indigo-600 hover:underline block mt-2">Descargar manual</a>
        </div>
    @endforeach
</div>
@endsection
