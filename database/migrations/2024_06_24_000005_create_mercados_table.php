<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMercadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mercados', function (Blueprint $table) {
            $table->increments('Id_mercado');
            $table->string('nombre', 50);
            $table->unsignedInteger('Id_localidad');
            $table->string('direccion', 200);
            $table->boolean('baja');
            $table->timestamps();
            
            $table->primary('Id_mercado');
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
        Schema::dropIfExists('mercados');
    }
}


