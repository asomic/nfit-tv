<?php

namespace App\Models\Tenant\Wods;

use App\Models\Tenant\Exercises\Stage;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class StageType extends Model
{
	use UsesTenantConnection;

	/**
     * Massive Assignment for this Model
     *
     * @var array
     */
	protected $fillable = ['stage_type', 'clase_type_id', 'featured'];

    /**
     * [stages description]
     *
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
	public function stages()
	{
		return $this->hasMany(Stage::class);
    }

    /**
  	 * Get the clase type who this model belongs
  	 *
  	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
  	 */
  	public function clase_type()
  	{
  		return $this->belongsTo(ClaseType::class);
  	}
}
