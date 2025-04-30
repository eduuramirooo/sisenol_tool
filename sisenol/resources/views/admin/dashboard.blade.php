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

    <div id="menu-buttons" class="grid grid-cols-1 sm:grid-cols-4 md:grid-cols-4 gap-4 text-center hidden sm:grid mb-4">
        <button onclick="mostrarSeccion('usuarios')" class="bg-white border rounded shadow hover:bg-[#DCE1DE] py-4 font-medium w-full transition transform hover:scale-105 duration-300">Usuarios</button>
        <button onclick="mostrarSeccion('productos')" class="bg-white border rounded shadow hover:bg-[#DCE1DE] py-4 font-medium w-full transition transform hover:scale-105 duration-300">Gestión productos</button>
        <button onclick="mostrarSeccion('proyectos')" class="bg-white border rounded shadow hover:bg-[#DCE1DE] py-4 font-medium w-full transition transform hover:scale-105 duration-300">Gestión proyectos</button>
        <button onclick="mostrarSeccion('notas')" class="bg-white border rounded shadow hover:bg-[#DCE1DE] py-4 font-medium w-full transition transform hover:scale-105 duration-300">Notas</button>
    </div>

    <!-- Sección: Usuarios -->
    <div id="seccion-usuarios" class="hidden opacity-0 transition-opacity duration-500">
        <h2 class="text-lg font-semibold">Gestión de usuarios</h2>
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

        <div class="mt-8">
            <h3 class="font-semibold text-md mb-2">Usuarios activos</h3>
            <form method="GET" class="bg-gray-50 p-4 rounded shadow-md mb-6 flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-4 sm:space-y-0">
                <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por alias o usuario"
                    class="border border-gray-300 px-4 py-2 rounded w-full sm:w-1/3">
                <select name="estado" class="border px-4 py-2 rounded w-full sm:w-1/5">
                    <option value="">Todos</option>
                    <option value="1" {{ request('estado') == '1' ? 'selected' : '' }}>Activos</option>
                    <option value="0" {{ request('estado') == '0' ? 'selected' : '' }}>Inactivos</option>
                </select>
                <select name="tipo" class="border px-4 py-2 rounded w-full sm:w-1/5">
                    <option value="">Todos los tipos</option>
                    <option value="admin" {{ request('tipo') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ request('tipo') == 'user' ? 'selected' : '' }}>User</option>
                </select>
                <div class="flex space-x-2 w-full sm:w-auto">
                    <a href="{{ route('admin.menu') }}" class="bg-gray-200 px-4 py-2 rounded">Borrar</a>
                    <button type="submit" class="bg-black text-white px-4 py-2 rounded hover:bg-[#216869] transition">Filtrar</button>
                </div>
            </form>

            <table class="w-full text-left text-sm bg-white rounded shadow">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2">Alias</th>
                        <th class="px-4 py-2">Username</th>
                        <th class="px-4 py-2">Tipo</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $usuario)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $usuario->alias }}</td>
                        <td class="px-4 py-2">{{ $usuario->username }}</td>
                        <td class="px-4 py-2">{{ $usuario->tipo }}</td>
                        <td class="px-4 py-2 space-x-2">
                            @if ($usuario->activo)
                                <form action="{{ route('admin.eliminarUsuario', $usuario->id) }}" method="POST" class="inline">@csrf
                                    <button type="submit" class="text-red-500 hover:underline">Eliminar</button>
                                </form>
                            @else
                                <form action="{{ route('admin.activarUsuario', $usuario->id) }}" method="POST" class="inline">@csrf
                                    <button type="submit" class="text-green-600 hover:underline">Re-activar</button>
                                </form>
                            @endif
                            <a href="{{ route('admin.editarUsuarioForm', $usuario->id) }}" class="text-blue-600 hover:underline">Editar</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Sección: Productos -->
    <div id="seccion-productos" class="hidden opacity-0 transition-opacity duration-500">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-2xl font-semibold">Gestión de productos</h2>
        <button onclick="toggleLayout('productos-layout')" class="bg-black text-white px-4 py-2 rounded hover:bg-[#1b5b5d] transition">
            Cambiar disposición
        </button>
    </div>

    <div id="productos-layout" class="flex flex-col gap-6 md:grid md:grid-cols-1 transition-all duration-300">
        {{-- Crear producto --}}
        <div class="bg-white p-6 rounded shadow space-y-6">
            <h3 class="text-xl font-medium border-b pb-2">Crear nuevo producto</h3>
            <form action="{{ route('admin.crearProducto') }}" method="POST" enctype="multipart/form-data" class="space-y-4">@csrf
                <input type="text" name="nombre" placeholder="Nombre del producto" class="w-full border px-4 py-2 rounded">
                <input type="text" name="descripcion" placeholder="Descripción" class="w-full border px-4 py-2 rounded">
                <input type="file" name="imagen" accept="image/*" class="w-full border px-4 py-2 rounded">
                <button type="submit" class="bg-black text-white px-6 py-3 rounded hover:bg-gray-800 transition">Crear</button>
            </form>
        </div>

        {{-- Asignar producto --}}
        <div class="bg-white p-6 rounded shadow space-y-6">
            <h3 class="text-xl font-medium border-b pb-2">Asignar producto a usuario</h3>
            <form action="{{ route('admin.asignarProducto') }}" method="POST" class="space-y-4">@csrf
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
                <button type="submit" class="bg-black text-white px-6 py-3 rounded hover:bg-gray-800 transition">Asignar</button>
            </form>
        </div>

        {{-- Subir documento --}}
        <div class="bg-white p-6 rounded shadow space-y-6">
            <h3 class="text-xl font-medium border-b pb-2">Subir documento PDF a producto</h3>
            <form action="{{ route('admin.actualizarDocumento') }}" method="POST" enctype="multipart/form-data" class="space-y-4">@csrf
                <select name="producto_id" class="w-full border px-4 py-2 rounded">
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                    @endforeach
                </select>
                <input type="file" name="documento" accept="application/pdf" class="w-full border px-4 py-2 rounded">
                <button type="submit" class="bg-black text-white px-6 py-3 rounded hover:bg-gray-800 transition">Subir</button>
            </form>
        </div>
    </div>
</div>


<!-- Seccion Proyectos -->
<div id="seccion-proyectos" class="hidden opacity-0 transition-opacity duration-500">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-2xl font-semibold">Gestión de proyectos</h2>
        <button onclick="toggleLayout('proyectos-layout')" class="bg-black text-white px-4 py-2 rounded hover:bg-[#1b5b5d] transition">
            Cambiar disposición
        </button>
    </div>

    {{-- Bloques de gestión --}}
    <div id="proyectos-layout" class="flex flex-col gap-6 md:grid md:grid-cols-1 transition-all duration-300 mb-10">
        {{-- Crear proyecto --}}
        <div class="bg-white p-5 rounded shadow space-y-4">
            <h3 class="text-lg font-medium border-b pb-2">Crear nuevo proyecto</h3>
            <form action="{{ route('admin.crearProyecto') }}" method="POST" class="space-y-4">@csrf
                <input type="text" name="nombre" placeholder="Nombre del proyecto" class="w-full border px-4 py-2 rounded">
                <button type="submit" class="bg-black text-white px-5 py-2 rounded hover:bg-gray-800 transition w-full sm:w-auto">
                    Crear
                </button>
            </form>
        </div>

        {{-- Editar nombre --}}
        <div class="bg-white p-5 rounded shadow space-y-4">
            <h3 class="text-lg font-medium border-b pb-2">Editar nombre del proyecto</h3>
            <form action="{{ route('admin.editarProyecto') }}" method="POST" class="space-y-4">@csrf
                <select name="proyecto_id" class="w-full border px-4 py-2 rounded">
                    @foreach($proyectos as $proyecto)
                        <option value="{{ $proyecto->id }}">{{ $proyecto->nombre }}</option>
                    @endforeach
                </select>
                <input type="text" name="nuevo_nombre" placeholder="Nuevo nombre" class="w-full border px-4 py-2 rounded">
                <button type="submit" class="bg-black text-white px-5 py-2 rounded hover:bg-gray-800 transition w-full sm:w-auto">
                    Actualizar
                </button>
            </form>
        </div>

        {{-- Asignar proyecto --}}
        <div class="bg-white p-5 rounded shadow space-y-4">
            <h3 class="text-lg font-medium border-b pb-2">Asignar proyecto a usuario</h3>
            <form action="{{ route('admin.asignarProyecto') }}" method="POST" class="space-y-4">@csrf
                <select name="usuario_id" class="w-full border px-4 py-2 rounded">
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id }}">{{ $usuario->alias }} ({{ $usuario->username }})</option>
                    @endforeach
                </select>
                <select name="proyecto_id" class="w-full border px-4 py-2 rounded">
                    @foreach($proyectos as $proyecto)
                        <option value="{{ $proyecto->id }}">{{ $proyecto->nombre }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-black text-white px-5 py-2 rounded hover:bg-gray-800 transition w-full sm:w-auto">
                    Asignar
                </button>
            </form>
        </div>
    </div>

    {{-- Tabla de proyectos --}}
    <div class="mt-14">
        <h3 class="text-xl font-semibold mb-4">Listado de proyectos</h3>
        <table class="w-full text-left text-sm bg-white rounded shadow">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Ruta</th>
                    <th class="px-4 py-2">Usuarios asignados</th>
                </tr>
            </thead>
            <tbody>
                @foreach($proyectos as $proyecto)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $proyecto->id }}</td>
                        <td class="px-4 py-2">{{ $proyecto->nombre }}</td>
                        <td class="px-4 py-2">upload/proyectos/{{ $proyecto->carpeta ?? Str::slug($proyecto->nombre, '_') }}</td>
                        <td class="px-4 py-2">
                            @forelse($proyecto->usuarios as $usuario)
                                <span class="inline-block bg-gray-200 text-gray-800 px-2 py-1 rounded text-xs mr-1 mb-1">
                                    {{ $usuario->alias }}
                                </span>
                            @empty
                                <span class="text-gray-400 text-sm">Sin usuarios asignados</span>
                            @endforelse
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>



    <!-- Sección: Notas -->
    <div id="seccion-notas" class="hidden opacity-0 transition-opacity duration-500">
        <h2 class="text-lg font-semibold">Modificar notas</h2>
        <p>Listado y edición de notas por usuario.</p>
        <!-- Por implementar -->
    </div>
</div>


<script src="{{ asset('js/admin.js') }}" defer></script>
@endsection
