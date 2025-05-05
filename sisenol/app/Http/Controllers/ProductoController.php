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
    
        $proyecto = DB::table('proyecto_usuario')
            ->join('proyectos', 'proyecto_usuario.proyecto_id', '=', 'proyectos.id')
            ->where('proyecto_usuario.usuario_id', $usuario->id)
            ->select('proyectos.nombre', 'proyectos.carpeta')
            ->first();
    
        $archivos = [];
        $notasDocs = [];
        $debugInfo = [];
    
        if ($proyecto && $proyecto->carpeta) {
            $carpeta = $proyecto->carpeta;
            $rutaCompleta = public_path('upload/proyectos/' . $carpeta);
            $urlBase = '/upload/proyectos/' . $carpeta;
    
            // Guardar info de depuración
            $debugInfo['ruta_proyecto'] = $rutaCompleta;
            $debugInfo['existe_carpeta'] = is_dir($rutaCompleta);
            $debugInfo['contenido'] = is_dir($rutaCompleta) ? scandir($rutaCompleta) : [];
    
            if ($debugInfo['existe_carpeta']) {
                $files = array_diff($debugInfo['contenido'], ['.', '..']);
                foreach ($files as $file) {
                    $filePath = $rutaCompleta . DIRECTORY_SEPARATOR . $file;
    
                    if (is_dir($filePath) && $file === 'notes') {
                        continue;
                    }
    
                    if (is_file($filePath)) {
                        $archivos[] = [
                            'nombre' => $file,
                            'peso' => round(filesize($filePath) / 1024, 2),
                            'url' => asset($urlBase . '/' . $file),
                        ];
                    }
                }
            }
    
            // Buscar archivos en notes
            $rutaNotas = $rutaCompleta . '/notes';
            $urlNotas = $urlBase . '/notes';
            $debugInfo['ruta_notes'] = $rutaNotas;
            $debugInfo['existe_notes'] = is_dir($rutaNotas);
            $debugInfo['contenido_notes'] = is_dir($rutaNotas) ? scandir($rutaNotas) : [];
    
            if ($debugInfo['existe_notes']) {
                $archivosNotas = array_diff($debugInfo['contenido_notes'], ['.', '..']);
                foreach ($archivosNotas as $archivo) {
                    $rutaArchivo = $rutaNotas . DIRECTORY_SEPARATOR . $archivo;
                    if (is_file($rutaArchivo)) {
                        $notasDocs[] = [
                            'nombre' => $archivo,
                            'peso' => round(filesize($rutaArchivo) / 1024, 2),
                            'url' => asset($urlNotas . '/' . $archivo),
                        ];
                    }
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
            'notasDocs',
            'debugInfo'
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
