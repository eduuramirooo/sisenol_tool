<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('notas')->insert(['id' => 1, 'usuario_id' => 1, 'contenido' => 'Revisar enchufes del plano cocina', 'fecha' => '2025-04-05 08:47:05', 'created_at' => '2025-04-05 06:47:05', 'updated_at' => '2025-04-05 06:47:05']);
        DB::table('notas')->insert(['id' => 2, 'usuario_id' => 2, 'contenido' => 'Cambiar interruptores en la oficina', 'fecha' => '2025-04-05 08:47:05', 'created_at' => '2025-04-05 06:47:05', 'updated_at' => '2025-04-05 06:47:05']);
        DB::table('planos')->insert(['id' => 1, 'usuario_id' => 1, 'titulo' => 'Plano 1', 'imagen' => '/upload/img/plano1.jpg', 'created_at' => '2025-04-05 06:47:05', 'updated_at' => '2025-04-05 06:47:05']);
        DB::table('planos')->insert(['id' => 2, 'usuario_id' => 1, 'titulo' => 'Plano 2', 'imagen' => '/upload/img/plano2.jpg', 'created_at' => '2025-04-05 06:47:05', 'updated_at' => '2025-04-05 06:47:05']);
        DB::table('planos')->insert(['id' => 3, 'usuario_id' => 2, 'titulo' => 'Plano 3', 'imagen' => '/upload/img/plano3.jpg', 'created_at' => '2025-04-05 06:47:05', 'updated_at' => '2025-04-05 06:47:05']);
        DB::table('productos')->insert(['id' => 1, 'nombre' => 'Producto A', 'descripcion' => 'Descripción A', 'imagen' => '/upload/img/productoA.png', 'documento' => '/upload/document/producto_a.pdf', 'created_at' => '2025-04-05 06:47:05', 'updated_at' => '2025-04-05 06:47:05']);
        DB::table('productos')->insert(['id' => 2, 'nombre' => 'Producto B', 'descripcion' => 'Descripción B', 'imagen' => '/upload/img/productoB.png', 'documento' => '/upload/document/producto_b.pdf', 'created_at' => '2025-04-05 06:47:05', 'updated_at' => '2025-04-05 06:47:05']);
        DB::table('productos')->insert(['id' => 3, 'nombre' => 'Producto C', 'descripcion' => 'Descripción C', 'imagen' => '/upload/img/productoC.png', 'documento' => '/upload/document/producto_c.pdf', 'created_at' => '2025-04-05 06:47:05', 'updated_at' => '2025-04-05 06:47:05']);
        DB::table('producto_usuario')->insert(['id' => 1, 'usuario_id' => 1, 'producto_id' => 1]);
        DB::table('producto_usuario')->insert(['id' => 2, 'usuario_id' => 1, 'producto_id' => 3]);
        DB::table('producto_usuario')->insert(['id' => 3, 'usuario_id' => 2, 'producto_id' => 2]);
        DB::table('producto_usuario')->insert(['id' => 5, 'usuario_id' => 5, 'producto_id' => 2]);
        DB::table('producto_usuario')->insert(['id' => 6, 'usuario_id' => 5, 'producto_id' => 1]);
        DB::table('proyectos')->insert(['id' => 1, 'nombre' => 'Proyecto Solar', 'carpeta' => 'proyecto_solar', 'created_at' => '2025-04-07 09:31:48', 'updated_at' => '2025-04-07 09:31:48']);
        DB::table('proyectos')->insert(['id' => 2, 'nombre' => 'Proyecto Alpha', 'carpeta' => 'proyecto_alpha', 'created_at' => '2025-04-24 11:44:53', 'updated_at' => '2025-04-24 11:44:53']);
        DB::table('proyectos')->insert(['id' => 3, 'nombre' => 'Proyecto Beta', 'carpeta' => 'proyecto_beta', 'created_at' => '2025-04-24 11:44:53', 'updated_at' => '2025-04-24 11:44:53']);
        DB::table('proyectos')->insert(['id' => 4, 'nombre' => 'Edu', 'carpeta' => 'edu', 'created_at' => '2025-04-24 09:59:59', 'updated_at' => '2025-04-24 09:59:59']);
        DB::table('proyectos')->insert(['id' => 5, 'nombre' => 'Practica', 'carpeta' => 'practica', 'created_at' => '2025-05-07 06:12:27', 'updated_at' => '2025-05-07 06:12:27']);
        DB::table('proyectos')->insert(['id' => 6, 'nombre' => 'Practica2', 'carpeta' => 'practica2', 'created_at' => '2025-05-07 06:14:25', 'updated_at' => '2025-05-07 06:14:25']);
        DB::table('proyecto_usuario')->insert(['id' => 1, 'proyecto_id' => 1, 'usuario_id' => 1, 'created_at' => '2025-04-07 09:31:54', 'updated_at' => '2025-04-07 09:31:54']);
        DB::table('proyecto_usuario')->insert(['id' => 2, 'proyecto_id' => 1, 'usuario_id' => 1, 'created_at' => '2025-04-24 11:45:03', 'updated_at' => '2025-04-24 11:45:03']);
        DB::table('proyecto_usuario')->insert(['id' => 3, 'proyecto_id' => 1, 'usuario_id' => 2, 'created_at' => '2025-04-24 11:45:03', 'updated_at' => '2025-04-24 11:45:03']);
        DB::table('proyecto_usuario')->insert(['id' => 4, 'proyecto_id' => 2, 'usuario_id' => 1, 'created_at' => '2025-04-24 11:45:03', 'updated_at' => '2025-04-24 11:45:03']);
        DB::table('proyecto_usuario')->insert(['id' => 5, 'proyecto_id' => 4, 'usuario_id' => 5, 'created_at' => '2025-05-05 08:29:32', 'updated_at' => '2025-05-05 08:29:32']);
        DB::table('proyecto_usuario')->insert(['id' => 6, 'proyecto_id' => 4, 'usuario_id' => 4, 'created_at' => '2025-05-07 06:05:18', 'updated_at' => '2025-05-07 06:05:18']);
        DB::table('usuarios')->insert(['id' => 1, 'username' => 'eduu', 'password' => '$2y$10$76KF1qNKTP7rk2Qbgz.9duyjkqCjkH4VUgjkHLE8RCRbgyX8YjUGa', 'alias' => 'Edu', 'tipo' => 'admin', 'created_at' => '2025-04-05 06:47:05', 'updated_at' => '2025-04-05 06:47:05', 'activo' => 1]);
        DB::table('usuarios')->insert(['id' => 2, 'username' => 'jdoe', 'password' => '$2y$10$NtrUx.A7M8yEkygP/zFGh.USCE/ieK3Ad1ghjUJW8Sxa8KbDsEoWa', 'alias' => 'Juan', 'tipo' => 'user', 'created_at' => '2025-04-05 06:47:05', 'updated_at' => '2025-04-05 06:47:05', 'activo' => 1]);
        DB::table('usuarios')->insert(['id' => 3, 'username' => 'amora', 'password' => '$2y$10$Sy/BglmCyaE5fteGRmCBZeoj9nVuyAQVnDoGsHvhfSKPRVsUdJOGy', 'alias' => 'Ana', 'tipo' => 'user', 'created_at' => '2025-04-05 06:47:05', 'updated_at' => '2025-04-05 06:47:05', 'activo' => 1]);
        DB::table('usuarios')->insert(['id' => 4, 'username' => 'admin1', 'password' => '$2y$10$czPK7xWsyRT7pr20D104ieG03PFKGMhrx9zPhCpY38NToSgVUJHRC', 'alias' => 'Administrador', 'tipo' => 'admin', 'created_at' => '2025-04-05 06:47:05', 'updated_at' => '2025-04-05 06:47:05', 'activo' => 1]);
        DB::table('usuarios')->insert(['id' => 5, 'username' => 'sisenolUser', 'password' => '$2y$10$gne9lvfCHCxH2RQqYgseUuklg1kehEFxBLRLTIuUX7Rad9hYrrU1m', 'alias' => 'el duro', 'tipo' => 'user', 'created_at' => null, 'updated_at' => null, 'activo' => 1]);
    }
}

