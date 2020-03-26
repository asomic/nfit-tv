<?php

namespace App\Models\Tenant\Users;

use App\Models\Tenant\Users\User;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

/** [Emergency description] */
class Emergency extends Model
{
    use UsesTenantConnection;

    /**
     * Massive Assignment for this Model
     * @var array
     */
    protected $fillable = ['user_id', 'contact_name', 'contact_phone'];

    /**
     * [user description]
     * @return [type] [description]
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
