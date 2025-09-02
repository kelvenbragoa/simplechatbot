<?php

namespace App\Http\Controllers\Api\Department;

use App\Http\Controllers\Controller;
use App\Http\Requests\Department\StoreDepartmentRequest;
use App\Http\Requests\Department\UpdateDepartmentRequest;
use App\Service\Department\DepartmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct(private readonly DepartmentService $departmentService)
    {
    }
    public function index(Request $request): JsonResponse
    {
        //

        return response()->json(
            $this->departmentService->getAllDepartments($request)
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $userItems = $this->departmentService->getAllUsers();

        return response()->json([
            'message' => 'success',
            'userItems' => $userItems
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        try {
            return $this->departmentService->createDepartment($request->validated());
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error creating department',
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
            $this->departmentService->getDepartmentById($id)
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //

        return response()->json([
            'department' => $this->departmentService->getDepartmentById($id),
            'userItems' => $this->departmentService->getAllUsers(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(UpdateDepartmentRequest $request, string $id): JsonResponse
    {
        //
        try {
            $updatedDepartment = $this->departmentService->updateDepartment($id, $request->validated());
            return response()->json($updatedDepartment);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error updating department',
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
            $department = $this->departmentService->deleteDepartment($id);
            return response()->json(['message' => 'Department deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error deleting department',
                'error' => $th->getMessage(),
            ], 400);
        }
    }
}
