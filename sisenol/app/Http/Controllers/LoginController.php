<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function recibir(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        // Buscar usuario por username
        $usuario = DB::table('usuarios')->where('username', $username)->first();

        if ($usuario && Hash::check($password, $usuario->password)) {
            session([
                'id' => $usuario->id,
                'username' => $usuario->username,
                'alias' => $usuario->alias,
                'tipo' => $usuario->tipo
            ]);
            return redirect('/');
        } else {
            return back()->with('error', 'Error al iniciar sesión: credenciales incorrectas');
        }
    }

    // Este método no deberías usarlo si los admins dan de alta usuarios.
    // Si aún así lo quieres para pruebas, lo dejo ajustado:
    public function registrar(Request $request)
    {
        $username = $request->input('username');
        $password = Hash::make($request->input('password'));

        $insertado = DB::table('usuarios')->insert([
            'username' => $username,
            'password' => $password,
            'alias' => null,
            'tipo' => 'user'
        ]);

        if ($insertado) {
            
            return redirect('/')->with('success', 'Usuario registrado correctamente');
        } else {
            return redirect('/')->with('error', 'Error al registrar el usuario');
        }
    }

    public function registrarform()
    {
        return view('formulario-register');
    }

    public function logout()
    {
        session()->forget(['id', 'username', 'alias', 'tipo']);
        return redirect('/');
    }
    public function formulario()
    {
        return view('welcome');
    }
}
