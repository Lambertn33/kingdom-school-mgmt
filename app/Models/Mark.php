<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mark extends Model
{
    use HasFactory;

    const Trimester = ['1st Term', '2nd Term', '3rd Term'];

    const firstTerm = self::Trimester[0];
    const secondTerm = self::Trimester[1];
    const thirdTerm = self::Trimester[2];

    protected $fillable = [
        'id','student_id','course_id','total_quizzes','total_exams','trimester'
    ];

    protected $casts = [
        'id'=>'string',
        'student_id'=>'string',
        'course_id'=>'string',
    ];

    /**
     * Get the student that owns the Mark
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    /**
     * Get the course that owns the Mark
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}
