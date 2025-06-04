<?php

namespace App\Http\Controllers;

use App\Models\Producto; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;    
class ProductoController extends Controller
{
    
    public function dashboard()
    {
        $usuario = DB::table('usuarios')->where('id', session('id'))->first();
        if (!$usuario) {
            return redirect('/formulario')->with('error', 'Usuario no encontrado o sesión expirada.');
        }
    
        $productos = DB::table('productos')
            ->join('producto_usuario', 'productos.id', '=', 'producto_usuario.producto_id')
            ->where('producto_usuario.usuario_id', $usuario->id)
            ->select('productos.*')
            ->get();
    
        $planos = DB::table('planos')->where('usuario_id', $usuario->id)->get();
        $notas = DB::table('notas')->where('usuario_id', $usuario->id)->get();
    
        $proyecto = DB::table('proyecto_usuario')
            ->join('proyectos', 'proyecto_usuario.proyecto_id', '=', 'proyectos.id')
            ->where('proyecto_usuario.usuario_id', $usuario->id)
            ->select('proyectos.nombre', 'proyectos.carpeta')
            ->first();
    
        $archivos = [];
        $notasDocs = [];
        $debugInfo = [];
    
        if ($proyecto && $proyecto->carpeta) {
            $rutaCompleta = $proyecto->carpeta;
            $nombreCarpeta = basename(str_replace('\\', '/', $rutaCompleta)); 
            $urlBase = '/upload/proyectos/' . $nombreCarpeta;
    
            $isCarpeta = is_dir($rutaCompleta);
            $debugInfo['ruta_proyecto'] = $rutaCompleta;
            $debugInfo['existe_carpeta'] = $isCarpeta;
            $debugInfo['contenido'] = $isCarpeta ? scandir($rutaCompleta) : [];
    
            if ($isCarpeta) {
                $files = array_diff($debugInfo['contenido'], ['.', '..']);
                foreach ($files as $file) {
                    $filePath = $rutaCompleta . DIRECTORY_SEPARATOR . $file;
    
                    if (is_dir($filePath) && $file === 'notes') continue;
    
                    if (is_file($filePath)) {
                            $archivos[] = [
                        'nombre' => $file,
                        'peso' => round(filesize($filePath) / 1024, 2),
                        'url' => asset($urlBase . '/' . $file),
                        'ruta_real' => $filePath, //  Aquí está la solución
                    ];

                    }
                }
            }
    
            // Archivos de la carpeta "notes"
            $rutaNotas = $rutaCompleta . DIRECTORY_SEPARATOR . 'notes';
            $urlNotas = $urlBase . '/notes';
            $debugInfo['ruta_notes'] = $rutaNotas;
            $debugInfo['existe_notes'] = is_dir($rutaNotas);
            $debugInfo['contenido_notes'] = $debugInfo['existe_notes'] ? scandir($rutaNotas) : [];
    
if ($debugInfo['existe_notes']) {
    $archivosNotas = array_diff($debugInfo['contenido_notes'], ['.', '..']);
    foreach ($archivosNotas as $archivo) {
        $rutaArchivo = $rutaNotas . DIRECTORY_SEPARATOR . $archivo;
        if (is_file($rutaArchivo)) {
            $notasDocs[] = [
                'nombre' => $archivo,
                'peso' => round(filesize($rutaArchivo) / 1024, 2),
                'url' => asset($urlNotas . '/' . $archivo),
                'ruta' => $rutaArchivo, // <-- Agregamos esto
            ];
        }
    }
}

        }
        
        return view('user.dashboard', compact(
            'usuario',
            'productos',
            'planos',
            'notas',
            'archivos',
            'proyecto',
            'notasDocs'
            
        ));
    }
    
    
    
    

    public function index()
    {
        return redirect()->route('dashboard');
    }

    public function descargar($id)
    {
        $producto = Producto::findOrFail($id);
        $ruta = public_path($producto->documento); // convierte '/upload/document/manualA.pdf' a ruta real
    
        if (file_exists($ruta)) {
            return response()->download($ruta);
        } else {
            return redirect()->back()->with('error', 'El archivo no se encontró');
        }
    }

public function descargarPorRuta(Request $request)
{
    $ruta = urldecode($request->input('ruta'));

    if (!str_starts_with($ruta, '\\\\DESKTOP-R9K7UMI\\Sisenol\\proyectosolar')) {
        return redirect()->back()->with('error', 'Ruta no permitida.');
    }

    $ruta = str_replace('\\', DIRECTORY_SEPARATOR, $ruta);

    if (file_exists($ruta)) {
        return Response::download($ruta);
    } else {
        return redirect()->back()->with('error', 'El archivo no se encontró.');
    }
}

    public function web($id)    
    {
        // Lógica para redirigir al sitio web relacionado con el producto
        $producto = Producto::findOrFail($id);
        return redirect($producto->url_web);
    }
    public function productos()
{
    $usuarioId = session('id');
    $productos = DB::table('productos')
        ->join('producto_usuario', 'productos.id', '=', 'producto_usuario.producto_id')
        ->where('producto_usuario.usuario_id', $usuarioId)
        ->select('productos.*')
        ->get();

    return view('user.productos', compact('productos'));
}

}
