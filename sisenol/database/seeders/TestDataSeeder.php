<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    public function run()
    {
        // Insertar usuarios y guardar IDs
        $idEdu = DB::table('usuarios')->insertGetId([
            'username' => 'eduu',
            'password' => Hash::make('1234'),
            'alias' => 'Edu',
            'tipo' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $idJuan = DB::table('usuarios')->insertGetId([
            'username' => 'jdoe',
            'password' => Hash::make('password123'),
            'alias' => 'Juan',
            'tipo' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $idAna = DB::table('usuarios')->insertGetId([
            'username' => 'amora',
            'password' => Hash::make('password456'),
            'alias' => 'Ana',
            'tipo' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $idAdmin = DB::table('usuarios')->insertGetId([
            'username' => 'admin1',
            'password' => Hash::make('adminpass'),
            'alias' => 'Administrador',
            'tipo' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insertar productos y guardar IDs
        $idProdA = DB::table('productos')->insertGetId([
            'nombre' => 'Producto A',
            'descripcion' => 'Descripción A',
            'imagen' => '/upload/img/productoA.png',
            'documento' => '/upload/document/manualA.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $idProdB = DB::table('productos')->insertGetId([
            'nombre' => 'Producto B',
            'descripcion' => 'Descripción B',
            'imagen' => '/upload/img/productoB.png',
            'documento' => '/upload/document/manualB.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $idProdC = DB::table('productos')->insertGetId([
            'nombre' => 'Producto C',
            'descripcion' => 'Descripción C',
            'imagen' => '/upload/img/productoC.png',
            'documento' => '/upload/document/manualC.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Relación producto_usuario
        DB::table('producto_usuario')->insert([
            ['usuario_id' => $idEdu, 'producto_id' => $idProdA],
            ['usuario_id' => $idEdu, 'producto_id' => $idProdC],
            ['usuario_id' => $idJuan, 'producto_id' => $idProdB],
        ]);

        // Planos
        DB::table('planos')->insert([
            ['usuario_id' => $idEdu, 'titulo' => 'Plano Cocina', 'imagen' => '/upload/img/plano1.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['usuario_id' => $idEdu, 'titulo' => 'Plano Baño', 'imagen' => '/upload/img/plano2.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['usuario_id' => $idJuan, 'titulo' => 'Plano Oficina', 'imagen' => '/upload/img/plano3.jpg', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Notas
        DB::table('notas')->insert([
            ['usuario_id' => $idEdu, 'contenido' => 'Revisar enchufes del plano cocina', 'fecha' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['usuario_id' => $idJuan, 'contenido' => 'Cambiar interruptores en la oficina', 'fecha' => now(), 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

