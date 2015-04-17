<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRutasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rutas', function(Blueprint $table)
		{
			$table->increments('ruta_id')->unsigned();
			//$table->integer('ruta_id')->unsigned();
			$table->integer('cliente_id')->unsigned();
			$table->integer('repartidor_id')->unsigned();
			$table->string('pedido', 100);
			$table->timestamps();
			//$table->primary(array('ruta_id'));
            //$table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
			//$table->foreign('repartidor_id')->references('id')->on('repartidores')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('rutas');
	}
	

}
