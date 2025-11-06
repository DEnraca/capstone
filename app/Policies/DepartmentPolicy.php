<?php

namespace App\Policies;

use App\Models\Department;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DepartmentPolicy
{

    public function create(User $user): bool
    {
        return $user->role === 'Admin';
    }


    public function delete(User $user, Department $department): bool
    {
        return $user->role === "Admin";
    }
}
