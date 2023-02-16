<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaPeliculasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sala_peliculas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->time('horaI');
            $table->time('horaF');
            //llave foranea de pelicula
            $table->foreignId('pelicula_id')
            ->constrained('peliculas')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();
            //llave foranea de sala
            $table->foreignId('sala_id')
            ->constrained('salas')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sala_peliculas');
    }
}
