<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepartidoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('repartidores', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre', 100);
			$table->string('apellido', 100);
			$table->string('ncarne', 200);
			$table->boolean('disabled')->nullable()->default(0);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('repartidores');
	}

}
