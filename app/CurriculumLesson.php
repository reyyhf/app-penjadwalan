<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CurriculumLesson extends Model
{
    use SoftDeletes;
    protected $table = 'curriculum_lessons';
    protected $fillable = [
        'employee_id',
        'category_id',
        'name_lesson',
        'weight_x',
        'weight_xi',
        'weight_xii'
    ];
    protected $guarded = array();

    public function categoryLesson()
    {
        return $this->belongsTo(CategoryLesson::class, 'category_id');
    }

    public function teacherLessons()
    {
        return $this->hasMany(TeacherLesson::class);
    }

    public function detailLessons()
    {
        return $this->hasMany(DetailLesson::class, 'curriculum_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
