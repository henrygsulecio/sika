<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserinfoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_info', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned();
			$table->string('firstname', 255);
			$table->string('lastname', 255);
			$table->string('email', 255);
			$table->string('dpi', 255);
			$table->date('birthday');
			$table->string('license', 255);
			$table->string('vehicle', 255);
			$table->string('workplace', 255);
			$table->primary('user_id');
			$table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_info');
	}



}
