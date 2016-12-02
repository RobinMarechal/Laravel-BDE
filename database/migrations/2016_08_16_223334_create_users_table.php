<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
			$table->softDeletes();
            $table->rememberToken();
			$table->string('first_name', 255);
			$table->string('last_name', 255);
			$table->string('password', 60);
			$table->tinyInteger('level')->unsigned()->index()->default('1');
			$table->string('email', 255)->unique();
			$table->tinyInteger('school_year')->nullable();
			$table->integer('department_id')->unsigned()->default('1');
			$table->boolean('validated')->default(1);
		});
	}

	public function down()
	{
		Schema::drop('users');
	}
}