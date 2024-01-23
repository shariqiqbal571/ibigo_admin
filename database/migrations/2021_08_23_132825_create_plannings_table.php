<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plannings', function (Blueprint $table) {
            $table->id();
            $table->string('planning_title')->nullable();
            $table->longtext('planning_description')->nullable();
            $table->integer('user_id');
            $table->integer('event_id')->nullable();
            $table->integer('spot_id')->nullable();
            $table->timestamp('start_date_time')->nullable();
            $table->timestamp('end_date_time')->nullable();
            $table->integer('is_liked')->nullable();
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
        Schema::dropIfExists('plannings');
    }
}
