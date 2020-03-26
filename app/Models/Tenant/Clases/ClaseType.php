<?php

namespace App\Models\Tenant\Clases;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class ClaseType extends Model
{
    use UsesTenantConnection;

    /**
     *  Massive Assignment for this Model
     *
     *  @var array
     */
    protected $fillable = [
        'clase_type', 'text_color',
        'clase_color', 'icon', 'icon_white'
    ];

    /**
     *  Return all Clase Types
     *
     *  @return  Collection
     */
    public function allClaseTypes()
    {
        return $this->get([
            'id', 'clase_type', 'text_color',
            'clase_color', 'icon', 'icon_white'
        ]);
    }

    // /**
    //  *  Add stage to this Clase Type
    //  *
    //  *  @return  void
    //  */
    // public function addStage()
    // {
    //     $this->
    // }
}
