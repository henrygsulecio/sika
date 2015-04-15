<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserappTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_app', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('group_id')->unsigned();
			$table->string('name', 255)->nullable();
			$table->string('user', 20)->unique();
			$table->string('password', 255);
			$table->boolean('disabled')->nullable()->default(0);
			$table->timestamps();
			$table->index('group_id');
			$table->foreign('group_id')->references('id')->on('user_app_group')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_app');
	}

}
