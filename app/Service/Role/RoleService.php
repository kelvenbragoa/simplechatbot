<?php

namespace App\Service\Role;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Role;

class RoleService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getAllRole(): LengthAwarePaginator
    {
        return Role::with('permissions')->paginate();
    }

    public function getRoleById(string $id): ?Role
    {
        return Role::findOrFail($id);
    }

    public function createRole(array $data): Role
    {
        $role = Role::create([
        'name' => $data['name'],
        'description' => $data['description'] ?? null,
        'guard_name' => $data['guard_name'] ?? 'sanctum',
    ]);

    // Se tiver permissões, sincroniza
    if (!empty($data['permissions'])) {
        $role->syncPermissions(collect($data['permissions'])->pluck('name'));
    }

    return $role;
    }

    public function updateRole(string $id, array $data): ?Role
    {
        $role = Role::with('permissions')->findOrFail($id);

        $role->update($data);

        $role->syncPermissions($data['permissions'] ?? []);

        return $role->fresh()->load('permissions');
    }

    public function deleteRole(string $id)
    {
        $role = Role::findOrFail($id);
         
        // if (!$role) {
        //     return null;
        // }

        return $role->delete();
    }
}
