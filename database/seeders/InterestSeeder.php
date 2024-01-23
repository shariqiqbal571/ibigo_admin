<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InterestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('interests')->insert([
            [
                'title'=>'Shopping',
                'description'=>"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
                'unique_id'=>Str::uuid(),
                'icon'=>'fa fa-shopping-bag',
                'image'=>'613b532e9902agetty_522735456_249841.jpg',
                'status'=>1,
                'show_in'=>2
            ],
            [
                'title'=>'Restaurants',
                'description'=>"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
                'unique_id'=>Str::uuid(),
                'icon'=>'fa fa-apple',
                'image'=>'613b53406c241restaurants.jpg',
                'status'=>1,
                'show_in'=>2
            ],
            [
                'title'=>'Games & Competative',
                'description'=>"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
                'unique_id'=>Str::uuid(),
                'icon'=>'fa fa-gamepad',
                'image'=>'613b5354dde67China-Brefing-Chinas-New-Gaming-Regulations-What-it-Means-for-Investors.jpg',
                'status'=>1,
                'show_in'=>2
            ],
        
            ]);
    }
}
