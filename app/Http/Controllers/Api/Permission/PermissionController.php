<?php

namespace App\Http\Controllers\Api\Permission;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\StorePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use App\Service\Permission\PermissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(private readonly PermissionService $permissionService)
    {
    }
    public function index(): JsonResponse
    {
        //
        return response()->json(
            $this->permissionService->getAllPermissions()
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request)
    {
        try {
            return $this->permissionService->createPermission($request->validated());
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error creating permission. '.$th->getMessage(),
                'error' => $th->getMessage(),
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return response()->json(
            $this->permissionService->getPermissionById($id)
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $permission = $this->permissionService->getPermissionById($id);

        return response()->json([
            'permission' => $permission,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(UpdatePermissionRequest $request, string $id): JsonResponse
    {
        //
        try {
            $updatedPermission = $this->permissionService->updatePermission($id, $request->validated());
            return response()->json($updatedPermission);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error updating permission',
                'error' => $th->getMessage(),
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            $permission = $this->permissionService->deletePermission($id);
            return response()->json(['message' => 'Permission deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error deleting permission',
                'error' => $th->getMessage(),
            ], 400);
        }
    }
}
