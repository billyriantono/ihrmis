<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plantilla extends DataMapper{

	var $table  = 'plantilla';
	// --------------------------------------------------------------------
	
	
	function __construct()
	{
		parent::__construct();
		
		//$this->load->helper('security');
	}
	
	// --------------------------------------------------------------------
	
}

/* End of file user.php */
/* Location: ./application/models/pages.php */