<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectStatus extends Model
{
    /**
     * @var string
     */
    protected $table = 'project_statuses';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'index',
    ];
}
