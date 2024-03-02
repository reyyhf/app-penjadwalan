<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherLesson extends Model
{
    use SoftDeletes;
    // JANGAN LUPA GANTI NAMA TABEL
    protected $table = 'guru_matpel'; 
    protected $primaryKey = [
        'id',
        'employee_id',
        'curriculum_id'
    ];
    public $incrementing = false;
    protected $fillable = [ 
        'id',       
        'employee_id',
        'curriculum_id'
    ];
    protected $guarded = array();

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function curriculumLesson()
    {
        return $this->belongsTo(CurriculumLesson::class,'curriculum_id');
    }
}
