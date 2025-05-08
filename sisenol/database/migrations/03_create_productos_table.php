<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->integer('id');
            $table->string('nombre', 100)->nullable();
            $table->text('descripcion')->nullable();
            $table->string('imagen', 255)->nullable();
            $table->string('documento', 255)->nullable();
            $table->string(')')  // Tipo original: engine=innodb->nullable();
            // Error procesando: --
            $table->string('--')  // Tipo original: volcado->nullable();
            // Error procesando: --
            $table->integer('INSERT')->nullable();
            $table->string('(1,')  // Tipo original: 'producto->nullable();
            $table->string('(2,')  // Tipo original: 'producto->nullable();
            $table->string('(3,')  // Tipo original: 'producto->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
