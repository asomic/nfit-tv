<?php

namespace App\Models\Tenant\Clases;

use App\Models\Tenant\Clases\Block;
use App\Models\Tenant\Plans\Plan;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;

class BlockPlan extends Model
{
	use UsesTenantConnection;

	/**
	 * [block description]
	 * @return [model] [return block model]
	 */
    public function block()
	{
		return $this->belongsTo(Block::class);
	}

	/**
	 * [plan description]
	 * @return [model] [return plan model]
	 */
	public function plan()
	{
		return $this->belongsTo(Plan::class);
	}
}
