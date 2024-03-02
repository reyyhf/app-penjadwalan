<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassReport extends Model
{
    protected $table = 'class_reports';
    protected $guarded = [];

    public function tabu_search_report()
    {
        return $this->belongsTo(TabuSearchReport::class);
    }

    public function schedule_reports()
    {
        return $this->hasMany(ScheduleReport::class);
    }
}
