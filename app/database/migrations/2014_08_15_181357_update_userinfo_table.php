<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserinfoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE user_info " .
			"MODIFY firstname VARCHAR(255) NULL," .
			"MODIFY lastname VARCHAR(255) NULL," .
			"MODIFY email VARCHAR(255) NULL," .
			"MODIFY dpi VARCHAR(255) NULL," .
			"MODIFY birthday DATE NULL," .
			"MODIFY license VARCHAR(255) NULL," .
			"MODIFY vehicle VARCHAR(255) NULL," .
			"MODIFY workplace VARCHAR(255) NULL");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("ALTER TABLE user_info " .
			"MODIFY firstname VARCHAR(255) NOT NULL," .
			"MODIFY lastname VARCHAR(255) NOT NULL," .
			"MODIFY email VARCHAR(255) NOT NULL," .
			"MODIFY dpi VARCHAR(255) NOT NULL," .
			"MODIFY birthday DATE NOT NULL," .
			"MODIFY license VARCHAR(255) NOT NULL," .
			"MODIFY vehicle VARCHAR(255) NOT NULL," .
			"MODIFY workplace VARCHAR(255) NOT NULL");
	}



}
