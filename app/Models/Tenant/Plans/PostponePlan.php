<?php

namespace App\Models\Tenant\Plans;

use App\Models\Tenant\Plans\PlanUser;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class PostponePlan extends Model
{
	use UsesTenantConnection;

	/**
	 * [$table description]
	 * @var string
	 */
	protected $table = 'freeze_plans';

	/**
	 * [$fillable description]
	 * @var [type]
	 */
	protected $fillable = ['plan_user_id', 'start_date', 'finish_date'];

	/**
	 * [$dates description]
	 * @var [type]
	 */
	protected $dates = ['start_date', 'finish_date'];

	/**
	 * PlanUser Relationship
	 * @return Eloquent class
	 */
	public function plan_user()
	{
		return $this->belongsTo(PlanUser::class, 'plan_user_id');
	}
}
