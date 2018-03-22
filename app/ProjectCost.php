<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectCost extends Model
{
    protected $fillable = [
        'project_id',
        'pers_id',
        'project_cost',
        'rus_date',
        'year_month',
        'hours'
    ];

    public function pers()
    {
        return $this->belongsTo('App\Personal', 'pers_id', 'pers_id');
    }
}
