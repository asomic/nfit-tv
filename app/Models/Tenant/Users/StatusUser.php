<?php

namespace App\Models\Tenant\Users;

use App\Models\Tenant\Users\User;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;


class StatusUser extends Model
{
	use UsesTenantConnection;

	/**
	 * Satus User
	 */
    const ACTIVO = 1;

    /**
     * Satus User
     */
    const INACTIVO = 2;

    /**
     * Satus User
     */
    const PRUEBA = 3;

    /**
     * [$type description]
     *
     * @var [type]
     */
    protected $type = [
        0 => 'secondary',
        1 => 'success',
        2 => 'danger',
        3 => 'warning'
    ];

    protected $typeName = [
        0 => 'SIN ESTADO',
        1 => 'ACTIVO',
        2 => 'INACTIVO',
        3 => 'PRUEBA'
    ];

    /**
     *  Return all Status User Colors
     *
     *  @return  array
     */
    public function listStatusUserColors()
    {
        return [
            self::ACTIVO   => 'success',
            self::INACTIVO => 'danger',
            self::PRUEBA   => 'warning',
        ];
    }

    /**
     *  Return a Css type color by an specific User Status Id
     *
     *  @param   integer   Id for a status user
     *
     *  @return  string    A User Status Color (CSS)
     */
    public function getColorUser($userStatusId = null)
    {
        $user_status_colors = $this->listStatusUserColors();

        return $user_status_colors[$userStatusId] ?? '';
    }

    /**
     * [getType description]
     *
     * @return  array
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * [getTypeName description]
     *
     * @return  array
     */
    public function getTypeName()
    {
        return $this->typeName;
    }

    // /**
    //  * Massive Assignment for this Model
    //  * @var array
    //  */
	// protected $fillable = ['status_user'];

	/**
	 * [users description]
	 * @return [type] [description]
	 */
	public function users()
	{
		return $this->hasMany(User::class);
	}
}
