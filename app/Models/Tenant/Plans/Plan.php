<?php

namespace App\Models\Tenant\Plans;

use App\Models\Tenant\Users\User;
use App\Models\Tenant\Clases\Block;
use App\Models\Tenant\Plans\PlanUser;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tenant\Plans\PlanPeriod;
use Hyn\Tenancy\Traits\UsesTenantConnection;


class Plan extends Model
{
    use UsesTenantConnection;

    /**
     *  Get the ID of the PRUEBA PLAN
     *
     *  @var  integer
     */
    const PRUEBA = 1;

    /**
     *  Get the ID of the INVITADO PLAN
     *
     *  @var  integer
     */
    const INVITADO = 2;

    /**
     * Massive assignment for this model
     *
     * @var array
     */
    protected $fillable = [
        'plan',
        'description',
        'plan_period_id',
        'class_numbers',
        'daily_clases',
        'amount',
        'custom',
        'contractable',
        'convenio',
        'discontinued'
    ];

    /**
     *  [activePlans description]
     *
     *  @return  [type]  [return description]
     */
    public function activePlans()
    {
        return $this->whereDiscontinued(false)->get([
            'id', 'plan', 'description', 'plan_period_id',
            'class_numbers', 'daily_clases', 'amount', 'custom',
            'contractable', 'convenio', 'discontinued'
        ]);
    }

    /**
     * [blocks relation to this model]
     *
     * @return App\Models\Clases\Block
     */
    public function blocks()
    {
        return $this->hasMany(Block::class);
    }

    /**
     * [plan_period relation to this model]
     *
     * @return App\Models\Plans\PlanPeriod
     */
    public function plan_period()
    {
        return $this->belongsTo(PlanPeriod::class);
    }

    /**
     * Get all the PlanUser related to this Model
     *
     * @return App\Models\Plans\PlanUser
     */
    public function user_plans()
    {
        return $this->hasMany(PlanUser::class);
    }

    /**
     * Get all the users related to this Model
     *
     * @return App\Models\Users\User
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'plan_user');
    }
}
