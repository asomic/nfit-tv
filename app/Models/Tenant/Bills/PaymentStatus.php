<?php

namespace App\Models\Tenant\Bills;

use App\Models\Tenant\Bills\Installment;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;


class PaymentStatus extends Model
{
    use UsesTenantConnection;

    /**
     * Massive Assignment for this Model
     * @var array
     */
    protected $fillable = ['payment_status'];

    /**
     * Relationship for Many installments for this model
     * @method installment
     * @return App\Models\Bills\Installment
     */
    public function installments()
    {
        return $this->hasMany(Installment::class);
    }
}
