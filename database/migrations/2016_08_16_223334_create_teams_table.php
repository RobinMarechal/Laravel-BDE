<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTeamsTable extends Migration {

	public function up()
	{
		Schema::create('teams', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
			$table->softDeletes();
			$table->string('name', 255);
			$table->text('article');
			$table->boolean('validated')->default(1)->index();
			$table->integer('user_id')->unsigned()->index();
			$table->string('slug', 255)->unique();
		});
	}

	public function down()
	{
		Schema::drop('teams');
	}
}