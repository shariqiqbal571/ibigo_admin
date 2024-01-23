<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FilterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('filters')->delete();
        DB::table('filters')->insert([
            [
                'id' => 1,
                'name' => 'City',
                'slug' => Str::slug('city','-'),
                'unique_id' => Str::uuid(),
                'type' => 'text',
                'status' => 1,
                'category' => 'address',
            ],
            [
                'id' => 2,
                'name' => 'Girls Night out',
                'slug' => Str::slug('Girls Night out','-'),
                'unique_id' => Str::uuid(),
                'type' => 'checkbox',
                'status' => 1,
                'category' => 'who',
            ],
            [
                'id' => 3,
                'name' => 'Outing with the boys',
                'slug' => Str::slug('Outing with the boys','-'),
                'unique_id' => Str::uuid(),
                'type' => 'checkbox',
                'status' => 1,
                'category' => 'who',
            ],
            [
                'id' => 4,
                'name' => 'Date Junior Kids',
                'slug' => Str::slug('Date Junior Kids','-'),
                'unique_id' => Str::uuid(),
                'type' => 'checkbox',
                'status' => 1,
                'category' => 'who',
            ],
            [
                'id' => 5,
                'name' => 'Spot',
                'slug' => Str::slug('Spot','-'),
                'unique_id' => Str::uuid(),
                'type' => 'checkbox',
                'status' => 1,
                'category' => 'what',
            ],
            [
                'id' => 6,
                'name' => 'Event',
                'slug' => Str::slug('Event','-'),
                'unique_id' => Str::uuid(),
                'type' => 'checkbox',
                'status' => 1,
                'category' => 'what',
            ],
            [
                'id' => 7,
                'name' => 'From',
                'slug' => Str::slug('From','-'),
                'unique_id' => Str::uuid(),
                'type' => 'datetime-local',
                'status' => 1,
                'category' => 'when',
            ],
            [
                'id' => 8,
                'name' => 'To',
                'slug' => Str::slug('To','-'),
                'unique_id' => Str::uuid(),
                'type' => 'datetime-local',
                'status' => 1,
                'category' => 'when',
            ],
            [
                'id' => 9,
                'name' => 'This weekend',
                'slug' => Str::slug('This weekend','-'),
                'unique_id' => Str::uuid(),
                'type' => 'radio',
                'status' => 1,
                'category' => 'when',
            ],
            [
                'id' => 10,
                'name' => 'This week',
                'slug' => Str::slug('This week','-'),
                'unique_id' => Str::uuid(),
                'type' => 'radio',
                'status' => 1,
                'category' => 'when',
            ],
            [
                'id' => 11,
                'name' => 'This month',
                'slug' => Str::slug('This month','-'),
                'unique_id' => Str::uuid(),
                'type' => 'radio',
                'status' => 1,
                'category' => 'when',
            ],
            [
                'id' => 12,
                'name' => 'Food and Drinks',
                'slug' => Str::slug('Food and Drinks','-'),
                'unique_id' => Str::uuid(),
                'type' => 'checkbox',
                'status' => 1,
                'category' => 'categorieen',
            ],
            [
                'id' => 13,
                'name' => 'Theatre',
                'slug' => Str::slug('Theatre','-'),
                'unique_id' => Str::uuid(),
                'type' => 'checkbox',
                'status' => 1,
                'category' => 'categorieen',
            ],
            [
                'id' => 14,
                'name' => 'Games and Competitie',
                'slug' => Str::slug('Games and Competitie','-'),
                'unique_id' => Str::uuid(),
                'type' => 'checkbox',
                'status' => 1,
                'category' => 'categorieen',
            ],
            [
                'id' => 15,
                'name' => 'Shopping',
                'slug' => Str::slug('Shopping','-'),
                'unique_id' => Str::uuid(),
                'type' => 'checkbox',
                'status' => 1,
                'category' => 'categorieen',
            ],
            [
                'id' => 16,
                'name' => 'Clubs',
                'slug' => Str::slug('Clubs','-'),
                'unique_id' => Str::uuid(),
                'type' => 'checkbox',
                'status' => 1,
                'category' => 'categorieen',
            ],
            [
                'id' => 17,
                'name' => 'Valentine Day',
                'slug' => Str::slug('Valentine Day','-'),
                'unique_id' => Str::uuid(),
                'type' => 'checkbox',
                'status' => 1,
                'category' => 'specials',
            ],
            [
                'id' => 18,
                'name' => 'Christmas',
                'slug' => Str::slug('Christmas','-'),
                'unique_id' => Str::uuid(),
                'type' => 'checkbox',
                'status' => 1,
                'category' => 'specials',
            ],
            [
                'id' => 19,
                'name' => 'Easter',
                'slug' => Str::slug('Easter','-'),
                'unique_id' => Str::uuid(),
                'type' => 'checkbox',
                'status' => 1,
                'category' => 'specials',
            ],
            [
                'id' => 20,
                'name' => 'Ibi Blog',
                'slug' => Str::slug('Ibi Blog','-'),
                'unique_id' => Str::uuid(),
                'type' => 'checkbox',
                'status' => 1,
                'category' => 'specials',
            ],
        ]);
    }
}
