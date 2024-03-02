<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryLesson extends Model
{
    use SoftDeletes;
    protected $table = 'category_lessons';
    protected $fillable = [
        'name'
    ];
    protected $guarded = array();

    public function curriculumLessons()
    {
        return $this->hasMany(CurriculumLesson::class,'category_id');
    }
}
