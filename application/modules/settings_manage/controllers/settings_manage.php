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
class Settings_Manage extends MX_Controller {

	// --------------------------------------------------------------------
	
	function __construct()
    {
        parent::__construct();
		
		$this->load->model('options');
		
		//$this->output->enable_profiler(TRUE);
		
		header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
		header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    }  
	
	// --------------------------------------------------------------------
	
	function salary_grade()
	{
		
		$data['page_name'] = '<b>Salary Grade</b>';
		$data['msg'] = '';
		
		$data['year_options'] 		= $this->options->year_options(2009, 2020);//2010 - 2020
		$data['year_selected'] 		= date('Y');
		
		if(Input::get('year'))
		{
			$data['year_selected'] 	= Input::get('year');
			
			// Check if the year exists
			$s = new Salary_grade_m();
			
			$s->get_by_year($data['year_selected']);
			
			if ( ! $s->exists() )
			{
				$i = 1;
				
				while($i != 31)
				{
					$s = new Salary_grade_m();
					$s->sg 					= $i;
					$s->year 				= $data['year_selected'];
					$s->salary_grade_type 	= (Input::get('salary_grade_type')) 
											? Input::get('salary_grade_type') 
											: '';
					$s->save();
					
					$i ++;
				}				
				
			}
		}
		
		$data['hospital'] = '';
		
		if ( Setting::getField('lgu_code') == 'marinduque_province' )
		{
			$data['hospital'] = 'yes';
		}
		
		$data['rows'] = $this->Salary_grade->get_salary_grade($data['year_selected'], Input::get('salary_grade_type'));
		
		$data['main_content'] = 'salary_grade';
		
		return View::make('includes/template', $data);
		
	}
	
	// --------------------------------------------------------------------
	
	function salary_grade_proposed()
	{
		
		$data['page_name'] = '<b>Salary Grade (Proposed)</b>';
		$data['msg'] = '';
		
		$data['year_options'] 		= $this->options->year_options(2009, 2020);//2010 - 2020
		$data['year_selected'] 		= date('Y');
		
		if(Input::get('year'))
		{
			$data['year_selected'] 	= Input::get('year');
			
			// Check if the year exists
			$s = new Salary_grade_proposed_m();
			
			$s->get_by_year($data['year_selected']);
			
			if ( ! $s->exists() )
			{
				$i = 1;
				
				while($i != 31)
				{
					$s = new Salary_grade_proposed_m();
					$s->sg 					= $i;
					$s->year 				= $data['year_selected'];
					$s->salary_grade_type 	= (Input::get('salary_grade_type')) 
											? Input::get('salary_grade_type') 
											: '';
					$s->save();
					
					$i ++;
				}				
				
			}
		}
		
		$data['hospital'] = '';
		
		if ( Setting::getField('lgu_code') == 'marinduque_province' )
		{
			$data['hospital'] = 'yes';
		}
		
		$s = new Salary_grade_proposed_m();
		
		$data['rows'] = $s->get_salary_grade($data['year_selected'], Input::get('salary_grade_type'));
		
		$data['main_content'] = 'salary_grade_proposed';
		
		return View::make('includes/template', $data);
		
	}
	
	// --------------------------------------------------------------------
	
	function holiday($delete_id = '')
	{
		
		$data['page_name'] = '<b>Holiday</b>';
		$data['msg'] = '';
		
		//Months
		$data['month_options'] 		= $this->options->month_options();
		$data['month_selected'] 	= date('m');
		
		//day
		$data['days_options'] 		= $this->options->days_options();
		$data['days_selected'] 		= date('d');
		
		$data['year_options'] 		= $this->options->year_options(2009, 2020);//2010 - 2020
		$data['year_selected'] 		= date('Y');
		
		if ($delete_id)
		{
			$this->Holiday->delete_holiday($delete_id);
		}
		
		$data['rows'] 				= $this->Holiday->holiday_list($data['year_selected']);
		
		if(Input::get('op'))
		{
			if (Input::get('add_date'))
			{
				if(Input::get('description') != "" && 
					checkdate(Input::get('month'), Input::get('day'), Input::get('year')))
				{	
					$info = array(
							'date' 			=> Input::get('year').'-'.Input::get('month').'-'.Input::get('day'),
							'description' 	=> Input::get('description'),
							'half_day' 		=> Input::get('half_day'),
							'am_pm' 		=> Input::get('am_pm'),
							);
					
					$this->Holiday->add_holiday($info);	
				}
			}
			
			$data['year_selected'] 		= Input::get('year_select');
			$data['rows'] 				= $this->Holiday->holiday_list(Input::get('year_select'));
		}
				
		$data['main_content'] = 'holiday';
		
		return View::make('includes/template', $data);
		
	}
	
	// --------------------------------------------------------------------
	
	function audit_trail($delete_id = '')
	{
		
		$data['page_name'] = '<b>Audit Trail</b>';
		$data['msg'] = '';
		
		if ($delete_id)
		{	
			$this->Logs->delete_logs($delete_id);
		}
		
		if (Input::get('remove_selected') && Input::get('log'))
		{	
			$logs = Input::get('log');
			
			foreach ($logs as $log)
			{
				$this->Logs->delete_logs($log);
			}
		}
		
		if (Input::get('remove_all'))
		{	
			$this->Logs->delete_all_logs();
		}
		
		// Use for office listbox
		$data['options'] 			= $this->options->office_options();
		$data['selected'] 			= Session::get('office_id');
	
		$office_id					= Session::get('office_id');
	
		if (Input::get('op'))
		{
			$data['selected'] 	= Input::get('office_id');
			$office_id 			= Input::get('office_id');
			
			if (Input::get('username'))
			{
				$this->Logs->username = Input::get('username');
			}
			if (Input::get('module'))
			{
				$this->Logs->module = Input::get('module');
			}
			if (Input::get('date1') and Input::get('date2'))
			{
				$this->Logs->date1 = Input::get('date1');
				$this->Logs->date2 = Input::get('date2');
			}
			
		}
		
		$this->load->library('pagination');
				
		$data['logs'] = $this->Logs->count_logs($office_id);
		
		$config['base_url'] = base_url().'settings_manage/audit_trail';
		$config['total_rows'] = $this->Logs->num_rows;
	    $config['per_page'] = '15';
	    //$config['full_tag_open'] = '<p>';
	    //$config['full_tag_close'] = '</p>';
				
		$this->pagination->initialize($config);
		
		$data['logs'] = $this->Logs->get_logs( $office_id, $config['per_page'], $this->uri->segment(3));
		
				
		$this->pagination->initialize($config);
				
		$data['main_content'] = 'audit_trail';
		
		return View::make('includes/template', $data);
		
	}
	
	// --------------------------------------------------------------------
	
	function general_settings()
	{
		
		$data['page_name'] = '<b>Settings</b>';
		$data['msg'] = '';
		
		$this->load->helper('string');
		
		if (Input::get('op'))
		{
			// We get all the POST data. $key is the field name
			// which is the name of settings in database table.
			// We update the settings table to a new value($val)
			foreach ($_POST as $key => $val)
			{
				// This fixed if the name has quote("") Like Gov. "E.R."
				if ($key == 'head_of_office')
				{
					$val  = quotes_to_entities($val);
				}
				
				$this->Settings->update_settings($key, $val);
			}
			
			$data['msg'] = 'Settings has been saved!';
		}
		
		$data['settings'] = $this->Settings->get_settings();
				
		$data['main_content'] = 'general_settings';
		
		return View::make('includes/template', $data);
		
	}
	
	// --------------------------------------------------------------------
	
	function backup()
	{
		
		$data['page_name'] = '<b>Restore/ Back up</b>';
		$data['msg'] = '';
				
		$data['main_content'] = 'backup';
		
		return View::make('includes/template', $data);
		
	}
	
	// --------------------------------------------------------------------
	
	function maintenance()
	{
		
		$data['page_name'] = '<b>Maintenance</b>';
		$data['msg'] = '';
		
		if(Input::get('repair'))
		{
			$this->load->dbutil();
			$this->dbutil->repair_table('ats_dtr');
			
			Session::flash('msg', 'Table has been repaired.');
				
			return Redirect::to('settings_manage/maintenance', 'refresh');
			
		}
				
		$data['main_content'] = 'maintenance';
		
		return View::make('includes/template', $data);
		
	}
	
	// --------------------------------------------------------------------
	
	function backup_database()
	{
		
		
		// Load the DB utility class
		$this->load->dbutil();
		
		// Backup your entire database and assign it to a variable
		$backup =& $this->dbutil->backup(); 
		
		// Load the file helper and write the file to your server
		$this->load->helper('file');
		write_file('/dtr/'.date('Y-m-d').'.zip', $backup); 
		
		// Load the download helper and send the file to your desktop
		$this->load->helper('download');
		force_download(date('Y-m-d').'.zip', $backup); 
	}
	
	
}	