<?php

namespace App\Models\Tenant\Exercises;

use App\Models\Tenant\Exercises\ExerciseStage;
use App\Models\Tenant\Exercises\Stage;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;

/**
 * [Exercise description]
 */
class Exercise extends Model
{
    use UsesTenantConnection;

    /**
     * Massive Assignment for this Model
     * @var array
     */
    protected $fillable = ['exercise'];

    /**
     * [stages relation]
     * @return [model] [description]
     */
    public function stages()
    {
       return $this->belongsToMany(Stage::class)->using(ExerciseStage::class);
    }
}
