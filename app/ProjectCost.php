<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectCost extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'pers_id',
        'project_id',
        'project_cost',
        'hours',
        'cost_override',
        'date',
        'percent',
    ];

    /**
     * Personal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pers()
    {
        return $this->belongsTo('App\Personal', 'pers_id', 'pers_id');
    }

    /**
     * Project
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function projects()
    {
        return $this->belongsTo('App\Project', 'project_id', 'project_id');
    }
}
