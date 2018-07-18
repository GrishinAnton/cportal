<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //protected $primaryKey = 'task_id';

    protected $fillable = [
        'type',
        'permalink',
        'name',
        'completed_on',
        'is_completed',
        'project_id',
        'task_list',
        'created_on',
        'assignee_id',
        'task_id',
        'estimated_time',
        'tracked_time'
    ];

    public function times()
    {
        return $this->hasMany('App\PersonalTime', 'task_id', 'task_id');
    }

    public function projects()
    {
        return $this->belongsTo('App\Project', 'project_id', 'project_id');
    }

    public function personal()
    {
        return $this->belongsTo('App\Personal', 'assignee_id');
    }
}
