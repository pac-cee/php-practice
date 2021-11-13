<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ResourceService;
use App\Http\Requests\ResourceRequest;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="ERP System API",
 *     version="1.0.0"
 * )
 */
class ResourceController extends Controller
{
    protected $resourceService;
