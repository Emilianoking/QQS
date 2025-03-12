<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('email')->unique();
            $table->string('telefono', 20)->nullable();
            $table->string('grado', 50)->nullable();
            $table->string('password');
            $table->string('avatar')->default('https://i.postimg.cc/JzBWVhW4/my-avatar.png');
            $table->enum('rol', ['estudiante', 'administrador'])->default('estudiante');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}