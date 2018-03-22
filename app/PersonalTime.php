<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalTime extends Model
{
    protected $fillable = [
        'worktime',
        'date',
        'pers_id',
        'task_id',
        'timerecord_id'
    ];

    public function tasks()
    {
        return $this->belongsTo('App\Task', 'task_id', 'task_id');
    }
}
