<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPasswordsFieldToUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->string('password')->after('name');
		});

        /*
         * id

varchar(50)

name

varchar(255)

dob

date

address

varchar(255)

city

varchar(255)

bloodtype

varchar(50)

donations_fk

varchar(50)

password

varchar(255)
         *
         * */
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{

		});
	}

}