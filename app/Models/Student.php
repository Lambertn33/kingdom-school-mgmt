<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Mark;

class Student extends Model
{
    use HasFactory;

    const GENDER = ['Male','Female'];

    const Male = self::GENDER[0];
    const Female = self::GENDER[1];

    protected $fillable = [
        'id','names','gender','student_no','classroom_id'
    ];

    protected $casts = [
        'id'=>'string',
        'classroom_id'=>'string'
    ];

    /**
     * Get the classRoom that owns the Student
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function classRoom(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class, 'classroom_id', 'id');
    }

    /**
     * Get all of the marks for the Student
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function marks(): HasMany
    {
        return $this->hasMany(Mark::class, 'mark_id', 'id');
    }

    public function checkStudentMark($courseId)
    {
        if(Mark::where('student_id',$this->id)->where('course_id',$courseId)->exists()) {
            return true;
        }else{
            return false;
        }
    }
}
