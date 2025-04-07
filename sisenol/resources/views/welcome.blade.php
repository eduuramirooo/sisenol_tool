<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión - Sisenol Solutions</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <?php if(session()->has('id')): ?>
        <script>
            window.location.href = "{{ url('/dashboard') }}";
        </script>
    <?php else: ?>
        @include('form-login')
    <?php endif; ?>
       
    </div>
</body>
</html>