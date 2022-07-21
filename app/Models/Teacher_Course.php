<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher_Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'id','teacher_id','course_id'
    ];

    protected $casts = [
        'id'=>'string',
        'teacher_id'=>'string',
        'course_id'=>'string'
    ];
}
