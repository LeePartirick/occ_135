<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 人事主页
 * @author 朱明
 *
 */
class Main extends CI_Controller {

	
	public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        
    	$p_id='proc_hr';
        $this->config->load('proc/'.$p_id.'/conf', FALSE, TRUE);
        $arr_conf = $this->config->item('p_conf');
        
      	$m_conf = 'm_'.$p_id;
        $this->load->model($p_id.'/'.$m_conf);
        
        //权限验证
        $this->acl_list = $this->$m_conf->get_acl();
        
        if( $this->acl_list > 0)
        {
        	
        }
        else 
        {
        	$msg = '没有【'.$arr_conf['p_name'].'】的权限，不可访问此页面！';
      		redirect('base/main/show_err/msg/'.fun_urlencode($msg));
        }
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
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		/************事件处理*****************/
		
		/************模板赋值***********/
		$data_out['title']='人事管理';
		$data_out['time']=time();
		/************载入视图 ****************/
		$arr_view[]='proc_hr/main/index';
		$arr_view[]='proc_hr/main/index_js';
		$this->m_view->load_view($arr_view,$data_out);
	}
	
}
