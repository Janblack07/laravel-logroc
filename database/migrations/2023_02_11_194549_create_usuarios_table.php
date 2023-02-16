<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombreU');
            $table->string('apellidoU');
            $table->string('cedulaU')->unique();
            $table->string('correoU')->unique();
            $table->string('passwordU');

            //foranea de roles
            $table->foreignId('rol_id')
            ->constrained('rols')
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
        Schema::dropIfExists('usuarios');
    }
}
