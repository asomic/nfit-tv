<?php

namespace App\Models\Tenant\Users;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;

/** [Millestone description] */
class Millestone extends Model
{
    use UsesTenantConnection;

    /**
     * Massive Assignment for this Model
     * @var array
     */
    protected $fillable = ['millestone'];

  /**
   * [users description]
   * @method users
   * @return [model] [description]
   */
  public function users()
  {
    return $this->belongsToMany(User::class);
  }

}
