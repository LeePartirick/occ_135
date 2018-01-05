<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 *信息系统申请
 */
class M_office_apply extends CI_Model {

	//@todo 主表配置
	private $table_name='oa_office_apply';
	private $pk_id='offa_id';
	private $table_form;
	private $title='信息系统申请';
	private $model_name = 'm_office_apply';
	private $url_conf = 'proc_office/office_apply/edit';
	private $proc_id = 'proc_office';

	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
		$this->m_define();

		//读取表结构
		$this->config->load('db_table/'.$this->table_name, FALSE,TRUE);
		$this->table_form=$this->config->item($this->table_name);
		
		$this->load->model('proc_office/m_oa_office');
		$this->load->model('proc_office/m_oa_contact');
	}

	/**
	 *
	 * 定义
	 */
	public function m_define()
	{
		//@todo 定义
		if( defined('LOAD_M_OFFICE_APPLY') ) return;
		define('LOAD_M_OFFICE_APPLY', 1);

		//define
		// 节点
    	define('OA_OFFA_PPO_END', 0); // 流程结束
		define('OA_OFFA_PPO_START', 1); // 起始
		define('OA_OFFA_PPO_ACCOUNT', 2); // 账户开通
		define('OA_OFFA_PPO_OFFICE', 3); // 系统开通
    	
    	$GLOBALS['m_office_apply']['text']['ppo']=array(
    		OA_OFFA_PPO_START=>'起始',
    		OA_OFFA_PPO_ACCOUNT=>'开通账户',
    		OA_OFFA_PPO_OFFICE=>'开通系统',
    		OA_OFFA_PPO_END=>'流程结束',
    	);
	}
	
	/**
	 * 
	 * 权限验证
	 * @param $content
	 */
	public function check_acl( $data_db=array() ,$acl_list = NULL)
    {
    	/************变量初始化****************/
    	
    	$data_get=trim_array($this->uri->uri_to_assoc(4));
    	$act=element('act', $data_get);
    	
    	if( ! $acl_list )
    	$acl_list= $this->m_proc_office->get_acl();
    	
    	$msg='';
    	/************权限验证*****************/
    	
    	//如果有超级权限，TRUE
    	if( ($acl_list & pow(2,ACL_PROC_OFFICE_SUPER)) != 0 )
    	{
    		return TRUE;
    	}
    	
    	$check_acl=FALSE;
    	
	    //账户开通节点，没有账户开通权限
    	if( ($acl_list & pow(2,ACL_PROC_OFFICE_ACCOUNT)) == 0 )
    	{
    		if( ! $check_acl 
	    	 && element('ppo',$data_db['content']) == OA_OFFA_PPO_ACCOUNT
	    	 && $act == STAT_ACT_EDIT
	    	)
		    {
		    	$url=current_url();
				$url=str_replace('/act/2','/act/3',$url);
				redirect($url);
		    }
    	}
    	else
    	{
    		$check_acl=TRUE;
    	}
	    
    	if(  ($acl_list & pow(2,ACL_PROC_OFFICE_CHECK)) == 0 )
    	{
    		//系统开通节点，没有审核权限
	    	if( ! $check_acl 
	    	 && element('ppo',$data_db['content']) == OA_OFFA_PPO_OFFICE
	    	 && $act == STAT_ACT_EDIT
	    	)
		    {
		    	$url=current_url();
				$url=str_replace('/act/2','/act/3',$url);
				redirect($url);
		    }
    	}
    	else
    	{
    		$check_acl=TRUE;
    	}
	    
    	if( ! $check_acl 
    	 && ($acl_list & pow(2,ACL_PROC_OFFICE_USER)) != 0 
    	)
	    {
    		$check_acl=TRUE;
	    		
	    	if( element('db_person_create',$data_db['content']) 
	    	 && ( element('db_person_create',$data_db['content']) != $this->sess->userdata('c_id') 
	    	   && element('iffa_c_id',$data_db['content']) != $this->sess->userdata('c_id') )
	    	)
	    	{
				$msg = '您不是该单据的所有人,不可进行操作！' ;
				$check_acl = FALSE;
	    	}
	    }
	    
	    if( ! $check_acl )
	    {
			if( ! $msg )
			$msg = '您没有【信息系统】的【操作】权限,不可进行操作！' ;
			
			redirect('base/main/show_err/msg/'.fun_urlencode($msg));
	    }
    }

	/**
     * 
     */
	public function get_code($data_save=array())
    {
    	$where='';
    	 
    	$pre='OA'.date("Ym");
    	$where .= " AND offa_code LIKE  '{$pre}%'"; 
    	
    	$max_code=$this->m_db->get_m_value('oa_office_apply','offa_code',$where);
    	$code=$pre.str_pad((intval(substr($max_code, (strlen($pre))))+1), 4, '0', STR_PAD_LEFT);
    	
    	return $code;
    }
    
	/**
	 *
	 * @param $id
	 */
	public function get($id)
	{
		/************模型载入*****************/

		/************变量初始化****************/
		$data_db=array();//数据库数组
		$arr_search=array();
		$rtn=array();//结果

		/************变量赋值*****************/
		$arr_search['field']='*';
		$arr_search['from']=$this->table_name;
		$arr_search['where']='AND '.$this->pk_id.' = ? ';
		$arr_search['value'][]=$id;
		$rs=$this->m_db->query($arr_search);

		if(count($rs['content'])>0)
			$rtn=current($rs['content']);

		/************返回数据*****************/
		return $rtn;
	}

	/**
	 *
	 * 创建
	 * @param $content
	 */
	public function add($content)
	{
		/************模型载入*****************/

		/************变量初始化****************/
		$data_save=array();//
		$rtn=array();//结果
		$rtn['rtn']=TRUE;
		/************变量赋值*****************/
		$data_save['content']=$content;

		if( empty(element($this->pk_id,$data_save['content'])) ) $data_save['content'][$this->pk_id]=get_guid();
		$data_save['content']['db_time_update']=date("Y-m-d H:i:s");
		$data_save['content']['db_time_create']=date("Y-m-d H:i:s");
		$data_save['content']['db_person_create']=$this->sess->userdata('c_id') ;
		/************数据处理*****************/

		$this->db->trans_begin();

		if($rtn['rtn'])
			$rtn=$this->m_db->insert($data_save['content'],$this->table_name);

		if( ! $rtn['rtn'] )
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
			$rtn['id']=$data_save['content'][$this->pk_id];
		}

		/************返回数据*****************/
		return $rtn;
	}

	/**
	 *
	 * 更新
	 * @param $content
	 */
	public function update($content)
	{
		/************模型载入*****************/

		/************变量初始化****************/
		$data_save=array();//
		$rtn=array();//结果
		$rtn['rtn']=TRUE;
		$where='';
		/************变量赋值*****************/
		$data_save['content']=$content;

		$data_save['content']['db_time_update']=date("Y-m-d H:i:s");
		$where=" 1=1 AND {$this->pk_id} = '{$data_save['content'][$this->pk_id]}'";

		/************数据处理*****************/
		$this->db->trans_begin();

		if($rtn['rtn'])
			$rtn=$this->m_db->update($this->table_name,$data_save['content'],$where);


		if( ! $rtn['rtn'] )
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
		}
		/************返回数据*****************/
		return $rtn;
	}

	/**
	 *
	 * 删除
	 * @param $content
	 */
	public function del($id)
	{
		/************模型载入*****************/

		/************变量初始化****************/
		$where=array();
		$rtn=array();//结果
		$rtn['rtn']=TRUE;
		/************变量赋值*****************/
		$where[$this->pk_id]=$id;

		/************数据处理*****************/
		$arr_link=array(
		);

		if(count($arr_link) > 0)
		{
			foreach ($arr_link as $v ) {
				$arr_tmp = explode('.', $v);
				$field=$this->m_base->get_field_where($arr_tmp[0],$arr_tmp[1]," AND {$arr_tmp[1]} = '{$id}' ");
				if($field)
				{
					$rtn['rtn'] = FALSE;
					$rtn['err']['msg'] = '于【'.$arr_tmp[0].'】存在关联数据,不可删除!';
					return $rtn;
				}
			}
		}

		$this->db->trans_begin();

		if($rtn['rtn'])
			$rtn=$this->m_db->delete($this->table_name,$where);
			
		if($rtn['rtn'])
			$rtn=$this->m_db->delete('oa_offa_item',$where);

		if( ! $rtn['rtn'] )
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
			
			//取消工单信息
	        $this->m_work_list->cancel_wl($id,$this->model_name);
		}

		/************返回数据*****************/
		return $rtn;
	}

	/**
	 *
	 * 生成导入xlsx
	 */
	public function create_import_xlsx()
	{
		$this->load->model('base/m_excel');

		$conf=array();

		//@todo 导入xlsx配置
		$conf['field_edit']=array(
			'oa_office_apply[offa_c_apply]',
			'oa_office_apply[offa_c_id]',
			'oa_office_apply[offa_note]',
		);

		$conf['field_required']=array(
			'oa_office_apply[offa_c_id]',
			'oa_office_apply[offa_c_apply]'
		);

		$conf['field_define']=array(
    	);

		$conf['table_form']=array(
			'oa_office_apply'=>$this->table_form
		);

		$path=str_replace('\\', '/', APPPATH).'models/'.$this->proc_id.'/'.$this->model_name.'.xlsx';

		$this->m_excel->create_import_file($path,$conf);
	}

	/**
	 *
	 * 载入编辑界面
	 * @param $content
	 */
	public function load($data_get=array(),$data_post=array())
	{
		/************变量初始化****************/
		$arr_view = array();//视图数组
		$data_out = array();//输出数组
		$data_db  = array();//数据库数据

		//@todo 必填只读配置
		//必填数组
		$data_out['field_required']=array(
			'content[offa_c_apply]',
			'content[offa_c_id]',
			'content[offa_c_apply_s]',
			'content[offa_c_id_s]',
		);

		//编辑数组
		$data_out['field_edit']=array(
			'content[offa_c_apply_s]',
			'content[offa_c_id_s]',
			'content[offa_c_apply]',
			'content[offa_c_id]',
			'content[offa_note]',
			'content[office]',
		);

		//只读数组
		$data_out['field_view']=array(
			'content[c_tel]',
			'content[c_tel_info]',
			'content[c_tel_2]',
			'content[c_tel_2_info]',
			'content[c_email]',
			'content[c_org_s]',
			'content[c_hr_org_s]',
			'content[c_ou_2_s]',
			'content[c_ou_3_s]',
			'content[c_ou_4_s]',
			'content[c_job_s]',
			'content[c_login_id]',
			'content[c_tel_code]',
			'content[c_pwd_web]',
			'content[c_org]',
		);

		$data_out['op_disable']=array();

		//输出数据数组
		$data_out['field_out']=array_unique(array_merge($data_out['field_view'],$data_out['field_edit']));

		/************变量赋值*****************/

		$flag_log=$this->input->post('flag_log');//日志标签

		if( empty($data_get) )
			$data_get= trim_array($this->uri->uri_to_assoc(4));

		if( ! isset($data_get['act']) )
			$data_get['act'] = STAT_ACT_CREATE;

		if( empty( element('btn', $data_post) ) )
			$data_post['btn']=$this->input->post('btn');//按钮

		$btn=$data_post['btn'];

		if( empty( element('content', $data_post) ) )
			$data_post['content']=trim_array($this->input->post('content'));

		$flag_more=element('flag_more', $data_post);

		/************字段定义*****************/
		//@todo 字段定义
		$arr_field=array_unique(array_merge($data_out['field_edit'], $data_out['field_view']));

		$data_out['json_field_define']=array();
		/************数据读取*****************/
		$data_db['content']=array();
		$data_db['wl_list']=array();

		switch ($data_get['act']) {
			case STAT_ACT_EDIT:
			case STAT_ACT_VIEW:
				try {

					//日志读取
					if( ! empty($flag_log))
					{
						$data_get['act'] = STAT_ACT_VIEW;
						$data_out['op_disable'][]='btn_log';

						$log_content=json_decode($this->input->post('log_content'),TRUE);
						$data_old=element('old', $log_content);
						$data_db['content']=$data_old['content'];
						$data_change=element('new', $log_content);

						if( count(element('content',$data_change))>0)
						{
							foreach (element('content',$data_change) as $k=>$v)
							{
								if( $v != element($k,$data_db['content']) )
								{
									switch ($k)
									{
										case 'office':
									
											$data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('offai_id',$v,element($k,$data_db['content']),'m_oa_contact','show_change_office');
											$data_db['content'][$k] =$v ;
											
											break;
										default:
											if( (element($k,$data_db['content']) || element($k,$data_db['content']) == '0' )
												&& isset($GLOBALS[$this->model_name]['text'][$k][$v]) )
												$data_db['content'][$k]=$GLOBALS[$this->model_name]['text'][$k][element($k,$data_db['content'])];

											$data_out['log']['content['.$k.']']='变更前:'.element($k,$data_db['content']);
											$data_db['content'][$k] =$v ;
									}
								}
							}
						}
					}
					else
					{

						$data_db['content'] = $this->get(element($this->pk_id,$data_get));
						
						$this->m_table_op->load('sys_contact');
						$data_db['content_c'] =  $this->m_table_op->get(element('offa_c_id',$data_db['content']));
						
						$data_db['content']= array_merge($data_db['content_c'],$data_db['content']);

						if( empty($data_db['content'][$this->pk_id]) )
						{
							$msg= '信息系统申请【'.element($this->pk_id,$data_get).'】不存在！';

							if($flag_more)
							{
								$rtn['result'] = FALSE;
								$rtn['msg_err'] = $msg;

								if( $flag_more )
									return $rtn;
							}

							redirect('base/main/show_err/msg/'.fun_urlencode($msg));
						}
						
						$data_db['wl_list']=$this->m_work_list->get_wl_to_do(element($this->pk_id,$data_get),$this->model_name);
						if( $data_db['content']['offa_c_apply'])
						$data_db['content']['offa_c_apply_s'] = $this->m_base->get_c_show_by_cid($data_db['content']['offa_c_apply']);

						if( $data_db['content']['offa_c_id'])
						$data_db['content']['offa_c_id_s'] = $this->m_base->get_c_show_by_cid($data_db['content']['offa_c_id']);
						
						//获取信息系统
						$arr_search=array();
						$arr_search['field']='offai.*,group_concat( l.link_id ) offi_person_start';
						$arr_search['from']="oa_offa_item offai
											 LEFT JOIN sys_link l ON
											 ( l.op_id = offai.offai_offi_id
											   AND l.op_field='offi_id' AND l.op_table = 'oa_office'
											   AND content='offi_person_start')";
						$arr_search['where']=' AND offa_id = ? ';
						$arr_search['value'][]=element('offa_id',$data_get);
						$arr_search['where'].='GROUP BY offai_id';
						$arr_search['sort']="instr('".implode(',', $GLOBALS['m_oa_office']['text']['d_sort'])."',offai_offi_id)";
						$arr_search['order']='desc';

						$rs=$this->m_db->query($arr_search);
						$data_db['content']['office'] = array();

						if(count($rs['content'])>0)
						{
							foreach ($rs['content'] as $v) {
								
								$v['offai_offi_id_s'] = $this->m_base->get_field_where('oa_office','offi_name'," AND offi_id = '{$v['offai_offi_id']}'");
								
								if($v['offai_person_start'])
								$v['offai_person_start_s'] = $this->m_base->get_c_show_by_cid($v['offai_person_start']);
								
								if($v['offai_person_end'])
								$v['offai_person_end_s'] = $this->m_base->get_c_show_by_cid($v['offai_person_end']);
								
								$v['c_org'] = $data_db['content']['c_org'];
								
								switch ($v['offai_offi_id'])
								{
									//LDAP账户
									case '26B028F103FD5AE7C1018A214D79E9EC':
										$v['c_login_id'] = $data_db['content']['c_login_id'];
										$v['a_id'] = $data_db['content']['a_id'];
									break;
									//短号
									case 'E733D2DF8A3A4D08E10F0604DD1689B0':
										$v['c_tel_code'] = $data_db['content']['c_tel_code'];
									break;
									//网络证书
									case '17384E798664501D49970BFF1959A175':
										$v['c_pwd_web'] = $data_db['content']['c_pwd_web'];
									break;
									//手机上网ID
									case 'FA31B79FEA42C7A246E7A78F5FCEE504':
										$v['c_login_id_m'] = $data_db['content']['c_login_id_m'];
									break;
									//工资邮箱
									case '53AB852B7054D11DBC846C5A6DBCE359':
										$v['c_email_gz'] = $data_db['content']['c_email_gz'];
									break;
									//邮箱
									case 'BC952B1E100717A078BDD79B45CC0736':
										$v['c_email_sys'] = $data_db['content']['c_email_sys'];
									break;
								}
								
								$data_db['content']['office'][]=$v;
							}
						}
						
						$data_db['content']['office']=json_encode($data_db['content']['office']);
						
						if( ! empty($data_db['content']['c_org']) )
						$data_db['content']['c_org_s']=$this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id = '{$data_db['content']['c_org']}'");
						
						if( ! empty($data_db['content']['c_hr_org']) )
						$data_db['content']['c_hr_org_s']=$this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id = '{$data_db['content']['c_hr_org']}'");
						
						if( ! empty($data_db['content']['c_job']) )
						$data_db['content']['c_job_s']=$this->m_base->get_field_where('hr_job','job_name'," AND job_id = '{$data_db['content']['c_job']}'");
						
						if( ! empty($data_db['content']['c_ou_2']) )
						$data_db['content']['c_ou_2_s']=$this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id = '{$data_db['content']['c_ou_2']}'");
						
						if( ! empty($data_db['content']['c_ou_3']) )
						$data_db['content']['c_ou_3_s']=$this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id = '{$data_db['content']['c_ou_3']}'");
						
						if( ! empty($data_db['content']['c_ou_4']) )
						$data_db['content']['c_ou_4_s']=$this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id = '{$data_db['content']['c_ou_4']}'");
						
					}
				} catch (Exception $e) {
				}
				break;
		}

		/************工单信息*****************/
		
		//工单控件展示标记
		$data_out['flag_wl'] = FALSE;
		$data_out['pp_id']=$this->model_name;
		$data_out['arr_wl_i_to_do'] = array();
		
		$data_out['ppo_btn_next']='通过';
		$data_out['ppo_btn_pnext']='退回';
		
		switch (element('ppo', $data_db['content'])) {
			case OA_OFFA_PPO_START:
				$data_out['ppo_btn_next']='提交';
				break;
			case OA_OFFA_PPO_END:
				$data_out['ppo_btn_next']='开通';
				break;
		}
				
		if( $data_get['act'] == STAT_ACT_EDIT 
		 && element('ppo', $data_db['content']) != OA_OFFA_PPO_END )
		{
			$data_out['flag_wl'] = TRUE;
		}
		
		$data_out=$this->m_work_list->get_wl_info($data_out,$data_db);
		
		/************权限验证*****************/
		//@todo 权限验证
		$acl_list= $this->m_proc_office->get_acl();
		
		if( ! empty (element('acl_wl_yj', $data_out)) ) 
		$acl_list= $acl_list | $data_out['acl_wl_yj'];
		
		$this->check_acl($data_db,$acl_list);

		/************显示配置*****************/
		//@todo 显示配置
		$title_field='-'.element('offa_c_id_s',$data_db['content']);

		switch ($data_get['act']) {
			case STAT_ACT_CREATE:
				$data_out['title']='创建'.$this->title;

				$data_out['op_disable'][]='btn_del';
				$data_out['op_disable'][]='btn_log';
				
				$data_out['op_disable'][]='btn_next';
				$data_out['op_disable'][]='btn_pnext';
				
				$data_out['op_disable'][]='btn_wl';
				$data_out['op_disable'][]='btn_im';
				
				$data_out['op_disable'][]='title_c_info';
				
				//创建默认值
				$data_db['content']['offa_c_apply']=$this->sess->userdata('c_id');
				$data_db['content']['offa_c_apply_s']=$this->sess->userdata('c_name').'['.$this->sess->userdata('a_login_id').']';
				$data_db['content']['offa_c_id']=$this->sess->userdata('c_id');
				$data_db['content']['offa_c_id_s']=$this->sess->userdata('c_name').'['.$this->sess->userdata('a_login_id').']';
				$data_db['content']['c_org'] = $this->sess->userdata('c_org');
				
				$data_db['content']['ppo'] = OA_OFFA_PPO_START;
				
				//个性化配置
				$data_out['url_conf']=str_replace('/', '-', $this->url_conf);

				//创建个性化配置
				$path_conf_person=PATH_PERSON_CONF.'/create/'.$data_out['url_conf'].'/'.$this->sess->userdata('a_login_id');

				$conf_person=array();
				if(file_exists($path_conf_person))
				{
					$conf_person=json_decode(file_get_contents($path_conf_person),TRUE);
					$data_conf_person=json_decode(fun_urldecode(element('data', $conf_person)),TRUE);

					if(count($data_conf_person)>0)
					{
						foreach ($data_conf_person as $k=>$v) {
							$arr_f=split_table_field($k);
							$data_db[$arr_f['table']][$arr_f['field']]=$v;
						}
					}
				}

				//GET参数赋值
				if(count($data_out['field_edit'])>0)
				{
					foreach ($data_out['field_edit'] as $v) {
						$arr_tmp=split_table_field($v);
						if(element($arr_tmp['field'] ,$data_get))
							$data_db['content'][$arr_tmp['field']]=element($arr_tmp['field'] ,$data_get);
					}
				}

				break;
			case STAT_ACT_EDIT:
				$data_out['title']='编辑'.$this->title.$title_field;

				$data_out['op_disable'][]='btn_person';
				$data_out['op_disable'][]='btn_import';


				break;
			case STAT_ACT_VIEW:
				$data_out['title']='查看'.$this->title.$title_field;

				$data_out['op_disable'][]='btn_save';
				$data_out['op_disable'][]='btn_del';
				
				$data_out['op_disable'][]='btn_next';
				$data_out['op_disable'][]='btn_pnext';
				
				$data_out['op_disable'][]='btn_person';
				$data_out['op_disable'][]='btn_import';

				$data_out['field_view']=array_unique(array_merge($data_out['field_view'],$data_out['field_edit']));

				break;
		}
		
		if( element( 'ppo',$data_db['content']) == OA_OFFA_PPO_START )
		{
			$data_out['op_disable'][]='btn_pnext';
		}
		
		if( element( 'ppo',$data_db['content']) != OA_OFFA_PPO_START )
		{
			$data_out['op_disable'][]='btn_del';
		}
		
		if( element( 'offa_offer_id',$data_db['content']) )
		{
			$data_out['op_disable'][]='btn_del';
			$data_out['op_disable'][]='btn_pnext';
			
			$data_out['field_view'][]='content[offa_c_apply]';
			$data_out['field_view'][]='content[offa_c_id]';
			$data_out['field_view'][]='content[offa_c_apply_s]';
			$data_out['field_view'][]='content[offa_c_id_s]';
		}

		if( $data_get['act'] == STAT_ACT_EDIT
		&& element( 'ppo',$data_db['content']) == OA_OFFA_PPO_END 
		&& ($acl_list & pow(2,ACL_PROC_OFFICE_SUPER) ) == 0 )
		{
			$data_out['op_disable'][]='btn_save';
			$data_out['op_disable'][]='btn_del';

			$data_out['op_disable'][]='btn_next';
			$data_out['op_disable'][]='btn_pnext';
			
			$data_out['field_view']=array_unique(array_merge($data_out['field_view'],$data_out['field_edit']));
		}

        if( $data_get['act'] == STAT_ACT_EDIT
            && element( 'ppo',$data_db['content']) == OA_OFFA_PPO_END
            && ($acl_list & pow(2,ACL_PROC_OFFICE_SUPER) ) != 0 )
        {
//            $data_out['op_disable'][]='btn_save';
            $data_out['op_disable'][]='btn_del';

            $data_out['op_disable'][]='btn_next';
            $data_out['op_disable'][]='btn_pnext';

            $data_out['field_view']=array_unique(array_merge($data_out['field_view'],$data_out['field_edit']));
        }
		
		//开通账户，开通系统节点，编辑时
		if( $data_get['act'] == STAT_ACT_EDIT
		&& ( element( 'ppo',$data_db['content']) == OA_OFFA_PPO_ACCOUNT 
		  || element( 'ppo',$data_db['content']) == OA_OFFA_PPO_OFFICE 
		   )
		)
		{
			//存在要做的事，即存在当前登陆人的工单，筛选信息系统
			if(element('wl_list_to_do', $data_out))
			{
				$data_db['content']['office'] = json_decode($data_db['content']['office'],TRUE);
				
				if(count($data_db['content']['office'])>0)
				{
					foreach ($data_db['content']['office'] as $k=>$v) {
						//系统开通人中，不存在当前登陆人
						if( ! strstr($v['offi_person_start'], $this->sess->userdata('c_id')))
						{
							$data_db['content']['office'][$k]['hide'] = 1;
						}
					}
				}
				
				$data_db['content']['office'] = json_encode($data_db['content']['office']);
			}
		}
		
		/************事件处理*****************/

		if(in_array('btn_'.$btn,$data_out['op_disable']))
		{
			$rtn['result'] = FALSE;

			if($btn == 'del')
				$rtn['msg_err'] = '禁止删除！';

			$rtn['err'] = array();

			if( $flag_more )
				return $rtn;

			exit;
		}

		switch ($btn)
		{
			case 'save':
			case 'next':
			case 'pnext':
			case 'yj':

				$rtn=array();//结果
				$check_data=TRUE;

				/************数据验证*****************/
				//@todo 数据验证
				if( $btn == 'yj' 
				 && empty(element('person_yj' ,$data_post['content'])))
				{
					$rtn['err']['msg']='请选择移交人！';
					$check_data=FALSE;
				}
				
				if($btn == 'save' || $btn == 'next')
				{
					//必填验证
					if(count($data_out['field_required'])>0)
					{
						foreach ($data_out['field_required'] as $v) {

							$arr_tmp=split_table_field($v);

							if( empty(element($arr_tmp['field'],$data_post['content']))
								&& element($arr_tmp['field'],$data_post['content']) !== '0'
							)
							{
								$field_s='';
								if(isset($this->table_form['fields'][$arr_tmp['field']]))
									$field_s = $this->table_form['fields'][$arr_tmp['field']]['comment'];

								$rtn['err']['content['.$arr_tmp['field'].']']='请输入'.$field_s.'！';
								$check_data=FALSE;
							}
						}
					}

				}
				
				if( ! empty(element('office', $data_post['content'])) )
				{
					$list_office_post = json_decode($data_post['content']['office'],TRUE);
					
					if( count($list_office_post) > 0 )
					{
						foreach ($list_office_post as $k=>$v) {
							
							switch ($v['offai_offi_id'])
							{
								//LDAP账户
								case '26B028F103FD5AE7C1018A214D79E9EC':
									
									if( element('ppo', $data_db['content']) == OA_OFFA_PPO_ACCOUNT
									 && $btn == 'next' 
									)
									{
										if( empty(element('a_id', $v)) || empty(element('offai_model', $v)) )
										{
											$rtn['err']['msg']='账户未开通！';
											$check_data=FALSE;
										}
									}
									
									if( element('a_id', $v))
									{
										//验证唯一
										$where_check=' AND c_id != \''.element('offa_c_id',$data_post['content']).'\'';
												
										$check=$this->m_check->unique('sys_contact','a_id',element('a_id',$v),$where_check);
										if( ! $check )
										{
											$rtn['err']['content[office]'][]=array(
											'id' => $v['offai_id'],
											'field' => 'offai_model',
											'err_msg'=>'账号【'.element('c_login_id',$v).'】已存在，不可重复创建！'
											);
											$check_data=FALSE;
										}
									}
									
								break;
	
								//短号
								case 'E733D2DF8A3A4D08E10F0604DD1689B0':
	
									if( element('c_tel_code', $v))
									{
										//验证唯一
										$where_check=' AND c_id != \''.element('offa_c_id',$data_post['content']).'\'';
												
										$check=$this->m_check->unique('sys_contact','c_tel_code',element('c_tel_code',$v),$where_check);
										if( ! $check )
										{
											$rtn['err']['content[office]'][]=array(
											'id' => $v['offai_id'],
											'field' => 'offai_model',
											'err_msg'=>'短号【'.element('c_tel_code',$v).'】已存在，不可重复创建！'
											);
											$check_data=FALSE;
										}
									}
									
								break;
	
								//网络证书
								case '17384E798664501D49970BFF1959A175':
									
								break;
							}
						}
					}
				}

				if( ! $check_data)
				{
					$rtn['result']=FALSE;

					if( $flag_more )
					{
						$rtn['msg_err']='';
						foreach($rtn['err'] as $v )
						{
							$rtn['msg_err'].=$v.'<br/>';
						}

						return $rtn;
					}

					echo json_encode($rtn);
					exit;
				}

				/************数据处理*****************/
				
				$data_save['content']=$data_db['content'];

				if(count(element('content',$data_post))>0)
				{
					foreach ($data_post['content'] as $k=>$v) {
						if( ! in_array('content['.$k.']',$data_out['field_view'])
							&& ! in_array('content['.$k.']',$data_out['op_disable'])
							&& in_array('content['.$k.']',$data_out['field_edit']) )
							$data_save['content'][$k]=$v;
					}
				}

				/************事件处理*****************/
				switch ($data_get['act']) {
					case STAT_ACT_CREATE:
						
						$data_save['content']['offa_code']=$this->get_code($data_save['content']);
						$data_save['content']['ppo']=OA_OFFA_PPO_START;
						
						$rtn=$this->add($data_save['content']);
						
						//信息系统
						if( ! empty(element('office',$data_save['content']) ) )
						{
							$list_office_save = json_decode($data_save['content']['office'],TRUE);
	
							if(count( $list_office_save ) > 0 )
							{
								$this->m_table_op->load('oa_offa_item');
								foreach ($list_office_save as $v) {
	
									$data_save['office']=$v;
									$data_save['office']['offai_c_id'] = $data_save['content']['offa_c_id'];
									$data_save['office']['offa_id'] = $rtn['id'];
									$this->m_table_op->add($data_save['office']);
								}
							}
						}

						//创建我的工单
	    				$data_save['wl']['wl_id'] = $rtn['id'];
	    				$data_save['wl']['wl_type'] = WL_TYPE_I;//工单类型  我发起的工单
	    				$data_save['wl']['wl_code']=$data_save['content']['offa_code'];//将申请的编号赋值给工单code
		    			$data_save['wl']['wl_op_table']='oa_office_apply';//对象表格
		    			$data_save['wl']['wl_op_field']='offa_id';//对象id
		    			$data_save['wl']['op_id']=$rtn['id'];//对象
	    				$data_save['wl']['p_id']=$this->proc_id;
	    				$data_save['wl']['pp_id']=$this->model_name;//模型名赋值给单据
	    				$data_save['wl']['wl_proc']=$data_save['content']['ppo'];//工单节点
		    			$data_save['wl']['wl_url']=$this->url_conf.'/act/2';//工单的连接
		    			$data_save['wl']['wl_note']='【'.$this->title.'】'
		    				.',申请人:'.$data_save['content']['offa_c_apply_s']
		    				.',系统所有人:'.$data_save['content']['offa_c_id_s']
		    				;//工单备注
	    				$data_save['wl']['c_accept'][] = $this->sess->userdata('c_id');//当期登陆人赋值给工单接受人
	    				
	    				$this->m_work_list->add($data_save['wl']);//创建工单
	    				
	    				$data_save['wl']['wl_id']=get_guid();//获取内部id
	    				$data_save['wl']['wl_type'] = 0 ;
	    				$data_save['wl']['wl_event']='补全、提交单据';
	    				$data_save['wl']['wl_proc'] = 1;//工单节点为起始
	    				$this->m_work_list->add($data_save['wl']);
	    				
	    				$rtn['wl_i'][] = $this->sess->userdata('c_id');
	    				$rtn['wl_accept'][] = $this->sess->userdata('c_id');//当前登陆人为工单接受人
	    				$rtn['wl_care']=array();
	    				$rtn['wl_end'] = array();
	    				
						$arr_log_content=array();
						$arr_log_content['new']['content']=$data_save['content'];//将保存的内容存为新日志
						$arr_log_content['old']['content'][$this->pk_id] = $rtn['id'];

						//操作日志
						$data_save['content_log']['op_id']=$rtn['id'];
						$data_save['content_log']['log_act']=$data_get['act'];
						$data_save['content_log']['log_url']=$this->url_conf.'/'.$this->pk_id.'/'.$rtn['id'];
						$data_save['content_log']['log_content']=json_encode($arr_log_content);
						$data_save['content_log']['log_module']=$this->title;
						$data_save['content_log']['log_p_id']=$this->proc_id;
						
						$this->m_log_operate->add($data_save['content_log']);

						break;
					case STAT_ACT_EDIT:
						
						//验证数据更新时间
						if($data_save['content']['db_time_update'] != $data_db['content']['db_time_update'])
						{
							$rtn['result']=FALSE;
							$rtn['err']['db_time_update']='后台数据刷新中，请重新操作！';
							echo json_encode($rtn);
							exit;
						}

						$data_save['content'][$this->pk_id]=element($this->pk_id,$data_get);

						//流程工单
						$ppo_btn_text = $data_out['ppo_btn_next'];//通过按钮
						if($btn == 'pnext')
						$ppo_btn_text = $data_out['ppo_btn_pnext'];//退回按钮
						
						//工单基本信息
						$data_save['wl']['wl_code']=$data_db['content']['offa_code'];//申请code赋值给工单code
		    			$data_save['wl']['wl_op_table']='oa_office_apply';//对象表
		    			$data_save['wl']['wl_op_field']='offa_id';//对象字段
		    			$data_save['wl']['op_id']=$data_save['content'][$this->pk_id];//对象id为申请id
	    				$data_save['wl']['p_id']=$this->proc_id;//系统
	    				$data_save['wl']['pp_id']=$this->model_name;//模型名赋值给单据
		    			$data_save['wl']['wl_url']=$this->url_conf.'/act/2';//单据路径
		    			$data_save['wl']['wl_proc']=$data_save['content']['ppo'];//工单节点为当前保存的节点
		    			$data_save['wl']['wl_time_end']=date('Y-m-d H:i:s',strtotime('+30 day'));//将当前日期增加30天后赋值给工单截止时间
		    			$data_save['wl']['c_accept'] = array();//工单接受人为空数组
		    			$data_save['wl']['wl_note']='【'.$this->title.'】'
		    				.',申请人:'.$data_save['content']['offa_c_apply_s']
		    				.',系统所有人:'.$data_save['content']['offa_c_id_s']
		    				;//工单备注
						
						//工单流转
						$flag_wl_combine_finish=TRUE;//联合工单通过标记
						
						switch (element('ppo',$data_db['content']))
						{
							case OA_OFFA_PPO_START://节点为起始
								
								if($btn == 'next')//按钮为通过
								{
									$data_save['content']['ppo'] = OA_OFFA_PPO_OFFICE;//保存节点为开通系统
									
									$data_save['wl']['wl_event']='信息系统开通';//工单事件
									
									//添加流程接收人
	    							$data_save['wl']['c_accept']=array();//工单接受人
								}
								
								break;
							case OA_OFFA_PPO_ACCOUNT://节点为开通账户
								
								if($btn == 'next')//按钮为通过
								{
									$data_save['content']['ppo'] = OA_OFFA_PPO_OFFICE;//保存节点为开通系统
									
									$data_save['wl']['wl_event']='信息系统开通';//保存工单事件
									
									//流程接收人为空
	    							$data_save['wl']['c_accept']=array();
								}
								
								break;
							case OA_OFFA_PPO_OFFICE://节点为开通系统
								
								if($btn == 'next')
								{
									//存在当前登录人的工单
									if( count(element('arr_wl_i_to_do', $data_out)) > 0 )//
									{
										//验证联合工单是否全部完成
										$flag_wl_combine_finish=$this->m_work_list->check_wl_combine_finish(
										$data_save['content']['offa_id'],$this->model_name,element('arr_wl_i_to_do', $data_out));//通过对象id，单据编号和工单数组进行查询

										if($flag_wl_combine_finish)
										$data_save['content']['ppo'] = OA_OFFA_PPO_END;
									}
									else 
									{
										$data_save['content']['ppo'] = OA_OFFA_PPO_END;
									}
					    			
								}
								elseif($btn == 'pnext')
								{
									$data_save['content']['ppo'] = OA_OFFA_PPO_START;
									
									$data_save['wl']['wl_event']='修改单据';
									$data_save['wl']['c_accept'][] = $data_db['content']['db_person_create'];
								}
								
								break;
						}
						
						$rtn=$this->update($data_save['content']);
						
						//信息系统
						$arr_wl_combine = array();
						
						if( ! empty(element('office',$data_save['content']) ) )
						{
							$list_office_save = json_decode($data_save['content']['office'],TRUE);
							$list_office_db = json_decode($data_db['content']['office'],TRUE);

							if(count( $list_office_db ) > 0 )
							{
								foreach ($list_office_db as $k=>$v) {
									unset($list_office_db[$k]);
									$list_office_db[$v['offai_id']]=$v;
								}
							}

							if(count( $list_office_save ) > 0 )
							{
								$v = array();
								$this->m_table_op->load('oa_offa_item');
								$data_save['content_c']=array();
								
								foreach ($list_office_save as $k=>$v) {

									$v['offa_id']=$data_save['content'][$this->pk_id];
									$data_save['office']=$v;
									
									switch ( $v['offai_offi_id'] )
									{
										//LDAP账户
										case '26B028F103FD5AE7C1018A214D79E9EC':
											
											if( ! element('c_login_id', $data_db['content']) 
											 && element('c_login_id', $v) )
											{
												$data_save['content_c']['c_login_id'] = $v['c_login_id'];
												$data_save['content_c']['a_id'] = $v['a_id'];
												
												$data_save['office']['offai_model']='已开通,账户:'.$data_save['content_c']['c_login_id'];
											}
											
										break;
			
										//短号
										case 'E733D2DF8A3A4D08E10F0604DD1689B0':
			
											if( ! element('c_tel_code', $data_db['content']) 
											 && element('c_tel_code', $v) )
											{
												$data_save['content_c']['c_tel_code'] = $v['c_tel_code'];
												
												$data_save['office']['offai_model']='已开通,短号:'.$data_save['content_c']['c_tel_code'];
											}
											
										break;
			
										//网络证书
										case '17384E798664501D49970BFF1959A175':
											
											if( ! element('c_pwd_web', $data_db['content']) 
											 && element('c_pwd_web', $v) )
											{
												$data_save['content_c']['c_pwd_web'] = $v['c_pwd_web'];
												
												$data_save['office']['offai_model']='已开通';
											}
											
										break;
										
										//邮箱
										case 'BC952B1E100717A078BDD79B45CC0736':
											
											if( ! element('c_email_sys', $data_db['content']) 
											 && element('c_email_sys', $v) )
											{
												$data_save['content_c']['c_email_sys'] = $v['c_email_sys'];
												
												$data_save['office']['offai_model']='已开通,邮箱:'.$data_save['content_c']['c_email_sys'];
											}
											
										break;
										
										//工资邮箱
										case '53AB852B7054D11DBC846C5A6DBCE359':
											
											if( ! element('c_email_gz', $data_db['content']) 
											 && element('c_email_gz', $v) )
											{
												$data_save['content_c']['c_email_gz'] = $v['c_email_gz'];
												
												$data_save['office']['offai_model']='已开通,工资邮箱:'.$data_save['content_c']['c_email_gz'];
											}
											
										break;
										
										//手机上网id
										case 'FA31B79FEA42C7A246E7A78F5FCEE504':
											
											if( ! element('c_login_id_m', $data_db['content']) 
											 && element('c_login_id_m', $v) )
											{
												$data_save['content_c']['c_login_id_m'] = $v['c_login_id_m'];
												
												$data_save['office']['offai_model']='已开通,手机上网ID:'.$data_save['content_c']['c_login_id_m'];
											}
											
										break;
									}

									if( empty( element('offai_person_start', $v))
									 && element('offai_model', $data_save['office']) )
									{
										$data_save['office']['offai_person_start'] = $this->sess->userdata('c_id');
										$data_save['office']['offai_time_start'] = date("Y-m-d");
									}
									
									if(isset($v['offai_id']) && isset($list_office_db[$v['offai_id']]))
									{
										if( $btn == 'next' && ! $data_save['office']['offai_person_start'] )
										{
											$offi_person_start=explode(',', $list_office_db[$v['offai_id']]['offi_person_start']);
											
											if(count($offi_person_start) > 1)
											{
												$arr_tmp=array();
												$arr_tmp[] = $offi_person_start;
												$arr_tmp[] = $data_db['content']['c_org'];
												
												$offi_person_start = $this->m_base->get_field_where('sys_contact','c_id',
												" AND c_id IN ? AND c_org = ? " , $arr_tmp,TRUE);
												
												if( count($offi_person_start) == 0 )
												$offi_person_start=explode(',', $list_office_db[$v['offai_id']]['offi_person_start']);
												
											}
											
											$arr_wl_combine[] = $offi_person_start;
										}
										
										$this->m_table_op->update($data_save['office']);

										unset($list_office_db[$v['offai_id']]);
									}
									else
									{
										$this->m_table_op->add($data_save['office']);
									}
								}
								
								$this->m_table_op->load('sys_contact');
								$data_save['content_c']['c_id'] = $data_db['content']['offa_c_id'];
								$this->m_table_op->update($data_save['content_c']);
							}
							
							//起始节点可以删除信息系统明细
							if( $data_db['content']['ppo'] == 1 
							 && count( $list_office_db ) > 0 )
							{
								$this->m_table_op->load('oa_offa_item');
								foreach ($list_office_db as $k=>$v) {
									$this->m_table_op->del($k);
								}
							}
						}
						
						//工单日志
						if( $btn == 'yj' )
						{
							$data_save['content_log']['log_note']=
						'【'.$this->sess->userdata('c_name').'['.$this->sess->userdata('a_login_id').']】'
						.'于节点【'.$GLOBALS['m_office_apply']['text']['ppo'][$data_db['content']['ppo']].'】'
						.',将【'.$this->title.'】移交于【'.$data_post['content']['person_yj_s'].'】';
						
							$data_save['wl']['wl_type']=WL_TYPE_YJ;
							$data_save['wl']['wl_event']=element('wl_list_to_do', $data_out);
							$data_save['wl']['c_accept'][]=$data_post['content']['person_yj'];
							
						}
						elseif( $btn == 'next' || $btn == 'pnext' )
						{
							
							$data_save['content_log']['log_note']=
						'于节点【'.$GLOBALS['m_office_apply']['text']['ppo'][$data_db['content']['ppo']].'】'.$ppo_btn_text
						.',流转至节点【'.$GLOBALS['m_office_apply']['text']['ppo'][$data_save['content']['ppo']].'】';
						
						}	
						
						//工单更新
						switch ($btn)
						{
							case 'yj':
								$data_save['wl_have_do']['wl_result']=WL_RESULT_YJ;
							case 'next':
								$data_save['wl_have_do']['wl_result']=WL_RESULT_SUCCESS;
							case 'pnext':

								$wl_comment='';
								if( is_array(element('wl', $data_post) ) 
								 && ! empty(element('wl_comment', $data_post['wl'])) )
								$wl_comment = element('wl_comment', $data_post['wl']);

								//更新工单已完成
								$data_save['wl_have_do']=array();
								$data_save['wl_have_do']['wl_comment']=$wl_comment;
								$data_save['wl_have_do']['wl_log_note']=$data_save['content_log']['log_note'];
								
								if( count(element('arr_wl_i_to_do', $data_out)) > 0 )
								$data_save['wl_have_do']['wl_id_i_do'] = $data_out['arr_wl_i_to_do'];
								
								$this->m_work_list->update_wl_have_do(element($this->pk_id,$data_get),$this->model_name,$data_save['wl_have_do']);
								
								//更新我的工单
								$data_save['wl_i'] = array();
								$data_save['wl_i']['wl_log_note']=$data_save['content_log']['log_note'];
								
								if($data_save['content']['ppo'] == 0)
								{
									$data_save['wl_i']['wl_status']=WL_STATUS_FINISH;
									$data_save['wl_i']['wl_result']=WL_RESULT_SUCCESS;
									$data_save['wl_i']['wl_person_do'] = $this->sess->userdata('c_id');
    								$data_save['wl_i']['wl_time_do'] = date('Y-m-d H:i:s');
								}
								
								$this->m_work_list->update_wl_i(element($this->pk_id,$data_get),$this->model_name,$data_save['wl_i']);
								
								$data_save['wl']['wl_comment_new'] = 
								'<p>'.date("Y-m-d H:i:s").' '.$this->sess->userdata('c_name').'['.$this->sess->userdata('a_login_id').']</p>'
								.'<p>'.$data_save['content_log']['log_note'].'</p>';
								
								if( ! empty($wl_comment) )
								$data_save['wl']['wl_comment_new'] = '<p>'.$wl_comment.'</p>';
									
								if( $data_save['content']['ppo'] != 0 
								 && $data_db['content']['ppo'] != OA_OFFA_PPO_OFFICE ) 
								{
									if($btn == 'next' && count($arr_wl_combine) > 0 )
									{
										//联合工单
										$data_save['wl']['wl_combine']=1;
										
										if( $flag_wl_combine_finish )
										{
											$arr_wl_accept=array();

											foreach ($arr_wl_combine as $v) {
												$data_save['wl']['c_accept'] =$v;//array_diff($v,$arr_wl_accept) ;

												if(count($data_save['wl']['c_accept']) > 0 )
												{
													$this->m_work_list->add($data_save['wl']);
													
													$arr_wl_accept=array_values(array_merge($arr_wl_accept,$v));
												}
											}
											
											$data_save['wl']['c_accept']=array_unique($arr_wl_accept);
										}
									}
									else 
									$this->m_work_list->add($data_save['wl']);
								}
								
								//获取工单关注人与所有人
								$arr_wl_person = $this->m_work_list->get_wl_care_accept(element($this->pk_id,$data_get),$this->model_name);
								
								$rtn['wl_end'] = array();
								$rtn['wl_accept'] = $data_save['wl']['c_accept'];
								$rtn['wl_accept'][] = $this->sess->userdata('c_id');
								
								if( count( element('arr_wl_accept', $data_out)) > 0 )
								$rtn['wl_accept'] =array_values(array_merge($rtn['wl_accept'],$data_out['arr_wl_accept']));
								
								$rtn['wl_care'] = $arr_wl_person['care'];
								$rtn['wl_i'] = $arr_wl_person['accept'];
								$rtn['wl_op_id'] = element($this->pk_id,$data_get);
								$rtn['wl_pp_id'] = $this->model_name;
								$rtn['wl_accept'] =array_unique($rtn['wl_accept']);
								
								if($data_save['content']['ppo'] == 0)
								$rtn['wl_end'] = $arr_wl_person['accept'];
								
								break;
						}
						

						$arr_log_content=array();
						$arr_log_content['new']['content']=$data_save['content'];
						$arr_log_content['old']['content']=$data_db['content'];

						//操作日志
						$data_save['content_log']['op_id']=element($this->pk_id, $data_get);
						$data_save['content_log']['log_act']=$data_get['act'];
						$data_save['content_log']['log_url']=$this->url_conf.'/'.$this->pk_id.'/'.element($this->pk_id, $data_get);
						$data_save['content_log']['log_content']=json_encode($arr_log_content);
						$data_save['content_log']['log_module']=$this->title;
						$data_save['content_log']['log_p_id']=$this->proc_id;
						$this->m_log_operate->add($data_save['content_log']);

						$rtn['db_time_update'] = date("Y-m-d H:i:s");

						break;
				}

				if( $flag_more )
					return $rtn;

				echo json_encode($rtn);
				exit;
				break;
			case 'del':

				$rtn=$this->del(element('offa_id',$data_get));

				$arr_wl_person = $this->m_work_list->get_wl_care_accept(element($this->pk_id,$data_get),$this->model_name);
								
				$rtn['wl_end'] = array();
				
				if( count( element('arr_wl_accept', $data_out)) > 0 )
				$rtn['wl_accept'] =$data_out['arr_wl_accept'];
								
				$rtn['wl_accept'][] = $this->sess->userdata('c_id');
				
				$rtn['wl_care'] = $arr_wl_person['care'];
				$rtn['wl_i'] = $arr_wl_person['accept'];
				$rtn['wl_op_id'] = element($this->pk_id,$data_get);
				$rtn['wl_pp_id'] = $this->model_name;
				
				if( element('rtn',$rtn) )
				{
					//操作日志
					$data_save['content_log']['op_id']=element($this->pk_id, $data_get);
					$arr_log_content=array();
					$arr_log_content['old']['content']=$data_db['content'];
					$data_save['content_log']['log_url']=$this->url_conf.'/'.$this->pk_id.'/'.element($this->pk_id, $data_get);
					$data_save['content_log']['log_act']=STAT_ACT_REMOVE;
					$data_save['content_log']['log_module']=$this->title;
					$data_save['content_log']['log_p_id']=$this->proc_id;
					$this->m_log_operate->add($data_save['content_log']);
				}

				if( $flag_more )
					return $rtn;

				echo json_encode($rtn);
				exit;
				break;
		}

		/************只读/必填****************/
		$data_out['field_required']=json_encode($data_out['field_required']);

		$data_out['field_edit']=array_values(array_diff($data_out['field_edit'],$data_out['field_view']));
		$data_out['field_edit']=json_encode($data_out['field_edit']);

		$data_out['field_view']=array_values($data_out['field_view']);
		$data_out['field_view']=json_encode($data_out['field_view']);

		$data_out['op_disable']=json_encode($data_out['op_disable']);

		/************模板赋值*****************/

		$data_out['act']=$data_get['act'];
		$data_out['url']=current_url();
		$data_out['time']=time();
		$data_out['fun_open']=element('fun_open', $data_get);
		$data_out['fun_open_id']=element('fun_open_id', $data_get);
		$data_out['flag_wl_win']=element('flag_wl_win', $data_get);
		
		$data_out['log']=json_encode(element('log', $data_out));

		$data_out['log_time']=$this->input->post('log_time');
		$data_out['log_a_login_id']=$this->input->post('log_a_login_id');
		$data_out['log_c_name']=$this->input->post('log_c_name');
		$data_out['log_act']=$this->input->post('log_act');
		$data_out['log_note']=$this->input->post('log_note');

		$data_out['db_time_create']=element('db_time_create', $data_db['content']);
		$data_out['code']=element('offa_code', $data_db['content']);
		
		$data_out['ppo']=element('ppo', $data_db['content']);
	    $data_out['ppo_name']=$GLOBALS['m_office_apply']['text']['ppo'][element('ppo', $data_db['content'])];

		$data_out[$this->pk_id]=element($this->pk_id,$data_get);
		$data_out['c_login_id']=element('c_login_id', $data_db['content']);
		
		$data_out['data']=array();

		if( count(element('content',$data_db))>0)
		{
			foreach ($data_db['content'] as $k=>$v) {
				if( in_array('content['.$k.']',$data_out['field_out']))
				{
					$data_out['data']['content['.$k.']']=$v;
				}
			}
		}
		$data_out['data']=json_encode($data_out['data']);

		/************载入视图 *****************/
		$arr_view[]=$this->url_conf;
		$arr_view[]=$this->url_conf.'_js';

		$this->m_view->load_view($arr_view,$data_out);
	}
	
	/**
	 * 
	 * 根据录用通知创建信息系统开通申请
	 * @param $arr 包含offer_id,c_id,c_name,c_org,c_tele,c_ou_2,c_ou_3,c_ou_4,c_ou_bud的数组
	 */
	public function create_default_by_hroffer($arr)
	{
		/************模型载入*****************/
		$this->load->model('proc_office/m_proc_office');
		/************变量初始化****************/
		$data_save=array();//
		$rtn=array();//结果
		$rtn['rtn']=TRUE;
		$rtn['c_accept'] = array();
		$where='';
		/************数据处理*****************/
		
		if( ! element('c_id', $arr) ) {
			$rtn['rtn']=FALSE;
			
			return $rtn;
		}
		
		$data_save['content']['offa_c_apply'] = $this->sess->userdata('c_id');
		$data_save['content']['offa_c_apply_s'] = $this->sess->userdata('c_name').'['.$this->sess->userdata('a_login_id').']';
		$data_save['content']['offa_c_id'] = $arr['c_id'];
		$data_save['content']['offa_c_id_s'] = $arr['c_name'];
		$data_save['content']['offa_note'] = element('offa_note', $arr);
		$data_save['content']['offa_offer_id'] = element('offer_id', $arr);
		
		$data_save['content']['offa_code']=$this->get_code($data_save['content']);
		
		$data_save['content']['ppo']=OA_OFFA_PPO_ACCOUNT;

		$rtn=$this->add($data_save['content']);

		//查找默认开通的信息系统
		$arr_search=array();
		$arr_search['field']='offi.offi_id';
		$arr_search['from']="oa_office offi";
		$arr_search['where']=' AND find_in_set(?,offi_org_default)';
		$arr_search['value'][] = $arr['c_org'];
		$arr_search['row']=0;
		$arr_search['sort']='db_time_create';
		$arr_search['order']='asc';
		
		$rs=$this->m_db->query($arr_search);
		
		$data_save['content']['office'] = array();

		if(count($rs['content'])>0)
		{
			$this->m_table_op->load('oa_offa_item');
			foreach ($rs['content'] as $v) {
				
				$data_save['office']=array();
				$data_save['office']['offai_offi_id']=$v['offi_id'];
				$data_save['office']['offai_c_id'] = $data_save['content']['offa_c_id'];
				$data_save['office']['offa_id'] = $rtn['id'];
                $this->m_table_op->add($data_save['office']);
			}

		}


		$data_save['content_log']['log_note']='【'.$data_save['content']['offa_c_apply_s'].'】于【人事管理-录用通知】，创建【信息系统申请】,流转至【开通账户】';

		//创建我的工单
    	$data_save['wl']['wl_id'] = $rtn['id'];
    	$data_save['wl']['wl_type'] = WL_TYPE_I;
    	$data_save['wl']['wl_code']=$data_save['content']['offa_code'];
    	$data_save['wl']['wl_op_table']='oa_office_apply';
    	$data_save['wl']['wl_op_field']='offa_id';
    	$data_save['wl']['op_id']=$rtn['id'];
    	$data_save['wl']['p_id']=$this->proc_id;
    	$data_save['wl']['pp_id']=$this->model_name;
    	$data_save['wl']['wl_proc']=$data_save['content']['ppo'];
    	$data_save['wl']['wl_url']=$this->url_conf.'/act/2';
    	$data_save['wl']['wl_note']='【'.$this->title.'】'
    		.',申请人:'.$data_save['content']['offa_c_apply_s']
    		.',系统所有人:'.$data_save['content']['offa_c_id_s']
    		;
    	//更新我的工单
		$data_save['wl']['wl_log_note']=$data_save['content_log']['log_note'];
    	$data_save['wl']['c_accept'][] = $this->sess->userdata('c_id');

    	$this->m_work_list->add($data_save['wl']);
    	
    	$data_save['wl']['wl_id']=get_guid();
    	$data_save['wl']['wl_type'] = 0 ;
    	$data_save['wl']['wl_event']='信息系统申请';
    	$data_save['wl']['ppo'] = 1;
    	$data_save['wl']['wl_status']=WL_STATUS_FINISH;
		$data_save['wl']['wl_result']=WL_RESULT_SUCCESS;
		$data_save['wl']['wl_person_do'] = $this->sess->userdata('c_id');
    	$data_save['wl']['wl_time_do'] = date('Y-m-d H:i:s');
    	
    	$this->m_work_list->add($data_save['wl']);
    	
    	//工单基本信息
    	$data_save['wl']=array();
		$data_save['wl']['wl_code']=$data_save['content']['offa_code'];
    	$data_save['wl']['wl_op_table']='oa_office_apply';
    	$data_save['wl']['wl_op_field']='offa_id';
    	$data_save['wl']['op_id']=$rtn['id'];
    	$data_save['wl']['p_id']=$this->proc_id;
    	$data_save['wl']['pp_id']=$this->model_name;
    	$data_save['wl']['wl_proc']=$data_save['content']['ppo'];
    	$data_save['wl']['wl_url']=$this->url_conf.'/act/2';
    	$data_save['wl']['wl_proc']=$data_save['content']['ppo'];
    	$data_save['wl']['wl_time_end']=date('Y-m-d H:i:s',strtotime('+30 day'));
    	$data_save['wl']['c_accept'] = $this->m_acl->get_acl_person($this->proc_id,ACL_PROC_OFFICE_ACCOUNT);
    	$data_save['wl']['wl_note']='【'.$this->title.'】'
    		.',申请人:'.$data_save['content']['offa_c_apply_s']
    		.',系统所有人:'.$data_save['content']['offa_c_id_s']
    		;
    		
    	$data_save['wl']['wl_event']='开通账户及相关信息系统';

    	$rtn['c_accept'] = $data_save['wl']['c_accept'];
        $this->m_work_list->add($data_save['wl']);
    	
		$arr_log_content=array();
		$arr_log_content['new']['content']=$data_save['content'];
		$arr_log_content['old']['content'][$this->pk_id] = $rtn['id'];

		//操作日志
		$data_save['content_log']['op_id']=$rtn['id'];
		$data_save['content_log']['log_act']=STAT_ACT_CREATE;
		$data_save['content_log']['log_url']=$this->url_conf.'/'.$this->pk_id.'/'.$rtn['id'];
		$data_save['content_log']['log_content']=json_encode($arr_log_content);
		$data_save['content_log']['log_module']=$this->title;
		$data_save['content_log']['log_p_id']=$this->proc_id;
		
		$this->m_log_operate->add($data_save['content_log']);
		
		return $rtn;
	}
	
	/**
	 * 
	 * 根据注销申请结束信息系统开通申请
	 * @param $arr 包含offa_id的数组
	 */
	public function end_offa_by_offl($arr)
	{
		/************模型载入*****************/
		$this->load->model('proc_office/m_proc_office');
		/************变量初始化****************/
		$data_save=array();//
		$rtn=array();//结果
		$rtn['rtn']=TRUE;
		$where='';
		/************数据处理*****************/
		
		if( ! element('offa_id', $arr) ) {
			$rtn['rtn']=FALSE;
			
			return $rtn['rtn'];
		}
		
		$data_db['content'] = $this->get($arr['offa_id']);
		
		if( $data_db['content']['ppo'] == OA_OFFA_PPO_END)
		return $rtn;
		
		$data_save['content'] = $data_db['content'];
		$data_save['content']['offa_id'] = $arr['offa_id'];
        $data_save['content']['ppo'] = OA_OFFA_PPO_END;
        $this->m_office_apply->update($data_save['content']);
    	
		$arr_log_content=array();
		$arr_log_content['new']['content'] = $data_save['content'];
		$arr_log_content['old']['content'] = $data_db['content'];

		//操作日志
		$data_save['content_log']['log_note'] = '流程因该录用人员回绝而终止';
		$data_save['content_log']['op_id']=$arr['offa_id'];
		$data_save['content_log']['log_act']=STAT_ACT_EDIT;
		$data_save['content_log']['log_url']=$this->url_conf.'/'.$this->pk_id.'/'.$arr['offa_id'];
		$data_save['content_log']['log_content']=json_encode($arr_log_content);
		$data_save['content_log']['log_module']=$this->title;
		$data_save['content_log']['log_p_id']=$this->proc_id;
		
		$this->m_log_operate->add($data_save['content_log']);
		
		//取消工单信息
        $this->m_work_list->cancel_wl($arr['offa_id'],$this->model_name);
	        
		return $rtn;
	}
	
	/**
	 * 
	 * 显信息系统开通变更
	 * @param $arr 
	 */
	public function show_change_office($id,$field,$v)
	{
		$rtn=array();
		$rtn['id'] = $id;
		$rtn['field'] = $field;
		$rtn['act'] = STAT_ACT_EDIT;
		$rtn['err_msg']= $v[$field];
		
		switch ($field)
		{
			case 'offai_offi_id':
				
				$rtn['err_msg'] = $this->m_base->get_field_where('oa_office','offi_name'," AND offi_id = '{$v['offai_offi_id']}'");

				break;
			case 'offai_person_start':
			case 'offai_person_end':

				$rtn['err_msg'] = $this->m_base->get_c_show_by_cid($v[$field]);

				break;

		}
		
		$rtn['err_msg']='变更前:'.$rtn['err_msg'];
		
		return $rtn;
	}
}