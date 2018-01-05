<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 系统登陆
 * @author 朱明
 *
 */
class Login extends CI_Controller {

	
	public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->model('base/m_login');
        $this->m_login->check();
    }
    
	public function _remap($method, $params = array())
	{
	    if (method_exists($this, $method))
	    {
	        return call_user_func_array(array($this, $method), $params);
	    }
	    
	    redirect('base/main/show_404');
	}
	
	/**
	 * index
	 */
	public function index()
	{
		/************变量初始化****************/
		$data_out=array();//输出数组
		$arr_view=array();//视图数组
		$data_post=array();//输出数组
		
		/************变量赋值*****************/
		
		/************事件处理*****************/
		
		$this->m_login->event();
		
		$arr_sess['sid']=session_id();
		$arr_sess['c_id']=get_guid();
		$this->sess->set_userdata($arr_sess);
		/************模板赋值***********/
		
		/************载入视图 ****************/
		$arr_view[]='base/login/index';
		$arr_view[]='base/login/index_js';
		$this->m_view->load_view($arr_view,$data_out);
	}
	
}
