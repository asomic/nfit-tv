<?php

namespace App\Http\Controllers\Tenant\Admin;

use Session;
use App\Models\Tenant\Users\User;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Clases\ClaseType;
use App\Models\Tenant\Settings\Parameter;

class AdminController extends Controller
{
    /**
     * [clasesConfig description]
     *
     * @return [type] [description]
     */
    public function clasesConfig()
    {
        $clase_type = ClaseType::first();

        if ( !Session::has('clases-type-id') && $clase_type) {
            Session::put('clases-type-id', $clase_type->id);

            Session::put('clases-type-name', $clase_type->clase_type);
        }

        $config_data = Parameter::first();

        return view('tenant.clases.config', ['data' => $config_data]);
    }

    /**
     * [coaches description]
     *
     * @return [type] [description]
     */
    public function coaches()
    {
        $users = User::join('role_user', 'users.id', '=', 'role_user.user_id')
            ->where('role_user.role_id', 2)
            ->get();

        return response()->json($users);
    }

    /**
     * [claseTypes description]
     *
     * @return [type] [description]
     */
    public function claseTypes()
    {
        $clase_types = ClaseType::all();

        return response()->json($clase_types);
    }
}
