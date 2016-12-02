<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTagsTable extends Migration {

    public function up()
    {
        Schema::create('tags', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->index();
            $table->integer('uses')->default('1');
        });
    }

    public function down()
    {
        Schema::drop('tags');
    }
}