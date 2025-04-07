@extends('layouts.app')

@section('content')
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
<div class="max-w-7xl mx-auto mt-10 px-4 relative" id="main-container">
    <!-- Botones de navegación -->
    <div class="sm:hidden flex justify-end mb-4">
    <button onclick="toggleMenu()" class="text-[#216869] focus:outline-none">
        &#9776; Menú
    </button>
</div>
<div id="menu-buttons" class="grid grid-cols-1 sm:grid-cols-5 gap-4 text-center hidden sm:grid">
    <button onclick="mostrarSeccion('usuarios')" class="bg-white border rounded shadow hover:bg-[#DCE1DE] py-4 font-medium w-full transition transform hover:scale-105 duration-300">Usuarios</button>
    <button onclick="mostrarSeccion('crear')" class="bg-white border rounded shadow hover:bg-[#DCE1DE] py-4 font-medium w-full transition transform hover:scale-105 duration-300">Crear producto</button>
    <button onclick="mostrarSeccion('asignar')" class="bg-white border rounded shadow hover:bg-[#DCE1DE] py-4 font-medium w-full transition transform hover:scale-105 duration-300">Asignar productos</button>
    <button onclick="mostrarSeccion('documentos')" class="bg-white border rounded shadow hover:bg-[#DCE1DE] py-4 font-medium w-full transition transform hover:scale-105 duration-300">Documentos</button>
    <button onclick="mostrarSeccion('notas')" class="bg-white border rounded shadow hover:bg-[#DCE1DE] py-4 font-medium w-full transition transform hover:scale-105 duration-300">Notas</button>
</div>


    <!-- Contenido dinámico -->
    <div class="mt-8 space-y-6 text-sm text-[#292727]">
        <!-- Usuarios -->
        <div id="seccion-usuarios" class="transition-opacity duration-500 opacity-100">
            <h2 class="text-lg font-semibold">Alta de usuarios</h2>
            <form action="{{ route('admin.registrarUsuario') }}" method="POST" class="bg-white p-6 rounded shadow space-y-4">
                @csrf
                <input type="text" name="username" placeholder="Usuario" class="w-full border px-4 py-2 rounded">
                <input type="password" name="password" placeholder="Contraseña" class="w-full border px-4 py-2 rounded">
                <input type="text" name="alias" placeholder="Alias" class="w-full border px-4 py-2 rounded">
                <select name="tipo" class="w-full border px-4 py-2 rounded">
                    <option value="user">Usuario</option>
                    <option value="admin">Admin</option>
                </select>
                <button type="submit" class="bg-black text-white px-6 py-4 w-[90%] rounded hover:bg-gray-800 transition">Registrar usuario</button>
            </form>
        </div>

        <!-- Asignar productos -->
        <div id="seccion-asignar" class="hidden opacity-0 transition-opacity duration-500">
            <h2 class="text-lg font-semibold">Asignar productos a usuarios</h2>
            <form action="{{ route('admin.asignarProducto') }}" method="POST" class="bg-white p-6 rounded shadow space-y-4">
                @csrf
                <select name="usuario_id" class="w-full border px-4 py-2 rounded">
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id }}">{{ $usuario->alias }} ({{ $usuario->username }})</option>
                    @endforeach
                </select>
                <select name="producto_id" class="w-full border px-4 py-2 rounded">
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-black text-white px-6 py-4 w-[90%] rounded hover:bg-gray-800 transition">Asignar producto</button>
            </form>
        </div>

        <!-- Documentos -->
        <div id="seccion-documentos" class="hidden opacity-0 transition-opacity duration-500">
    <h2 class="text-lg font-semibold">Modificar documentos de productos</h2>
    <form action="{{ route('admin.actualizarDocumento') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow space-y-4">
        @csrf
        <select name="producto_id" id="productoSelector" class="w-full border px-4 py-2 rounded" onchange="mostrarInput()">
            <option value="">Selecciona un producto</option>
            @foreach($productos as $producto)
                <option value="{{ $producto->id }}" data-nombre="{{ $producto->nombre }}">{{ $producto->nombre }}</option>
            @endforeach
        </select>

        <div id="fileInput" class="hidden">
            <label for="documento" class="block text-sm font-medium text-gray-700">Documento PDF</label>
            <input type="file" name="documento" accept="application/pdf" class="w-full border px-4 py-2 rounded">
            <button type="submit" class="bg-black text-white px-6 py-4 w-[90%] rounded hover:bg-gray-800 transition mt-2">Subir documento</button>
        </div>
    </form>
</div>

<script>
    function mostrarInput() {
        const selector = document.getElementById('productoSelector');
        const fileInput = document.getElementById('fileInput');
        if (selector.value) {
            fileInput.classList.remove('hidden');
        } else {
            fileInput.classList.add('hidden');
        }
    }
</script>

        <!-- Crear producto -->
<div id="seccion-crear" class="hidden opacity-0 transition-opacity duration-500">
    <h2 class="text-lg font-semibold">Crear nuevo producto</h2>
    <form action="{{ route('admin.crearProducto') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow space-y-4">
        @csrf
        <input type="text" name="nombre" placeholder="Nombre del producto" class="w-full border px-4 py-2 rounded">
        <input type="text" name="descripcion" placeholder="Descripción del producto" class="w-full border px-4 py-2 rounded">
        <label for="imagen" class="block text-sm font-medium text-gray-700">Imagen del producto (opcional)</label>
        <input type="file" name="imagen" accept="image/*" class="w-full border px-4 py-2 rounded">
        <button type="submit" class="bg-black text-white px-6 py-4 w-[90%] rounded hover:bg-gray-800 transition">Crear producto</button>
    </form>
</div>


        <div id="seccion-notas" class="hidden opacity-0 transition-opacity duration-500">
            <h2 class="text-lg font-semibold">Modificar notas</h2>
            <p>Listado y edición de notas por usuario.</p>
        </div>
    </div>
</div>

<script>
    function mostrarSeccion(seccion) {
        ['usuarios', 'asignar', 'documentos', 'notas', 'crear'].forEach(id => {
            const div = document.getElementById('seccion-' + id);
            const btn = document.querySelector(`#menu-buttons button[onclick*="${id}"]`);

            if (id === seccion) {
                div.classList.remove('hidden');
                btn.classList.remove('bg-white');
                btn.classList.add('bg-[#49A078]');

                const children = div.querySelectorAll('div, form, p');
                children.forEach((el, i) => {
                    el.style.opacity = 0;
                    el.style.transform = 'translateY(20px)';
                    el.style.transition = `opacity 400ms ease ${i * 100}ms, transform 400ms ease ${i * 100}ms`;
                    setTimeout(() => {
                        el.style.opacity = 1;
                        el.style.transform = 'translateY(0)';
                    }, 50);
                });

                setTimeout(() => div.classList.add('opacity-100'), 10);
                div.classList.remove('opacity-0');
            } else {
                div.classList.remove('opacity-100');
                div.classList.add('opacity-0');
                setTimeout(() => div.classList.add('hidden'), 500);
                btn.classList.remove('bg-[#49A078]');
            }
        });
    }

    function toggleMenu() {
        const menu = document.getElementById('menu-buttons');
        menu.classList.toggle('hidden');
    }
    </script>

@endsection
