<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Personal extends Model
{
    protected $table = 'personal';

    protected $primaryKey = 'pers_id';

    protected $fillable = [
        'pers_id',
        'avatar',
        'class',
        'created_on',
        'email',
        'first_name',
        'is_archived',
        'is_trashed',
        'last_name',
        'phone',
        'trashed_on',
        'updated_on',
        'url_path'
    ];

    /**
     * The roles that belong to the user.
     */
    public function projects()
    {
        return $this->belongsToMany(
            'App\Project',
            'personal_project',
            'pers_id',
            'project_id',
            'pers_id',
            'project_id'
        );
    }

    public function times()
    {
        return $this->hasMany('App\PersonalTime', 'pers_id', 'pers_id');
    }

    public function tasks()
    {
        return $this->belongsToMany('App\Task', 'personal_times', 'pers_id', 'task_id', 'pers_id', 'task_id');
    }

    public function salary()
    {
        return $this->hasMany('App\Salary', 'pers_id', 'pers_id');
    }

    public function costs()
    {
        return $this->hasMany('App\ProjectCost', 'pers_id', 'pers_id');
    }
}
