<?php

namespace App\Http\Controllers\Tenant\Admin\Users;

use Illuminate\Http\Request;
use App\Models\Tenant\Users\Role;
use App\Models\Tenant\Users\User;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Users\RoleUser;

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all(['id', 'role']);

        $users = User::with(['roles' => function($query) {
            $query->select('id', 'role');
        }])->get(['id', 'rut', 'first_name', 'last_name']);

        $users_with_roles = User::join('role_user', 'role_user.user_id', '=', 'users.id')

                                ->join('roles', 'role_user.role_id', '=', 'roles.id', 'left outer')

                                ->distinct()

                                ->get(['users.id', 'rut', 'first_name', 'last_name']);

        return view('admin.personal.index', [
            'roles' => $roles,
            'users' => $users,
            'users_with_roles' => $users_with_roles
        ]);
    }

    // public function getUsers(Request $request)
    // {
    //     $columns = array(
    //         0 => 'first_name',
    //         1 => 'rut',
    //     );

    //     $totalData = User::count();

    //     $limit = $request->input('length');

    //     $start = $request->input('start');

    //     $order = $columns[$request->input('order.0.column')];

    //     $dir = $request->input('order.0.dir');

    //     if (empty($request->input('search.value'))) {
    //         $users = User::offset($start)

    //                      ->limit($limit)

    //                      ->orderBy($order, $dir)

    //                      ->select('id', 'first_name', 'last_name', 'rut')

    //                      ->get();

    //         $totalFiltered = $users->count();
    //     } else {
    //         $search = $request->input('search.value');

    //         $users = User::where('first_name', 'like', "%{$search}%")

    //                      ->orWhere('last_name', 'like', "%{$search}%")

    //                      ->offset($start)

    //                      ->limit($limit)

    //                      ->orderBy($order, $dir)

    //                      ->get();

    //         $totalFiltered = $users->count();
    //     }

    //     $data = array();

    //     if ($users) {
    //         foreach ($users as $user) {
    //             $nestedData['id'] = $user->id;

    //             $nestedData['rut'] = $user->rut;

    //             $nestedData['full_name'] = $user->first_name . ' ' . $user->last_name;

    //             $data[] = $nestedData;
    //         }
    //     }

    //     $json_data = array(
    //         "draw" => intval($request->input('draw')),
    //         "recordsTotal" => intval($totalData),
    //         "recordsFiltered" => intval($totalFiltered),
    //         "data" => $data,
    //     );

    //     echo json_encode($json_data);

    //     // $users = User::all(['id', 'first_name', 'last_name', 'rut']);

    //     // return response()->json(['data' => $users]);
    // }
}
