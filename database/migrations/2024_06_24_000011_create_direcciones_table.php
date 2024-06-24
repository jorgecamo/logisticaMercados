<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDireccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direcciones', function (Blueprint $table) {
            $table->increments('Id_direcciones');
            $table->string('direcciones', 200);
            $table->unsignedInteger('Id_cliente');
            $table->unsignedInteger('Id_localidad');
            $table->timestamps();

            $table->primary('Id_direcciones');
            $table->foreign('Id_cliente')->references('Id_cliente')->on('clientes');
            $table->foreign('Id_localidad')->references('Id_localidad')->on('localidades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('direcciones');
    }
}
