<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->integer('id');
            $table->string('username', 100)->nullable();
            $table->string('password', 255)->nullable();
            $table->string('alias', 100)->nullable();
            $table->string('tipo')  // Tipo original: enum('admin','user')->nullable();
            $table->integer('activo');
            $table->string(')')  // Tipo original: engine=innodb->nullable();
            // Error procesando: --
            $table->string('--')  // Tipo original: volcado->nullable();
            // Error procesando: --
            $table->integer('INSERT')->nullable();
            $table->string('(1,')  // Tipo original: 'eduu',->nullable();
            $table->string('(2,')  // Tipo original: 'jdoe',->nullable();
            $table->string('(3,')  // Tipo original: 'amora',->nullable();
            $table->string('(4,')  // Tipo original: 'admin1',->nullable();
            $table->string('(5,')  // Tipo original: 'sisenoluser',->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
