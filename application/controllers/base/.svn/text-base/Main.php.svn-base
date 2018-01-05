<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 系统主页
 * @author 朱明
 *
 */
class Main extends CI_Controller {

	
	public function __construct()
    {
        parent::__construct();
        // Your own constructor code
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
		$this->load->model('proc_back/m_proc');
		/************变量初始化****************/
		$data_out=array();//输出数组
		$arr_view=array();//视图数组
		$data_post=array();//输出数组
		
		/************变量赋值*****************/
		
		/************事件处理*****************/
		
		/************模板赋值***********/
		$data_out['time']=time();
		
		/************载入视图 ****************/
		$arr_view[]='base/main/index';
		$arr_view[]='base/main/index_js';
		$this->m_view->load_view($arr_view,$data_out);
	}
	
	/**
	 * 注销
	 *
	 */
	public function login_out()
	{
		$this->load->model('base/m_log_login');
		
		$data_save['content_log']['a_id']=$this->sess->userdata('a_id') ;
		$data_save['content_log']['a_login_id']=$this->sess->userdata('a_login_id') ;
        $data_save['content_log']['c_id']=$this->sess->userdata('c_id') ;
        $data_save['content_log']['c_name']=$this->sess->userdata('c_name') ;
        
        $data_save['content_log']['log_result']=1;
		
		$data_save['content_log']['log_note']= '退出';
		
		$this->m_log_login->add($data_save['content_log']);
		
		//销毁session
		$this->sess->sess_destroy();
		
		delete_cookie('id');
		
		//跳转到登录页面
		$url='app/index.html';
		    	
		redirect($url);
	}
	
	/**
	 * 保持sess
	 *
	 */
	public function keep_sess()
	{
		echo $this->sess->userdata('a_id') ;
	}
	
	/**
	 * 404
	 *
	 */
	public function show_404()
	{
		/************变量初始化****************/
		$data_out=array();//输出数组
		$arr_view=array();//视图数组
		$data_post=array();//输出数组
		
		/************变量赋值*****************/
		
		/************事件处理*****************/
		
		/************模板赋值***********/
		
		/************载入视图 ****************/
		$arr_view[]='base/main/show_404';
		$this->m_view->load_view($arr_view,$data_out);
	}
	
/**
	 * 错误页面
	 *
	 */
	public function show_err()
	{
		/************变量初始化****************/
		$arr_view = array();//视图数组
		$data_post= array();//$POST数组
		$data_get = array();//$GET 数组
		$data_out = array();//输出数组
		$data_db  = array();//数据库数据
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		
		/************事件处理*****************/
		
		/************模板赋值***********/
		
		$data_out['fun_open']= element('fun_open', $data_get);
		$data_out['fun_open_id']=  element('fun_open_id', $data_get);
		
		$data_out['msg']= element('msg', $data_get);
		$data_out['icon']=  element('icon', $data_get);
		
		if( empty($data_out['msg']) )
		$data_out['msg']='您没有权限访问此页面！';
		else 
		$data_out['msg']=fun_urldecode($data_out['msg']);
		
		
		if( empty($data_out['icon']) )
		$data_out['icon']='msg-error';
		
		/************载入视图 ****************/
		$arr_view[]='base/main/show_err';
		$this->m_view->load_view($arr_view,$data_out);
	}
	
	/**
	 * 操作日志
	 */
	public function load_win_log_operate()
	{
		/************变量初始化****************/
		$arr_view = array();//视图数组
		$data_post= array();//$POST数组
		$data_get = array();//$GET 数组
		$data_out = array();//输出数组
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		
		/************事件处理*****************/
		
		/************模板赋值*****************/
		$data_out['parent_id']=$this->input->post_get('parent_id');
		$data_out['op_id']=$this->input->post_get('op_id');
		$data_out['field']=$this->input->post_get('field');
		$data_out['table']=$this->input->post_get('table');
		
		$data_out['fun_m']=$this->input->post_get('fun_m');
		$data_out['fun_f']=$this->input->post_get('fun_f');
		$data_out['fun_p']=$this->input->post_get('fun_p');
		
		$data_out['field_search_value_dispaly']=json_encode($GLOBALS['m_log_operate']['text']['field_search_value_dispaly']);
		$data_out['field_search_rule']=$GLOBALS['m_log_operate']['text']['field_search_rule'];
		$data_out['field_search_rule_default']=$GLOBALS['m_log_operate']['text']['field_search_rule_default'];
		$data_out['field_search_start']=implode($GLOBALS['m_log_operate']['text']['field_search_start'],',');
		
		$data_out['url']='base-main-log_operate';
		
		if( $this->input->post_get('time') )
		$data_out['time']=$this->input->post_get('time');
		else
		$data_out['time']=time();
		
		//索引查询个性化配置
		$data_out=$this->m_base->get_person_conf_index($data_out);
				
		/************载入视图 *****************/
		$arr_view[]='base/main/win_log_operate';
		$arr_view[]='base/main/win_log_operate_js';
		$this->m_view->load_view($arr_view,$data_out);
	}
	
	/**
	 * 获取登陆日志
	 */
	public function get_json_log_operate()
	{
		//判断是否ajax请求
		$is_ajax=$this->input->is_ajax_request();
		if( ! $is_ajax) exit;
		
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
			$arr_search['sort']='log_time';
			$arr_search['order']='desc';
		}
		
		$arr_search['where']='';
		$arr_search['value']=array();
		
		/************查询条件*****************/
		
		if(element('fun_f', $data_get))
		{
			$p = $data_get['fun_p'];
			$m = $data_get['fun_m'];
			$f = $data_get['fun_f'];
			
			$this->load->model($p.'/'.$m);
			
			$arr_search = $this->$m->$f($arr_search,$data_get);
		}
		else 
		{
			$arr_search['where'].=' AND op_id = ? ';
			$arr_search['value'][]=element('op_id',$data_get);
		}
		
		
		$arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);
		
		/************数据查询*****************/
		$arr_field_search=array_keys($GLOBALS['m_log_operate']['text']['field_search']);
		$arr_search['field']=implode(',',$arr_field_search);
		
		$arr_search['from']='sys_log_operate';
		
		$rs=$this->m_db->query($arr_search);
		
		/************json拼接****************/
		if (count($rs['content']) > 0)
		{
			foreach($rs['content'] as $k => $v)
			{
				$rows.='{';
				
				$row_f='';
				foreach ($arr_field_search as $f) {
					
					if(isset($GLOBALS['m_log_operate']['text'][$f]))
					$v[$f]=$GLOBALS['m_log_operate']['text'][$f][$v[$f]];
					
					if(isset($GLOBALS['m_log_operate']['text']['show_by_rule'][$f]))
					$v[$f]=$this->m_base->show_by_rule($GLOBALS['m_log_operate']['text']['show_by_rule'][$f],$v[$f],$v);
					
					$row_f.='"'.$f.'":"'.fun_urlencode(element($f,$v)).'",';
				}
				$row_f=trim($row_f,',');
				
				$rows.=$row_f.'},';
			}
			$rows=trim($rows,',');
		}
		
		//结束时间
		$time_end=time();
		$time=$time_end-$time_start;
		
		$json.='{"total":"'.$rs['total'].'"'
			   .',"time":"'.$time.'"'
			   .',"msg":"'.$msg.'"'
			   .',"title":"操作日志"'
			   .',"rows":['.$rows.']}';
		
		/************返回数据*****************/
		echo $json;
	}
	
	/**
	 * 流程列表
	 */
	public function load_win_proc_table()
	{
		/************变量初始化****************/
		$arr_view = array();//视图数组
		$data_post= array();//$POST数组
		$data_get = array();//$GET 数组
		$data_out = array();//输出数组
		$data_db  = array();//数据库数据
		
		$data_save=array();//数据库保存数组
		$arr_search=array();
		$data_out['op_disable']=array();
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		
		//排序
		$arr_search['order']=$this->input->post_get('order');
		$arr_search['sort']=$this->input->post_get('sort');
		
		if( empty($arr_search['sort']) )
		{
			$arr_search['sort']=array('p_status_run','ra_id_all');
			$arr_search['order']=array('desc','desc');
		}
		
		/************数据查询*****************/
		
		$arr_search['where']='';
		$arr_search['where'].='AND p.p_url !=\'\' AND p.p_url IS NOT NULL';
		
		//获取角色
		$arr_ra_id=$this->m_acl->get_role();
		$arr_search['value'][]=$arr_ra_id;
		
		if( ! empty(element('p_class', $data_get)))
		{
			$arr_search['where'].=' AND p_class = ? ';
			$arr_search['value'][] = $data_get['p_class'];
		}
		
		$arr_search['field']='p.p_id,p_name,p_note,p_url,p_status_run,concat(ra_id) ra_id_all';
		$arr_search['from']='sys_proc p
		LEFT JOIN sys_acl acl ON 
		( acl.op_id = p.p_id AND acl.ra_id IN ? )
		';
		$arr_search['where'].=' GROUP BY p.p_id ';

		$rs=$this->m_db->query($arr_search);
		
		/************模板赋值*****************/
		
		$data_out['time']=time();
		
		$data_out['list_proc'] = $rs['content'];
		
		/************载入视图 *****************/

		$arr_view[]='base/main/win_proc_table';
		$arr_view[]='base/main/win_proc_table_js';
		 
		$this->m_view->load_view($arr_view,$data_out);
	}
	
	/**
	 * 工单列表
	 */
	public function get_json_win_work_list()
	{
		//判断是否ajax请求
		$is_ajax=$this->input->is_ajax_request();
		if( ! $is_ajax) exit;
		
		/************变量初始化****************/
		//开始时间
		$time_start=time();
		
		$arr_search=array();
		$data_search=array();
		
		$rows = '';
		$json = '';
		$msg  = '';
		$num_news = 0; 
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		
		//分页
		$arr_search['page']=$this->input->post_get('page');
		$arr_search['rows']=$this->input->post_get('rows');
		
		//排序
		$arr_search['order']=$this->input->post_get('order');
		$arr_search['sort']=$this->input->post_get('sort');
		
		switch (element('wl_type', $data_get))
		{
			//已办事项
			case 'finish':
				
			if( empty($arr_search['sort']) )
			{
				$arr_search['sort']='db_time_update';
				$arr_search['order']='desc';
			}
			
			$arr_search['where']='';
			$arr_search['value']=array();
			/************查询条件*****************/
			
			/************数据查询*****************/
			$arr_search['field']='wl.*,
								  c.c_name,
								  c.c_login_id,
								  p.p_name';
			
			$arr_search['from']='sys_work_list wl
							    LEFT JOIN sys_proc p ON
							    (p.p_id = wl.p_id )
							    LEFT JOIN sys_contact c ON
								(c.c_id = wl.db_person_create)';
			
			$arr_search['where']=' AND wl.wl_person_do =? AND wl.wl_status = '.WL_STATUS_FINISH.' AND wl.wl_type != '.WL_TYPE_I.'';
			$arr_search['value'][]=$this->sess->userdata('c_id');
			
			$rs=$this->m_db->query($arr_search);
			
			/************json拼接****************/
			if (count($rs['content']) > 0)
			{
				foreach($rs['content'] as $k => $v)
				{
					$rows.='{'
						.'"p_name":"'.$v['p_name'].'"'
						.',"wl_time_do":"'.$v['wl_time_do'].'"'
						.',"wl_code":"'.$v['wl_code'].'"'
						.',"wl_event":"'.$v['wl_event'].'"'
						.',"wl_id":"'.$v['wl_id'].'"'
						.',"c_name":"'.$v['c_name'].'['.$v['c_login_id'].']"'
						.',"wl_proc":"'.$v['wl_proc'].'"'
						.',"wl_url":"'.$v['wl_url'].'/'.$v['wl_op_field'].'/'.$v['op_id'].'"'
						.',"wl_note":"'.fun_urlencode($v['wl_note']).'"';
					
					$rows.='},';
				}
				$rows=trim($rows,',');
			}	
			
			break;
			
			//已结事项
			case 'end':
			
			if( empty($arr_search['sort']) )
			{
				$arr_search['sort']='db_time_update';
				$arr_search['order']='desc';
			}
			
			$arr_search['where']='';
			$arr_search['value']=array();
			/************查询条件*****************/
			
			/************数据查询*****************/
			$arr_search['field']='wl.*,
								  wlp_time_read,
								  c.c_name,
								  c.c_login_id,
								  p.p_name';
			
			$arr_search['from']='sys_work_list wl
							    LEFT JOIN sys_wl_person wlp ON
								(wlp.wl_id = wl.wl_id AND wlp.wlp_person = ?  )
								LEFT JOIN sys_proc p ON
							    (p.p_id = wl.p_id )
							    LEFT JOIN sys_contact c ON
								(c.c_id = wl.db_person_create)';
			
			$arr_search['where']=' AND wlp.wlp_person = ? AND wl.wl_type = '.WL_TYPE_I.' AND wl.wl_status = '.WL_STATUS_FINISH.'';
			$arr_search['value'][]=$this->sess->userdata('c_id');
			$arr_search['value'][]=$this->sess->userdata('c_id');
			
			$rs=$this->m_db->query($arr_search);
			
			/************json拼接****************/
			if (count($rs['content']) > 0)
			{
				foreach($rs['content'] as $k => $v)
				{
					if( ! $v['wlp_time_read'] || strtotime($v['db_time_update']) > strtotime($v['wlp_time_read']) )
					{
						$num_news++;
					}
					
					$rows.='{'
						.'"p_name":"'.$v['p_name'].'"'
						.',"db_time_create":"'.$v['db_time_create'].'"'
						.',"db_time_run":"'.time_diff($v['db_time_update'],$v['db_time_create']).'"'
						.',"c_name":"'.$v['c_name'].'['.$v['c_login_id'].']"'
						.',"wl_code":"'.$v['wl_code'].'"'
						.',"wl_proc":"'.$v['wl_proc'].'"'
						.',"wl_url":"'.$v['wl_url'].'/'.$v['wl_op_field'].'/'.$v['op_id'].'"'
						.',"wl_note":"'.fun_urlencode($v['wl_note']).'"';
					
					$rows.='},';
				}
				$rows=trim($rows,',');
			}
				
			break;
			
			//我的请求
			case WL_TYPE_I:
			
			if( empty($arr_search['sort']) )
			{
				$arr_search['sort']='db_time_update';
				$arr_search['order']='desc';
			}
			
			$arr_search['where']='';
			$arr_search['value']=array();
			/************查询条件*****************/
			
			/************数据查询*****************/
			$arr_search['field']='wl.*,
								  wlp_time_read,
								  p.p_name';
			
			$arr_search['from']='sys_work_list wl
							    LEFT JOIN sys_proc p ON
							    (p.p_id = wl.p_id )
							    LEFT JOIN sys_wl_person wlp ON
								(wlp.wl_id = wl.wl_id AND wlp.wlp_person = ? AND wlp.wlp_type = '.WLP_TYPE_ACCEPT.' )';
			
			$arr_search['where']=' AND wlp.wlp_person = ? AND wl.wl_type = '.WL_TYPE_I.' AND wl.wl_status < '.WL_STATUS_FINISH.'';
			
			$arr_search['value'][]=$this->sess->userdata('c_id');
			$arr_search['value'][]=$this->sess->userdata('c_id');
			
			$rs=$this->m_db->query($arr_search);
			/************json拼接****************/
			if (count($rs['content']) > 0)
			{
				foreach($rs['content'] as $k => $v)
				{
					if( ! $v['wlp_time_read'] || strtotime($v['db_time_update']) > strtotime($v['wlp_time_read']) )
					{
						$v['flag_new'] = 1;
						$num_news++;
					}
					
					$rows.='{'
						.'"p_name":"'.$v['p_name'].'"'
						.',"flag_new":"'.element('flag_new', $v).'"'
						.',"db_time_update":"'.$v['db_time_update'].'"'
						.',"wl_id":"'.$v['wl_id'].'"'
						.',"wl_code":"'.$v['wl_code'].'"'
						.',"wl_url":"'.$v['wl_url'].'/'.$v['wl_op_field'].'/'.$v['op_id'].'"'
						.',"wl_note":"'.fun_urlencode($v['wl_note']).'"'
						.',"wl_log_note":"'.fun_urlencode($v['wl_log_note']).'"';
					
					$rows.='},';
				}
				$rows=trim($rows,',');
			}
				
			break;
			
			//我的关注
			case 'care':
			
			if( empty($arr_search['sort']) )
			{
				$arr_search['sort']='db_time_update';
				$arr_search['order']='desc';
			}
			
			$arr_search['where']='';
			$arr_search['value']=array();
			/************查询条件*****************/
			
			/************数据查询*****************/
			$arr_search['field']='wl.*,
								  wlp_time_read,
								  p.p_name';
			
			$arr_search['from']='sys_work_list wl
							    LEFT JOIN sys_proc p ON
							    (p.p_id = wl.p_id  )
							    LEFT JOIN sys_wl_person wlp ON
								(wlp.wl_id = wl.wl_id AND wlp.wlp_person = ? AND wlp.wlp_type = '.WLP_TYPE_CARE.' )';
			
			$arr_search['where']=' AND wlp.wlp_person IS NOT NULL AND wl.wl_type = '.WL_TYPE_I.' AND wl.wl_status != '.WL_STATUS_FINISH.'';
			$arr_search['value'][]=$this->sess->userdata('c_id');
			
			$rs=$this->m_db->query($arr_search);
			/************json拼接****************/
			if (count($rs['content']) > 0)
			{
				foreach($rs['content'] as $k => $v)
				{
					if( ! $v['wlp_time_read'] || strtotime($v['db_time_update']) > strtotime($v['wlp_time_read']) )
					{
						$v['flag_new'] = 1;
						$num_news++;
					}
					$rows.='{'
						.'"p_name":"'.$v['p_name'].'"'
						.',"flag_new":"'.element('flag_new', $v).'"'
						.',"db_time_update":"'.$v['db_time_update'].'"'
						.',"wl_id":"'.$v['wl_id'].'"'
						.',"wl_proc":"'.$v['wl_proc'].'"'
						.',"wl_url":"'.$v['wl_url'].'/'.$v['wl_op_field'].'/'.$v['op_id'].'"'
						.',"wl_note":"'.fun_urlencode($v['wl_note']).'"'
						.',"wl_log_note":"'.fun_urlencode($v['wl_log_note']).'"';
					
					$rows.='},';
				}
				$rows=trim($rows,',');
			}
				
			break;
				
			//待办事项
			default:
		
			if( empty($arr_search['sort']) )
			{
				$arr_search['sort']='wl_time_end';
				$arr_search['order']='asc';
			}
			
			$arr_search['where']='';
			$arr_search['value']=array();
			/************查询条件*****************/
			
			/************数据查询*****************/
			$arr_search['field']='wl.*,
								  c.c_name,
								  c.c_login_id,
								  p.p_name';
			
			$arr_search['from']='sys_work_list wl
								LEFT JOIN sys_contact c ON
								(c.c_id = wl.db_person_create)
								LEFT JOIN sys_wl_person wlp ON
								(wlp.wl_id = wl.wl_id AND wlp.wlp_person = ?)
							    LEFT JOIN sys_proc p ON
							    (p.p_id = wl.p_id )';
			
			$arr_search['where']=' AND wl.wl_type != '.WL_TYPE_I.' AND wl.wl_status < '.WL_STATUS_FINISH.' AND wlp.wlp_person IS NOT NULL';
			$arr_search['value'][]=$this->sess->userdata('c_id');
			
			$arr_search['where'].=' GROUP BY wl.op_id';
			$rs=$this->m_db->query($arr_search);
			
			/************json拼接****************/
			if (count($rs['content']) > 0)
			{
				foreach($rs['content'] as $k => $v)
				{
					$rows.='{'
						.'"p_name":"'.$v['p_name'].'"'
						.',"wl_code":"'.$v['wl_code'].'"'
						.',"wl_event":"'.$v['wl_event'].'"'
						.',"db_time_create":"'.$v['db_time_create'].'"'
						.',"c_name":"'.$v['c_name'].'['.$v['c_login_id'].']"'
						.',"wl_id":"'.$v['wl_id'].'"'
						.',"wl_url":"'.$v['wl_url'].'/'.$v['wl_op_field'].'/'.$v['op_id'].'"'
						.',"wl_note":"'.fun_urlencode($v['wl_note']).'"';
					
					$rows.='},';
				}
				$rows=trim($rows,',');
			}
		}
		
		//结束时间
		$time_end=time();
		$time=$time_end-$time_start;
		
		$json.='{"total":"'.$rs['total'].'"'
			   .',"time":"'.$time.'"'
			   .',"num_news":"'.$num_news.'"'
			   .',"title":"工单列表"'
			   .',"msg":"'.$msg.'"'
			   .',"rows":['.$rows.']}';
		
		/************返回数据*****************/
		echo $json;
	}
	
	/**
	 * 工单留言列表
	 */
	public function load_win_worklist()
	{
		/************变量初始化****************/
		$arr_view = array();//视图数组
		$data_post= array();//$POST数组
		$data_get = array();//$GET 数组
		$data_out = array();//输出数组
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		
		/************事件处理*****************/
		
		/************模板赋值*****************/
		$data_out['parent_id']=$this->input->post_get('parent_id');
		$data_out['op_id']=$this->input->post_get('op_id');
		$data_out['pp_id']=$this->input->post_get('pp_id');
		
		if( $this->input->post_get('time') )
		$data_out['time']=$this->input->post_get('time');
		else
		$data_out['time']=time();
				
		/************载入视图 *****************/
		$arr_view[]='base/main/win_worklist';
		$arr_view[]='base/main/win_worklist_js';
		$this->m_view->load_view($arr_view,$data_out);
	}
	
	/**
	 * 工单留言列表
	 */
	public function get_json_wl_comment()
	{
		//判断是否ajax请求
		$is_ajax=$this->input->is_ajax_request();
		if( ! $is_ajax) exit;
		
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
		
		//分页
		$arr_search['page']=$this->input->post_get('page');
		$arr_search['rows']=$this->input->post_get('rows');
		
		//排序
		$arr_search['order']=$this->input->post_get('order');
		$arr_search['sort']=$this->input->post_get('sort');
		
		
		if( empty($arr_search['sort']) )
		{
			$arr_search['sort']='wl_time_do';
			$arr_search['order']='desc';
		}
		
		$arr_search['where']='';
		$arr_search['value']=array();
		/************查询条件*****************/
		
		/************数据查询*****************/
		$arr_search['field']='wl.*,
							 c.c_name,
							 c.c_login_id';
		
		$arr_search['from']='sys_work_list wl
							 LEFT JOIN sys_contact c ON
							 (c.c_id = wl.wl_person_do)';
		
		$arr_search['where']='AND wl.op_id = ? AND pp_id = ? AND wl.wl_type != '.WL_TYPE_I.' AND c.c_name IS NOT NULL AND wl_status > '.WL_STATUS_READ;
		$arr_search['value'][]=element('op_id', $data_get);
		$arr_search['value'][]=element('pp_id', $data_get);
		
		$rs=$this->m_db->query($arr_search);
		/************json拼接****************/
		if (count($rs['content']) > 0)
		{
			foreach($rs['content'] as $k => $v)
			{
				$rows.='{'
					 .'"wl_id":"'.$v['wl_id'].'"'
					 .',"wl_time_do":"'.($v['wl_time_do']).'"'
					 .',"c_name":"'.($v['c_name']).'"'
					 .',"c_login_id":"'.($v['c_login_id']).'"'
					 .',"wl_log_note":"'.($v['wl_log_note']).'"'
					 .',"wl_comment":"'.fun_urlencode($v['wl_comment']).'"';
				
				$rows.='},';
			}
			$rows=trim($rows,',');
		}
		
		//结束时间
		$time_end=time();
		$time=$time_end-$time_start;
		
		$json.='{"total":"'.$rs['total'].'"'
			   .',"time":"'.$time.'"'
			   .',"title":"工单留言"'
			   .',"msg":"'.$msg.'"'
			   .',"rows":['.$rows.']}';
		
		/************返回数据*****************/
		echo $json;
	}
	
	/**
	 * 关联文件
	 */
	public function load_win_file_link()
	{
		/************变量初始化****************/
		$data_out=array();//输出数组
		$arr_view=array();//视图数组
		$data_post=array();//输出数组
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		
		/************事件处理*****************/
		
		/************模板赋值***********/
		$data_get['time'] = $this->input->post_get('time');
		
		$data_out['parent_id']=$this->input->post_get('parent_id');
		$data_out['link_op_id']=$this->input->post_get('op_id');
		$data_out['field']=$this->input->post_get('field');
		$data_out['table']=$this->input->post_get('table');
		
		$data_out['fun_m']=$this->input->post_get('fun_m');
		$data_out['fun_up']=$this->input->post_get('fun_up');
		$data_out['fun_ck']=$this->input->post_get('fun_ck');
		
		$data_out['search_f_t_proc']=$this->input->post_get('search_f_t_proc');
		$data_out['flag_f_type_more']=$this->input->post_get('flag_f_type_more');
		
		$this->load->model('proc_file/m_proc_file');
		$acl_file = $this->m_proc_file->get_acl();
		
		$data_out['flag_f_del']= '';
		
		if( ($acl_file & pow(2,ACL_PROC_FILE_SUPER)) != 0 
		 || ($acl_file & pow(2,ACL_PROC_FILE_LFILE_DEL)) != 0 )
    	{
    		$data_out['flag_f_del']= '1';
    	}
		
		$data_out['title']='文件索引';
		$data_out['time']=time();
		if( ! empty(element('time', $data_get)) )
		$data_out['time']=element('time', $data_get);
		
		$data_out['url']='base-main-file_link';
		
		$data_out['field_search_start']='f_name,db_person_create,f_type';
		$data_out['field_search_rule_default']='{"field":"f_name","field_s":"文件名","table":"sys_file","value":"","rule":"like","group":"search","editor":"text"}';
		$data_out['field_search_rule_f_type']='{"field":"f_type","field_r":"f_id","m_link":"f_id","m_link_content":"f_type","field_s":"文件属性","table":"","value":"'.element('f_type',$data_get).'","rule":"in","group":"search"
		  ,"fun_end":"fun_end_f_type_search'.$data_out['time'].'()"
		  ,"editor":{
			"type":"combotree",
			"options":{
				"valueField": "id",
				"textField": "text",
				"panelHeight":"auto",
				"panelMaxHeight":"200",
				"panelWidth":"250",
				"multiple":"true",
				"url_l":"proc_file/file_type/get_json/from/combobox/field_id/f_t_id/field_text/f_t_name/search_f_t_proc/'.$data_out['search_f_t_proc'].'",
			}
		}}';
		$data_out['field_search_rule']='
		{"id":"f_name","text":"文件名","rule":{"field":"f_name","field_s":"文件名","table":"sys_file","value":"'.element('f_name',$data_get).'","rule":"like","group":"search","editor":"text"}}
		,{"id":"db_person_create","text":"创建人","rule":{"field":"db_person_create","field_s":"创建人","table":"","value":"'.element('db_person_create',$data_get).'","rule":"=","group":"search","editor":{
			"type":"combobox",
			"options":{
				"hasDownArrow":"",
				"panelHeight":"0",
				"start_fun":"load_db_person_create_search'.$data_out['time'].'()"
			}
		}}}
		,{"id":"f_type","text":"文件属性","rule":{"field":"f_type","field_r":"f_id","m_link":"f_id","m_link_content":"f_type","field_s":"文件属性","table":"","value":"'.element('f_type',$data_get).'","rule":"in","group":"search"
		  ,"fun_end":"fun_end_f_type_search'.$data_out['time'].'()"
		  ,"editor":{
			"type":"combotree",
			"options":{
				"valueField": "id",
				"textField": "text",
				"panelHeight":"auto",
				"panelMaxHeight":"200",
				"panelWidth":"250",
				"multiple":"true",
				"url_l":"proc_file/file_type/get_json/from/combobox/field_id/f_t_id/field_text/f_t_name/search_f_t_proc/'.$data_out['search_f_t_proc'].'",
			}
		}}}
		,{"id":"db_time_create_start","text":"上传时间(>)","rule":{"field":"db_time_create_start","field_s":"上传时间(>)","field_r":"db_time_create","table":"","value":"'.element('db_time_create_start',$data_get).'","rule":">=","group":"search","editor":{
			"type":"datetimebox",
			"options":{
			}
		}}}
		,{"id":"db_time_create_end","text":"上传时间(<)","rule":{"field":"db_time_create_end","field_s":"上传时间(<)","field_r":"db_time_create","table":"","value":"'.element('db_time_create_end',$data_get).'","rule":"<=","group":"search","editor":{
			"type":"datetimebox",
			"options":{
			}
		}}}
		';
		
		$data_out['field_search_value_dispaly']= array(
		);
		$data_out['field_search_value_dispaly']=json_encode($data_out['field_search_value_dispaly']);
		
		$data_out=$this->m_base->get_person_conf_index($data_out);
		
		/************载入视图 ****************/
		$arr_view[]='base/main/win_file_link';
		$arr_view[]='base/main/win_file_link_js';
		$this->m_view->load_view($arr_view,$data_out);
	}
	
}
