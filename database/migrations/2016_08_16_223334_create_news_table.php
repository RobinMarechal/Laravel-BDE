<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewsTable extends Migration {

	public function up()
	{
		Schema::create('news', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('title', 255);
			$table->integer('user_id')->unsigned();
			$table->text('content');
			$table->boolean('team')->default(0);
			$table->boolean('validated')->default(1);
		});
	}

	public function down()
	{
		Schema::drop('news');
	}
}