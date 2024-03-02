<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LessonHour extends Model
{
    use SoftDeletes;
    protected $table = 'lesson_hours';
    protected $guarded = array();
    protected $fillable = [
        'class_id',
        'type_curriculum',
        'status'
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'class_id');
    }

    public function DetailLesson()
    {
        return $this->hasMany(DetailLesson::class);
    }
}
