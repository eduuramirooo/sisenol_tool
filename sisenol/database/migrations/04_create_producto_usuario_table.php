<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('producto_usuario', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('usuario_id')->nullable();
            $table->integer('producto_id')->nullable();
            $table->string(')')  // Tipo original: engine=innodb->nullable();
            // Error procesando: --
            $table->string('--')  // Tipo original: volcado->nullable();
            // Error procesando: --
            $table->integer('INSERT')->nullable();
            $table->string('(1,')  // Tipo original: 1,->nullable();
            $table->string('(2,')  // Tipo original: 1,->nullable();
            $table->string('(3,')  // Tipo original: 2,->nullable();
            $table->string('(5,')  // Tipo original: 5,->nullable();
            $table->string('(6,')  // Tipo original: 5,->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('producto_usuario');
    }
};
