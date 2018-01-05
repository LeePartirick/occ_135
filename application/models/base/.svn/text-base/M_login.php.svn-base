<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 登陆类
 */
class M_login extends CI_Model {
	
 	public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        
        $this->load->model('base/m_log_login');
    }
    
	/**
     * 
     * 定义
     */
	public function m_define()
    {
    	if( defined('LOAD_M_LODIN') ) return;
    	define('LOAD_M_LODIN', 1);
    }
    
	/**
     * 
     * 验证登陆
     */
	public function check()
    {
    	//获取session
		$a_id=$this->sess->userdata('a_id') ;
		
		//已登陆
		if( ! empty($a_id) )
		{
			//是否存在跳转uri
			$r_uri=$this->sess->userdata('r_uri') ;
			if( ! empty($r_uri) 
			 && ! strstr($r_uri, 'show_404'))
			{
				$this->sess->unset_userdata('r_uri');
				redirect($r_uri);
			}
			
			redirect('app/index.html');
		}
    }
    
	/**
	 * 
	 * 事件处理
	 */
	public function event()
    {

    	$fun=$this->uri->segment(3, 0);
    	
    	$btn=$this->input->post('btn');
    	
    	switch ($fun)
		{
			case 'index':
				
				if($btn == 'login')
				{
					$this->event_login();
				}
				
				break;
			default:
				break; 
		}
    }
    
	private function event_login()
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$data_post=array();//POST数组
		$data_get=array();//GET数组
		$data_db=array();//数据库数组
		$data_save=array();//数据库保存数组
		$arr_search=array();
		$rtn=array();//结果
		$check_data=TRUE;
		$arr_sess=array();
		/************变量赋值*****************/
		$data_post=$this->input->post('data');
		
		$login_id=trim(element('login_id',$data_post));
		$login_pwd=trim(element('login_pwd',$data_post));
		$login_yzm=trim(element('login_yzm',$data_post));
		$login_yzm_time=trim(element('login_yzm_time',$data_post));
		/************数据验证*****************/
		
    	if( empty(element('login_id',$data_post)) )
		{
			$rtn['err']['data[login_id]']='请输入账号！';
			$check_data=FALSE;
		}
		
    	if( empty(element('login_pwd',$data_post)) )
		{
			$rtn['err']['data[login_pwd]']='请输入密码！';
			$check_data=FALSE;
		}
		
		$sess_yzm=$this->sess->userdata('sess_yzm') ;
		
    	if( element($login_yzm_time, $sess_yzm) != element('login_yzm',$data_post) )
		{
			$rtn['err']['data[login_yzm]']='请输入验证码！';
			$check_data=FALSE;
		}
		
    	if( ! $check_data)
		{
			$rtn['result']=FALSE;
			echo json_encode($rtn);
			exit; 
		}
		
		/************事件处理*****************/
		$arr_search['field']='a.a_id,
							  a.a_login_id,
							  a.a_name,
							  a.a_password,
							  a.a_status,
							  a.a_login_type,
							  c.c_id,
							  c.c_tel,
							  c.c_org,
							  c.c_img,
							  c.c_ou_4,
							  c.c_ou_bud
							  ';
		$arr_search['from']='sys_account a
							 LEFT JOIN sys_contact c ON
							 (c.c_login_id = a.a_login_id)';
		$arr_search['where']='AND a_login_id = ? ';
		$arr_search['value'][]=$login_id;
		$rs=$this->m_db->query($arr_search);
		
		if (count($rs['content']) == 0)
		{
			$rtn['result']=FALSE;
			$rtn['err']['data[login_id]']='账号或密码错误！';
		}
		else 
		{
			$rs['content']=current($rs['content']);
			
			//账户状态是否停用
			if($rs['content']['a_status']==A_STATUS_STOP)
			{
				$rtn['result']=FALSE;
				$rtn['err']['data[login_id]']='该账号已停用！';
			}
			elseif( empty($rs['content']['c_id']) )
			{
				$rtn['result']=FALSE;
				$rtn['err']['data[login_id]']='该账号未关联【联系人】！';
			}
			elseif($rs['content']['a_status']==A_STATUS_NORMAL)
			{
				//数据库认证
				if($rs['content']['a_login_type']==A_LOGIN_TYPE_DB)
				{
					if(encry_pwd($login_pwd)===$rs['content']['a_password'])
					{
						$rtn['result']=TRUE;
						$rtn['sys_msg']='登录成功！';
					}
					else
					{
						$rtn['result']=FALSE;
						$rtn['err']['data[login_id]']='账号或密码错误！';
					}
				}
				//AD域认证
				elseif($rs['content']['a_login_type']==A_LOGIN_TYPE_AD)
				{
					$ad_host=$this->config->item('ad_host');
					$ad_yu=$this->config->item('ad_yu');
					
					$conn = ldap_connect($ad_host);
					
					if ($conn)
					{
						ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);
						
						if ( ! @ldap_bind($conn, $login_id.$ad_yu, $login_pwd))
						{
							$rtn['result']=FALSE;
							$rtn['sys_msg']='AD域认证错误！';
						}
						else
						{
							$rtn['result']=TRUE;
							$rtn['sys_msg']='登录成功！';
						}
					}
					else 
					{
						$rtn['result']=FALSE;
						$rtn['sys_msg']='AD域链接失败！请联系管理员！';
					}
				}
				
				//登录成功
				if($rtn['result']==TRUE)
				{
					$this->sess->unset_userdata('sess_yzm');
					
					//创建session
					$arr_sess['sid']=session_id();
					$arr_sess['a_login_id']=$login_id;
					$arr_sess['a_id']=$rs['content']['a_id'];
					$arr_sess['c_name']=$rs['content']['a_name'];
					$arr_sess['c_show']=$rs['content']['a_name'].'['.$login_id.']';
					$arr_sess['c_id']=$rs['content']['c_id'];
					$arr_sess['c_tel']=$rs['content']['c_tel'];
					$arr_sess['c_org']=$rs['content']['c_org'];
					$arr_sess['c_img']=$rs['content']['c_img'];
					$arr_sess['c_ou_bud']=$rs['content']['c_ou_bud'];
					$this->sess->set_userdata($arr_sess);
					
				}
			}
		}
		
		//登陆日志
		$data_save['sys_log_login']=$arr_sess;
		$data_save['sys_log_login']['a_login_id']=$login_id;
		$data_save['sys_log_login']['log_result']=$rtn['result'];
		$data_save['sys_log_login']['log_note']= ! empty( element('sys_msg', $rtn) )? element('sys_msg', $rtn) : $rtn['err']['data[login_id]'];
		$this->m_log_login->add($data_save['sys_log_login']);
		
		/************返回结果****************/
    	
		echo json_encode($rtn);
		exit; 
    }
    
}