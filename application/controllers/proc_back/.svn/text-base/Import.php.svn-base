<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 导入
 * @author 朱明
 *
 */
class Import extends CI_Controller {

	
	public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        
        $p_id='proc_back';
        $this->config->load('proc/'.$p_id.'/conf', FALSE, TRUE);
        
        $arr_conf = $this->config->item('p_conf');
        
        $m_conf = 'm_'.$p_id;
        $this->load->model($p_id.'/'.$m_conf);
        
        //权限验证
        $acl_list = $this->$m_conf->get_acl();
        if( ( $acl_list & pow(2,ACL_PROC_BACK_SUPER) ) == 0 )
        {
        	$msg = '没有【'.$arr_conf['p_name'].'】的【'.$GLOBALS[strtoupper($p_id)]['text']['d_acl'][ACL_PROC_BACK_SUPER].'】权限，不可进行操作！';
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
	 * 
	 * 导入账户
	 */
	public function import_account()
	{
		/************变量初始化****************/
		$data_out=array();//输出数组
		$arr_view=array();//视图数组
		$data_post=array();//输出数组
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		$setp=element('setp', $data_get);
		$btn = $this->input->post('btn');
		/************事件处理*****************/
		
		$this->load->model('proc_back/m_import');
		
		if($btn)
		{
			$this->m_import->import_account();
		}
		
		/************模板赋值***********/
		$data_out['title']="account";
		$data_out['url']=current_url();
		$data_out['time']=time();
		/************载入视图 ****************/
		$arr_view[]='proc_back/import/index';
		$arr_view[]='proc_back/import/index_js';
		$this->m_view->load_view($arr_view,$data_out);
	}
	
	/**
	 * 
	 * 导入联系人
	 */
	public function import_contact()
	{
		/************变量初始化****************/
		$data_out=array();//输出数组
		$arr_view=array();//视图数组
		$data_post=array();//输出数组
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		$setp=element('setp', $data_get);
		$btn = $this->input->post('btn');
		/************事件处理*****************/
		
		$this->load->model('proc_back/m_import');
		
		if($btn)
		{
			$this->m_import->import_contact();
		}
		
		/************模板赋值***********/
		$data_out['title']="contact";
		$data_out['url']=current_url();
		$data_out['time']=time();
		/************载入视图 ****************/
		$arr_view[]='proc_back/import/index';
		$arr_view[]='proc_back/import/index_js';
		$this->m_view->load_view($arr_view,$data_out);
	}
	
	/**
	 * 
	 * 导入机构信息
	 */
	public function import_org()
	{
		/************变量初始化****************/
		$data_out=array();//输出数组
		$arr_view=array();//视图数组
		$data_post=array();//输出数组
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		$setp=element('setp', $data_get);
		$btn = $this->input->post('btn');
		/************事件处理*****************/
		
		$this->load->model('proc_back/m_import');
		
		if($btn)
		{
			$this->m_import->import_org();
		}
		/************模板赋值***********/
		$data_out['title']="ou";
		$data_out['url']=current_url();
		$data_out['time']=time();
		/************载入视图 ****************/
		$arr_view[]='proc_back/import/index';
		$arr_view[]='proc_back/import/index_js';
		$this->m_view->load_view($arr_view,$data_out);
	}
	
	/**
	 * 
	 * 导入分公司信息
	 */
	public function import_hr_org()
	{
		/************变量初始化****************/
		$data_out=array();//输出数组
		$arr_view=array();//视图数组
		$data_post=array();//输出数组
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		$setp=element('setp', $data_get);
		$btn = $this->input->post('btn');
		/************事件处理*****************/
		
		$this->load->model('proc_back/m_import');
		
		if($btn)
		{
			$this->m_import->import_hr_org();
		}
		/************模板赋值***********/
		$data_out['title']="ou";
		$data_out['url']=current_url();
		$data_out['time']=time();
		/************载入视图 ****************/
		$arr_view[]='proc_back/import/index';
		$arr_view[]='proc_back/import/index_js';
		$this->m_view->load_view($arr_view,$data_out);
	}
	
	/**
	 * 
	 * 导入机构信息
	 */
	public function import_ou()
	{
		/************变量初始化****************/
		$data_out=array();//输出数组
		$arr_view=array();//视图数组
		$data_post=array();//输出数组
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		$setp=element('setp', $data_get);
		$btn = $this->input->post('btn');
		/************事件处理*****************/
		
		$this->load->model('proc_back/m_import');
		
		if($btn)
		{
			$this->m_import->import_ou();
		}
		/************模板赋值***********/
		$data_out['title']="ou";
		$data_out['url']=current_url();
		$data_out['time']=time();
		/************载入视图 ****************/
		$arr_view[]='proc_back/import/index';
		$arr_view[]='proc_back/import/index_js';
		$this->m_view->load_view($arr_view,$data_out);
	}
	
	/**
	 * 
	 * 导入职位
	 */
	public function import_hr_job()
	{
		/************变量初始化****************/
		$data_out=array();//输出数组
		$arr_view=array();//视图数组
		$data_post=array();//输出数组
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		$setp=element('setp', $data_get);
		$btn = $this->input->post('btn');
		/************事件处理*****************/
		
		$this->load->model('proc_back/m_import');
		
		if($btn)
		{
			$this->m_import->import_hr_job();
		}
		
		/************模板赋值***********/
		$data_out['title']="job";
		$data_out['url']=current_url();
		$data_out['time']=time();
		/************载入视图 ****************/
		$arr_view[]='proc_back/import/index';
		$arr_view[]='proc_back/import/index_js';
		$this->m_view->load_view($arr_view,$data_out);
	}
	
	/**
	 * 
	 * 导入信息系统
	 */
	public function import_oa_office()
	{
		/************变量初始化****************/
		$data_out=array();//输出数组
		$arr_view=array();//视图数组
		$data_post=array();//输出数组
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		$setp=element('setp', $data_get);
		$btn = $this->input->post('btn');
		/************事件处理*****************/
		
		$this->load->model('proc_back/m_import');
		
		if($btn)
		{
			$this->m_import->import_oa_office();
		}
		
		/************模板赋值***********/
		$data_out['title']="contact";
		$data_out['url']=current_url();
		$data_out['time']=time();
		/************载入视图 ****************/
		$arr_view[]='proc_back/import/index';
		$arr_view[]='proc_back/import/index_js';
		$this->m_view->load_view($arr_view,$data_out);
	}
	
	/**
	 * 
	 * 导入技术方向
	 */
	public function import_hr_tec()
	{
		/************变量初始化****************/
		$data_out=array();//输出数组
		$arr_view=array();//视图数组
		$data_post=array();//输出数组
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		$setp=element('setp', $data_get);
		$btn = $this->input->post('btn');
		/************事件处理*****************/
		
		$this->load->model('proc_back/m_import');
		
		if($btn)
		{
			$this->m_import->import_hr_tec();
		}
		
		/************模板赋值***********/
		$data_out['title']="hr_tec";
		$data_out['url']=current_url();
		$data_out['time']=time();
		/************载入视图 ****************/
		$arr_view[]='proc_back/import/index';
		$arr_view[]='proc_back/import/index_js';
		$this->m_view->load_view($arr_view,$data_out);
	}
	
	/**
	 * 
	 * 导入文件属性
	 */
	public function import_file_type()
	{
		/************变量初始化****************/
		$data_out=array();//输出数组
		$arr_view=array();//视图数组
		$data_post=array();//输出数组
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		$setp=element('setp', $data_get);
		$btn = $this->input->post('btn');
		/************事件处理*****************/
		
		$this->load->model('proc_back/m_import');
		
		if($btn)
		{
			$this->m_import->import_file_type();
		}
		
		/************模板赋值***********/
		$data_out['title']="oa_file_type";
		$data_out['url']=current_url();
		$data_out['time']=time();
		/************载入视图 ****************/
		$arr_view[]='proc_back/import/index';
		$arr_view[]='proc_back/import/index_js';
		$this->m_view->load_view($arr_view,$data_out);
	}
	
	/**
	 * 
	 * 导入预算科目
	 */
	public function import_subject()
	{
		/************变量初始化****************/
		$data_out=array();//输出数组
		$arr_view=array();//视图数组
		$data_post=array();//输出数组
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		$setp=element('setp', $data_get);
		$btn = $this->input->post('btn');
		/************事件处理*****************/
		
		$this->load->model('proc_back/m_import');
		
		if($btn)
		{
			$this->m_import->import_subject();
		}
		
		/************模板赋值***********/
		$data_out['title']="fm_subject";
		$data_out['url']=current_url();
		$data_out['time']=time();
		/************载入视图 ****************/
		$arr_view[]='proc_back/import/index';
		$arr_view[]='proc_back/import/index_js';
		$this->m_view->load_view($arr_view,$data_out);
	}
	
	/**
	 * 
	 * 导入全国区域
	 */
	public function import_area()
	{
		/************变量初始化****************/
		$data_out=array();//输出数组
		$arr_view=array();//视图数组
		$data_post=array();//输出数组
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		$setp=element('setp', $data_get);
		$btn = $this->input->post('btn');
		/************事件处理*****************/
		
		$this->load->model('proc_back/m_import');
		
		if($btn)
		{
			$this->m_import->import_area();
		}
		
		/************模板赋值***********/
		$data_out['title']="fm_subject";
		$data_out['url']=current_url();
		$data_out['time']=time();
		/************载入视图 ****************/
		$arr_view[]='proc_back/import/index';
		$arr_view[]='proc_back/import/index_js';
		$this->m_view->load_view($arr_view,$data_out);
	}
}
