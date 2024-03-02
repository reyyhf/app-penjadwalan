<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleReport extends Model
{
    protected $table = 'schedule_reports';
    protected $guarded = [];

    public function class_report()
    {
        return $this->belongsTo(ClassReport::class);
    }

    public function hour_reports()
    {
        return $this->hasMany(HourReport::class);
    }
}
