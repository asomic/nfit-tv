<?php

namespace App\Models\Tenant\Wods;

use App\Models\Tenant\Wods\Wod;
use App\Models\Tenant\Clases\Clase;
use App\Models\Tenant\Wods\StageType;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tenant\Clases\ClaseStage;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Stage extends Model
{
	use UsesTenantConnection;

    /**
     * Massive Assignment for this Model
     *
     * @var array
     */
	protected $fillable = [
		'wod_id',
		'stage',
		'stage_type_id',
		'name',
		'description',
		'star'
	];

	/**
	 * Relationship to get the wod who belongs this model
	 *
	 * @return App\Models\Wods\Wod
	 */
	public function wod()
	{
		return $this->belongsTo(Wod::class);
	}

	/**
	 * Relationship to get the Stage Type who belongs this model
	 *
	 * @return App\Models\Wods\StageType
	 */
	public function stage_type()
	{
		return $this->belongsTo(StageType::class);
	}
}
