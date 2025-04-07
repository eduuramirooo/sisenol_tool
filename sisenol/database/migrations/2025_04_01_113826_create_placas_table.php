<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacasTable extends Migration
{
    public function up()
    {
        Schema::create('placas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained()->onDelete('cascade'); // Relación con productos
            $table->string('tipo_panel');
            $table->integer('potencia');
            $table->float('peso');
            $table->date('fecha_instalacion');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('placas');
    }
}

