<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventTeamTable extends Migration {

	public function up()
	{
		Schema::create('event_team', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('event_id')->unsigned();
			$table->integer('team_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('event_team');
	}
}