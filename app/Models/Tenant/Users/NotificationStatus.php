<?php

namespace App\Models\Tenant\Users;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;

class NotificationStatus extends Model
{
    use UsesTenantConnection;

    /**
     *  Assign notification status by number
     *
     *  @var integer
     */
    const PROGRAMADO = 0;

    /**
     *  Assign notification status by number
     *
     *  @var integer
     */
    const ENVIADO = 1;

    /**
     *  Get all Notifications Statuses
     *
     *  @return  array
     */
    public function listNotificationStatuses()
    {
        return [
            self::PROGRAMADO => 'PROGRAMADO',
            self::ENVIADO => 'ENVIADO'
        ];
    }

    /**
     *  Get all Notifications Statuses
     *
     *  @return  array
     */
    public function listNotificationStatuseColors()
    {
        return [
            self::PROGRAMADO => 'warning',
            self::ENVIADO => 'success'
        ];
    }

    /**
     *  Return an Status ['PROGRAMADO', 'ENVIADO']
     *
     *  @param   integer   Id for a status
     *
     *  @return  string    A Notification Status
     */
    public function reservationStatus($notificationStatusId = null)
    {
        $notification_statuses = $this->listNotificationStatuses();

        return $notification_statuses[$notificationStatusId] ?? 'SIN ESTADO';
    }

    /**
     *  Return an Status ['PROGRAMADO', 'ENVIADO']
     *
     *  @param   integer   Id for a status
     *
     *  @return  string    A Notification Status
     */
    public function reservationStatusColor($notificationStatusId = null)
    {
        $notification_statuses = $this->listNotificationStatuseColors();

        return $notification_statuses[$notificationStatusId] ?? 'SIN ESTADO';
    }
}
