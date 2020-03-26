<?php

namespace App\Models\Tenant\Exercises;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use App\Models\Tenant\Clases\ReservationStatisticStage;

/**
 * [Statistic description]
 */
class Statistic extends Model
{
    use UsesTenantConnection;

    /**
     * Massive Assignment for this Model
     *
     * @var array
     */
    protected $fillable = ['statistic'];

    /**
     * [reservation_statistic_stages description]
     *
     * @return App\Models\Clases\ReservationStatisticStage
     */
    public function reservation_statistic_stages()
    {
        return $this->hasMany(ReservationStatisticStage::class);
    }
}
