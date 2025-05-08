<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    /* ========== AUTENTICACIÓN & ACCESO ========== */

    public function checkAdminBD(Request $request)
    {
        $usuarioId = session('id');
        $user = DB::table('usuarios')->where('id', $usuarioId)->first();
        return $user && $user->tipo === 'admin';
    }

    public function menu(Request $request)
    {
        $usuarioId = session('id');
        $user = DB::table('usuarios')->where('id', $usuarioId)->first();

        if ($user && $user->tipo === 'admin') {
            $usuarios = DB::table('usuarios')->get();
            $productos = DB::table('productos')->get();
            $proyectos = DB::table('proyectos')->get();

            foreach ($proyectos as $proyecto) {
                $proyecto->usuarios = DB::table('usuarios')
                    ->join('proyecto_usuario', 'usuarios.id', '=', 'proyecto_usuario.usuario_id')
                    ->where('proyecto_usuario.proyecto_id', $proyecto->id)
                    ->select('usuarios.alias')
                    ->get();
            }

            return view('admin.dashboard', compact('usuarios', 'productos', 'proyectos'));
        }

        return redirect()->route('dashboard')->with('error', 'No tienes acceso a esta sección.');
    }

    public function dashboard()
    {
        $usuarioId = session('id');
        $usuario = DB::table('usuarios')->where('id', $usuarioId)->first();

        if (!$usuario) {
            return redirect('/formulario')->with('error', 'Usuario no encontrado o sesión expirada');
        }

        $productos = DB::table('productos')
            ->join('producto_usuario', 'productos.id', '=', 'producto_usuario.producto_id')
            ->where('producto_usuario.usuario_id', $usuario->id)
            ->select('productos.*')
            ->get();

        $planos = DB::table('planos')->where('usuario_id', $usuario->id)->get();
        $notas = DB::table('notas')->where('usuario_id', $usuario->id)->get();

        $proyectos = DB::table('proyectos')
            ->join('proyecto_usuario', 'proyectos.id', '=', 'proyecto_usuario.proyecto_id')
            ->where('proyecto_usuario.usuario_id', $usuario->id)
            ->select('proyectos.*')
            ->get();

        $count = $productos->count();
        $fecha = '2024-01-01';
        $fechaMan = '2024-03-15';
        $cantidad = 12.5;

        return view('user.dashboard', compact(
            'usuario', 'productos', 'planos', 'notas', 'proyectos',
            'count', 'fecha', 'fechaMan', 'cantidad'
        ));
    }

    /* ========== GESTIÓN DE USUARIOS ========== */

    public function registrarUsuario(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:usuarios,username',
            'password' => 'required|string|min:4',
            'alias' => 'nullable|string',
            'tipo' => 'required|in:user,admin',
        ]);

        DB::table('usuarios')->insert([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'alias' => $request->alias,
            'tipo' => $request->tipo,
            'activo' => 1
        ]);

        return redirect()->route('admin.menu')->with('success', 'Usuario registrado correctamente.');
    }

    public function eliminarUsuario($id)
    {
        DB::table('usuarios')->where('id', $id)->update(['activo' => 0]);
        return redirect()->route('admin.menu')->with('success', 'Usuario dado de baja correctamente.');
    }

    public function activarUsuario($id)
    {
        DB::table('usuarios')->where('id', $id)->update(['activo' => 1]);
        return redirect()->route('admin.menu')->with('success', 'Usuario reactivado correctamente.');
    }

    public function editarUsuarioForm($id)
    {
        $usuario = DB::table('usuarios')->where('id', $id)->first();
        return view('admin.editar_usuario', compact('usuario'));
    }

    public function actualizarUsuario(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string|unique:usuarios,username,' . $id,
            'alias' => 'nullable|string',
            'tipo' => 'required|in:user,admin',
        ]);

        $datos = [
            'username' => $request->username,
            'alias' => $request->alias,
            'tipo' => $request->tipo,
        ];

        if ($request->filled('password')) {
            $datos['password'] = Hash::make($request->password);
        }

        DB::table('usuarios')->where('id', $id)->update($datos);

        return redirect()->route('admin.menu')->with('success', 'Usuario actualizado correctamente.');
    }

    /* ========== GESTIÓN DE PRODUCTOS ========== */

    public function crearProducto(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'required|string',
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $rutaImagen = null;

            if ($request->hasFile('imagen')) {
                $imagen = $request->file('imagen');
                $nombreImagen = 'producto_' . strtolower(str_replace(' ', '_', $request->nombre)) . '.' . $imagen->getClientOriginalExtension();
                Log::info('Subiendo imagen: ' . $nombreImagen);
                $imagen->move(public_path('upload/img'), $nombreImagen);
                $rutaImagen = '/upload/img/' . $nombreImagen;
            }

            DB::table('productos')->insert([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'imagen' => $rutaImagen,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('admin.menu')->with('success', 'Producto creado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear producto: ' . $e->getMessage());
            return redirect()->route('admin.menu')->with('error', 'Hubo un problema al crear el producto.');
        }
    }

    public function asignarProducto(Request $request)
    {
        DB::table('producto_usuario')->insert([
            'usuario_id' => $request->usuario_id,
            'producto_id' => $request->producto_id
        ]);

        return redirect()->route('admin.menu')->with('success', 'Producto asignado correctamente.');
    }

    public function actualizarDocumento(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'documento' => 'required|mimes:pdf|max:5120'
        ]);

        $producto = DB::table('productos')->where('id', $request->producto_id)->first();

        if (!$producto) {
            return redirect()->back()->with('error', 'Producto no encontrado');
        }

        $nombreProducto = str_replace(' ', '_', strtolower($producto->nombre)) . '.pdf';

        $request->file('documento')->move(public_path('upload/document'), $nombreProducto);

        DB::table('productos')
            ->where('id', $request->producto_id)
            ->update(['documento' => '/upload/document/' . $nombreProducto]);

        return redirect()->route('admin.menu')->with('success', 'Documento actualizado correctamente.');
    }

    /* ========== GESTIÓN DE PROYECTOS ========== */

    public function crearProyecto(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:proyectos,nombre',
        ]);

        $nombre = $request->nombre;
        $carpeta = strtolower(str_replace(' ', '_', $nombre));
        $rutaBase = public_path('upload/proyectos/' . $carpeta);
        $rutaNotes = $rutaBase . '/notes';

        if (!File::exists($rutaBase)) {
            File::makeDirectory($rutaBase, 0775, true);
            File::makeDirectory($rutaNotes, 0775, true);
        }

        DB::table('proyectos')->insert([
            'nombre' => $nombre,
            'carpeta' => $carpeta,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.menu')->with('success', 'Proyecto creado correctamente.');
    }

    public function editarProyecto(Request $request)
    {
        $request->validate([
            'proyecto_id' => 'required|exists:proyectos,id',
            'nueva_carpeta' => 'required|string|max:255',
        ]);
    
        $proyecto = DB::table('proyectos')->where('id', $request->proyecto_id)->first();
        if (!$proyecto) {
            return redirect()->route('admin.menu')->with('error', 'Proyecto no encontrado.');
        }
    
        $nuevaCarpeta = strtolower(str_replace(' ', '_', $request->nueva_carpeta));
        $rutaAntigua = public_path('upload/proyectos/' . $proyecto->carpeta);
        $rutaNueva = public_path('upload/proyectos/' . $nuevaCarpeta);
    
        if (File::exists($rutaAntigua)) {
            File::move($rutaAntigua, $rutaNueva);
        }
    
        DB::table('proyectos')->where('id', $proyecto->id)->update([
            'carpeta' => $nuevaCarpeta,
            'updated_at' => now(),
        ]);
    
        return redirect()->route('admin.menu')->with('success', 'Carpeta del proyecto actualizada correctamente.');
    }
    
    public function asignarProyecto(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'proyecto_id' => 'required|exists:proyectos,id',
        ]);

        DB::table('proyecto_usuario')->insert([
            'usuario_id' => $request->usuario_id,
            'proyecto_id' => $request->proyecto_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.menu')->with('success', 'Proyecto asignado correctamente.');
    }
}

