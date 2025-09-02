<?php

namespace App\Service\Permission;

use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Permission;

class PermissionService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getAllPermissions(): LengthAwarePaginator
    {
        return Permission::paginate();
    }

    public function getPermissionById(string $id): ?Permission
    {
        return Permission::with(['department', 'gender', 'company'])->findOrFail($id);
    }

    public function createPermission(array $data): Permission
    {
        $permission = Permission::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'guard_name' => $data['guard_name'] ?? 'sanctum',
        ]);
        return $permission;
    }

    public function updatePermission(string $id, array $data): ?Permission
    {
        $permission = Permission::findOrFail($id);
        if (!$permission) {
            abort('404', 'Permission not found');
        }

        $permission->update($data);

        return $permission->fresh();
    }

    public function deletePermission(string $id): ?bool
    {
        $permission = Permission::findOrFail($id);
        if (!$permission) {
            return null;
        }

        return $permission->delete();
    }
}
