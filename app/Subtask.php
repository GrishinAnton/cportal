<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
    protected $fillable = [
        'subtask_id',
        'task_id',
        'assignee_id',
        'body',
        'created_on',
        'permalink',
        'completed_on',
        'is_completed',
        'type'
    ];
}
