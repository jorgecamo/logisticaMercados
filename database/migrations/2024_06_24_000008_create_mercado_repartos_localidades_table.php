<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMercadoRepartosLocalidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mercado_repartos_localidades', function (Blueprint $table) {
            $table->unsignedInteger('Id_mercado')->nullable();
            $table->unsignedInteger('Id_localidad')->nullable();
            $table->timestamps();
            
            $table->primary(['Id_mercado', 'Id_localidad']);
            $table->foreign('Id_mercado')->references('Id_mercado')->on('mercados')->onDelete('cascade');
            $table->foreign('Id_localidad')->references('Id_localidad')->on('localidades')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mercado_repartos_localidades');
    }
}
