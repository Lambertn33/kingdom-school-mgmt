<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Class_Course extends Model
{
    use HasFactory;

    const Days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];

    protected $fillable = [
        'id','classroom_id','course_id','day','from','to','teacher_id'
    ];

    protected $casts = [
        'id' => 'string',
        'classroom_id' => 'string',
        'course_id' => 'string',
        'teacher_id' => 'string'
    ];
}
