<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HourReport extends Model
{
    protected $table = 'hour_reports';
    protected $guarded = [];

    public function schedule_report()
    {
        return $this->belongsTo(ScheduleReport::class);
    }
}
