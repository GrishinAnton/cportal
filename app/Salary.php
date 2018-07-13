<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'pers_id',
        'coefficient',
        'fix',
        'salary',
        'close_hours',
        'teamlead_bonus',
        'salary_hours',
        'penalty_hours',
        'date'
    ];
}
