<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->integer('post_id')->nullable();
            $table->integer('from_user_id')->nullable();
            $table->integer('to_user_id')->nullable();
            $table->integer('group_id')->nullable();
            $table->integer('invited_spot_id')->nullable();
            $table->integer('invited_group_id')->nullable();
            $table->integer('invited_event_id')->nullable();
            $table->integer('invited_planning_id')->nullable();
            $table->string('notification_type')->nullable();
            $table->timestamp('notification_time')->nullable();
            $table->integer('notification_read')->nullable();
            $table->integer('is_read')->nullable();
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
        Schema::dropIfExists('notifications');
    }
}
