<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('users', function(Blueprint $table) {
			$table->foreign('department_id')->references('id')->on('departments')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('teams', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('team_user', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('team_user', function(Blueprint $table) {
			$table->foreign('team_id')->references('id')->on('teams')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('news', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('no action');
		});
		Schema::table('events', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('event_team', function(Blueprint $table) {
			$table->foreign('event_id')->references('id')->on('events')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('event_team', function(Blueprint $table) {
			$table->foreign('team_id')->references('id')->on('teams')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('news_team', function(Blueprint $table) {
			$table->foreign('team_id')->references('id')->on('teams')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('news_team', function(Blueprint $table) {
			$table->foreign('news_id')->references('id')->on('news')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::table('users', function(Blueprint $table) {
			$table->dropForeign('users_department_id_foreign');
		});
		Schema::table('teams', function(Blueprint $table) {
			$table->dropForeign('teams_user_id_foreign');
		});
		Schema::table('team_user', function(Blueprint $table) {
			$table->dropForeign('team_user_user_id_foreign');
		});
		Schema::table('team_user', function(Blueprint $table) {
			$table->dropForeign('team_user_team_id_foreign');
		});
		Schema::table('news', function(Blueprint $table) {
			$table->dropForeign('news_user_id_foreign');
		});
		Schema::table('events', function(Blueprint $table) {
			$table->dropForeign('events_user_id_foreign');
		});
		Schema::table('event_team', function(Blueprint $table) {
			$table->dropForeign('event_team_event_id_foreign');
		});
		Schema::table('event_team', function(Blueprint $table) {
			$table->dropForeign('event_team_team_id_foreign');
		});
		Schema::table('news_team', function(Blueprint $table) {
			$table->dropForeign('news_team_team_id_foreign');
		});
		Schema::table('news_team', function(Blueprint $table) {
			$table->dropForeign('news_team_news_id_foreign');
		});
	}
}