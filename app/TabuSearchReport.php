<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TabuSearchReport extends Model
{
    protected $table = 'tabu_search_reports';
    protected $guarded = [];

    public function class_reports()
    {
        return $this->hasMany(ClassReport::class, 'ts_report_id');
    }
}
