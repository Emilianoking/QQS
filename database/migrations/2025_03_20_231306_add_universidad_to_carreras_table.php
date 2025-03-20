<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniversidadToCarrerasTable extends Migration
{
    public function up()
    {
        Schema::table('carreras', function (Blueprint $table) {
            $table->string('universidad')->nullable()->after('categoria');
        });
    }

    public function down()
    {
        Schema::table('carreras', function (Blueprint $table) {
            $table->dropColumn('universidad');
        });
    }
}