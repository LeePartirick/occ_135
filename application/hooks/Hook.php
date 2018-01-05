<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hook  {

	private $CI;   
	
	public function __construct() 
	{        
		$this->CI = &get_instance();     
	}    
	
    public function post_controller_constructor()
    {
		$this->CI->m_app->check_login();
    }
    
}
