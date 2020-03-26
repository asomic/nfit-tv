<?php

namespace App\Models\Tenant\Wods;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Tenant\Clases\Clase;
use App\Models\Tenant\Clases\ClaseType;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Wod extends Model
{
    use UsesTenantConnection;

    /**
     *  [$appends description]
     *
     *  @var  array
     */
    protected $dates = ['date'];

    /**
     *  [$appends description]
     *
     *  @var  array
     */
    protected $fillable = ['date', 'clase_type_id'];

    /**
     *  [$appends description]
     *
     *  @var  array
     */
    protected $appends = ['allDay', 'title', 'url'];

    /**
     *  [setDateAttribute description]
     *
     *  @param   [type]  $value  [$value description]
     *
     *  @return  [type]          [return description]
     */
    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::parse($value)->format('Y-m-d');
    }

    /**
     *  [getAllDayAttribute description]
     *
     *  @return  [type]  [return description]
     */
    public function getDateAttribute()
    {
        return Carbon::parse($this->attributes['date'])->format('Y-m-d');
    }

    /**
     *  [getAllDayAttribute description]
     *
     *  @return  [type]  [return description]
     */
    public function getAllDayAttribute()
    {
        return true;
    }

    // /**
    //  *  [getStartAttribute description]
    //  *
    //  *  @return  [type]  [return description]
    //  */
    // public function getStartAttribute()
    // {
    //     return Carbon::parse($this->attributes['date'])->format('Y-m-d H:i:s');
    // }

    // /**
    //  *  [getStartAttribute description]
    //  *
    //  *  @return  [type]  [return description]
    //  */
    // public function getEndAttribute()
    // {
    //     return Carbon::parse($this->attributes['date'])->format('Y-m-d H:i:s');
    // }

    /**
     *  Get the ClaseTypr for the Clases Calendar
     *
     *  @return string
     */
    public function getTitleAttribute()
    {
        return "Rutina de {$this->clase_type->clase_type}";
    }

    /**
     *  URL for Workout Rutine showed on Clases Calendar
     *
     *  @return  [type]  [return description]
     */
    public function getUrlAttribute()
    {
        return url("/admin/wods/{$this->id}/edit");
    }

    /**
     *  [clases description]
     *
     *  @return  App\Models\Tenant\Clases\Clase
     */
    public function clases()
    {
        return $this->hasMany(Clase::class);
    }

    /**
     *  methodDescription
     *
     *  @return  App\Models\Tenant\Clases\ClaseType
     */
    public function clase_type()
    {
        return $this->belongsTo(ClaseType::class);
    }

    /**
     *  methodDescription
     *
     *  @return
     */
    public function stages()
    {
        return $this->hasMany(Stage::class);
    }

    /**
     *  Etapa por ID
     *
     *  @param   [type]  $id  [$id description]
     *
     *  @return  [type]       [return description]
     */
    public function stage($id)
    {
        return $this->hasMany(Stage::class)->where('stage_type_id', $id)->first() ?? null;
    }

    /**
     *  Get all the rutines for an specific interval time,
     *  ussualy for a week
     *
     *  @return  $this (App\Models\Tenant\Wods\Wod)
     */
    public static function getCalendarWods(Request $request)
    {
        return self::where('clase_type_id', session()->get('clases-type-id'))
                   ->whereBetween('date', [$request->datestart, $request->dateend])
                   ->with(['clase_type:id,clase_type,clase_color,text_color,icon,icon_white,active'])
                   ->get(['id', 'date', 'clase_type_id']);
    }
}
