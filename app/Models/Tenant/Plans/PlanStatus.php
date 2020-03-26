<?php

namespace App\Models\Tenant\Plans;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;

class PlanStatus extends Model
{
	use UsesTenantConnection;

	/** ID status Plan */
	const ACTIVO = 1;

	/** ID status Plan */
	const INACTIVO = 2;

	/** ID status Plan */
	const PRECOMPRA = 3;

	/** ID status Plan */
	const COMPLETADO = 4;

	/** ID status Plan */
	const CANCELADO = 5;

	/**
	 * Table name on Database
	 * @var string
	 */
	protected $table = 'plan_status';
}
