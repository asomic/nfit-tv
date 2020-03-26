<?php

namespace App\Models\System\Users;

use App\Models\Tenant\Users\User;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesSystemConnection;

class Role extends Model
{
    use UsesSystemConnection;

    /**
     * Make easy to identify/assign admin inside system
     */
    const ADMIN = 1;

    /**
     * [users description]
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }
}
