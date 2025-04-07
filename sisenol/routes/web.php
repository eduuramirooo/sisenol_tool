<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

// Login
Route::get('/formulario', [LoginController::class, 'formulario'])->name('login.formulario');
Route::post('/recibir', [LoginController::class, 'recibir'])->name('login.recibir');
Route::get('/logout', [LoginController::class, 'logout'])->name('login.logout');

// Ruta protegida con verificación de sesión manual
Route::middleware('check.session')->group(function () {
    Route::get('/dashboard', [ProductoController::class, 'dashboard'])->name('dashboard');
    Route::get('/productos', [ProductoController::class, 'productos'])->name('producto.lista');
    Route::get('/instalacion', [ProductoController::class, 'instalacion'])->name('producto.instalacion');
    Route::get('/notas', [ProductoController::class, 'notas'])->name('producto.notas');
    Route::get('/descargar/{id}', [ProductoController::class, 'descargar'])->name('producto.descargar');
});
Route::post('/admin/asignar-producto', [AdminController::class, 'asignarProducto'])->name('admin.asignarProducto');


Route::middleware(['check.session'])->group(function () {
    Route::get('/admin', [AdminController::class, 'menu'])->name('admin.menu');
    Route::post('/admin/registrar-usuario', [AdminController::class, 'registrarUsuario'])->name('admin.registrarUsuario');
    Route::post('/admin/actualizar-documento', [AdminController::class, 'actualizarDocumento'])->name('admin.actualizarDocumento');
    Route::post('/admin/actualizar-nota', [AdminController::class, 'actualizarNota'])->name('admin.actualizarNota');
    Route::post('/admin/crear-producto', [AdminController::class, 'crearProducto'])->name('admin.crearProducto');
    Route::get('/archivos-proyecto', [ProductoController::class, 'mostrarArchivosProyecto'])->name('proyecto.archivos');
    Route::get('/admin/usuario/{id}/editar', [AdminController::class, 'editarUsuarioForm'])->name('admin.editarUsuarioForm');
    Route::post('/admin/usuario/{id}/actualizar', [AdminController::class, 'actualizarUsuario'])->name('admin.actualizarUsuario');
    Route::post('/admin/usuario/{id}/eliminar', [AdminController::class, 'eliminarUsuario'])->name('admin.eliminarUsuario');
    Route::post('/admin/activar-usuario/{id}', [AdminController::class, 'activarUsuario'])->name('admin.activarUsuario');

});



