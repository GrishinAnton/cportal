<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    /**
     * @var string
     */
    protected $table = 'personal';

    /**
     * @var string
     */
    protected $primaryKey = 'pers_id';

    /**
     * @var array
     */
    protected $fillable = [
        'pers_id',
        'avatar',
        'class',
        'created_on',
        'email',
        'first_name',
        'is_archived',
        'is_trashed',
        'last_name',
        'phone',
        'trashed_on',
        'updated_on',
        'url_path'
    ];

    /**
     * The roles that belong to the user.
     */
    public function projects()
    {
        return $this->belongsToMany(
            'App\Project',
            'personal_project',
            'pers_id',
            'project_id',
            'pers_id',
            'project_id'
        );
    }

    /**
     * Get times
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function times()
    {
        return $this->hasMany('App\PersonalTime', 'pers_id', 'pers_id');
    }

    /**
     * Get tasks
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tasks()
    {
        return $this->belongsToMany(
            'App\Task',
            'personal_times',
            'pers_id',
            'task_id',
            'pers_id',
            'task_id'
        );
    }

    /**
     * Get salary
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function salary()
    {
        return $this->hasMany('App\Salary', 'pers_id', 'pers_id');
    }

    /**
     * Get costs
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function costs()
    {
        return $this->hasMany('App\ProjectCost', 'pers_id', 'pers_id');
    }

    /**
     * Get personal group
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function group()
    {
        return $this->hasOne('App\PersonalGroup', 'id', 'group_id');
    }

    /**
     * Get personal company
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function company()
    {
        return $this->hasOne('App\PersonalCompany', 'id', 'company_id');
    }

    /**
     * Get project costs
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projectCosts()
    {
        return $this->hasMany('App\ProjectCost', 'pers_id', 'pers_id');
    }

    /**
     * Filter by companies
     *
     * @param $query
     * @param $companyId
     * @return mixed
     */
    public function scopeCompany($query, $companyId)
    {
        return $query->whereIn('company_id', $companyId);
    }

    /**
     * Filter by groups
     *
     * @param $query
     * @param $groupId
     * @return mixed
     */
    public function scopeGroup($query, $groupId)
    {
        return $query->whereIn('group_id', $groupId);
    }
}
