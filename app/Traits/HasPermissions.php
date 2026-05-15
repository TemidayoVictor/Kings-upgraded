<?php

namespace App\Traits;

use App\Enums\UserType;

trait HasPermissions
{
    public function hasPermissionTo($permission)
    {
        return $this->can($permission);
    }

    public function hasAnyRole($roles)
    {
        return $this->hasRole($roles);
    }

    public function isSuperAdmin()
    {
        return $this->hasRole(UserType::SUPERADMIN);
    }

    public function getPermissions()
    {
        return $this->getAllPermissions();
    }
}
