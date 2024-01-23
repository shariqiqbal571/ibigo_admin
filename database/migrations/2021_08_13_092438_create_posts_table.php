<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('spot_id')->nullable();
            $table->integer('group_id')->nullable();
            $table->integer('event_id')->nullable();
            $table->string('title')->nullable();
            $table->longtext('description')->nullable();
            $table->string('shared_group_id')->nullable();
            $table->string('shared_user_id')->nullable();
            $table->string('tagged_user_id')->nullable();
            $table->integer('checkin_id')->nullable();
            $table->integer('review_id')->nullable();
            $table->integer('planning_id')->nullable();
            $table->string('spot_review')->nullable();
            $table->integer('parent_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
