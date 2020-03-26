<?php

namespace App\Models\Tenant\Users;

use Carbon\Carbon;
use Freshwork\ChileanBundle\Rut;
use App\Models\Tenant\Plans\Plan;
use App\Models\Tenant\Users\Role;
use Laravel\Passport\HasApiTokens;
use App\Models\Tenant\Clases\Block;
use App\Models\Tenant\Clases\Clase;
use App\Models\Tenant\Plans\PlanUser;
use App\Models\Tenant\Users\Emergency;
use App\Notifications\MyResetPassword;
use App\Models\Tenant\Plans\PlanStatus;
use App\Models\Tenant\Users\StatusUser;
use Illuminate\Notifications\Notifiable;
use App\Models\Tenant\Clases\Reservation;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, UsesTenantConnection, SoftDeletes;

    /**
     * [$dates description]
     *
     * @var  array
     */
    protected $dates = ['birthdate', 'since', 'deleted_at'];

    /**
     * Massive Assignment for this Model
     *
     * @var  array
     */
    protected $fillable = [
        'rut', 'first_name', 'last_name',
        'email', 'password', 'avatar', 'phone',
        'birthdate', 'gender', 'address',
        'since', 'emergency_id', 'status_user'
    ];

    /**
     *  [$hidden description]
     *
     *  @var [type]
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     *  [$appends description]
     *
     *  @var array
     */
    protected $appends = ['full_name', 'rut_formated', 'status_color'];

    /**
     *  Set birthdate value to American type
     *
     *  @param [type] $value [description]
     */
    public function setBirthdateAttribute($value)
    {
        $this->attributes['birthdate'] = Carbon::parse($value)->format('Y-m-d');
    }

    /**
     *  set since date (user initiation), to American date
     *
     *  @param [type] $value [description]
     */
    public function setSinceAttribute($value)
    {
        $this->attributes['since'] = Carbon::parse($value)->format('Y-m-d');
    }

    // /**
    //  *  [setRutAttribute description]
    //  *
    //  *  @param [type] $value [description]
    //  */
    // public function setRutAttribute($value)
    // {
    //     dd($value);
    //     $this->attributes['rut'] = Rut::parse($value)->number();
    // }

    /**
     *  get user role for navigation
     *
     *  @return [type] [description]
     */
    public static function navigation()
    {
        return auth()->check() ? auth()->user()->role->role : 'guest';
    }

    /**
     *  By-Pass notification to send pass reset
     *
     *  @param  [type] $token [description]
     *
     *  @return [type]        [description]
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MyResetPassword($token));
    }

    /**
     *  [getFullNameAttribute description]
     *
     *  @return [type] [description]
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * getRutAttribute
     *
     * @return [type] [description]
     */
    public function getRutFormatedAttribute()
    {
        return Rut::set($this->rut)->fix()->format();
    }

    /**
     * getRutAttribute
     *
     * @return [type] [description]
     */
    public function getStatusColorAttribute()
    {
        return app(StatusUser::class)->getColorUser($this->status_user);
    }

    /**
     *  Relationship to StatusUser
     *
     *  @return  StatusUser
     */
    public function statusUser()
    {
        return $this->belongsTo(StatusUser::class);
    }

    /**
     * get avatar of the user profile
     *
     * @param  [string] $value
     * @return [object]
     */
    public function getAvatarAttribute($value)
    {
        if ( !$value ) {
            return url('img/default_user.png');
        }

        return $value;
    }

    /**
     * [scopeCountStatusUsers description]
     *
     * @param  [type] $users [description]
     * @return [type]        [description]
     */
    public function scopeCountStatusUsers($users)
    {
        $users->groupBy('status_user')
              ->selectRaw('count(id) as total, status_user');
    }

    /**
     * Scope a query to get all the users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAllUsers($query)
    {
        $query->select(['id', 'rut', 'first_name', 'last_name', 'email', 'avatar', 'status_user'])
              ->with(['actualPlan:id,start_date,finish_date,user_id,plan_id',
                      'actualPlan.plan:id,plan'
                    ]);
    }

    /**
     * Obtener el plan activo del usuario
     *
     * @return [type] [description]
     */
    public function actualPlan()
    {
        return $this->hasOne(PlanUser::class)
                    ->where('plan_status_id', 1)
                    ->where('start_date', '<=', today())
                    ->where('finish_date', '>=', today());
    }

    /**
     * [assignRole description]
     *
     * @param  [type] $role [description]
     * @return [type]       [description]
     */
    public function assignRole($role)
    {
        $role_id = Role::where('role', $role)->first();

        if ($role_id) {
            $this->roles()->attach($role_id);
        }
    }

    /**
     * get all users who are on birthday
     *
     * @return [object] [description]
     */
    public function birthdateUsers()
    {
        return User::whereMonth('birthdate', toDay()->month)
                   ->whereDay('birthdate', toDay()->day)
                   ->get(['id', 'first_name', 'last_name', 'avatar', 'birthdate']);
    }

    /**
     * [blocks description]
     *
     * @return [type] [description]
     */
    public function blocks()
    {
        return $this->hasMany(Block::class);
    }

    /**
     * [bills description]
     *
     * @return [type] [description]
     */
    public function bills()
    {
        return $this->hasManyThrough(
            Bill::class, PlanUser::class, 'user_id', 'plan_user_id'
        );
    }

    /**
     * [clases description]
     *
     * @return [type] [description]
     */
    public function clases()
    {
        return $this->belongsToMany(Clase::class, 'reservations', 'user_id', 'clase_id');
    }

    /**
     * emergency method to get emergency user's contact
     *
     * @return [object] [description]
     */
    public function emergency()
    {
        return $this->hasOne(Emergency::class);
    }

    /**
     * get future user reservations
     *
     * @return [type] [description]
     */
    public function futureReservs()
    {
        return $this->HasMany(Reservation::class)
                    ->whereIn('reservation_status_id', [1, 2])
                    ->take(10);
    }

    /**
     * Reservations 'Consumidas' and 'perdidas'
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function pastReservations()
    {
        return Reservation::where('user_id', $this->id)
                          ->whereIn('reservation_status_id', [3,4])
                          ->with(['clase:id,date,start_at,finish_at',
                                  'reservationStatus:id,reservation_status',
                                  'plan_user:id,plan_id',
                                  'plan_user.plan:id,plan'])
                          ->get(['id', 'clase_id', 'user_id',
                                 'plan_user_id', 'reservation_status_id'
                            ]);
    }

    /**
     * [hasRole description]
     *
     * @param  [type]  $role [description]
     * @return boolean       [description]
     */
    public function hasRole($role)
    {
        if ($this->roles()->where('id', $role)->exists('id')) {
            return true;
        }

        return false;
    }

    /**
     * get true or false if user is on birthday
     *
     * @return [object] [description]
     */
    public function itsBirthDay()
    {
        if ($this->birthdate->month == toDay()->month &&
            $this->birthdate->day == toDay()->day) {
            return true;
        }

        return false;
    }

    /**
     * get the last user plan
     *
     * @return [type] [description]
     */
    public function lastPlan()
    {
        return $this->hasOne(PlanUser::class)
                    ->where('plan_status_id', '!=', 5)
                    ->orderByDesc('finish_date');
    }

    /**
     * get past user resrevations
     *
     * @return [type] [description]
     */
    public function pastReservs()
    {
        return $this->HasMany(Reservation::class)
                    ->whereIn('reservation_status_id', [3, 4])
                    ->orderByDesc('updated_at');
    }

    /**
     * [plans description]
     *
     * @return [type] [description]
     */
    public function plans()
    {
        return $this->belongsToMany(Plan::class)
                    ->wherePivot('deleted_at', null);
    }

    /**
     * [userPlans description]
     *
     * @return [type] [description]
     */
    public function userPlans()
    {
        return PlanUser::where('user_id', $this->id)
                       ->with(['bill:id,date,amount,payment_type_id,plan_user_id',
                                'bill.payment_type:id,payment_type',
                                'plan:id,plan,class_numbers',
                                'planStatus:id,plan_status,type,can_delete',
                                'postpone',
                                'user:id,first_name'])
                       ->get(['id', 'start_date', 'finish_date',
                              'counter', 'plan_id', 'plan_status_id', 'user_id'
                        ]);
    }

    /**
     * [regular_users description]
     *
     * @return [collection] [description]
     */
    public function regularUsers()
    {
        return User::all()
                   ->where('admin', 'false')
                   ->orderBy('name');
    }

    /**
     * get all user plans who can used for class reserv
     */
    public function reservablePlans()
    {
        return $this->hasMany(PlanUser::class)
                    ->whereIn('plan_status_id', [PlanStatus::ACTIVO, PlanStatus::PRECOMPRA]);
    }

    /**
     * method to get user reservations
     *
     * @return [object] [description]
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Get user roles
     *
     * @return [object] [description]
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
