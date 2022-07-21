<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ClassRoom extends Model
{
    use HasFactory;
    
    const STATUS = ['OPEN','CLOSED'];

    const OPEN = self::STATUS[0];
    const CLOSED = self::STATUS[1];

    protected $fillable = [
        'id','room_code','status'
    ];

     /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id'=>'string',
    ];

    /**
     * Get all of the students for the ClassRoom
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'classroom_id', 'id');
    }

    /**
     * The courses that belong to the ClassRoom
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'class__courses', 'classroom_id', 'course_id')->withPivot('day','from','to','teacher_id');
    }

    /**
     * Get all of the attendances for the ClassRoom
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'class_id', 'id');
    }

}
