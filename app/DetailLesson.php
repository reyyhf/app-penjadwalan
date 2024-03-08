<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailLesson extends Model
{
    protected $table = 'detail_lessons';
    protected $guarded = array();
    protected $fillable = [
        'lesson_hour_id',
        'employee_id',
        'curriculum_id',
        'day',
        'hour'
    ];

    public function lessonHour()
    {
        return $this->belongsTo(LessonHour::class, 'lesson_hour_id');
    }

    public function curriculumLesson()
    {
        return $this->belongsTo(CurriculumLesson::class, 'curriculum_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
