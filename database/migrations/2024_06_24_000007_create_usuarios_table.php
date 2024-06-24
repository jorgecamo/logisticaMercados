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
            $table->increments('Id_usuario');
            $table->string('DNI', 10)->unique();
            $table->string('nombre', 50);
            $table->unsignedInteger('Id_rol');
            $table->integer('telefono');
            $table->string('contrasenya', 150);
            $table->unsignedInteger('Id_mercado');
            $table->tinyInteger('baja');
            $table->timestamps();

            $table->primary(['Id_usuario', 'DNI']);
            $table->foreign('Id_mercado')->references('Id_mercado')->on('mercados')->onDelete('cascade');
            $table->foreign('Id_rol')->references('Id_rol')->on('roles')->onDelete('cascade');
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
