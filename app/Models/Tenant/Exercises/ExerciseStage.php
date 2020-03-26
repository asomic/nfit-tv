<?php

namespace App\Models\Tenant\Exercises;

use App\Models\Tenant\Exercises\Stage;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tenant\Exercises\Exercise;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use App\Models\Tenant\Clases\ReservationStatisticStage;

class ExerciseStage extends Model
{
	use UsesTenantConnection;

	/**
	 * [reservation_statistic_stages description]
	 * @method reservation_statistic_stages
	 * @return App\Models\Clases\ReservationStatisticStage
	 */
	public function reservation_statistic_stages()
	{
	  return $this->hasMany(ReservationStatisticStage::class);
	}

	/**
	 * [stage relation to this model]
	 *
	 * @return [model] [return stage model]
	 */
	public function stage()
	{
		return $this->belongsTo(Stage::class);
	}

	/**
	 * [exercise relation to this model]
	 *
	 * @return [model] [return exercise model]
	 */
	public function exercise()
	{
		return $this->belongsTo(Exercise::class);
	}
}
