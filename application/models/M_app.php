<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * APP类
 */
class M_app extends CI_Model {
	
 	public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        
    }
    
	/**
     * 
     * 定义
     */
	public function m_define()
    {
    	
    }
    
	/**
     * 
     * 验证登陆
     */
	public function check_login()
    {
    	//获取控制器
    	$c_app=$this->uri->segment(1, 0);
    	$c_login=$this->uri->segment(2, 0);
    	
		//获取session
		$a_id=$this->sess->userdata('a_id') ;
		if( empty($c_app) )
		{
			$this->sess->set_userdata('r_uri', uri_string());
			redirect('app/index');
		}
		
		// 判断是否登陆
    	if(  $c_app !='app'
    	  && $c_login != 'login' 
    	  && empty($a_id))
		{
			$this->sess->set_userdata('r_uri', uri_string());
			redirect('app/index');
		}
    }    
}