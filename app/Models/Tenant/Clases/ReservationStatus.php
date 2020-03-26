<?php

namespace App\Models\Tenant\Clases;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tenant\Clases\Reservation;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class ReservationStatus extends Model
{
    use UsesTenantConnection;

    /**
     *  Reservation Status id
     *
     *  @var  integer
     */
    const PENDIENTE = 1;

    /**
     * Reservation Status id
     *
     * @var  integer
     */
    const CONFIRMADA = 2;

    /**
     * Reservation Status id
     *
     * @var  integer
     */
    const CONSUMIDA = 3;

    /**
     * Reservation Status id
     *
     * @var  integer
     */
    const PERDIDA = 4;

    /**
     *  Return all ReservationsStatus
     *
     *  @return  array
     */
    public function listReservationStatuses()
    {
        return [
            self::PENDIENTE => 'PENDIENTE',
            self::CONFIRMADA => 'CONFIRMADA',
            self::CONSUMIDA => 'CONSUMIDA',
            self::PERDIDA => 'PERDIDA',
        ];
    }

    /**
     *  Return all ReservationStatusColors
     *
     *  @return  array
     */
    public function listReservationStatusColors()
    {
        return [
            self::PENDIENTE => 'warning',
            self::CONFIRMADA => 'success',
            self::CONSUMIDA => 'info',
            self::PERDIDA => 'danger',
        ];
    }

    /**
     *  Return a ReservationStatus by an specific Id
     *
     *  @param   integer   Id for a status
     *
     *  @return  string    A Reservation Status
     */
    public function getReservationStatus($reservationStatusId)
    {
        $reservation_statuses = $this->listReservationStatuses();

        return $reservation_statuses[$reservationStatusId] ?? 'SIN ESTADO';
    }

    /**
     *  Return a Css type color by an specific Status Id
     *
     *  @param   integer   Id for a status
     *
     *  @return  string    A Reservation Status Color (CSS)
     */
    public function getColorReservation($reservationStatusId = null)
    {
        $reservation_status_colors = $this->listReservationStatusColors();

        return $reservation_status_colors[$reservationStatusId] ?? '';
    }

    /**
     *  return Reservations associated to an specific Status
     *
     *  @return  App\Models\Tenant\Clases\Reservation
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
