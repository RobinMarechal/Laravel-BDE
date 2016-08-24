<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewsTeamTable extends Migration {

	public function up()
	{
		Schema::create('news_team', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('team_id')->unsigned();
			$table->integer('news_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('news_team');
	}
}