<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventsTable extends Migration {

	public function up()
	{
		Schema::create('events', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
			$table->softDeletes();
			$table->timestamp('start')->index()->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('end')->index()->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->string('name', 255);
			$table->integer('user_id')->unsigned();
			$table->boolean('validated')->default(1);
			$table->text('article');
			$table->integer('team_id')->unsigned()->index()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('events');
	}
}