<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function activarUsuario($id)
{
    DB::table('usuarios')->where('id', $id)->update(['activo' => 1]);
    return redirect()->route('admin.menu')->with('success', 'Usuario reactivado correctamente.');
}

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

        // APLICAR FILTROS
        $usuariosQuery = DB::table('usuarios');

        if ($request->filled('estado')) {
            $usuariosQuery->where('activo', $request->estado);
        }

        if ($request->filled('tipo')) {
            $usuariosQuery->where('tipo', $request->tipo);
        }

        if ($request->filled('buscar')) {
            $usuariosQuery->where(function ($query) use ($request) {
                $query->where('username', 'like', '%' . $request->buscar . '%')
                      ->orWhere('alias', 'like', '%' . $request->buscar . '%');
            });
        }

        $usuarios = $usuariosQuery->get();
        $productos = DB::table('productos')->get();

        return view('admin.dashboard', compact('usuarios', 'productos'));
    }

    return redirect()->route('dashboard')->with('error', 'No tienes acceso a esta sección.');
}


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

    public function asignarProducto(Request $request)
    {
        DB::table('producto_usuario')->insert([
            'usuario_id' => $request->usuario_id,
            'producto_id' => $request->producto_id
        ]);

        return redirect()->route('admin.menu')->with('success', 'Producto asignado correctamente.');
    }

    public function dashboard()
    {
        $usuarioId = session('id');
        $usuario = DB::table('usuarios')->where('id', $usuarioId)->first();

        if (!$usuario) {
            return redirect('/')->with('error', 'Usuario no encontrado o sesión expirada');
        }

        $productos = DB::table('productos')
            ->join('producto_usuario', 'productos.id', '=', 'producto_usuario.producto_id')
            ->where('producto_usuario.usuario_id', $usuario->id)
            ->select('productos.*')
            ->get();

        $planos = DB::table('planos')->where('usuario_id', $usuario->id)->get();
        $notas = DB::table('notas')->where('usuario_id', $usuario->id)->get();

        $count = $productos->count();
        $fecha = '2024-01-01';
        $fechaMan = '2024-03-15';
        $cantidad = 12.5;

        return view('user.dashboard', compact('usuario', 'productos', 'planos', 'notas', 'count', 'fecha', 'fechaMan', 'cantidad'));
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

            Log::info('Insertando producto: ' . $request->nombre . ' con ruta ' . $rutaImagen);

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
}