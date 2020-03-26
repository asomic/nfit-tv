<?php

namespace App\Models\Tenant\Plans;

use App\Models\Tenant\Plans\Plan;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class PlanIncomeSummary extends Model
{
    use UsesTenantConnection;

    /**
     * Massive Assignment for this Model
     * @var array
     */
    protected $fillable = ['plan_id', 'amount', 'month', 'year', 'quantity'];

    /**
	 * Table name on Database
	 * @var string
	 */
    protected $table = 'plan_income_summaries';

    /**
     * Get the plan related to this Model
     * @return App\Models\Plans\Plan
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
