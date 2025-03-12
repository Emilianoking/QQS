<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespuestasUsuarioTable extends Migration
{
    public function up()
    {
        Schema::create('respuestas_usuario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_usuario')->constrained('usuarios')->onDelete('cascade');
            $table->foreignId('id_pregunta')->constrained('preguntas')->onDelete('cascade');
            $table->foreignId('id_respuesta')->constrained('respuestas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('respuestas_usuario');
    }
}