<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalCompany extends Model
{
    /**
     * @var string
     */
    protected $table = 'personal_companies';

    /**
     * @var array
     */
    protected $fillable = [
        'index', 'name'
    ];
}
