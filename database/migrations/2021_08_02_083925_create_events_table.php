<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('event_title');
            $table->string('event_slug');
            $table->string('event_unique_id')->unique();
            $table->string('event_category')->nullable();
            $table->text('event_cover')->nullable();
            $table->biginteger('user_id')->nullable();
            $table->biginteger('group_id')->nullable();
            $table->datetime('start_date_time');
            $table->datetime('end_date_time');
            $table->longtext('event_description')->nullable();
            $table->string('event_location');
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
        Schema::dropIfExists('events');
    }
}
