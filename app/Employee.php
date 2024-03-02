<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;
    protected $table = 'employees';
    protected $fillable = [
        'position_id',
        'nik',
        'name',
        'load_teacher',
        'x_class',
        'xi_class',
        'xii_class'
    ];
    protected $guarded = array();

    public function position()
    {
        return $this->belongsTo(Position::class,'position_id');
    }

    public function teacherLessons()
    {
        return $this->hasMany(TeacherLesson::class, 'employee_id');
    }

    public function curriculumLessons()
    {
        return $this->hasMany(CurriculumLesson::class, 'employee_id');
    }

    public function detailLessons()
    {
        return $this->hasMany(DetailLesson::class, 'employee_id');
    }
}
