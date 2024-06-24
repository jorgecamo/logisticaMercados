<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePuestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('puestos', function (Blueprint $table) {
            $table->increments('Id_puesto');
            $table->unsignedInteger('Id_mercado');
            $table->string('nombre', 50);
            $table->unsignedInteger('Id_usuario');
            $table->tinyInteger('baja');
            $table->timestamps();

            $table->primary(['Id_puesto', 'Id_mercado']);
            $table->foreign('Id_mercado')->references('Id_mercado')->on('mercados')->onDelete('cascade');
            $table->foreign('Id_usuario')->references('Id_usuario')->on('usuarios')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('puestos');
    }
}
