<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePicturesTable extends Migration {

    public function up()
    {
        Schema::create('pictures', function(Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('name', 255);
            $table->text('legend');
            $table->integer('user_id')->unsigned()->index()->default('1');
            $table->string('path', 255);
            $table->integer('team_id')->unsigned()->nullable()->index();
            $table->integer('event_id')->unsigned()->nullable()->index();
            $table->integer('news_id')->unsigned()->nullable()->index();
        });
    }

    public function down()
    {
        Schema::drop('pictures');
    }
}