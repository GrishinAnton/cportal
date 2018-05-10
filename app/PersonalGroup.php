<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalGroup extends Model
{
    /**
     * @var string
     */
    protected $table = 'personal_groups';

    /**
     * @var array
     */
    protected $fillable = [
        'index', 'name'
    ];
}
