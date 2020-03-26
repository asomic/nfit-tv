<?php

namespace App\Models\Tenant\Users;

use Carbon\Carbon;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use UsesTenantConnection;

    /**
     * [$dates description]
     * @var [type]
     */
	protected $dates = ['from','to'];

    /**
     * Massive Assignment for this Model
     * @var array
     */
    protected $fillable = ['message', 'from', 'to'];

    public function setFromAttribute($value)
    {
        $this->attributes['from'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function setToAttribute($value)
    {
        $this->attributes['to'] = Carbon::parse($value)->format('Y-m-d');
    }
}
