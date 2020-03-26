<?php

namespace App\Http\Controllers\Tenant\Admin\Users;

use App\Models\Tenant\Users\Role;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function roles()
    {
        $roles = Role::all();

        return response()->json($roles);
    }
}
