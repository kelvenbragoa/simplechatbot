<?php

namespace App\Http\Controllers\Api\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Service\Role\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(private readonly RoleService $roleService)
    {
    }
    public function index(): JsonResponse
    {
        //
        return response()->json(
            $this->roleService->getAllRole()
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
    public function store(StoreRoleRequest $request)
    {
        try {
            return $this->roleService->createRole($request->validated());
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error creating role. '.$th->getMessage(),
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
            $this->roleService->getRoleById($id)
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $role = $this->roleService->getRoleById($id);

        return response()->json([
            'role' => $role,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(UpdateRoleRequest $request, string $id): JsonResponse
    {
        //
        try {
            $updatedRole = $this->roleService->updateRole($id, $request->validated());
            return response()->json($updatedRole);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error updating role',
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
            $role = $this->roleService->deleteRole($id);
            return $role;
            return response()->json(['message' => 'Role deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error deleting role',
                'error' => $th->getMessage(),
            ], 400);
        }
    }
}
