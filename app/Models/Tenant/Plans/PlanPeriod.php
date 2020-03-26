<?php

namespace App\Models\Tenant\Plans;

use App\Models\Tenant\Plans\Plan;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;


class PlanPeriod extends Model
{
	use UsesTenantConnection;

    /**
     * Massive Assignment for this Model
     * @var array
     */
	protected $fillable = ['period', 'period_number'];

	/**
	* Get all the plan for this PlanPeriod Model
	*
	* @return App\Models\Plans\Plan
	*/
	public function plans()
	{
		return $this->hasMany(Plan::class);
	}
}
