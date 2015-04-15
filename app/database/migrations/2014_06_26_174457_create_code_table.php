<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('code', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('code_type_id')->unsigned();
			$table->string('code', 20)->unique();
			$table->timestamp('created_at');
			$table->index('code_type_id');
			$table->foreign('code_type_id')->references('id')->on('code_type')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('code');
	}

}
