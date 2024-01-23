<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id')->unique();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('username')->unique()->nullable();
            $table->string('user_slug');
            $table->date('birth_date')->nullable();
            $table->text('user_profile')->nullable();
            $table->text('user_cover')->nullable();
            $table->longtext('user_about')->nullable();
            $table->string('city')->nullable();
            $table->text('full_address')->nullable();
            $table->integer('user_status')->nullable();
            $table->string('country_code')->nullable();
            $table->string('country_short_code')->nullable();
            $table->string('mobile')->unique()->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->string('gender')->nullable();
            $table->string('user_type');
            $table->text('user_interests')->nullable();
            $table->string('mobile_opt')->nullable();
            $table->integer('accept_email')->nullable();
            $table->integer('terms_conditions')->nullable();
            $table->text('user_api_token')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->text('reset_password_token')->nullable();
            $table->rememberToken()->nullable();
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
        Schema::dropIfExists('users');
    }
}
