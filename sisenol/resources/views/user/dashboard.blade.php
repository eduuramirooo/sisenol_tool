@extends('layouts.user')

@section('seccion')
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">
    <a href="{{ route('producto.lista') }}"
       class="block text-center bg-white p-4 border rounded shadow hover:bg-[#DCE1DE] transition">
        Ver productos
    </a>
    <a href="{{ route('proyecto.archivos') }}"
       class="block text-center bg-white p-4 border rounded shadow hover:bg-[#DCE1DE] transition">
        Ver instalación
    </a>
    <a href="{{ route('producto.notas') }}"
       class="block text-center bg-white p-4 border rounded shadow hover:bg-[#DCE1DE] transition">
        Ver notas
    </a>
</div>


@endsection





