<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ClassRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('class_rooms')->delete();
       
         \DB::table('class_rooms')->insert(array(
            0 => array(
                'id' => Str::uuid()->toString(),
                'room_code' => 'S1A',
                'created_at' => now(),
                'updated_at' => now()
            ),
            1 => array(
                'id' => Str::uuid()->toString(),
                'room_code' => 'S1B',
                'created_at' => now(),
                'updated_at' => now()
            ),
            2 => array(
                'id' => Str::uuid()->toString(),
                'room_code' => 'S2A',
                'created_at' => now(),
                'updated_at' => now()
            ),
            3 => array(
                'id' => Str::uuid()->toString(),
                'room_code' => 'S2B',
                'created_at' => now(),
                'updated_at' => now()
            ),
            4 => array(
                'id' => Str::uuid()->toString(),
                'room_code' => 'S3A',
                'created_at' => now(),
                'updated_at' => now()
            ),
            5 => array(
                'id' => Str::uuid()->toString(),
                'room_code' => 'S3B',
                'created_at' => now(),
                'updated_at' => now()
            ),
            6 => array(
                'id' => Str::uuid()->toString(),
                'room_code' => 'S4MPCs',
                'created_at' => now(),
                'updated_at' => now()
            ),
            7 => array(
                'id' => Str::uuid()->toString(),
                'room_code' => 'S5MPCs',
                'created_at' => now(),
                'updated_at' => now()
            ),
            8 => array(
                'id' => Str::uuid()->toString(),
                'room_code' => 'S6MPCs',
                'created_at' => now(),
                'updated_at' => now()
            ),
            9 => array(
                'id' => Str::uuid()->toString(),
                'room_code' => 'S4MPG',
                'created_at' => now(),
                'updated_at' => now()
            ),
            10 => array(
                'id' => Str::uuid()->toString(),
                'room_code' => 'S5MPG',
                'created_at' => now(),
                'updated_at' => now()
            ),
            11 => array(
                'id' => Str::uuid()->toString(),
                'room_code' => 'S5MPG',
                'created_at' => now(),
                'updated_at' => now()
            ),

         ));
    }
}
