<?php

namespace App\Models\Tenant\Users;

use App\Models\Tenant\Users\User;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Role extends Model
{
    use UsesTenantConnection;

    protected $guarded = [];

    /**
     * Make easy to identify/assign admin inside system
     */
    const ADMIN = 1;

    /**
     * Make easy to identify/assign coach inside system
     */
    const COACH = 2;

    /**
     * [users description]
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }
}
