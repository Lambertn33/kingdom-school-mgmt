<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->delete();

        \DB::table('users')->insert(array(
            0 => array(
                'id'=>Str::uuid()->toString(),
                'role_id'=> '4c7a09ea-b50d-4a46-b2d1-673bffb6a67b',
                'names'=> 'System Administrator',
                'username'=>'administrator',
                'password'=>Hash::make('admin12345'),
                'created_at'=>now(),
                'updated_at'=>now(),
            )
        ));
    }
}
