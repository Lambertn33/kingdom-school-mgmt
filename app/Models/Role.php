<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;
    const ROLE = [
        'ADMINISTRATOR','DIRECTOR_OF_STUDIES','TEACHER'
    ];
    const ADMINISTRATOR = self::ROLE[0];
    const DIRECTOR_OF_STUDIES = self::ROLE[1];
    const TEACHER = self::ROLE[2];
    
    protected $fillable = ['id','name'];

    protected $casts = [
        'id'=>'string'
    ];

    /**
     * Get all of the users for the Role
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}
