<?php

namespace App\Models\Tenant\Bills;

use Carbon\Carbon;
use App\Models\Tenant\Users\User;
use App\Models\Tenant\Plans\PlanUser;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tenant\Bills\Installment;
use App\Models\Tenant\Bills\PaymentType;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Tenant\Plans\PlanIncomeSummary;

/**
 * [Bill description]
 */
class Bill extends Model
{
    use SoftDeletes, UsesTenantConnection;

    protected $dates = ['deleted_at','date'];

    /**
     * Massive assignment for this model
     * @var array
     */
    protected $fillable = ['payment_type_id', 'plan_user_id', 'date', 'start_date', 'finish_date', 'detail', 'amount'];

    protected $appends = ['date_formated'];

    public function getDateFormatedAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    /**
     * [installments description]
     * @method installments
     * @return [model]       [description]
     */
    public function installments()
    {
      return $this->hasMany(Installment::class);
    }

    /**
     * [payment_type description]
     * @method payment_type
     * @return [model]       [description]
     */
    public function payment_type()
    {
      return $this->belongsTo(PaymentType::class);
    }

    /**
     * [user description]
     * @method user
     * @return [type] [description]
     */
    // public function user()
    // {
    //     return $this->hasManyThrough('App\Models\Users\User',
    //                                  'App\Models\Plans\PlanUser', 'user_','user_id');
    //     // return $this->belongsToMany(User::class);
    // }

    public function plan_user()
    {
        return $this->belongsTo('App\Models\Tenant\Plans\PlanUser');
    }

    /**
     * [storeBill description]
     *
     * @param   [type]  $request   [$request description]
     * @param   [type]  $planuser  [$planuser description]
     *
     * @return  [type]             [return description]
     */
    public function storeBill($request, $planuser)
    {
        $this->create([
            'plan_user_id' => $planuser->id,
            'payment_type_id' => $request->payment_type_id,
            'date' => Carbon::parse($request->date),
            'start_date' => $planuser->start_date,
            'finish_date' => $planuser->finish_date,
            'detail' => $request->detalle,
            'amount' => $request->amount,
        ]);
    }

    public function updateBillIncome($plan_saved, $request)
    {
        if ($plan_saved->bill) {
            $plan_income_sum = PlanIncomeSummary::where('month', $plan_saved->bill->date->month)
                                                ->where('year', $plan_saved->bill->date->year)
                                                ->where('plan_id', $plan_saved->bill->plan_user->plan->id)
                                                ->first();

            if ($plan_income_sum) {
                $plan_income_sum->amount -= $plan_saved->bill->amount;

                $plan_income_sum->quantity -= 1;

                $plan_income_sum->save();
            }
        }

        $this->update([
            'plan_user_id' => $plan_saved->id,
            'payment_type_id' => $request->payment_type_id ?? 1,
            'date' => $request->date ? Carbon::parse($request->date) : $this->date,
            'start_date' => $plan_saved->start_date,
            'finish_date' => $plan_saved->finish_date,
            'detail' => $request->detalle,
            'amount' => $request->amount,
        ]);

        return $plan_saved;
    }
}
