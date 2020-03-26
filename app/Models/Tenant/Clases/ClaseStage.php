<?php

namespace App\Models\Tenant\Clases;

use App\Models\Tenant\Clases\Clase;
use App\Models\Tenant\Exercises\Stage;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;

class ClaseStage extends Model
{
    use UsesTenantConnection;
	/**
	 * Table name on Database
	 * @var string
	 */
	protected $table = 'clase_stage';

    /**
     * Massive Assignment for this Model
     * @var array
     */
	protected $fillable = ['clase_id', 'stage_id'];

	/**
	 * [clase relation to this model]
	 * @return [model] [description]
	 */
	public function clase()
	{
		return $this->belongsTo(Clase::class);
	}

	/**
	 * [stage relation to this model]
	 * @return [model] [description]
	 */
	public function stage()
	{
		return $this->belongsTo(Stage::class);
	}
}
