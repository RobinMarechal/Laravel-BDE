<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTeamsTable extends Migration {

	public function up()
	{
		Schema::create('teams', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('name', 255);
			$table->text('article');
			$table->boolean('validated')->index();
			$table->integer('user_id')->unsigned()->index();
		});
	}

	public function down()
	{
		Schema::drop('teams');
	}
}