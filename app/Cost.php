<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'cost',
        'date',
    ];
}
