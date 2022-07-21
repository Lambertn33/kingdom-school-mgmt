<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = ['id','date','class_id','date','time','course_id','by','students_ids'];

    protected $casts = [
        'id' => 'string',
        'course_id' => 'string',
        'class_id' => 'string',
        'by' => 'string'
    ];

    /**
     * Get the classRoom that owns the Attendance
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function classRoom(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class, 'class_id', 'id');
    }
}
