<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 权限管理
 * @author 朱明
 *
 */
class Acl extends CI_Controller {

	
	public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        
    	$p_id='proc_back';
        $this->config->load('proc/'.$p_id.'/conf', FALSE, TRUE);
        
        $arr_conf = $this->config->item('p_conf');
        
        $m_conf='m_'.$p_id;
        $this->load->model($p_id.'/'.$m_conf);
        
        //权限验证
        $this->acl_list = $this->$m_conf->get_acl();
        
        //超级权限
        if( ( $this->acl_list & pow(2,ACL_PROC_BACK_SUPER) ) != 0 
        //权限管理
         || ( $this->acl_list & pow(2,ACL_PROC_BACK_ACL) ) != 0 
        )
        {
        	
        }
        else 
        {
        	$msg = '没有【'.$arr_conf['p_name'].'】的的【'.$GLOBALS[strtoupper($p_id)]['text']['d_acl'][ACL_PROC_BACK_ACL].'】权限，不可访问此页面！';
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
	 * 权限管理
	 */
	public function main()
	{
		/************变量初始化****************/
		$data_out=array();//输出数组
		$arr_view=array();//视图数组
		$data_post=array();//输出数组
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		/************事件处理*****************/
		
		/************模板赋值***********/
		$data_out['title']='权限管理';
		$data_out['time']=time();
		
		/************载入视图 ****************/
		$arr_view[]='proc_back/acl/main';
		$arr_view[]='proc_back/acl/main_js';
		$this->m_view->load_view($arr_view,$data_out);
	}
	
	/**
	 * 获取流程权限列表
	 */
	public function get_json_proc_acl()
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
		
		if( empty(element('p_id', $data_get)) )
		exit;
		
		$p_id=$data_get['p_id'];
		/************读取数据*****************/
		
		$m_conf = 'm_'.$p_id;
        $this->load->model($p_id.'/'.$m_conf);
        
		$p_id=strtoupper($p_id);
		if(count($GLOBALS[$p_id]['text']['d_acl']) > 0)
		{
			foreach ($GLOBALS[$p_id]['text']['d_acl'] as $k => $v) {
				$rows.='{"acl":"'.$k.'"
						 ,"acl_s":"'.$v.'"
						 ,"acl_note":"'.element($k,$GLOBALS[$p_id]['text']['d_acl_note']).'"
						},';
			}
			$rows=trim($rows,',');
		}
		
		/************返回数据*****************/
		echo '['.$rows.']';
	}
	
	/**
	 * 获取流程权限数据
	 */
	public function get_json_acl_data()
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
		$role_id = element('role_id', $data_get);
		
		$search_ra_id=$this->input->post('search_ra_id');
		
		//分页
		$arr_search['page']=$this->input->post_get('page');
		$arr_search['rows']=$this->input->post_get('rows');
		
		//排序
		$arr_search['order']=$this->input->post_get('order');
		$arr_search['sort']=$this->input->post_get('sort');
		
		$arr_search['where']='';
		$arr_search['value']=array();
		
		if( empty(element('p_id', $data_get)) )
		exit;
		
		/************数据查询*****************/
		
		if( ! empty($search_ra_id) )
		{
			$search_ra_id=trim($search_ra_id);
			$arr_search['where']=' AND a.a_login_id IN ? ';
			$arr_search['value'][]=explode(',', $search_ra_id);
			
			if( empty($arr_search['sort']) || $arr_search['sort'] == 'ra_name')
			{
				$arr_search['sort']=array('a.a_login_id');
				$arr_search['order']=array($arr_search['order']);
			}
			else 
			{
				$pa_sn = trim($arr_search['sort'],'acl_');
				
				$arr_search['sort']=array('(acl.a_acl & '.pow(2,$pa_sn).')','a.a_login_id');
				$arr_search['order']=array($arr_search['order'],'asc');
			}
			
			$arr_search['field']='a.a_id ra_id,
								  a.a_login_id,
								  a.a_name,
								  acl.op_id,
								  GROUP_CONCAT(acl.a_acl) a_acl';
			
			$arr_search['from']="sys_account a 
								 LEFT JOIN sys_ra_link ra ON
								 (ra.a_id = a.a_id )
			   					 LEFT JOIN sys_acl acl ON
			   					 ( acl.op_id ='{$data_get['p_id']}' AND (acl.ra_id = a.a_id OR acl.ra_id = ra.role_id))";
			
			$arr_search['where'].='GROUP BY a.a_id'; 
			
			$rs=$this->m_db->query($arr_search);
			/************json拼接****************/
			if (count($rs['content']) > 0)
			{
				foreach($rs['content'] as $k => $v)
				{
					$rows.='{'
						 .'"ra_name":"'.$v['a_name'].'['.$v['a_login_id'].']",'
						 .'"ra_id":"'.$v['ra_id'].'",'
						 .'"op_id":"'.$v['op_id'].'",';

					//叠加所有角色的权限
					$arr_tmp=explode(',', $v['a_acl']);
					$v['a_acl']='';
					if(count($arr_tmp)>0)
					{
						foreach ($arr_tmp as $v1) {
							$v['a_acl']=$v['a_acl'] | $v1;
						}
					}
					
					//权限位转换
					$v['a_acl']=str_split(strrev(decbin($v['a_acl'])));	 
					
					if(count($v['a_acl'])>0)
					{
						foreach ($v['a_acl'] as $k2=>$v2) {
							$rows.='"acl_'.$k2.'":"'.$v2.'",';
						}
					}
					
					$rows=trim($rows,',');
					
					$rows.='},';
				}
				$rows=trim($rows,',');
			}
			
		}
		elseif( ! empty($role_id) )
		{
			if( empty($arr_search['sort']) || $arr_search['sort'] == 'ra_name')
			{
				$arr_search['sort']=array('role_name');
				$arr_search['order']=array($arr_search['order']);
			}
			else 
			{
				$pa_sn = trim($arr_search['sort'],'acl_');
				
				$arr_search['sort']=array('(a_acl & '.pow(2,$pa_sn).')','role_name');
				$arr_search['order']=array($arr_search['order'],'asc');
			}
			$arr_search['field']='acl.*,
								  r.role_name,
								  r.role_id';
			
			$arr_search['from']="sys_role r
								 LEFT JOIN sys_acl acl ON
								 (r.role_id = acl.ra_id AND acl.op_id ='{$data_get['p_id']}')";
			
			$arr_search['where']=' AND role_id = ? ';
			$arr_search['value'][]=$role_id;
			
			$rs=$this->m_db->query($arr_search);
			
			if (count($rs['content']) > 0)
			{
				foreach($rs['content'] as $k => $v)
				{
					$rows.='{'
						 .'"ra_name":"'.$v['role_name'].'",'
						 .'"ra_id":"'.$v['role_id'].'",'
						 .'"op_id":"'.$v['op_id'].'",';
					
					//权限位转换
					$v['a_acl']=str_split(strrev(decbin($v['a_acl'])));	 
					
					if(count($v['a_acl'])>0)
					{
						foreach ($v['a_acl'] as $k2=>$v2) {
							$rows.='"acl_'.$k2.'":"'.$v2.'",';
						}
					}
					
					$rows=trim($rows,',');
					
					$rows.='},';
				}
				$rows=trim($rows,',');
			}
		}
		else 
		{
			$arr_search['where']=' AND op_id= ? AND a_acl != 0';
			$arr_search['value'][]=element('p_id', $data_get);
				
			if( empty($arr_search['sort']) || $arr_search['sort'] == 'ra_name')
			{
				$arr_search['sort']=array('a.a_login_id');
				$arr_search['order']=array($arr_search['order']);
			}
			else 
			{
				$pa_sn = trim($arr_search['sort'],'acl_');
				
				$arr_search['sort']=array('(a_acl & '.pow(2,$pa_sn).')','a.a_login_id');
				$arr_search['order']=array($arr_search['order'],'asc');
			}
			
			$arr_search['field']='acl.op_id,
								  GROUP_CONCAT(acl.a_acl) a_acl,
								  a.a_id,
								  a.a_name,
								  a.a_login_id ra_login_id';
			
			$arr_search['from']='sys_acl acl
								 LEFT JOIN sys_ra_link ra ON
								 (ra.role_id = acl.ra_id)
								 LEFT JOIN sys_account a ON
								 (a.a_id =ra.a_id OR a.a_id = acl.ra_id)';
			$arr_search['where'].=' AND a.a_id IS NOT NULL  GROUP BY a.a_id'; 
			$rs=$this->m_db->query($arr_search);
			
			/************json拼接****************/
			if (count($rs['content']) > 0)
			{
				foreach($rs['content'] as $k => $v)
				{
					$v['ra_name']= $v['a_name'].'['.$v['ra_login_id'].']';
					
					$rows.='{'
						 .'"ra_name":"'.$v['ra_name'].'",'
						 .'"ra_id":"'.$v['a_id'].'",'
						 .'"op_id":"'.$v['op_id'].'",';
					
					//叠加所有角色的权限
					$arr_tmp=explode(',', $v['a_acl']);
					$v['a_acl']=0;
					foreach ($arr_tmp as $v1) {
						$v['a_acl']=$v['a_acl'] | $v1;
					}
					
					//权限位转换
					$v['a_acl']=str_split(strrev(decbin($v['a_acl'])));	 
					
					if(count($v['a_acl'])>0)
					{
						foreach ($v['a_acl'] as $k2=>$v2) {
							$rows.='"acl_'.$k2.'":"'.$v2.'",';
						}
					}
					
					$rows=trim($rows,',');
					
					$rows.='},';
				}
				$rows=trim($rows,',');
			}
		}
		
		//结束时间
		$time_end=time();
		$time=$time_end-$time_start;
		
		if($rs['total'] < 50 && $rs['total'] > count($rs['content']))
		$rs['total'] =count($rs['content']);
		
		$json.='{"total":"'.$rs['total'].'"'
			   .',"time":"'.$time.'"'
			   .',"msg":"'.$msg.'"'
			   .',"search_ra_id":"'.$search_ra_id.'"'
			   .',"rows":['.$rows.']}';
		
		/************返回数据*****************/
		echo $json;
		
	}
	
	/**
	 * 权限操作
	 */
	public function fun_acl_operate()
	{
		//判断是否ajax请求
		$is_ajax=$this->input->is_ajax_request();
		if( ! $is_ajax) exit;
		
		/************变量初始化****************/
		$rtn=array();//结果
		$data_post=array();//POST数组
		$data_get=array();//GET数组
		$data_db=array();//数据库数组
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		$data_post= $this->input->post('content');
		$check   = $this->input->post('check');
		$ra_list = $this->input->post('ra_list');
		
		$data_post['a_acl'] = trim($data_post['a_acl'],'acl_');
		$ra_list = trim($ra_list);
		
		$rtn['rtn']=FALSE;
		/************数据验证*****************/
		
		if( element('a_acl',$data_post) !=0 && empty(element('a_acl',$data_post)) )
		{
			exit;
		}
		
		if( empty(element('op_id',$data_post)) 
		 || ( empty(element('ra_id',$data_post)) ) )//&& empty($ra_list)
		{
			exit;
		}
		
		/************事件处理*****************/
		
		$data_db['content']=$this->m_acl->get($data_post['op_id'],$data_post['ra_id']);
		
		if( ! empty($data_db['content']) )
		{
			//存在权限，请求取消权限
			if( $check != 1 && ($data_db['content']['a_acl'] & pow(2,$data_post['a_acl'])) )
			{
				$data_save['content']['op_id'] = $data_post['op_id'];
				$data_save['content']['ra_id'] = $data_post['ra_id'];
				$data_save['content']['a_acl'] = $data_db['content']['a_acl'];
				$data_save['content']['a_acl']-=pow(2,$data_post['a_acl']);
				
				if( $data_save['content']['a_acl'] == 0 )
				$rtn=$this->m_acl->del($data_save['content']['op_id'],$data_save['content']['ra_id']);
				else
				$rtn=$this->m_acl->update($data_save['content']);
			}
			//不存在权限，请求添加权限
			elseif( $check == 1 && ! ($data_db['content']['a_acl'] & pow(2,$data_post['a_acl'])) )
			{
				$data_save['content']['op_id'] = $data_post['op_id'];
				$data_save['content']['ra_id'] = $data_post['ra_id'];
				$data_save['content']['a_acl'] = $data_db['content']['a_acl'];
				$data_save['content']['a_acl']+=pow(2,$data_post['a_acl']);
				
				$rtn=$this->m_acl->update($data_save['content']);
			}
			
		}
		//不存在权限，请求添加权限
		elseif( $check == 1 )
		{
			$this->load->model('proc_back/m_account');
			
			$data_db['content_a']=$this->m_account->get($data_post['ra_id']);
			
			if( ! empty(element('a_id', $data_db['content_a'])) )
			{
				$data_save['content']['a_login_id']=$data_db['content_a']['a_login_id'];
			}
			
			$data_save['content']['op_id'] = $data_post['op_id'];
			$data_save['content']['ra_id'] = $data_post['ra_id'];
			$data_save['content']['a_acl'] = pow(2,$data_post['a_acl']) ;
			
			$rtn=$this->m_acl->add($data_save['content']);
		}
		
		$rtn['check']=$this->m_acl->check_acl($data_post['op_id'],$data_post['a_acl'],$data_post['ra_id']);
		
		/************返回数据*****************/
		echo json_encode($rtn);
	}
	
	/**
	 * 账户权限管理
	 */
	public function index_account()
	{
		/************变量初始化****************/
		$data_out=array();//输出数组
		$arr_view=array();//视图数组
		$data_post=array();//输出数组
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		/************事件处理*****************/
		
		/************模板赋值***********/
		$data_out['title']='账户权限管理';
		$data_out['time']=time();
		
		/************载入视图 ****************/
		$arr_view[]='proc_back/acl/index_account';
		$arr_view[]='proc_back/acl/index_account_js';
		$this->m_view->load_view($arr_view,$data_out);
	}
	
	/**
	 * 角色权限管理
	 */
	public function index_role()
	{
		/************变量初始化****************/
		$data_out=array();//输出数组
		$arr_view=array();//视图数组
		$data_post=array();//输出数组
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		/************事件处理*****************/
		
		/************模板赋值***********/
		$data_out['title']='账户权限管理';
		$data_out['time']=time();
		
		/************载入视图 ****************/
		$arr_view[]='proc_back/acl/index_role';
		$arr_view[]='proc_back/acl/index_role_js';
		$this->m_view->load_view($arr_view,$data_out);
	}
}
