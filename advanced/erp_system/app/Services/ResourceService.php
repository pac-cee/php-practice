<?php

namespace App\Services;

use App\Models\Resource;
use App\Repositories\ResourceRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class ResourceService
{
    protected $repository;
    protected $cacheTime = 3600; // 1 hour

    public function __construct(ResourceRepository $repository)
    {
        $this->repository = $repository;
    }
