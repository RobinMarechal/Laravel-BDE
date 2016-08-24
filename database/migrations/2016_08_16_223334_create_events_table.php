<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventsTable extends Migration {

	public function up()
	{
		Schema::create('events', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('name', 255);
			$table->integer('user_id')->unsigned();
			$table->boolean('validated');
			$table->text('article');
			$table->boolean('team')->default(0);
		});
	}

	public function down()
	{
		Schema::drop('events');
	}
}