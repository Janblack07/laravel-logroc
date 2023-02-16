<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoletosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boletos', function (Blueprint $table) {
            $table->id();
             //llave foranea de venta
             $table->foreignId('venta_id')
             ->constrained('ventas')
             ->cascadeOnUpdate()
             ->cascadeOnDelete();
             //llave foranea de boletoSala
             $table->foreignId('boletosala_id')
             ->constrained('boleto_salas')
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
        Schema::dropIfExists('boletos');
    }
}
