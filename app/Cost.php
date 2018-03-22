<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    protected $fillable = [
        'year',
        'month',
        'cost',
        'rus_date'
    ];
}
