<?php

namespace App\Models\Tenant\Clases;

use Carbon\Carbon;
use App\Models\Tenant\Wods\Wod;
use App\Models\Tenant\Users\User;
use App\Models\Tenant\Wods\Stage;
use App\Models\Tenant\Clases\ClaseType;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tenant\Clases\Reservation;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clase extends Model
{
    use SoftDeletes, UsesTenantConnection;

    /**
     *  Table name on Database
     *
     *  @var string
     */
    protected $table = 'clases';

    /**
     *  Massive Assignment for this Model
     *
     *  @var array
     */
    protected $fillable = [
        'date', 'start_at', 'finish_at',
        'room', 'profesor_id', 'quota',
        'block_id', 'clase_type_id'
    ];

    /**
     *  [$dates description]
     *
     *  @var array
     */
    protected $dates = ['deleted_at'];

    /**
     *  values to append on querys
     *
     *  @var [type]
     */
    protected $appends = [
        'start', 'end', 'allDay', 'url', 'reservation_count',
        'color', 'text_color', 'date_time_start'
    ];

    /**
     *  [getAllDayAttribute description]
     *
     *  @return  [type]  [return description]
     */
    public function getAllDayAttribute()
    {
        return false;
    }

    /**
     * [reservations description]
     *
     * @return [type] [description]
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     *  [wod description]
     *
     *  @return [type] [description]
     */
    public function wod()
    {
        return $this->belongsTo(Wod::class);
    }

    /**
     *  [users relation to this model]
     *
     *  @return [model] [description]
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->using(Reservation::class);
    }

    /**
     *  [claseType description]
     *
     *  @return [type] [description]
     */
    public function claseType()
    {
        return $this->belongsTo(ClaseType::class);
    }

    /**
     *  [profesor relation to this model]
     *
     *  @return  [model] [description]
     */
    public function profesor()
    {
        return $this->belongsToMany(User::class)->using(Reservation::class);
    }

    /**
     *  [block relation to this model]
     *
     *  @return [model] [description]
     */
    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    /**
     *  [getReservationCountAttribute description]
     *
     *  @return [type] [description]
     */
    public function getReservationCountAttribute()
    {
        return $this->hasMany(Reservation::class)->count('id');
    }

    /**
     *  Get Y-m-d H:i:s format for clase
     *
     *  @return  Carbon\Carbon
     */
    public function getDateTimeStartAttribute()
    {
        return Carbon::createFromFormat(
            'Y-m-d H:i:s',
            "{$this->attributes['date']} {$this->attributes['start_at']}"
        );
    }

    /**
     *  [getStartAttribute description]
     *
     *  @return [type] [description]
     */
    public function getStartAttribute()
    {
        if ($this->block->date === null) {
            return "{$this->date} {$this->block->start}";
        }

        return $this->block->start;
    }

    /**
     *  [getEndAttribute description]
     *
     *  @return [type] [description]
     */
    public function getEndAttribute()
    {
        if ($this->block->date == null) {
            return "{$this->date} {$this->block->end}";
        }

        return $this->block->end;
    }

    /**
     *  [getUrlAttribute description]
     *
     *  @return [type] [description]
     */
    public function getUrlAttribute()
    {
        return url("admin/clases/{$this->id}");
    }

    /**
     *  [getColorAttribute description]
     *
     *  @return [type] [description]
     */
    public function getColorAttribute()
    {
        return $this->claseType->clase_color;
    }

    /**
     *  [getTextColorAttribute description]
     *
     *  @return [type] [description]
     */
    public function getTextColorAttribute()
    {
        return $this->claseType->text_color;
    }
}
