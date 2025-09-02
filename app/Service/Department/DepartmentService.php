<?php

namespace App\Service\Department;

use App\Models\Department;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DepartmentService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }


    public function getAllDepartments(Request $request): LengthAwarePaginator
    {

        $department = Department::when($request->input('query'), fn($query) =>
            $query->where('name', 'like', '%' . $request->input('query') . '%')
        )->with(['user'])->paginate();

        return $department;
    }

    public function getDepartmentById(string $id): ?Department
    {
        return Department::with(['user'])->findOrFail($id);
    }

    public function createDepartment(array $data): Department
    {
        return Department::create($data);
    }

    public function updateDepartment(string $id, array $data): ?Department
    {
        $department = Department::findOrFail($id);
        if (!$department) {
            abort('404', 'Department not found');
        }

        $department->update($data);

        return $department->fresh();
    }

    public function deleteDepartment(string $id): ?bool
    {
        $department = Department::findOrFail($id);
        if (!$department) {
            return null;
        }

        return $department->delete();
    }

    public function getAllUsers(): array
    {
        $users = User::where('company_id',1)->where('is_active', 1)->get();
        return $users->toArray();
    }
}
