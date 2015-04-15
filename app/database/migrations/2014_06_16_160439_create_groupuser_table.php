<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupuserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('group_user', function(Blueprint $table)
		{
			$table->integer('group_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->primary(array('group_id', 'user_id'));
			$table->foreign('group_id')->references('id')->on('group')->onDelete('cascade');
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
		Schema::drop('group_user');
	}

}
