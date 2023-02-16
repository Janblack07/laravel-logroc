<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoletoSalasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boleto_salas', function (Blueprint $table) {
            $table->id();
            $table->integer('numeroAsientos');
            $table->boolean('estado');
            //llave foranea de salapelicula
            $table->foreignId('sala_pelicula_id')
            ->constrained('sala_peliculas')
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
        Schema::dropIfExists('boleto_salas');
    }
}
