<?php

namespace App\Http\Controllers\Api\Report\Project;

use App\Repositories\Project\CostRepository;
use App\Http\Controllers\Controller;

class CostController extends Controller
{
    /**
     * @var CostRepository
     */
    private $costRepository;

    public function __construct()
    {
        $this->costRepository = new CostRepository();
    }

    public function show($projectId)
    {
        dd($this->costRepository->project($projectId)->costs()->toSql());
    }
}
