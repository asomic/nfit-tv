<?php

namespace App\Models\Tenant\Clases;

use App\Models\Tenant\Plans\Plan;
use App\Models\Tenant\Users\User;
use App\Models\Tenant\Clases\Clase;
use App\Models\Tenant\Clases\ClaseType;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Block extends Model
{
    use UsesTenantConnection;

    /**
     * Table name on Database
     *
     * @var string
     */
    protected $table = 'blocks';

    /**
     * Massive Assignment for this Model
     *
     * @var array
     */
    protected $fillable = ['start',
        'end',
        'dow',
        'title',
        'date',
        'profesor_id',
        'quota',
        'clase_type_id'
    ];

    // protected $appends = ['plans_id', 'color', 'textColor'];
    // protected $with = array('plans');

    //transformamos el valor de dow a un arraglo para fullcalendar
    public function getDowAttribute($value)
    {
        $array = [];
        array_push($array, $value);
        return $array;
    }

    /**
     * [plans description]
     *
     * @return  [type]  [return description]
     */
    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'block_plan');
    }

    /**
     * [user description]
     *
     * @return  [type]  [return description]
     */
    public function coach()
    {
        return $this->belongsTo(User::class, 'profesor_id');
    }

    /**
     * [claseType description]
     *
     * @return  [type]  [return description]
     */
    public function claseType()
    {
        return $this->belongsTo(ClaseType::class);
    }

    /**
     * [getPlansIdAttribute description]
     *
     * @return  [type]  [return description]
     */
    public function getPlansIdAttribute()
    {
        return $this->plans->pluck('id');
    }

    /**
     * [getStartAttribute description]
     *
     * @param   [type]  $value  [$value description]
     *
     * @return  [type]          [return description]
     */
    public function getStartAttribute($value)
    {
        if ($this->date != null) {
            return "{$this->date} {$value}";
        }

        return $value;
    }

    /**
     * [getEndAttribute description]
     *
     * @param   [type]  $value  [$value description]
     *
     * @return  [type]          [return description]
     */
    public function getEndAttribute($value)
    {
        if ($this->date != null) {
            return "{$this->date} {$value}";
        }

        return $value;
    }

    /**
     * [getColorAttribute description]
     *
     * @return  [type]  [return description]
     */
    public function getColorAttribute()
    {
        return $this->claseType->clase_color;
    }

    /**
     * [getTextColorAttribute description]
     *
     * @return  [type]  [return description]
     */
    public function getTextColorAttribute()
    {
        return $this->claseType->text_color;
    }

    /**
     * [clases description]
     *
     * @return  [type]  [return description]
     */
    public function clases()
    {
        return $this->hasMany(Clase::class);
    }
}
