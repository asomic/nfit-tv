<?php

namespace App\Models\Tenant\Plans;

use Carbon\Carbon;
use App\Models\Tenant\Bills\Bill;
use App\Models\Tenant\Plans\Plan;
use App\Models\Tenant\Users\User;
use App\Models\Tenant\Plans\PlanStatus;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tenant\Clases\Reservation;
use App\Models\Tenant\Plans\PostponePlan;
use App\Models\Tenant\Plans\PlanUserPeriod;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanUser extends Model
{
    use SoftDeletes, UsesTenantConnection;

    /**
     * Table name on Database
     * @var string
     */
    protected $table = 'plan_user';

    /**
     * Massive Assignment for this Model
     * @var array
     */
    protected $fillable = [
        'start_date',
        'finish_date',
        'counter',
        'plan_status_id',
        'plan_id',
        'user_id',
        'observations'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['start_date', 'finish_date', 'deleted_at'];


    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    // protected $appends = ['plan'];

    /**
     * Convert to Carbon date the date who come from Database
     *
     * @param  string $value
     * @return Carbon\Carbon
     */
    public function getStartDateAttribute($value)
    {
        return Carbon::parse($value);
    }

    /**
     * [getPlanAttribute description]
     *
     * @return App\Models\Plans\Plan
     */
    // public function getPlanAttribute()
    // {
    //     return $this->plan()->first();
    // }

    /**
     * [getFinishDateAttribute description]
     * @param  [type] $value [description]
     * @return Carbon/Carbon
     */
    public function getFinishDateAttribute($value)
    {
        return Carbon::parse($value);
    }

    // *
    //  * [plan description]
    //  * @method plan
    //  * @return [model] [description]
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * [user description]
     * @method user
     * @return [model] [description]
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * [bill description]
     * @return [model] [description]
     */
    public function bill()
    {
        return $this->hasOne(Bill::class);
    }

    /**
     * [plan_status description]
     * @return [model] [description]
     */
    public function planStatus()
    {
        return $this->belongsTo(PlanStatus::class);
    }

    /**
     * [plan_user_periods description]
     * @return [model] [description]
     */
    public function planUserPeriods()
    {
        return $this->hasMany(PlanUserPeriod::class);
    }

    /**
     * [reservations description]
     * @return [type] [description]
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Get the information on the postponement of this plan.
     *
     * @return App\Models\Plans\PostponePlan
     */
    public function postpone()
    {
        return $this->hasOne(PostponePlan::class);
    }

    /**
     *  Check if PlanUser is Active
     *
     *  @return  boolean
     */
    public function isActive()
    {
        return $this->plan_status_id === PlanStatus::ACTIVO;
    }

    /**
     * Custom Query tyo return all plans
     *
     * @return  $this
     */
    public function allPlanUser()
    {
        return $this->where('user_id', $user->id)
                    ->orderBy('plan_status_id')
                    ->orderByDesc('start_date')
                    ->with([
                        'plan:id,plan,class_numbers',
                        'planStatus:id,plan_status,can_delete',
                        'bill:id,date,amount,plan_user_id,payment_type_id',
                        'bill.payment_type:id,payment_type'
                    ])
                    ->get([
                        'id', 'start_date', 'finish_date', 'counter',
                        'plan_status_id', 'plan_id', 'user_id'
                    ]);
    }

    /**
     * [storePruebaPlan description]
     *
     * @param   User  $user  [$user description]
     *
     * @return  [type]       [return description]
     */
    public function storePruebaPlan(User $user)
    {
        /** Always need to be first in table the Prueba plan */
        $prueba_plan = Plan::find(1);

        $this->create([
            'plan_id' => $prueba_plan->id,
            'user_id' => $user->id,
            'counter' => $prueba_plan->class_numbers,
            'plan_status_id' => PlanStatus::ACTIVO,
            'start_date' => today(),
            'finish_date' => today()->addDays(7),
        ]);
    }

    /**
     * [storePlanUser description]
     *
     * @param   [type]  $request  [$request description]
     * @param   [type]  $user     [$user description]
     *
     * @return  [type]            [return description]
     */
    public function storePlanUser($request, $user)
    {
        $plan = Plan::find($request->plan_id);

        $counter = $this->calculateCounter($plan, $request->counter);

        return $this->create([
            'plan_id' => $plan->id,
            'user_id' => $user->id,
            'start_date' => Carbon::parse($request->start_date),
            'finish_date' => Carbon::parse($request->finish_date),
            'plan_status_id' => PlanStatus::ACTIVO,
            'counter' => $counter,
            'observations' => $request->observations
        ]);
    }

    /**
     * [calculateCounter description]
     *
     *  @param   [type]  $fechaInicio  [$fechaInicio description]
     *  @param   [type]  $plan         [$plan description]
     *
     *  @return  [type]                [return description]
     */
    protected function calculateCounter($plan, $counter)
    {
        /** The admin choose how many classes */
        if (boolval($plan->custom)) {
            return $counter;
        }

        /** if plan is "Prueba", then put the class numbers of prueba's plan */
        if ($plan->id === 1) {
            return $plan->class_numbers;
        }

        /** If none above, then add months by the period */
        return ($plan->class_numbers * $plan->plan_period->period_number * $plan->daily_clases);
    }

        /**
     * Create a bill from a plan user
     *
     * @param  $request
     * @return App\Models\Bills
     */
    public function createBill($request)
    {
        return Bill::create([
            'plan_user_id' => $this->id,
            'payment_type_id' => $request->payment_type_id,
            'date' => Carbon::parse($request->date),
            'start_date' => $this->start_date,
            'finish_date' => $this->finish_date,
            'detail' => $request->detalle,
            'amount' => $request->amount
        ]);
    }
}

// if ($plan->id == 1) {
//     $planuser->finish_date = Carbon::parse($request->fecha_inicio)->addWeeks(1);

//     $planuser->counter = $plan->class_numbers;
//   } else {
//     $planuser->finish_date = Carbon::parse($request->fecha_inicio)
//                                    ->addMonths($plan->plan_period->period_number)
//                                    ->subDay();

//     $planuser->counter = $plan->class_numbers * $plan->plan_period->period_number * $plan->daily_clases;
// }
// if ($plan->custom ) {
//     $planuser->finish_date = Carbon::parse($request->fecha_termino);

//     $planuser->counter = $request->counter;
// }
