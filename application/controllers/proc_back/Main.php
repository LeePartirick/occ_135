<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 后台主页
 * @author 朱明
 *
 */
class Main extends CI_Controller {

	private $acl_list;
	
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
		$data_out['title']='后台管理';
		
		/************载入视图 ****************/
		$arr_view[]='proc_back/main/index';
		$arr_view[]='proc_back/main/index_js';
		$this->m_view->load_view($arr_view,$data_out);
	}
	
	/**
	 * 模块管理
	 */
	public function main_proc()
	{
		$this->load->model('proc_back/m_proc');
		
		/************变量初始化****************/
		$data_out=array();//输出数组
		$arr_view=array();//视图数组
		$data_post=array();//输出数组
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		
		/************权限验证*****************/
		
		$p_id='proc_back';
        $this->config->load('proc/'.$p_id.'/conf', FALSE, TRUE);
        $arr_conf = $this->config->item('p_conf');
        
		//超级权限
        if( ( $this->acl_list & pow(2,ACL_PROC_BACK_SUPER) ) != 0 
        //模块权限
         || ( $this->acl_list & pow(2,ACL_PROC_BACK_MODEL) ) != 0 
        )
        {
        	
        }
        else 
        {
        	$msg = '没有【'.$arr_conf['p_name'].'】的【'.$GLOBALS[strtoupper($p_id)]['text']['d_acl'][ACL_PROC_BACK_MODEL].'】权限，不可进行操作！';
      		redirect('base/main/show_err/msg/'.fun_urlencode($msg).'/fun_open/'.element('fun_open', $data_get).'/fun_open_id/'.element('fun_open_id', $data_get));
        }
		/************事件处理*****************/
		
		/************模板赋值***********/
		$data_out['title']='模块管理';
		$data_out['time']=time();
		
		$data_out['list_proc']=$this->m_proc->get_list_proc();
		
		$data_out['field_search_value_dispaly']=json_encode($GLOBALS['m_proc']['text']['field_search_value_dispaly']);
		$data_out['field_search_rule']=$GLOBALS['m_proc']['text']['field_search_rule'];
		$data_out['field_search_rule_default']=$GLOBALS['m_proc']['text']['field_search_rule_default'];
		$data_out['field_search_start']=implode($GLOBALS['m_proc']['text']['field_search_start'],',');
		
		$data_out['url']='proc_back-main-main_proc';
		
		//索引查询个性化
		$data_out=$this->m_base->get_person_conf_index($data_out);
		
		/************载入视图 ****************/
		$arr_view[]='proc_back/main/main_proc';
		$arr_view[]='proc_back/main/main_proc_js';
		$this->m_view->load_view($arr_view,$data_out);
	}
	
	/**
	 * 模块管理
	 */
	public function get_json_proc()
	{
		//判断是否ajax请求
		$is_ajax=$this->input->is_ajax_request();
		if( ! $is_ajax) exit;
		
		$this->load->model('proc_back/m_proc');
		
		/************变量初始化****************/
		//开始时间
		$time_start=time();
		
		$arr_search=array();
		$data_search=array();
		
		$rows = '';
		$json = '';
		$msg  = '';
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		
		$data_search=$this->input->post_get('data_search');
		if( ! empty($data_search))
		{
			$data_search=json_decode($data_search,TRUE);
		}
		
		//查询参数
		$query=trim($this->input->post_get('query'));
		$field_q=trim($this->input->post_get('field_q'));
		
		//分页
		$arr_search['page']=$this->input->post_get('page');
		$arr_search['rows']=$this->input->post_get('rows');
		
		if( empty($arr_search['rows']) )
		{
			$arr_search['rows'] = 40;
		}
		
		//排序
		$arr_search['order']=$this->input->post_get('order');
		$arr_search['sort']=$this->input->post_get('sort');
		
		if( empty($arr_search['sort']) )
		{
			$arr_search['sort']='p_id';
			$arr_search['order']='asc';
		}
		
		$arr_search['where']='';
		$arr_search['value']=array();
		/************查询条件*****************/
		$role_id=element('role_id', $data_get);
		
		if( ! empty($role_id) )
		{
			$arr_search['where'].=" AND p_id IN ( 
				SELECT op_id
				FROM sys_acl
				WHERE ra_id = ? 
			) ";
			$arr_search['value'][]= $role_id;
		}
		
		if( $query )
		{
			if( ! $field_q ) $field_q="p_name,p_id";
			
			$arr_search['where'].=" AND CONCAT({$field_q}) like '%".$this->m_base->escape_like_str($query)."%'";
		}
		
		$arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);
		
		/************数据查询*****************/
		$arr_field_search = array_keys($GLOBALS['m_proc']['text']['field_search']);
		$arr_search['field']=implode(',',$arr_field_search);
		
		$arr_search['from']='sys_proc';
		
		$rs=$this->m_db->query($arr_search);
		/************json拼接****************/
		$show_by_rule=array();
		
		if (count($rs['content']) > 0)
		{
			foreach($rs['content'] as $k => $v)
			{
				
				$row_f='';
				foreach ($arr_field_search as $f) {
					
					if(isset($GLOBALS['m_proc']['text'][$f]) && isset($GLOBALS['m_proc']['text'][$f][$v[$f]]) )
					$v[$f]=$GLOBALS['m_proc']['text'][$f][$v[$f]];
					
					if(isset($show_by_rule[$f]))
					$v[$f]=$this->m_base->show_by_rule($show_by_rule[$f],$v[$f],$v);
					
					$row_f.='"'.$f.'":"'.fun_urlencode(element($f,$v)).'",';
				}
				$row_f=trim($row_f,',');
				
				if( $query )
				{
					$tmp_arr=explode(',', $field_q);
					
					$value_s='';
					foreach ($tmp_arr as $v1) {
						$value_s.=element($v1,$v).',';
					}
					
					$rows.='{"value":"'.trim($value_s,',').'",'
						   .'"data": {'.$row_f.'}},';
				
				}
				else 
				{
					$rows.='{'.$row_f.'},';
				}
			}
			$rows=trim($rows,',');
		}
		
		//结束时间
		$time_end=time();
		$time=$time_end-$time_start;
		
		if( $query )
		{
			$json.='{"query": "'.$query.'","suggestions":['.$rows.']}';
		}
		else 
		{
			$json.='{"total":"'.$rs['total'].'"'
				   .',"time":"'.$time.'"'
				   .',"title":"模块列表"'
				   .',"msg":"'.$msg.'"'
				   .',"rows":['.$rows.']}';
		}
		
		/************返回数据*****************/
		echo $json;
		
	}
	
	/**
	 * 模块管理
	 */
	public function fun_proc_operate()
	{
		//判断是否ajax请求
		$is_ajax=$this->input->is_ajax_request();
		if( ! $is_ajax) exit;
		
		$this->load->model('proc_back/m_proc');
		
		/************变量初始化****************/
		//开始时间
		$time_start=time();
		
		$arr_view = array();//视图数组
		$data_out = array();//输出数组
		$data_db  = array();//数据库数据
		
		$data_save=array();//数据库保存数组
		$arr_search=array();
		$rtn=array();//结果
		
		$rows = '';
		$json = '';
		$msg  = '';
		
		/***********变量赋值**************/
		$data_get=$this->uri->uri_to_assoc(4);
		$data_get['p_id']=$this->input->post('p_id');

		if( ! $data_get['p_id'] )
		exit;
		
		/************权限验证*****************/
		//超级权限
        if( ( $this->acl_list & pow(2,ACL_PROC_BACK_SUPER) ) != 0 
        //模块权限
         || ( $this->acl_list & pow(2,ACL_PROC_BACK_MODEL) ) != 0 
        )
        {
        	
        }
        else 
        {
        	$msg = '没有【'.$arr_conf['p_name'].'】的【'.$GLOBALS[strtoupper($p_id)]['text']['d_acl'][ACL_PROC_BACK_MODEL].'】权限，不可进行操作！';
      		redirect('base/main/show_err/msg/'.fun_urlencode($msg).'/fun_open/'.element('fun_open', $data_get).'/fun_open_id/'.element('fun_open_id', $data_get));
        }
		
		/***************数据查询*****************/
		
		$data_db['content']=$this->m_proc->get($data_get['p_id']);
		
		if(element('p_status_run', $data_db['content']) == P_STATUS_RUN_STOP )
		{
			$this->config->load('proc/'.$data_get['p_id'].'/conf', FALSE, TRUE);
			
			$data_save['content'] = $this->config->item('p_conf');
			$data_save['content']['p_id']=$data_get['p_id'];
			$data_save['content']['p_status_run'] = P_STATUS_RUN_START;
			
			$rtn=$this->m_proc->update($data_save['content']);
			
			$p_table_list = $this->config->item('p_table_list');
			
			if(count($p_table_list) > 0)
			{
				foreach ($p_table_list as $v) {
					$this->m_db->update_db_table($v);
				}
			}
			
			$p_id=$data_get['p_id'];
			$m_conf = 'm_'.$p_id;
	        $this->load->model($p_id.'/'.$m_conf);
	        
			$this->$m_conf->create_import_xlsx();
			$rtn['p_status_run'] = $GLOBALS['m_proc']['text']['p_status_run'][P_STATUS_RUN_START];
		}
		else 
		{
			$data_save['content']['p_id']=$data_get['p_id'];
			$data_save['content']['p_status_run'] = P_STATUS_RUN_STOP;
			
			$rtn=$this->m_proc->update($data_save['content']);
			
			$rtn['p_status_run'] = $GLOBALS['m_proc']['text']['p_status_run'][P_STATUS_RUN_STOP];
		}
		
		/************返回数据*****************/
		echo json_encode($rtn);
	}
}
