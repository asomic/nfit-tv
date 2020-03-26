<?php

namespace App\Models\Tenant\Users;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use App\Models\Tenant\Users\NotificationStatus;

class Notification extends Model
{
	use UsesTenantConnection;

	/**
     *  Massive Assignment for this Model
     *
     *  @var  array
     */
    protected $fillable = ['title', 'body', 'users', 'sended', 'trigger_at'];

    /**
     *  [$dates description]
     *
     *  @var  array
     */
    protected $dates = ['trigger_at', 'created_at', 'updated_at'];

    /**
     *  Relation to NotificationStatus
     *
     *  @return  Model
     */
    public function status()
    {
        return app(NotificationStatus::class);
    }

    /**
     *  methodDescription
     *
     *  @return  string  'PROGRAMADO' | 'ENVIADO'
     */
    public function getStatus()
    {
        return $this->status()->reservationStatus($this->sended);
    }

    /**
     *  Return a Css color
     *
     *  @return  string  'warning' | 'success'
     */
    public function getStatusColor()
    {
        return $this->status()->reservationStatusColor($this->sended);
    }
}
