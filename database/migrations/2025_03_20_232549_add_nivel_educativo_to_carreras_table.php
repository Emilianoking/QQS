<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNivelEducativoToCarrerasTable extends Migration
{
    public function up()
    {
        Schema::table('carreras', function (Blueprint $table) {
            $table->enum('nivel_educativo', ['técnico', 'tecnólogo', 'profesional'])->nullable()->after('universidad');
        });
    }

    public function down()
    {
        Schema::table('carreras', function (Blueprint $table) {
            $table->dropColumn('nivel_educativo');
        });
    }
}