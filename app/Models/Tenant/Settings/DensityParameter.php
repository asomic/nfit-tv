<?php

namespace App\Models\Tenant\Settings;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;

class DensityParameter extends Model
{
	use UsesTenantConnection;

	/**
	 * Name of the table in the DataBase
	 *
	 * @var string
	 */
	protected $table = 'density_parameters';

	/**
	 * Columns for Massive Assignment
	 *
	 * @var array
	 */
    protected $fillable = ['level', 'from', 'to', 'color'];
}
