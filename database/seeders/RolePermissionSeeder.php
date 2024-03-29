<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_permissions')->delete();
        DB::table('role_permissions')->insert([
            [
                'id'=>1,
                'role_id'=>1,
                'permission_id'=>1,
                
            ],
            [
                'id'=>2,
                'role_id'=>1,
                'permission_id'=>2,
                
            ],
            [
                'id'=>3,
                'role_id'=>1,
                'permission_id'=>3,
                
            ],
            [
                'id'=>4,
                'role_id'=>1,
                'permission_id'=>4,
                
            ],
            [
                'id'=>5,
                'role_id'=>1,
                'permission_id'=>5,
                
            ],
            [
                'id'=>6,
                'role_id'=>1,
                'permission_id'=>6,
                
            ],
            [
                'id'=>7,
                'role_id'=>1,
                'permission_id'=>7,
                
            ],
            [
                'id'=>8,
                'role_id'=>1,
                'permission_id'=>8,
                
            ],
            [
                'id'=>9,
                'role_id'=>1,
                'permission_id'=>9,
                
            ],
            [
                'id'=>10,
                'role_id'=>1,
                'permission_id'=>10,
                
            ],
            [
                'id'=>11,
                'role_id'=>1,
                'permission_id'=>11,
                
            ],
            [
                'id'=>12,
                'role_id'=>1,
                'permission_id'=>12,
                
            ],
            [
                'id'=>13,
                'role_id'=>1,
                'permission_id'=>13,
                
            ],
            [
                'id'=>14,
                'role_id'=>1,
                'permission_id'=>14,
                
            ],
            [
                'id'=>15,
                'role_id'=>1,
                'permission_id'=>15,
                
            ],
            [
                'id'=>16,
                'role_id'=>1,
                'permission_id'=>16,
                
            ],
            [
                'id'=>17,
                'role_id'=>1,
                'permission_id'=>17,
                
            ],
            [
                'id'=>18,
                'role_id'=>1,
                'permission_id'=>18,
                
            ],
            [
                'id'=>19,
                'role_id'=>1,
                'permission_id'=>19,
                
            ],
            [
                'id'=>20,
                'role_id'=>1,
                'permission_id'=>20,
                
            ],
            [
                'id'=>21,
                'role_id'=>1,
                'permission_id'=>21,
                
            ],
            [
                'id'=>22,
                'role_id'=>1,
                'permission_id'=>22,
                
            ],
            [
                'id'=>23,
                'role_id'=>1,
                'permission_id'=>23,
                
            ],
            [
                'id'=>24,
                'role_id'=>1,
                'permission_id'=>24,
                
            ],
            [
                'id'=>25,
                'role_id'=>1,
                'permission_id'=>25,
                
            ],
            [
                'id'=>26,
                'role_id'=>1,
                'permission_id'=>26,
                
            ],
            [
                'id'=>27,
                'role_id'=>1,
                'permission_id'=>27,
                
            ],
            [
                'id'=>28,
                'role_id'=>1,
                'permission_id'=>28,
                
            ],
            [
                'id'=>29,
                'role_id'=>1,
                'permission_id'=>29,
                
            ],
            [
                'id'=>30,
                'role_id'=>1,
                'permission_id'=>30,
                
            ],
            [
                'id'=>31,
                'role_id'=>1,
                'permission_id'=>31,
                
            ],
            [
                'id'=>32,
                'role_id'=>1,
                'permission_id'=>32,
                
            ],
            [
                'id'=>33,
                'role_id'=>1,
                'permission_id'=>33,
                
            ],
            [
                'id'=>34,
                'role_id'=>1,
                'permission_id'=>34,
                
            ],
            [
                'id'=>35,
                'role_id'=>1,
                'permission_id'=>35,
                
            ],
            [
                'id'=>36,
                'role_id'=>1,
                'permission_id'=>36,
                
            ],
            [
                'id'=>37,
                'role_id'=>1,
                'permission_id'=>37,
                
            ],
            [
                'id'=>38,
                'role_id'=>1,
                'permission_id'=>38,
                
            ],
            [
                'id'=>39,
                'role_id'=>1,
                'permission_id'=>39,
                
            ],
            [
                'id'=>40,
                'role_id'=>1,
                'permission_id'=>40,
                
            ],
            [
                'id'=>41,
                'role_id'=>1,
                'permission_id'=>41,
                
            ],
            [
                'id'=>42,
                'role_id'=>1,
                'permission_id'=>42,
                
            ],
            [
                'id'=>43,
                'role_id'=>1,
                'permission_id'=>43,
                
            ],
            [
                'id'=>44,
                'role_id'=>1,
                'permission_id'=>44,
                
            ],
            [
                'id'=>45,
                'role_id'=>1,
                'permission_id'=>45,
                
            ],
            [
                'id'=>46,
                'role_id'=>1,
                'permission_id'=>46,
                
            ],
            [
                'id'=>47,
                'role_id'=>1,
                'permission_id'=>47,
                
            ],
            [
                'id'=>48,
                'role_id'=>1,
                'permission_id'=>48,
                
            ],
            [
                'id'=>49,
                'role_id'=>1,
                'permission_id'=>49,
                
            ],
            [
                'id'=>50,
                'role_id'=>1,
                'permission_id'=>50,
                
            ],
            [
                'id'=>51,
                'role_id'=>1,
                'permission_id'=>51,
                
            ],
            [
                'id'=>52,
                'role_id'=>1,
                'permission_id'=>52,
                
            ],
            [
                'id'=>53,
                'role_id'=>1,
                'permission_id'=>53,
                
            ],
            [
                'id'=>54,
                'role_id'=>1,
                'permission_id'=>54,
                
            ],
            [
                'id'=>55,
                'role_id'=>1,
                'permission_id'=>55,
                
            ],
            [
                'id'=>56,
                'role_id'=>1,
                'permission_id'=>56,
                
            ],
            [
                'id'=>57,
                'role_id'=>1,
                'permission_id'=>57,
                
            ],
            [
                'id'=>58,
                'role_id'=>1,
                'permission_id'=>58,
                
            ],
            [
                'id'=>59,
                'role_id'=>1,
                'permission_id'=>59,
                
            ],
            [
                'id'=>60,
                'role_id'=>1,
                'permission_id'=>60,
                
            ],

        ]);
    }
}
