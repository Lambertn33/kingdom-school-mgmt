<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('roles')->delete();

        \DB::table('roles')->insert(array(
            0 => array(
                'id'=>'4c7a09ea-b50d-4a46-b2d1-673bffb6a67b',
                'name'=>'ADMINISTRATOR',
                'created_at'=>now(),
                'updated_at'=>now(),
            ),
            1 => array(
                'id'=>'71d2e301-bdb4-4343-8ec8-449702e823af',
                'name'=>'DIRECTOR_OF_STUDIES',
                'created_at'=>now(),
                'updated_at'=>now(),
            ),
            2 => array(
                'id'=>'77eee863-b8f9-44cb-98ca-a71af6761c3c',
                'name'=>'TEACHER',
                'created_at'=>now(),
                'updated_at'=>now(),
            ),
        ));
    }
}
