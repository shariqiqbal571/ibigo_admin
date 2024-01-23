<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpots extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spots', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('street_no')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('city')->nullable();
            $table->text('spot_profile')->nullable();
            $table->text('spot_cover')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('business_name')->nullable();
            $table->longtext('short_description')->nullable();
            $table->text('parking_details')->nullable();
            $table->string('place_id')->nullable();
            $table->string('rating')->nullable();
            $table->string('user_total_rating')->nullable();
            $table->string('business_type');
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
        Schema::dropIfExists('spots');
    }
}
