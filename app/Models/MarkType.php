<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MarkType extends Model
{
    use HasFactory;

    const MARKTYPE = ['QUIZZES','EXAM'];

    const QUIZZES = self::MARKTYPE[0];
    const EXAM = self::MARKTYPE[1];

    protected $fillable =  [
        'id','type','type_total'
    ];

    protected $casts = [
        'id' => 'string'
    ];
}
