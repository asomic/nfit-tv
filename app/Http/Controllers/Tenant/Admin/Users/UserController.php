<?php

namespace App\Http\Controllers\Tenant\Admin\Users;

use Session;
use Redirect;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Imports\UsersImport;
use App\Exports\UsersExport;
use Freshwork\ChileanBundle\Rut;
use App\Models\Tenant\Users\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\VueTables\EloquentVueTables;
use App\Models\Tenant\Users\Emergency;
use App\Http\Requests\Tenant\Users\UserRequest;

class UserController extends Controller
{
    /** @var array Make status user array */
    private $status = [0 => 'SIN ESTADO', 1 => 'ACTIVO', 2 => 'INACTIVO', 3 => 'PRUEBA'];

    /** @var array Make styles badges */
    private $badges = [0 => 'secondary', 1 => 'success', 2 => 'danger', 3 => 'warning'];

    /**
     * Return to 'create user' view
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        return view('tenant.users.create');
    }

    /**
     * Return to 'index users' view
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $status_users = User::CountStatusUsers()->get();

        return view('tenant.users.index', compact('status_users'));
    }

    /**
     * Return to 'user show' with an specific User model instance
     *
     * @param  App\Models\Users\User   $user
     *
     * @return Illuminate\View\View
     */
    public function show(User $user)
    {
        return view(
            'tenant.users.show', [
                'user' => $user,
                'status_users' => User::CountStatusUsers()->get(),
                'pastReservations' => $user->pastReservations(),
                'auth_roles' => auth()->user(['id'])->roles()->orderBy('role_id')->pluck('id')->toArray()
            ]
        );
    }

    /**
     * [edit description]
     *
     * @return  view
     */
    public function edit(User $user)
    {
        return view('tenant.users.edit')->with('user', $user);
    }

    /**
     * [store description]
     *
     * @param  Illuminate\Http\Request $request [description]
     * @param  User    $user    [description]
     *
     * @return [type]           [description]
     */
    public function store(UserRequest $request, User $user)
    {
        $user = User::create($request->all());

        $emergency = Emergency::create(array_merge($request->all(), [
            'user_id' => $user->id,
        ]));

        if ($user->save()) {
            $status_users = User::CountStatusUsers()->get();

            $pastReservations = $user->pastReservations();

            $auth_roles = auth()->user(['id'])->roles()->orderBy('role_id')->pluck('id')->toArray();

            Session::flash('success', 'El usuario ha sido creado correctamente');

            return view('tenant.users.show', compact(
                'user', 'status_users', 'pastReservations', 'auth_roles'
            ));
        }

        return redirect()->back();
    }

    /**
     * [update description]
     *
     * @param   UserRequest  $request
     * @param   integer
     *
     * @return  json
     */
    public function update(UserRequest $request, User $user)
    {
        // if ($request->image) {
        //     $avatar_name = md5(mt_rand());

        //     request()->file('image')->storeAs('public/users', "{$avatar_name}.jpg");

        //     $user->update(['avatar' => url("storage/users/$avatar_name.jpg")]);
        // }

        $user->update([
            'rut' => Rut::parse($request->rut)->number(),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'birthdate' => Carbon::parse($request->birthdate),
            'address' => $request->address,
            'since' => $request->since
        ]);

        return back()->with('success', 'Datos actualizados correctamente');
    }

    /**
     * Through ajax,
     * get all users who meet certain requirements, indicated in the table of all users
     *
     * @return json
     */
    public function usersJson()
    {
        $users = User::allUsers()->get();

        return response()->json(['data' => $users]);
    }

    /**
     * [export description]
     *
     * @return [type] [description]
     */
    public function export()
    {
        return Excel::download(new UsersExport, toDay()->format('d-m-Y') . '_usuarios.xls');
    }

    /**
     * [import description]
     *
     * @param  Request $request [description]
     *
     * @return [type]           [description]
     */
    public function import(Request $request)
    {
        Excel::import(new UsersImport, $request->file('excel'));

        return back()->with('success', 'Se ha subido!');
    }

    /**
     * [excel description]
     *
     * @return [type] [description]
     */
    public function excel()
    {
        return view('admin.files.import-files');
    }

    /**
     * Request for the auth user profile
     * @return [json] [return authenticated user]
     */
    public function profile()
    {
        $user = auth()->user();

        return $user;
    }
}
