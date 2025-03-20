<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarrerasTable extends Migration
{
    public function up()
    {
        Schema::create('carreras', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique(); // Nombre de la carrera (por ejemplo, "Ingeniería de Sistemas")
            $table->text('descripcion')->nullable(); // Descripción de la carrera
            $table->string('categoria')->nullable(); // Categoría (por ejemplo, "Ciencias", "Humanidades")
            $table->string('estado')->default('activa'); // Estado (activa/inactiva)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('carreras');
    }
}