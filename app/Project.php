<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //protected $primaryKey = 'project_id';

    protected $fillable = [
        'project_id',
        'class',
        'url_path',
        'name',
        'category_id',
        'is_trashed',
        'trashed_on',
        'updated_on',
        'body_formatted',
        'company_id',
        'currency_id',
        'budget',
        'is_completed'
    ];

    public function tasks()
    {
        return $this->hasMany('App\Task', 'project_id', 'project_id');
    }

    public function costs()
    {
        return $this->hasMany('App\ProjectCost', 'project_id', 'project_id');
    }

    public function fullInfoCosts()
    {
        return $this->hasMany('App\ProjectCost', 'project_id', 'project_id');
    }

    public function personal()
    {
        return $this->belongsToMany('App\Personal', 'personal_project', 'project_id', 'pers_id', 'project_id');
    }
}
