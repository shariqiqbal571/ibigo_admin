<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_permissions')->delete();
        DB::table('user_permissions')->insert([
            [
                'id'=>1,
                'user_id'=>1,
                'permission_id'=>1,
                
            ],
            [
                'id'=>2,
                'user_id'=>1,
                'permission_id'=>2,
                
            ],
            [
                'id'=>3,
                'user_id'=>1,
                'permission_id'=>3,
                
            ],
            [
                'id'=>4,
                'user_id'=>1,
                'permission_id'=>4,
                
            ],
            [
                'id'=>5,
                'user_id'=>1,
                'permission_id'=>5,
                
            ],
            [
                'id'=>6,
                'user_id'=>1,
                'permission_id'=>6,
                
            ],
            [
                'id'=>7,
                'user_id'=>1,
                'permission_id'=>7,
                
            ],
            [
                'id'=>8,
                'user_id'=>1,
                'permission_id'=>8,
                
            ],
            [
                'id'=>9,
                'user_id'=>1,
                'permission_id'=>9,
                
            ],
            [
                'id'=>10,
                'user_id'=>1,
                'permission_id'=>10,
                
            ],
            [
                'id'=>11,
                'user_id'=>1,
                'permission_id'=>11,
                
            ],
            [
                'id'=>12,
                'user_id'=>1,
                'permission_id'=>12,
                
            ],
            [
                'id'=>13,
                'user_id'=>1,
                'permission_id'=>13,
                
            ],
            [
                'id'=>14,
                'user_id'=>1,
                'permission_id'=>14,
                
            ],
            [
                'id'=>15,
                'user_id'=>1,
                'permission_id'=>15,
                
            ],
            [
                'id'=>16,
                'user_id'=>1,
                'permission_id'=>16,
                
            ],
            [
                'id'=>17,
                'user_id'=>1,
                'permission_id'=>17,
                
            ],
            [
                'id'=>18,
                'user_id'=>1,
                'permission_id'=>18,
                
            ],
            [
                'id'=>19,
                'user_id'=>1,
                'permission_id'=>19,
                
            ],
            [
                'id'=>20,
                'user_id'=>1,
                'permission_id'=>20,
                
            ],
            [
                'id'=>21,
                'user_id'=>1,
                'permission_id'=>21,
                
            ],
            [
                'id'=>22,
                'user_id'=>1,
                'permission_id'=>22,
                
            ],
            [
                'id'=>23,
                'user_id'=>1,
                'permission_id'=>23,
                
            ],
            [
                'id'=>24,
                'user_id'=>1,
                'permission_id'=>24,
                
            ],
            [
                'id'=>25,
                'user_id'=>1,
                'permission_id'=>25,
                
            ],
            [
                'id'=>26,
                'user_id'=>1,
                'permission_id'=>26,
                
            ],
            [
                'id'=>27,
                'user_id'=>1,
                'permission_id'=>27,
                
            ],
            [
                'id'=>28,
                'user_id'=>1,
                'permission_id'=>28,
                
            ],
            [
                'id'=>29,
                'user_id'=>1,
                'permission_id'=>29,
                
            ],
            [
                'id'=>30,
                'user_id'=>1,
                'permission_id'=>30,
                
            ],
            [
                'id'=>31,
                'user_id'=>1,
                'permission_id'=>31,
                
            ],
            [
                'id'=>32,
                'user_id'=>1,
                'permission_id'=>32,
                
            ],
            [
                'id'=>33,
                'user_id'=>1,
                'permission_id'=>33,
                
            ],
            [
                'id'=>34,
                'user_id'=>1,
                'permission_id'=>34,
                
            ],
            [
                'id'=>35,
                'user_id'=>1,
                'permission_id'=>35,
                
            ],
            [
                'id'=>36,
                'user_id'=>1,
                'permission_id'=>36,
                
            ],
            [
                'id'=>37,
                'user_id'=>1,
                'permission_id'=>37,
                
            ],
            [
                'id'=>38,
                'user_id'=>1,
                'permission_id'=>38,
                
            ],
            [
                'id'=>39,
                'user_id'=>1,
                'permission_id'=>39,
                
            ],
            [
                'id'=>40,
                'user_id'=>1,
                'permission_id'=>40,
                
            ],
            [
                'id'=>41,
                'user_id'=>1,
                'permission_id'=>41,
                
            ],
            [
                'id'=>42,
                'user_id'=>1,
                'permission_id'=>42,
                
            ],
            [
                'id'=>43,
                'user_id'=>1,
                'permission_id'=>43,
                
            ],
            [
                'id'=>44,
                'user_id'=>1,
                'permission_id'=>44,
                
            ],
            [
                'id'=>45,
                'user_id'=>1,
                'permission_id'=>45,
                
            ],
            [
                'id'=>46,
                'user_id'=>1,
                'permission_id'=>46,
                
            ],
            [
                'id'=>47,
                'user_id'=>1,
                'permission_id'=>47,
                
            ],
            [
                'id'=>48,
                'user_id'=>1,
                'permission_id'=>48,
                
            ],
            [
                'id'=>49,
                'user_id'=>1,
                'permission_id'=>49,
                
            ],
            [
                'id'=>50,
                'user_id'=>1,
                'permission_id'=>50,
                
            ],
            [
                'id'=>51,
                'user_id'=>1,
                'permission_id'=>51,
                
            ],
            [
                'id'=>52,
                'user_id'=>1,
                'permission_id'=>52,
                
            ],
            [
                'id'=>53,
                'user_id'=>1,
                'permission_id'=>53,
                
            ],
            [
                'id'=>54,
                'user_id'=>1,
                'permission_id'=>54,
                
            ],
            [
                'id'=>55,
                'user_id'=>1,
                'permission_id'=>55,
                
            ],
            [
                'id'=>56,
                'user_id'=>1,
                'permission_id'=>56,
                
            ],
            [
                'id'=>57,
                'user_id'=>1,
                'permission_id'=>57,
                
            ],
            [
                'id'=>58,
                'user_id'=>1,
                'permission_id'=>58,
                
            ],
            [
                'id'=>59,
                'user_id'=>1,
                'permission_id'=>59,
                
            ],
            [
                'id'=>60,
                'user_id'=>1,
                'permission_id'=>60,
                
            ],
        ]);
    }
}
