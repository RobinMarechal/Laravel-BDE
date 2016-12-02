<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewsTable extends Migration {

	public function up()
	{
		Schema::create('news', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
			$table->softDeletes();
			$table->timestamp('published_at')->index()->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->string('title', 255);
			$table->integer('user_id')->unsigned();
			$table->text('content');
			$table->boolean('validated')->default(1);
			$table->integer('team_id')->unsigned()->index()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('news');
	}
}