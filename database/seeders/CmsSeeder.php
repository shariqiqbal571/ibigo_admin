<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('c_m_s')->delete();
        DB::table('c_m_s')->insert([
            [
                'id' => 1,
                'title'=>'Over Ibigo',
                'unique_id'=>Str::uuid(),
                'slug'=>Str::slug('Over Ibigo','-'),
                'image'=>'over-ibigo.jpg',
                'created_at'=>now(),
                'updated_at'=>now(),
            ],
            [
                'id' => 2,
                'title'=>'Over ons',
                'unique_id'=>Str::uuid(),
                'slug'=>Str::slug('Over ons','-'),
                'image'=>'over-ons.jpg',
                'created_at'=>now(),
                'updated_at'=>now(),
            ],
            [
                'id' => 3,
                'title'=>'Adverteren',
                'unique_id'=>Str::uuid(),
                'slug'=>Str::slug('Adverteren','-'),
                'image'=>'adverteren.jpg',
                'created_at'=>now(),
                'updated_at'=>now(),
            ],
            [
                'id' => 4,
                'title'=>'FAQ',
                'unique_id'=>Str::uuid(),
                'slug'=>Str::slug('FAQ','-'),
                'image'=>'faq.jpg',
                'created_at'=>now(),
                'updated_at'=>now(),
            ],
            [
                'id' => 5,
                'title'=>'Contact & verbetersuggesties',
                'unique_id'=>Str::uuid(),
                'slug'=>Str::slug('Contact and verbetersuggesties','-'),
                'image'=>'contact.jpg',
                'created_at'=>now(),
                'updated_at'=>now(),
            ],
            [
                'id' => 6,
                'title'=>'Privacy & Gebruikersvoorwaarden',
                'unique_id'=>Str::uuid(),
                'slug'=>Str::slug('Privacy and Gebruikersvoorwaarden','-'),
                'image'=>'privacy.jpg',
                'created_at'=>now(),
                'updated_at'=>now(),
            ],
        ]);
    }
}
