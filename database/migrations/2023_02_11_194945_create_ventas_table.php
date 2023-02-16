<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->double('precioTotal');
            $table->date('fechaV');

            //llave foranea de salapelicula
            $table->foreignId('sala_pelicula_id')
            ->constrained('sala_peliculas')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();
            //llave foranea de usuario
            $table->foreignId('usuario_id')
            ->constrained('usuarios')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            //llave foranea de cliente
            $table->foreignId('cliente_id')
            ->constrained('clientes')
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
        Schema::dropIfExists('ventas');
    }
}
