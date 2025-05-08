<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proyectos', function (Blueprint $table) {
            $table->integer('id');
            $table->string('nombre', 255);
            $table->string('carpeta', 255);
            $table->string(')')  // Tipo original: engine=innodb->nullable();
            // Error procesando: --
            $table->string('--')  // Tipo original: volcado->nullable();
            // Error procesando: --
            $table->integer('INSERT')->nullable();
            $table->string('(1,')  // Tipo original: 'proyecto->nullable();
            $table->string('(2,')  // Tipo original: 'proyecto->nullable();
            $table->string('(3,')  // Tipo original: 'proyecto->nullable();
            $table->string('(4,')  // Tipo original: 'edu',->nullable();
            $table->string('(5,')  // Tipo original: 'practica',->nullable();
            $table->string('(6,')  // Tipo original: 'practica2',->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proyectos');
    }
};
