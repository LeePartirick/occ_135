<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 基础图片类
 */
class M_img extends CI_Model {
	
 	public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        
        $this->m_define();
    }
    
	/**
     * 
     * 定义
     */
	public function m_define()
    {
    	if( defined('LOAD_M_IMG') ) return;
    	
    	define('LOAD_M_IMG', 1);
    	
    	define('BASE_PHOTO', $this->config->item('base_img_photo'));// 
    	define('PATH_PHOTO', $this->config->item('base_photo_path'));// 
    	
    }
    
	/**
	 * 
	 * 头像
	 * @param $c_id 联系人id
	 * @param $type 头像类型 
	 * 				0：照片
	 * 				1：头像
	 * 
	 */
	public function get_person_photo($c_img,$type=0)
    {
    	//默认头像	
    	$data_photo=file_get_contents(BASE_PHOTO);
    	
    	if( ! empty($c_img) )
    	{
	    	switch ($type) {
	    		
	    		default:
	    			//人物照片
	    			$path=PATH_PHOTO.$c_img.'.jpg';
			    	if(file_exists($path))
			    	{
			    		$data_photo=file_get_contents($path);
			    	}
			    	
	    		break;
	    	}
    	}
    	
    	return $data_photo;
    }
    
}