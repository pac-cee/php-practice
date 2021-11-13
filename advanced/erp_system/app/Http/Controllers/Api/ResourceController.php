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

    public function __construct(ResourceService $resourceService)
    {
        $this->resourceService = $resourceService;
        $this->middleware('auth:sanctum');
        $this->middleware('role:admin')->only(['store', 'update', 'destroy']);
    }

    /**
     * @OA\Get(
     *     path="/api/resources",
     *     summary="List all resources",
     *     @OA\Response(response="200", description="List of resources")
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $resources = $this->resourceService->getAllWithCache();
