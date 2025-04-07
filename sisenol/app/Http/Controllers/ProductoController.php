<?php

namespace App\Http\Controllers;

use App\Models\Producto; // Asegúrate de tener este modelo
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ProductoController extends Controller
{
    
public function dashboard()
{
    $usuario = DB::table('usuarios')->where('id', session('id'))->first();

    $productos = DB::table('productos')
        ->join('producto_usuario', 'productos.id', '=', 'producto_usuario.producto_id')
        ->where('producto_usuario.usuario_id', $usuario->id)
        ->select('productos.*')
        ->get();

    $planos = DB::table('planos')->where('usuario_id', $usuario->id)->get();
    $notas = DB::table('notas')->where('usuario_id', $usuario->id)->get();

    // Buscar carpeta del proyecto del usuario
    $proyecto = DB::table('proyecto_usuario')
    ->join('proyectos', 'proyecto_usuario.proyecto_id', '=', 'proyectos.id')
    ->where('proyecto_usuario.usuario_id', $usuario->id)
    ->select('proyectos.nombre', 'proyectos.carpeta')
    ->first();

    // Obtener archivos de la carpeta del proyecto
    $archivos = [];

    if ($proyecto && $proyecto->carpeta) {
        $rutaCompleta = public_path($proyecto->carpeta);
    
        if (is_dir($rutaCompleta)) {
            $files = array_diff(scandir($rutaCompleta), ['.', '..']);
            foreach ($files as $file) {
                $filePath = $rutaCompleta . DIRECTORY_SEPARATOR . $file;
    
                // Ignorar carpeta llamada "nombre"
                if (is_dir($filePath) && $file === 'notes') {
                    continue;
                }
    
                // Solo incluir archivos (no carpetas)
                if (is_file($filePath)) {
                    $archivos[] = [
                        'nombre' => $file,
                        'peso' => round(filesize($filePath) / 1024, 2), // en KB
                        'url' => asset($proyecto->carpeta . '/' . $file),
                    ];
                }
            }
        }
    }
    
$notasDocs = [];

if ($proyecto && $proyecto->carpeta) {
    $rutaNotas = public_path($proyecto->carpeta . '/notes');

    if (is_dir($rutaNotas)) {
        $archivosNotas = array_diff(scandir($rutaNotas), ['.', '..']);
        foreach ($archivosNotas as $archivo) {
            $rutaCompleta = $rutaNotas . DIRECTORY_SEPARATOR . $archivo;
            $notasDocs[] = [
                'nombre' => $archivo,
                'peso' => round(filesize($rutaCompleta) / 1024, 2), // en KB
                'url' => asset($proyecto->carpeta . '/notes/' . $archivo)
            ];
        }
    }
}



    $count = $productos->count();
    $fecha = '2024-01-01';
    $fechaMan = '2024-03-15';
    $cantidad = 12.5;

    return view('user.dashboard', compact(
        'usuario',
        'productos',
        'planos',
        'notas',
        'count',
        'fecha',
        'fechaMan',
        'cantidad',
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
