<?php

namespace App\Http\Controllers\Tenant\Admin\Users;

use Illuminate\Http\Request;
use App\Models\Tenant\Users\Role;
use App\Models\Tenant\Users\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\Users\RoleUserRequest;

class RoleUserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, Request $request)
    {
        $fail = $this->specialValidation($request);

        if ($fail) {
            return back()->with(['error' => $fail]);
        }

        $user = User::find((int) $request->user_id);

        $user->roles()->sync($request->role);

        return back()->with('success', 'Roles asignados correctamente');
    }

    /**
     * [edit description]
     *
     * @param  User   $role_user [description]
     *
     * @return [type]            [description]
     */
    public function edit(User $role_user)
    {
        $roles = Role::all(['id', 'role']);

        return view('admin.personal.edit', ['user' => $role_user, 'roles' => $roles]);
    }

    /**
     * [destroy description]
     *
     * @param  User    $role_user [description]
     * @param  Request $request   [description]
     *
     * @return [type]             [description]
     */
    public function destroy(User $role_user, Request $request)
    {
        dd($role_user, $request->all());
    }

    /**
     * Make validation if it's editing to the admin of the system
     *
     * @param  $request
     *
     * @return string|null
     */
    public function specialValidation($request)
    {
        $has_not_admin_role = $request->role ? !in_array(1, $request->role) : false;

        if (( $request->role == null && $request->user_id == 1) ||
            ($has_not_admin_role && $request->user_id == 1)) {

            return 'No se puede dejar al Administrador sin el Rol de Admin';

        }
        return null;
    }
}
