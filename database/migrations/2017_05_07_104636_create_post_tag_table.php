<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('blog_post_tag', function (Blueprint $table) {
          $table->increments('id');

          $table->integer('post_id')->unsigned();
          $table->foreign('post_id')->references('id')->on('posts');// posts table

          $table->integer('tag_id')->unsigned();
          $table->foreign('tag_id')->references('id')->on('tags');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_post_tag');
    }
}
