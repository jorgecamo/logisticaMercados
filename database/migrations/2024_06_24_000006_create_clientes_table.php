<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('Id_cliente');
            $table->string('DNI', 10);
            $table->string('contrasenya', 200);
            $table->string('nombre', 50);
            $table->integer('telefono');
            $table->string('correo', 50);
            $table->integer('puntos');
            $table->unsignedInteger('Id_mercado');
            $table->boolean('baja');
            $table->timestamps();

            $table->primary('Id_cliente');
            $table->foreign('Id_mercado')->references('Id_mercado')->on('mercados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
