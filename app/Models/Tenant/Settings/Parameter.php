<?php

namespace App\Models\Tenant\Settings;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
	use UsesTenantConnection;

	/**
	 * Massive assignment for Parameters of the system
	 *
	 * 	['calendar_start']		   time Start time of the calendar clases
 	 *  ['calendar_end']   		   time Finish time of the calendar clases
 	 *  ['check_confirm_clases']   boolean Check true if it's necessary confirm the assistance to the class.
 	 *  ['mins_confirm_clases']    integer Mins before the class start needs to be confirm, or reservation will be deleted.
 	 *  ['check_quite_alumnos']    boolean Check if the user will be remove from a class if he doesn't confirm it.
 	 *  ['mins_quite_alumnos']     integer Mins before the class start, the user will be removed if he doesn't confirm her assistance.
 	 *  ['user_convertion_days']   	   integer  Max time who a user end his test plan to take a bill plan
	 *
	 * @var array
	 */
    protected $fillable = [
    	'id',
    	'calendar_start',
    	'calendar_end',
    	'check_confirm_clases',
        'mins_confirm_clases',
        'check_quite_alumnos',
        'mins_quite_alumnos',
        'user_convertion_days',
        'box_name',
        'box_email'
    ];
}
