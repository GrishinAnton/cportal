<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $fillable = [
        'salary_fix',
        'hour',
        'salary',
        'edit_salary',
        'pers_id',
        'coefficient',
        'date',
        'edit_hours'
    ];
}
