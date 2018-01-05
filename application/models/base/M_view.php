<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 基础视图类
 */
class M_view extends CI_Model {
	
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
	 * 载入视图
	 * @param $arr_view 视图数组
	 * @param $data_out 输出数组
	 */
	public function load_view($arr_view,$data_out)
    {
    	
    	//判断是否ajax请求
		$is_ajax=$this->input->is_ajax_request();
		
		if( ! $is_ajax)
		{
			$url=fun_urlencode(uri_string());
			
			redirect('app/index/uri/'.$url);
		}
		
    	$prefix='comn/';
    	
    	if( count($arr_view) > 0)
    	{
    		foreach ($arr_view as $k=>$v) {
    			
    			if($k == 0)
    			$this->load->view($prefix.$v,$data_out);
    			else
    			$this->load->view($prefix.$v);
    		}
    	}
    }
}