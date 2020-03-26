<?php

namespace App\Models\Tenant\Clases;

use App\Models\Tenant\Users\User;
use App\Models\Tenant\Clases\Clase;
use App\Models\Tenant\Plans\PlanUser;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use App\Models\Tenant\Clases\ReservationStatus;
use App\Models\Tenant\Clases\ReservationStatisticStage;

class Reservation extends Model
{
    use UsesTenantConnection;

    /**
     * [$dates description]
     *
     * @var  array
     */
    protected $dates = ['deleted_at'];

    /**
     * Massive Assignment for this Model
     *
     * @var array
     */
    protected $fillable = [
        'plan_user_id', 'clase_id',
        'reservation_status_id', 'user_id',
        'by_god', 'details'
    ];

    protected $appends = ['status_color'];

    /**
     *  Get status Color by type
     *
     *  @return  string
     */
    public function getStatusColorAttribute()
    {
        return app(ReservationStatus::class)->getColorReservation($this->reservation_status_id);
    }

    /**
     * [reservation_statistic_stages description]
     *
     * @method reservation_statistic_stages
     *
     * @return [type]                       [description]
     */
    public function reservation_statistic_stages()
    {
        return $this->hasMany(ReservationStatisticStage::class);
    }

    /**
     * [user description]
     *
     * @return [type] [description]
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * [clase description]
     *
     * @return  [type]  [return description]
     */
    public function clase()
    {
        return $this->belongsTo(Clase::class);
    }

    /**
     * [reservation_status description]
     *
     * @return  [type]  [return description]
     */
    public function reservationStatus()
    {
        return $this->belongsTo(ReservationStatus::class);
    }

    /**
     * [plan_user description]
     *
     * @return  [type]  [return description]
     */
    public function plan_user()
    {
      return $this->belongsTo(PlanUser::class);
    }
}
