<?php

namespace App\Models\Tenant\Bills;

use App\Models\Tenant\Bills\Bill;
use App\Models\Tenant\Plans\PlanUser;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tenant\Bills\PaymentStatus;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\SoftDeletes;

/** [Installment description] */
class Installment extends Model
{
    use SoftDeletes, UsesTenantConnection;

    protected $dates = ['deleted_at'];

    /**
     * Massive Assignment for this Model
     * @var array
     */
    protected $fillable = [
        'bill_id',
        'payment_status_id',
        'commitment_date',
        'expiration_date',
        'payment_date'.
        'amount',
    ];

    /**
     * [bill description]
     * @return [type] [description]
     * @method bill
     */
    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

  /**
   * [payment_status description]
   * @method payment_status
   * @return [type]         [description]
   */
  public function payment_status()
  {
    return $this->belongsTo(PaymentStatus::class);
  }

  /**
   * [plan_cliente description]
   * @method plan_cliente
   * @return [type]       [description]
   */
  public function plan_user()
  {
    return $this->belongsTo(PlanUser::class);
  }

}
