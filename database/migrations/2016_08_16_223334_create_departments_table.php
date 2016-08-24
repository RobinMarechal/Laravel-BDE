<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDepartmentsTable extends Migration {

	public function up()
	{
		Schema::create('departments', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 255)->index();
			$table->string('short_name', 10);
		});
	}

	public function down()
	{
		Schema::drop('departments');
	}
}