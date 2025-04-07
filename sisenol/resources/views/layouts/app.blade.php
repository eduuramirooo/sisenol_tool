<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sisenol Solutions</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 pt-16 pb-28">
    <!-- Header -->
    <header class="bg-white text-[#292727] w-full fixed top-0 left-0 z-50 shadow">
        <div class="px-6 py-4 flex justify-between items-center max-w-7xl mx-auto">
            <div class="flex items-center space-x-3">
                <a href="/">
                    <img src="{{ asset('img/logo.png') }}" alt="Sisenol Solutions" class="h-8" onerror="this.onerror=null; this.src='{{ asset('img/default-logo.png') }}';">
                </a>
            </div>
            <nav class="flex space-x-6 text-sm items-center">
                <a href="#" class="hover:text-[#9CC5A1]">Soluciones</a>
                <a href="#" class="hover:text-[#9CC5A1]">Proyectos</a>
                <a href="#" class="hover:text-[#9CC5A1]">Contáctanos</a>

                @if(session('id'))
                    @php
                        $tipo = DB::table('usuarios')->where('id', session('id'))->value('tipo');
                    @endphp

                    @if($tipo === 'admin')
                        <a href="{{ route('admin.menu') }}" class="ml-4 px-4 py-1.5 text-sm bg-[#216869] text-[#DCE1DE] rounded-md hover:bg-[#49A078] transition duration-300 shadow">
                            Menú admin
                        </a>
                    @endif
                    <form action="{{ route('login.logout') }}" method="GET">
                        <button type="submit" class="ml-4 px-4 py-1.5 text-sm bg-[#49A078] text-[#DCE1DE] rounded-md hover:bg-[#216869] transition duration-300 shadow">
                            &#x274C; Cerrar sesión
                        </button>
                    </form>
                @endif
            </nav>
        </div>
    </header>


    <!-- Contenido -->
    <main class="min-h-[calc(100vh-7rem)]">
        <div class="max-w-7xl mx-auto px-6 py-10">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white text-gray-600 border-t w-full fixed bottom-0 left-0 z-40">
    <div class="px-6 py-4 flex flex-col md:flex-row justify-between items-center text-sm max-w-7xl mx-auto space-y-4 md:space-y-0">
        <!-- Logo y enlaces -->
        <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-6 text-center md:text-left">
            <img src="{{ asset('img/icon.png') }}" alt="Logo Sisenol" class="h-8 md:h-10 mx-auto md:mx-0">
            <div class="flex flex-col sm:flex-row sm:space-x-4 space-y-2 sm:space-y-0">
                <a href="#" class="hover:underline">Quiénes somos</a>
                <a href="#" class="hover:underline">Soluciones</a>
                <a href="#" class="hover:underline">Contáctanos</a>
            </div>
        </div>

        <!-- Información legal -->
        <div class="text-center md:text-right text-xs text-gray-400">
            Diseñado por Sisenol Solutions © 2023. Todos los derechos reservados. <br>
            <a href="#" class="hover:underline">Política de calidad y medio ambiente</a> |
            <a href="#" class="hover:underline">Política de privacidad</a>
        </div>
    </div>
</footer>
</body>
</html>


