<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Teacher;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'id','name','code','total_quizzes','total_exams'
    ];

    protected $casts = [
        'id'=>'string'
    ];

    /**
     * The teachers that belong to the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, 'teacher__courses', 'course_id', 'teacher_id');
    }

    /**
     * The classes that belong to the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(ClassRoom::class, 'class__courses', 'course_id', 'classroom_id')->withPivot('day','from','to','teacher_id');
    }


    /**
     * Get all of the marks for the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function marks(): HasMany
    {
        return $this->hasMany(Mark::class, 'mark_id', 'id');
    }

    public function teacherName()
    {
        $teacherId = $this->pivot->teacher_id;
        $teacher = Teacher::find($teacherId);
        return $teacher->user->names;
    }

    public function className()
    {
        $classRoomId = $this->pivot->classroom_id;
        $classRoom = ClassRoom::find($classRoomId);
        return $classRoom->room_code;
    }


}
