<?php

namespace App\Models\Tenant\Plans;

use App\Models\Tenant\Plans\PlanUser;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;

class PlanUserPeriod extends Model
{
    use UsesTenantConnection;

    /**
     * Massive Assignment for this Model
     * @var array
     */
    protected $fillable = [
        'start_date',
        'finish_date',
        'counter',
        'plan_user_id'
    ];

    /**
     * [planuser description]
     * @return [model] [description]
     */
    public function planuser()
    {
    	return $this->belongsTo(PlanUser::class);
    }
}
