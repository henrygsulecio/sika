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
			$table->string('nrutas', 100)->null;
			//$table->integer('ruta_id')->unsigned();
			$table->integer('cliente_id')->unsigned();
			$table->integer('repartidor_id')->unsigned();
			$table->string('pedido', 100);
			$table->string('direccionu', 100)->null;
			$table->string('direccion', 100)->null;
			$table->string('nfactura', 100);
			$table->string('norden', 100);
			$table->string('nhr', 100);
			$table->string('estado', 100)->null;
			$table->string('comentario', 100)->null;
			$table->string('long', 50)->null;
			$table->string('lat', 50)->null;
			$table->string('checkP', 300)->null;
			$table->string('img', 300)->null;
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
