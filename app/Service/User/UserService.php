<?php

namespace App\Service\User;

use App\Models\Department;
use App\Models\Gender;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getAllUsers(): LengthAwarePaginator
    {
        return User::with(['department','gender','company'])->paginate();
    }

    public function getUserById(string $id): ?User
    {
        return User::with(['department','gender','company'])->findOrFail($id);
    }

    public function createUser(array $data): User
    {
        $data['name'] = $data['first_name'].' '.$data['last_name'];
        $data['password'] = Hash::make($data['password']);
        $data['is_active'] = 1;
        $data['company_id'] = 1;


        return User::create($data);
    }

    public function updateUser(string $id, array $data): ?User
    {
        $user = User::findOrFail($id);
        if (!$user) {
            abort('404', 'User not found');
        }

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        if (array_key_exists('role', $data)) {
            $role = $data['role'];
            unset($data['role']);      
            $user->syncRoles($role);
        }
        $data['name'] = $data['first_name'].' '.$data['last_name'];

        $user->update($data);

        return $user->fresh();
    }

    public function deleteUser(string $id): ?bool
    {
        $user = User::findOrFail($id);
        if (!$user) {
            return null;
        }

        return $user->delete();
    }

    public function resetUserPassword(string $id, string $password): void
    {
        $user = User::findOrFail($id);
        if (!$user) {
            abort('404', 'User not found');
        }

        $user->password = Hash::make($password);
        $user->save();
    }

    public function loginHistory(string $id): LengthAwarePaginator
    {
        $user = User::findOrFail($id);
        if (!$user) {
            abort('404', 'User not found');
        }

        return $user->loginHistory()->paginate();
    }

    public function activateOrDeActivateUser(string $id): ?User
    {
        $user = User::findOrFail($id);
        if (!$user) {
            abort('404', 'User not found');
        }

        $user->is_active = $user->is_active == 0 ? 1 : 0;
        $user->save();

        return $user;
    }

    public function assignRole(string $id, string $role): ?User
    {
        $user = User::findOrFail($id);
        if (!$user) {
            abort('404', 'User not found');
        }

        $user->syncRoles($role);

        return $user;
    }

    public function assignPermission(string $id, string $permission): ?User
    {
        $user = User::findOrFail($id);
        if (!$user) {
            abort('404', 'User not found');
        }

        $user->syncPermissions($permission);

        return $user;
    }

    public function notifyUser(string $id, string $message): ?User
    {
        $user = User::findOrFail($id);
        if (!$user) {
            abort('404', 'User not found');
        }

        // Here you would implement the logic to send a notification to the user.
        // For example, using Laravel's notification system.

        return $user;
    }


    protected function generateUniqueUserName(string $base): string
    {
        $username = $base;
        $counter  = 1;

        while (User::where('username', $username)->exists()) {
            $username = "{$base}{$counter}";
            $counter++;
        }

        return $username;
    }
    public function getGenders()
    {
        return Gender::all();
    }

    public function getDepartments()
    {
        return Department::all();
    }
}
