<?php

// app/Helpers/PermissionHelper.php

namespace App\Helpers;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionHelper
{
    public static function getRolePermissions($roleName)
    {
        $role = Role::findByName($roleName);

        return $role->permissions;
    }

    public static function userHasPermission($userId, $permission)
    {
        $user = \App\Models\User::find($userId);

        return $user ? $user->can($permission) : false;
    }

    public static function getAllModules()
    {
        return Permission::select('module')->distinct()->whereNotNull('module')->get()->pluck('module');
    }
}
