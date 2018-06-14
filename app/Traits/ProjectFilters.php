<?php

namespace App\Traits;

trait ProjectFilters
{
    /**
     * Scope Company
     *
     * @param $query
     * @param $param
     * @return mixed
     */
    public function scopeCompany($query, $param)
    {
        return $query->whereIn('projects.company_id', $param);
    }

    /**
     * Scope Status
     *
     * @param $query
     * @param $param
     * @return mixed
     */
    public function scopeStatus($query, $param)
    {
        return $query->whereIn('projects.status_id', $param);
    }
}
