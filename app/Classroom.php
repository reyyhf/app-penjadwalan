<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classroom extends Model
{
    use SoftDeletes;
    protected $table = 'classrooms';
    protected $fillable = [
        'name',
        'class_major',
        'total_student'
    ];
    protected $guarded = array();

    public function LessonHour()
    {
        return $this->hasMany(LessonHour::class);
    }
}
