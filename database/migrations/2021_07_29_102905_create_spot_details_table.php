<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpotDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spot_details', function (Blueprint $table) {
            $table->id();
            $table->biginteger('spot_id')->nullable();
            $table->biginteger('user_id')->nullable();
            $table->string('rating')->nullable();
            $table->longtext('review')->nullable();
            $table->integer('connected')->nullable();
            $table->integer('like')->nullable();
            $table->datetime('review_date_time')->nullable();
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
        Schema::dropIfExists('spot_details');
    }
}
