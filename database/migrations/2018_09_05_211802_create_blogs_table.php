<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('blogs')){
            Schema::create('blogs', function (Blueprint $table) {
                $table->increments('id');
                $table->text('blog_title',100);
                $table->text('blog_post');
                $table->integer('blog_upvotes')->default(0);
                $table->integer('blog_downvotes')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}
