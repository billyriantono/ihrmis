<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Integrated Human Resource Management Information System 3.0dev
 *
 * An Open Source Application Software use by Government agencies for  
 * management of employees Attendance, Leave Administration, Payroll, 
 * Personnel Training, Service Records, Performance, Recruitment,
 * Personnel Schedule(Plantilla) and more...
 *
 * @package		iHRMIS
 * @author		Manny Isles
 * @copyright	Copyright (c) 2008 - 2014, Isles Technologies
 * @license		http://charliesoft.net/ihrmis/license
 * @link		http://charliesoft.net
 * @github	    http://github.com/mannysoft/ihrmis
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * iHRMIS Conversion Table Class
 *
 * This class use for converting number of minutes late
 * to the corresponding equivalent to leave credits.
 *
 * @package		iHRMIS
 * @subpackage	Models
 * @category	Models
 * @author		Manny Isles
 * @link		http://charliesoft.net
 * @github	    http://github.com/mannysoft/ihrmis/hrmis/user_guide/models/conversion_table.html
 */
class Schedule extends DataMapper{ 

	// --------------------------------------------------------------------
	//var $has_one = array("schedule_detail");
	public $has_many = array("schedule_detail");
	
	function __construct()
	{
		parent::__construct();
	}

}

/* End of file schedule.php */
/* Location: ./application/models/schedule.php */