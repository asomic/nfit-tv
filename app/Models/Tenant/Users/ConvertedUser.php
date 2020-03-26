<?php

namespace App\Models\Tenant\Users;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class ConvertedUser extends Model
{
	use UsesTenantConnection;

	/**
	 * Table name on Database
	 * @var string
	 */
	protected $table = 'convert_users_summaries';

	/**
     * Massive Assignment for this Model
     * @var array
     */
	protected $fillable = [
		'total_users',
		'converted_users',
		'converted_percentage',
		'month',
		'year',
		'start_day',
		'finish_day'
	];
}
