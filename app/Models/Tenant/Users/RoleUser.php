<?php

namespace App\Models\Tenant\Users;

use App\Models\Tenant\Users\Role;
use App\Models\Tenant\Users\User;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
	use UsesTenantConnection;

	/**
	 * Table name on Database
	 * @var string
	 */
	protected $table = 'role_user';

    /**
     * Massive Assignment for this Model
     * @var array
     */
	protected $fillable = ['role_id', 'user_id'];

	public function role()
	{
		return $this->belongsTo(Role::class);
	}

    public function user()
	{
		return $this->belongsTo(User::class);
	}
}
