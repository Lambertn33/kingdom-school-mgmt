<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('courses')->delete();

        \DB::table('courses')->insert(array(

           0 => array(
             'id'=>Str::uuid()->toString(),
             'name'=>'Mathematics',
             'code' =>'MATHS',
             'total_quizzes' => 50,
             'total_exams' => 50,
             'created_at' => now(),
             'updated_at' => now(),
           ),

           1 => array(
             'id'=>Str::uuid()->toString(),
             'name'=>'French',
             'code'=>'FR',
             'total_quizzes' => 50,
             'total_exams' => 50,
             'created_at' => now(),
             'updated_at' => now(),
           ),

           2 => array(
             'id' => Str::uuid()->toString(),
             'name' => 'Kinyarwanda',
             'code' => 'KINY',
             'total_quizzes' => 50,
             'total_exams' => 50,
             'created_at' => now(),
             'updated_at' => now(),
           ),

           3 => array(
             'id' => Str::uuid()->toString(),
             'name' => 'Biology',
             'code' => 'BIO',
             'total_quizzes' => 50,
             'total_exams' => 50,
             'created_at' => now(),
             'updated_at' => now(),
           ),

           4 => array(
             'id' => Str::uuid()->toString(),
             'name'=> 'Chemistry',
             'code' => 'CHEM',
             'total_quizzes' => 50,
             'total_exams' => 50,
             'created_at' => now(),
             'updated_at' => now(),
           ),

           5 => array(
             'id' => Str::uuid()->toString(),
             'name' => 'History',
             'code' => 'HIST',
             'total_quizzes' => 50,
             'total_exams' => 50,
             'created_at' => now(),
             'updated_at' => now(),
           ),

           6 => array(
             'id' => Str::uuid()->toString(),
             'name' => 'Geography',
             'code' =>'GEO',
             'total_quizzes' => 50,
             'total_exams' => 50,
             'created_at' => now(),
             'updated_at' => now(),
           ),

           7 => array(
             'id' => Str::uuid()->toString(),
             'name' => 'Entrepreneurship',
             'code' => 'ENTR',
             'total_quizzes' => 50,
             'total_exams' => 50,
             'created_at' => now(),
             'updated_at' => now(),
           )
        ));
    }
}
