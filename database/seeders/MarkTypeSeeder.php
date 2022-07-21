<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MarkTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('mark_types')->delete();

        \DB::table('mark_types')->insert(array(
          0 => array(
              'id'=>Str::uuid()->toString(),
              'type'=>\App\Models\MarkType::QUIZZES,
              'type_total'=>50,
              'created_at'=>now(),
              'updated_at'=>now(),
          ),
          1 => array(
            'id'=>Str::uuid()->toString(),
            'type'=>\App\Models\MarkType::EXAM,
            'type_total'=>50,
            'created_at'=>now(),
            'updated_at'=>now(),
          ),
        ));
    }
}
