<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id'=> 1,
            'unique_id'=>Str::uuid(),
            'first_name'=>'Shadow',
            'last_name' =>'User',
            'username' =>'shadow.user',
            'user_slug' =>'shadow-user',
            'user_status'=>1,
            'country_code'=>31,
            'country_short_code' =>'NL',
            'mobile'=>101234567,
            'user_type'=>'normal',
            'user_api_token'=>'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMzA2MjlmNDZjNmViNTNhYzA5NGU2NjA5NjdmZjIwMWM0YTc4YWYwNGNhNWJjNjUwMTcyMGQ2MjBmY2IxYmM1YmZjZjUxNGQ3N2EzYzdkZDYiLCJpYXQiOjE2Mjg3NjI3NzkuOTUwMjU3LCJuYmYiOjE2Mjg3NjI3NzkuOTUwMjYyLCJleHAiOjE2NjAyOTg3NzkuOTM0MjUzLCJzdWIiOiIiLCJzY29wZXMiOltdfQ.JcT3xuSaepwzFCHOUHhJx3o2wZOU4rqphKObv1n7eAgUT3SqAKV-yVR33UxfEhrKPkwKnUL_cnZaH6rCVs1F3YecI-lR9NQvKa29wNmI5ry_q4SPA2Po4aqaYL_na-ERHfRt1nErymOhUOL79shs0oJj5JHrPB07xeIzrHWvB1OuAdgKzOPpgy88K_8nY-yrlL1xVspZMas7M9-6QG_TbkG2G3n4lKusCaRvVHVdyVPNOrlMFmSdS9li6jpr6B5NByH9yx1GL7f1JsqqfgJabvk4IT6WmDKQw3X3ZSPUJS914wNAbqo8tE8JVFU343rGlx2JlXs-QVN8yPLC62kPsZi1lGtAg5vuGHleQm7-4myTkig4Swj_EiZQaesUsl1odUdwZkkaypWumdGIV9Tz6EKOxskV-HY6TKr2v7vdl-kAZes5wYEIzRalSR4Q2mqhYmsM_kbtBRfTKA4fKwjRMxfaoYBnq3Bpl9uk-puiByQfxmRwg8tWFlDtJj6-HlniKUni9qJ3yNVRDJ99iU3zkeiLT61-z_F8-otqEmOBlZvWpFq1Ig1einsft0-egu6dqU19elRSA8u4SzNQAF-P2rsZ5g6Ip9btUwf6FOOMOxx1fyFGVSVu7Ai1NWORBmMtT09cyyd09dfZr1kBS8NbInlR1pNg-RoqoKLgUp9c_WI',
            'email' => 'shadow@shadowis.nl',
            'email_verified_at'=>now(),
            'password' => Hash::make('admin@123'),
            'accept_email' => 1,
            'terms_conditions' =>1,
            'created_at'=>now(),
            'updated_at'=>now(),

        ]);
    }
}
