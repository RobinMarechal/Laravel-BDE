<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePictureTagTable extends Migration {

    public function up()
    {
        Schema::create('picture_tag', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('picture_id')->unsigned()->index();
            $table->integer('tag_id')->unsigned()->index();
        });
    }

    public function down()
    {
        Schema::drop('picture_tag');
    }
}