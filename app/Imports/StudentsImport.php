<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;

class StudentsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    protected $id;
    
    public function  __construct($id)
    {
        $this->id= $id;
    }
    public $count = 0;
    
    public function model(array $row)
    {
        $maxStudentNo = Student::max('student_no');
        $this->count = $maxStudentNo;
        ++$this->count;
        return new Student([
            'id' =>Str::uuid()->toString(),
            'names' => $row['student_names'],
            'gender' => $row['student_gender'],
            'classroom_id' =>$this->id,
            'student_no' => $this->count,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

}
