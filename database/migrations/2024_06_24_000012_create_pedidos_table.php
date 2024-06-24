<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->increments('Id_pedido');
            $table->unsignedInteger('Id_usuario');
            $table->unsignedInteger('Id_cliente');
            $table->unsignedInteger('Id_direccion');
            $table->string('direccion', 200);
            $table->unsignedInteger('Id_estado');
            $table->tinyInteger('pagado');
            $table->unsignedInteger('Id_metodo_pago')->nullable();
            $table->unsignedInteger('bultos');
            $table->integer('bultos_perecederos');
            $table->datetime('fecha_pedido');
            $table->integer('total_pedido');
            $table->time('franja_horaria');
            $table->timestamps();

            $table->primary(['Id_pedido', 'Id_cliente', 'Id_usuario']);
            $table->foreign('Id_cliente')->references('Id_cliente')->on('clientes')->onDelete('cascade');
            $table->foreign('Id_usuario')->references('Id_usuario')->on('usuarios')->onDelete('cascade');
            $table->foreign('Id_direccion')->references('Id_direcciones')->on('direcciones')->onDelete('cascade');
            $table->foreign('Id_estado')->references('Id_estado')->on('estados_pedido')->onDelete('cascade');
            $table->foreign('Id_metodo_pago')->references('Id_metodo')->on('metodos_pago')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}
