<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_chats', function (Blueprint $table) {
            $table->id();
            $table->integer('group_id');
            $table->integer('user_id');
            $table->longtext('message')->nullable();
            $table->timestamp('message_date_time')->nullable();
            $table->tinyInteger('is_read');
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
        Schema::dropIfExists('group_chats');
    }
}
