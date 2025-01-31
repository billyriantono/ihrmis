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
class User_type extends CI_Model {

	// --------------------------------------------------------------------
	
	/**
	 * Constructor
	 *
	 * @return User_type
	 */
	function __construct()
	{
		parent::__construct();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get the user type of a user
	 *
	 * @param int $id
	 * @return string
	 */
	function get_user_type($id)
	{
		$user_type = '';
		
		$this->db->where('id', $id);
		$q = $this->db->get('user_type');
		
		if ($q->num_rows() > 0)
		{
			foreach ($q->result_array() as $row)
			{
				$user_type = $row['name'];
			}
		}
		
		return $user_type;
		
		$q->free_result();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get selected field in user info
	 *
	 * @param string $field
	 * @param int $id
	 * @return string
	 */
	function select($field, $id)
	{
		if($field == '')
		{
			$field = '*';
		}
		
		$this->db->select($field);
		$this->db->where('id', $id);
		$q = $this->db->get('user_type', 1);
		
		if ($q->num_rows() > 0)
		{
			foreach ($q->result_array() as $row)
			{
				$user_type = $row[$field];	
			}
		}
		
		return $user_type;
		
		$q->free_result();
		
	}
	
}

/* End of file user_type.php */
/* Location: ./application/models/user_type.php */