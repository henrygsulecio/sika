<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsercodeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_code', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned();
			$table->integer('code_id')->unsigned();
			$table->timestamp('created_at');
			$table->primary(array('user_id', 'code_id'));
			$table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
			$table->foreign('code_id')->references('id')->on('code')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_code');
	}

}
