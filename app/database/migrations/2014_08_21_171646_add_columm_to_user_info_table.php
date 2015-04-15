<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColummToUserInfoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('user_info', function(Blueprint $table)
		{
			$table->string('location', 255)->nullable();
			$table->integer('tons')->unsigned()->nullable();
			$table->longText('comments', 3000)->nullable();
			
			//
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('user_info', function(Blueprint $table)
		{

			$table->dropColumn('location');
			$table->dropColumn('tons');
			$table->dropColumn('comments');
			
			//
		});
	}

}
