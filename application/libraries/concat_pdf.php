<?php
/**
 * Integrated Human Resource Management Information System 3.0dev
 *
 * An Application Software use by Government agencies for management
 * of employees Attendance, Leave Administration, Payroll, Personnel
 * Training, Service Records, Performance, Recruitment and more...
 *
 * @package		iHRMIS
 * @author		Manny Isles
 * @copyright	Copyright (c) 2008 - 2012, Isles Technologies
 * @license		http://charliesoft.net/hrmis/user_guide/license.html
 * @link		http://charliesoft.net
 * @github	    http://github.com/mannysoft/ihrmis
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * iHRMIS Concatenate PDF Class
 *
 * This class use for concatenating pdf files.
 *
 * @package		iHRMIS
 * @subpackage	Libraries
 * @category	PDF Utilities
 * @author		Manolito Isles
 * @link		http://charliesoft.net
 * @github	    http://github.com/mannysoft/ihrmis/hrmis/user_guide/libraries/concat_pdf.html
 */
require_once('fpdi.php');

class Concat_pdf extends FPDI{
	
	// ------------------------------------------------------------------------
	
	public $orientation = array();
	public $default_orientation = 'P';
	
	// ------------------------------------------------------------------------
	
	function setFiles($files) 
	{ 
		$this->files = $files; 
	} 
	
	// ------------------------------------------------------------------------
	
	function concat() 
	{ 
		foreach($this->files as $key => $file) 
		{ 
			$pagecount = $this->setSourceFile($file);
			
			for ($i = 1; $i <= $pagecount; $i++) 
			{ 
				 $tplidx = $this->ImportPage($i); 
				 $s = $this->getTemplatesize($tplidx);
				 
				 $orientation = 'P';
				 
				 // If the array key is not numeric
				 // might be 'P' or 'L' portrait or
				 // landscape.				 
				 if ( ! is_numeric($key) )
				 {
					 $orientation = $key;
				 }
				 
				 if ($this->default_orientation == 'L')
				 {
					 $orientation = 'L';
				 }
				 
				 //$this->AddPage('P', array($s['w'], $s['h'])); // orig
				 $this->AddPage($orientation, array($s['w'], $s['h'])); 
				 $this->useTemplate($tplidx); 
			} 
		} 
	}
	
	// ------------------------------------------------------------------------
}