<?php

namespace App\Models\Tenant\Clases;

use App\Models\Tenant\Clases\Reservation;
use App\Models\Tenant\Exercises\ExerciseStage;
use App\Models\Tenant\Exercises\Statistic;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * [ReservationStatisticStage description]
 */
class ReservationStatisticStage extends Model
{
    use SoftDeletes, UsesTenantConnection;

    protected $dates = ['deleted_at'];

    /**
     * Massive Assignment for this Model
     * @var array
     */
    protected $fillable = [
        'statistic_id',
        'reservation_id',
        'stage_exercise_id',
        'weight',
        'time',
        'round',
        'repetitions',
    ];

    /**
     * [stage description]
     * @method stage
     * @return [type] [description]
     */
    public function excercise_stage()
    {
        return $this->belongsTo(ExerciseStage::class);
    }

    /**
     * [reservation description]
     * @method reservation
     * @return [type]      [description]
     */
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    /**
     * [statistic description]
     * @method statistic
     * @return [type]    [description]
     */
    public function statistic()
    {
        return $this->belongsTo(Statistic::class);
    }
}
