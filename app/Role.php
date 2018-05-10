<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * @var string
     */
    protected $table = 'role';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'description'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;
}
