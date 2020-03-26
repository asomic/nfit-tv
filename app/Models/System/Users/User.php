<?php

namespace App\Models\System\Users;

use App\Models\Users\Role;
use Illuminate\Notifications\Notifiable;
use Hyn\Tenancy\Traits\UsesSystemConnection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable, UsesSystemConnection, SoftDeletes;

    /**
     *  [$dates description]
     *
     *  @var [type]
     */
    protected $dates = ['birthdate', 'since', 'deleted_at'];

    /**
     *  Massive Assignment for this Model
     *
     *  @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar',
        'phone', 'birthdate', 'address', 'lat', 'lng'
    ];

    /**
     * [$hidden description]
     *
     * @var [type]
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     *  [assignRole description]
     *
     *  @param  [type] $role [description]
     *
     *  @return [type]       [description]
     */
    public function assignRole($role)
    {
        $role_id = Role::where('role', $role)->first();

        if ($role_id) {
            $this->roles()->attach($role_id);
        }
    }

    /**
     *  [hasRole description]
     *
     *  @param  [type]  $role [description]
     *
     *  @return boolean       [description]
     */
    public function hasRole($role)
    {
        if ($this->roles()->where('id', $role)->exists('id')) {
            return true;
        }

        return false;
    }

    /**
     * Get user roles
     *
     * @return [object] [description]
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
