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
		Schema::table('events', function(Blueprint $table) {
			$table->foreign('team_id')->references('id')->on('teams')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('news', function(Blueprint $table) {
			$table->foreign('team_id')->references('id')->on('teams')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('contents', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('set null')
						->onCascade('set null');
		});
		Schema::table('content_records', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('set null')
						->onCascade('set null');
		});
		Schema::table('notifications', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('pictures', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('pictures', function(Blueprint $table) {
			$table->foreign('team_id')->references('id')->on('teams')
						->onDelete('set null')
						->onUpdate('set null');
		});
		Schema::table('pictures', function(Blueprint $table) {
			$table->foreign('event_id')->references('id')->on('events')
						->onDelete('set null')
						->onUpdate('set null');
		});
		Schema::table('pictures', function(Blueprint $table) {
			$table->foreign('news_id')->references('id')->on('news')
						->onDelete('set null')
						->onUpdate('set null');
		});
		Schema::table('picture_tag', function(Blueprint $table) {
			$table->foreign('picture_id')->references('id')->on('pictures')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('picture_tag', function(Blueprint $table) {
			$table->foreign('tag_id')->references('id')->on('tags')
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
		Schema::table('events', function(Blueprint $table) {
			$table->dropForeign('events_team_id_foreign');
		});
		Schema::table('news', function(Blueprint $table) {
			$table->dropForeign('news_team_id_foreign');
		});
		Schema::table('contents', function(Blueprint $table) {
			$table->dropForeign('contents_user_id_foreign');
		});
		Schema::table('content_records', function(Blueprint $table) {
			$table->dropForeign('content_records_user_id_foreign');
		});
		Schema::table('notifications', function(Blueprint $table) {
			$table->dropForeign('notifications_user_id_foreign');
		});
		Schema::table('pictures', function(Blueprint $table) {
			$table->dropForeign('pictures_user_id_foreign');
		});
		Schema::table('pictures', function(Blueprint $table) {
			$table->dropForeign('pictures_team_id_foreign');
		});
		Schema::table('pictures', function(Blueprint $table) {
			$table->dropForeign('pictures_event_id_foreign');
		});
		Schema::table('pictures', function(Blueprint $table) {
			$table->dropForeign('pictures_news_id_foreign');
		});
		Schema::table('picture_tag', function(Blueprint $table) {
			$table->dropForeign('picture_tag_picture_id_foreign');
		});
		Schema::table('picture_tag', function(Blueprint $table) {
			$table->dropForeign('picture_tag_tag_id_foreign');
		});
	}
}