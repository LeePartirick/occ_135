<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 *信息系统注销
 */
class M_office_logout extends CI_Model {

	//@todo 主表配置
	private $table_name='oa_office_logout';
	private $pk_id='offl_id';
	private $table_form;
	private $title='信息系统注销';
	private $model_name = 'm_office_logout';
	private $url_conf = 'proc_office/office_logout/edit';
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
		if( defined('LOAD_M_OFFICE_LOGOUT') ) return;
		define('LOAD_M_OFFICE_LOGOUT', 1);

		//define
		
		// 节点
    	define('OA_OFFL_PPO_END', 0); // 流程结束
		define('OA_OFFL_PPO_START', 1); // 起始
		define('OA_OFFL_PPO_CHECK', 2); // 注销系统
    	
    	$GLOBALS['m_office_logout']['text']['ppo']=array(
    		OA_OFFL_PPO_START=>'起始',
    		OA_OFFL_PPO_CHECK=>'注销系统',
    		OA_OFFL_PPO_END=>'流程结束',
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
    	
	    //账户注销节点，没有账户注销权限
    	if( ($acl_list & pow(2,ACL_PROC_OFFICE_CHECK)) == 0 )
    	{
    		if( ! $check_acl 
	    	 && element('ppo',$data_db['content']) == OA_OFFL_PPO_CHECK
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
    	 
    	$pre='ZX'.date("Ym");
    	$where .= " AND offl_code LIKE  '{$pre}%'";
    	
    	$max_code=$this->m_db->get_m_value('oa_office_logout','offl_code',$where);
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
			'oa_office_logout[offl_c_id]',
		);

		$conf['field_required']=array(
			'oa_office_logout[offl_c_id]',
		);

		$conf['field_define']=array(
    	);

		$conf['table_form']=array(
			'oa_office_logout'=>$this->table_form
		);

		$path=str_replace('\\', '/', APPPATH).'models/'.$this->proc_id.'/'.$this->model_name.'.xlsx';

		//$this->m_excel->create_import_file($path,$conf);
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
			'content[offl_c_id_s]',
			'content[offl_c_id]',
		);

		//编辑数组
		$data_out['field_edit']=array(
			'content[offl_c_id_s]',
			'content[offl_c_id]',
			'content[offl_note]',
			'content[office]'
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
						$data_db['content_c'] =  $this->m_table_op->get(element('offl_c_id',$data_db['content']));
						
						$data_db['content']= array_merge($data_db['content_c'],$data_db['content']);

						if( empty($data_db['content'][$this->pk_id]) )
						{
							$msg= '信息系统注销【'.element($this->pk_id,$data_get).'】不存在！';

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


						if( $data_db['content']['offl_c_id'])
						$data_db['content']['offl_c_id_s'] = $this->m_base->get_c_show_by_cid($data_db['content']['offl_c_id']);

						//获取信息系统
                        $arr_search=array();
                        $arr_search['field']='offai.*,group_concat( l.link_id ) offi_person_start';
                        $arr_search['from']="oa_offa_item offai
											 LEFT JOIN sys_link l ON
											 ( l.op_id = offai.offai_offi_id
											   AND l.op_field='offi_id' AND l.op_table = 'oa_office'
											   AND content='offi_person_start')";
                        $arr_search['where'] = '';
                        
                        if($data_db['content']['ppo'] != 0)
                        {
                        	$arr_search['where'].='AND offai_c_id = ?';
                        	$arr_search['value'][]=$data_db['content']['offl_c_id'];
                        	$arr_search['where'].=" AND (offai_person_start IS NOT NULL AND offai_person_start != '') 
                         					   AND (offai_person_end IS NULL OR offai_person_end ='') ";
                        }
                        else
                        {
                        	$arr_search['where'].='AND offl_id = ?';
                        	$arr_search['value'][]=$data_db['content']['offl_id'];
                        }
                        
                        $arr_search['where'].='GROUP BY offai_id';
                        $arr_search['sort']="instr('".implode(',', $GLOBALS['m_oa_office']['text']['d_sort'])."',offai_offi_id)";
                        $arr_search['order']='desc';

						$rs=$this->m_db->query($arr_search);
						$data_db['content']['office'] = array();

						if(count($rs['content'])>0)
						{
							foreach ($rs['content'] as $v) {

								$v['offai_offi_id_s'] = $this->m_base->get_field_where('oa_office','offi_name'," AND offi_id = '{$v['offai_offi_id']}'");

								if($v['offai_person_end'])
								$v['offai_person_end_s'] = $this->m_base->get_c_show_by_cid($v['offai_person_end']);

								$v['c_org'] = $data_db['content']['c_org'];

								if($flag_more){
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
			case OA_OFFL_PPO_START:
				$data_out['ppo_btn_next']='提交';
				break;
			case OA_OFFL_PPO_END:
				$data_out['ppo_btn_next']='注销';
				break;
		}

		if( $data_get['act'] == STAT_ACT_EDIT 
		 && element('ppo', $data_db['content']) != OA_OFFL_PPO_END )
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
		$title_field='-'.element('offl_c_id_s',$data_db['content']);

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
				$data_db['content']['offl_c_id']=$this->sess->userdata('c_id');
				$data_db['content']['offl_c_id_s']=$this->sess->userdata('c_name').'['.$this->sess->userdata('a_login_id').']';
				$data_db['content']['c_org'] = $this->sess->userdata('c_org');
				
				$data_db['content']['ppo'] = OA_OFFL_PPO_START;
				
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
                $data_out['op_disable'][]='btn_pnext';

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
		
		if( element( 'ppo',$data_db['content']) == OA_OFFL_PPO_START )
		{
			$data_out['op_disable'][]='btn_pnext';
		}
		
		if( element( 'ppo',$data_db['content']) != OA_OFFL_PPO_START )
		{
			$data_out['op_disable'][]='btn_del';
		}
		
		if( $data_get['act'] == STAT_ACT_EDIT
		&& element( 'ppo',$data_db['content']) == OA_OFFL_PPO_END
		&& ($acl_list & pow(2,ACL_PROC_OFFICE_SUPER) ) == 0 )
		{
			$data_out['op_disable'][]='btn_save';
			$data_out['op_disable'][]='btn_del';
			
			$data_out['op_disable'][]='btn_next';
			$data_out['op_disable'][]='btn_pnext';
			
			$data_out['field_view']=array_unique(array_merge($data_out['field_view'],$data_out['field_edit']));
		}

		//注销账户，注销系统节点，编辑时
		if( $data_get['act'] == STAT_ACT_EDIT 
		 && ( element( 'ppo',$data_db['content']) == OA_OFFL_PPO_CHECK ) )
		{
			//存在要做的事，即存在当前登陆人的工单，筛选信息系统
			if(element('wl_list_to_do', $data_out))
			{
				$data_db['content']['office'] = json_decode($data_db['content']['office'],TRUE);

				if(count($data_db['content']['office'])>0)
				{

					foreach ($data_db['content']['office'] as $k=>$v) {
						//系统注销人中，不存在当前登陆人
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
				
				if($btn == 'save' || $btn == 'next')//按钮为保存或通过
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
					
					if( ! empty(element('office', $data_post['content'])) )
					{
						$list_office_post = json_decode($data_post['content']['office'],TRUE);
						
						if( count($list_office_post) > 0 )
						{
							foreach ($list_office_post as $k=>$v) {
								
								if( element('hide', $v) ) continue;
								
								if( ! $v['offai_flag_alert'] && ! element('offail',$v) )
								{
									$rtn['err']['content[office]']='存在未处理系统（请勾选注销或者提醒）！';
									$check_data=FALSE;
									
									break;
								}
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
						
						$data_save['content']['offl_code']=$this->get_code($data_save['content']);
						$data_save['content']['ppo']=OA_OFFL_PPO_START;
						
						$rtn=$this->add($data_save['content']);
						
						//信息系统
						if( ! empty(element('office',$data_save['content']) ))
						{
							$list_office_save = json_decode($data_save['content']['office'],TRUE);
	
							if(count( $list_office_save ) > 0 )
							{
								$this->m_table_op->load('oa_offa_item');
								foreach ($list_office_save as $v) {
	
									$data_save['office']=$v;
									$this->m_table_op->update($data_save['office']);
								}
							}
						}

						//创建我的工单
	    				$data_save['wl']['wl_id'] = $rtn['id'];
	    				$data_save['wl']['wl_type'] = WL_TYPE_I;
	    				$data_save['wl']['wl_code']=$data_save['content']['offl_code'];
		    			$data_save['wl']['wl_op_table']='oa_office_logout';
		    			$data_save['wl']['wl_op_field']='offl_id';
		    			$data_save['wl']['op_id']=$rtn['id'];
	    				$data_save['wl']['p_id']=$this->proc_id;
	    				$data_save['wl']['pp_id']=$this->model_name;
	    				$data_save['wl']['wl_proc']=$data_save['content']['ppo'];
		    			$data_save['wl']['wl_url']=$this->url_conf.'/act/2';
		    			$data_save['wl']['wl_note']='【'.$this->title.'】'
		    				.',系统所有人:'.$data_save['content']['offl_c_id_s']
		    				;
	    				$data_save['wl']['c_accept'][] = $this->sess->userdata('c_id');
	    				
	    				$this->m_work_list->add($data_save['wl']);
	    				
	    				$data_save['wl']['wl_id']=get_guid();
	    				$data_save['wl']['wl_type'] = 0 ;
	    				$data_save['wl']['wl_event']='补全、提交单据';
	    				$data_save['wl']['wl_proc'] = 1;
	    				$this->m_work_list->add($data_save['wl']);
	    				
	    				$rtn['wl_i'][] = $this->sess->userdata('c_id');
	    				$rtn['wl_accept'][] = $this->sess->userdata('c_id');
	    				$rtn['wl_care']=array();
	    				$rtn['wl_end'] = array();
	    				
						$arr_log_content=array();
						$arr_log_content['new']['content']=$data_save['content'];
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
						$ppo_btn_text = $data_out['ppo_btn_next'];
						if($btn == 'pnext')
						$ppo_btn_text = $data_out['ppo_btn_pnext'];
						
						//工单基本信息
						$data_save['wl']['wl_code']=$data_db['content']['offl_code'];
		    			$data_save['wl']['wl_op_table']='oa_office_logout';
		    			$data_save['wl']['wl_op_field']='offl_id';
		    			$data_save['wl']['op_id']=$data_save['content'][$this->pk_id];
	    				$data_save['wl']['p_id']=$this->proc_id;
	    				$data_save['wl']['pp_id']=$this->model_name;
		    			$data_save['wl']['wl_url']=$this->url_conf.'/act/2';
		    			$data_save['wl']['wl_proc']=$data_save['content']['ppo'];
		    			$data_save['wl']['wl_time_end']=date('Y-m-d H:i:s',strtotime('+30 day'));
		    			$data_save['wl']['c_accept'] = array();
		    			$data_save['wl']['wl_note']='【'.$this->title.'】'
		    				.',系统所有人:'.$data_save['content']['offl_c_id_s']
		    				;
						
						//工单流转
						$flag_wl_combine_finish=TRUE;//联合工单通过标记
						
						switch (element('ppo',$data_db['content']))
						{
							case OA_OFFL_PPO_START:

								if($btn == 'next')
								{
									$data_save['content']['ppo'] = OA_OFFL_PPO_CHECK;

									$data_save['wl']['wl_event']='信息系统注销';

									//添加流程接收人
	    							$data_save['wl']['c_accept']=array();
								}

								break;

							case OA_OFFL_PPO_CHECK:
								
								if($btn == 'next')
								{
									//存在当前登录人的工单
									if( count(element('arr_wl_i_to_do', $data_out)) > 0 )
									{
										//验证联合工单是否全部完成
										$flag_wl_combine_finish=$this->m_work_list->check_wl_combine_finish(
										$data_save['content']['offl_id'],$this->model_name,element('arr_wl_i_to_do', $data_out));
										
										if($flag_wl_combine_finish)
										$data_save['content']['ppo'] = OA_OFFL_PPO_END;

									}else{
                                        $data_save['content']['ppo']=OA_OFFL_PPO_END;
                                    }
								}
								break;
						}

						$rtn=$this->update($data_save['content']);

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

                                    $v['offl_id']=$data_save['content'][$this->pk_id];
                                    $data_save['office']=$v;

                                    switch ( $v['offai_offi_id'] )
                                    {
                                        //LDAP账户
                                        case '26B028F103FD5AE7C1018A214D79E9EC':

                                            break;

                                        //短号
                                        case 'E733D2DF8A3A4D08E10F0604DD1689B0':

                                            if( element('offail', $data_save['office']) 
                                             && ! empty(element('c_tel_code', $data_db['content'])))
                                            {
                                                $data_save['content_c']['c_tel_code'] = '';
                                            }

                                            break;

                                        //网络证书
                                        case '17384E798664501D49970BFF1959A175':

                                            if( element('offail', $data_save['office']) 
                                             && !empty(element('c_pwd_web', $data_db['content'])))
                                            {
                                                $data_save['content_c']['c_pwd_web'] = '';
                                            }

                                            break;

                                        //邮箱
                                        case 'BC952B1E100717A078BDD79B45CC0736':

                                            if( element('offail', $data_save['office']) 
                                             && ! empty(element('c_email_sys', $data_db['content'])))
                                            {
                                                $data_save['content_c']['c_email_sys'] = '';
                                            }

                                            break;

                                        //工资邮箱
                                        case '53AB852B7054D11DBC846C5A6DBCE359':

                                            if( element('offail', $data_save['office']) 
                                             && ! empty(element('c_email_gz', $data_db['content'])))
                                            {
                                                $data_save['content_c']['c_email_gz'] = '';
                                            }

                                            break;

                                        //手机上网id
                                        case 'FA31B79FEA42C7A246E7A78F5FCEE504':

                                            if( element('offail', $data_save['office']) 
                                             && ! empty(element('c_login_id_m', $data_db['content'])))
                                            {
                                                $data_save['content_c']['c_login_id_m'] = '';
                                            }

                                            break;
                                    }

                                    if( empty( element('offai_person_end', $v))
                                        && element('offail', $data_save['office']) )
                                    {
                                        $data_save['office']['offai_person_end'] = $this->sess->userdata('c_id');
                                        $data_save['office']['offai_time_end'] = date("Y-m-d");
                                        
                                        if(strstr($data_save['office']['offai_model'], '已开通'))
                                        $data_save['office']['offai_model'] = str_replace('已开通', '已注销', $data_save['office']['offai_model']);
                                        else
                                        $data_save['office']['offai_model'] .= '，已注销';
                                    }

                                    if(isset($v['offai_id']) && isset($list_office_db[$v['offai_id']]))
                                    {
                                        if( $btn == 'next' && ! $data_save['office']['offai_person_end'] )
                                        {
                                            $offi_person_end=explode(',', $list_office_db[$v['offai_id']]['offi_person_start']);

                                            if(count($offi_person_end) > 1)
                                            {
                                                $arr_tmp=array();
                                                $arr_tmp[] = $offi_person_end;
                                                $arr_tmp[] = $data_db['content']['c_org'];

                                                $offi_person_end = $this->m_base->get_field_where('sys_contact','c_id',
                                                    " AND c_id IN ? AND c_org = ? " , $arr_tmp,TRUE);

                                                if( count($offi_person_end) == 0 )
                                                    $offi_person_end=explode(',', $list_office_db[$v['offai_id']]['offai_person_start']);

                                            }

                                            $arr_wl_combine[] = $offi_person_end;
                                        }
                                        
                                        $this->m_table_op->update($data_save['office']);

                                        unset($list_office_db[$v['offai_id']]);
                                    }
                                    else
                                    {
                                        $this->m_table_op->update($data_save['office']);
                                    }
                                }

                                $this->m_table_op->load('sys_contact');
                                $data_save['content_c']['c_id'] = $data_db['content']['offl_c_id'];
                                $this->m_table_op->update($data_save['content_c']);
                            }
                        }

						//工单日志
						if( $btn == 'yj' )
						{
							$data_save['content_log']['log_note']=
						'【'.$this->sess->userdata('c_name').'['.$this->sess->userdata('a_login_id').']】'
						.'于节点【'.$GLOBALS['m_office_logout']['text']['ppo'][$data_db['content']['ppo']].'】'
						.',将【'.$this->title.'】移交于【'.$data_post['content']['person_yj_s'].'】';
						
							$data_save['wl']['wl_type']=WL_TYPE_YJ;
							$data_save['wl']['wl_event']=element('wl_list_to_do', $data_out);
							$data_save['wl']['c_accept'][]=$data_post['content']['person_yj'];
							
						}
						elseif( $btn == 'next')
						{

							$data_save['content_log']['log_note']=
						'于节点【'.$GLOBALS['m_office_logout']['text']['ppo'][$data_db['content']['ppo']].'】'.$ppo_btn_text
						.',流转至节点【'.$GLOBALS['m_office_logout']['text']['ppo'][$data_save['content']['ppo']].'】';
                            $data_save['wl']['wl_event']=element('wl_list_to_do', $data_out);

						}
						
						//工单更新 判断流程是否走完
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
								 && $data_db['content']['ppo'] != OA_OFFL_PPO_CHECK )
								{
									if($btn == 'next' && count($arr_wl_combine) > 0 )
									{
										//联合工单
										$data_save['wl']['wl_combine']=1;

										if( $flag_wl_combine_finish )
										{
											$arr_wl_accept=array();

											foreach ($arr_wl_combine as $v) {
												$data_save['wl']['c_accept'] = $v;//array_diff($v,$arr_wl_accept) ;

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

				$rtn=$this->del(element('offl_id',$data_get));

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
		$data_out['code']=element('offl_code', $data_db['content']);
		
		$data_out['ppo']=element('ppo', $data_db['content']);
	    $data_out['ppo_name']=$GLOBALS['m_office_logout']['text']['ppo'][element('ppo', $data_db['content'])];

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
	 * 根据录用通知创建信息系统注销注销
	 * @param $arr 包含offer_id,c_id,c_name,c_org,c_tele,c_ou_2,c_ou_3,c_ou_4,c_ou_bud的数组
	 */
	public function create_default_by_hr($arr)
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
		
		if( element('dim_id', $arr) )
		{
			$arr['offer_id'] = $arr['dim_id'];
			$arr['offl_link_id'] = $arr['dim_id'];
		}
		
		//结束开通申请
        $this->load->model('proc_office/m_office_apply');
        $arr['offa_id'] = $this->m_base->get_field_where('oa_office_apply','offa_id'," AND offa_offer_id = '{$arr['offer_id']}'");
        $this->m_office_apply->end_offa_by_offl($arr);
        
        //删除未开通系统
        $this->load->model('proc_office/m_oa_offai');
        $this->m_oa_offai->del_no_kt($arr['c_id']);
        
		//获取信息系统
        $arr_search=array();
        $arr_search['field']='offai.*,group_concat( l.link_id ) offi_person_start';
        $arr_search['from']="oa_offa_item offai
							 LEFT JOIN sys_link l ON
							 ( l.op_id = offai.offai_offi_id
							   AND l.op_field='offi_id' AND l.op_table = 'oa_office'
							   AND content='offi_person_start')";
        $arr_search['where']=" AND offai_c_id = ?
		         			   AND (offai_person_start IS NOT NULL AND offai_person_start != '') 
		         			   AND (offai_person_end IS NULL OR offai_person_end ='') ";
        $arr_search['value'][]=$arr['c_id'];
        $arr_search['where'].='GROUP BY offai_id';

		$rs=$this->m_db->query($arr_search);
		
        $accept=array();
        
        $arr_wl_combine = array();
        
        if(count($rs['content'])>0){
            foreach($rs['content'] as $k=>$v){
            	
                //获取默认开通人
                $offi_person_start=explode(',', $v['offi_person_start']);
                
				if(count($offi_person_start) > 1)
				{
					$arr_tmp=array();
					$arr_tmp[] = $offi_person_start;
					$arr_tmp[] = $arr['c_org'];
					
					$offi_person_start = $this->m_base->get_field_where('sys_contact','c_id',
					" AND c_id IN ? AND c_org = ? " , $arr_tmp,TRUE);
					
					if( count($offi_person_start) == 0 )
					$offi_person_start=explode(',', $v['offi_person_start']);
					
				}
				
				$arr_wl_combine[] = $offi_person_start;
				
				$accept = array_values(array_merge($accept,$offi_person_start));
            }
            
            $accept = array_unique($accept);
        }
        
        if(count($accept) == 0)
        return $rtn;

		$data_save['content']['offl_c_id'] = $arr['c_id'];
        $data_save['content']['offl_c_id_s'] = $this->m_base->get_c_show_by_cid($arr['c_id']);
		$data_save['content']['offl_note'] = element('offl_note', $arr);
		
		$data_save['content']['offl_link_id'] = element('offl_link_id', $arr);
		
		$data_save['content']['offl_code']=$this->get_code($data_save['content']);

		$data_save['content']['ppo']=OA_OFFL_PPO_CHECK;

		$rtn=$this->add($data_save['content']);

		$data_save['content_log']['log_note']='于【人事管理-录用通知】，创建【信息系统注销】,流转至【注销账户】';
		if(element('dim_id', $arr))
		{
			$data_save['content_log']['log_note']='于【人事管理-离职流程】，创建【信息系统注销】,流转至【注销账户】';	
		}

		//创建我的工单
    	$data_save['wl']['wl_id'] = $rtn['id'];
    	$data_save['wl']['wl_type'] = WL_TYPE_I;
    	$data_save['wl']['wl_code']=$data_save['content']['offl_code'];
    	$data_save['wl']['wl_op_table']='oa_office_logout';
    	$data_save['wl']['wl_op_field']='offl_id';
    	$data_save['wl']['op_id']=$rtn['id'];
    	$data_save['wl']['p_id']=$this->proc_id;
    	$data_save['wl']['pp_id']=$this->model_name;
    	$data_save['wl']['wl_proc']=$data_save['content']['ppo'];
    	$data_save['wl']['wl_url']=$this->url_conf.'/act/2';
    	$data_save['wl']['wl_note']='【'.$this->title.'】'
    		.',系统所有人:'.$data_save['content']['offl_c_id_s']
    		;
    		
    	//更新我的工单
		$data_save['wl']['wl_log_note']=$data_save['content_log']['log_note'];
    	$data_save['wl']['c_accept'][] = $this->sess->userdata('c_id');

        $this->m_work_list->add($data_save['wl']);
    	
    	$data_save['wl']['wl_id']=get_guid();
    	$data_save['wl']['wl_type'] = 0 ;
    	$data_save['wl']['wl_event']='注销信息系统申请';
    	$data_save['wl']['ppo'] = 1;
    	$data_save['wl']['wl_status']=WL_STATUS_FINISH;
		$data_save['wl']['wl_result']=WL_RESULT_SUCCESS;
		$data_save['wl']['wl_person_do'] = $this->sess->userdata('c_id');
    	$data_save['wl']['wl_time_do'] = date('Y-m-d H:i:s');

        $this->m_work_list->add($data_save['wl']);
    	
    	//工单基本信息 创建工单同时对应的人接收到工单
    	$data_save['wl']=array();
		$data_save['wl']['wl_code']=$data_save['content']['offl_code'];
    	$data_save['wl']['wl_op_table']='oa_office_logout';
    	$data_save['wl']['wl_op_field']='offl_id';
    	$data_save['wl']['op_id']=$rtn['id'];
    	$data_save['wl']['p_id']=$this->proc_id;
    	$data_save['wl']['pp_id']=$this->model_name;
    	$data_save['wl']['wl_proc']=$data_save['content']['ppo'];
    	$data_save['wl']['wl_url']=$this->url_conf.'/act/2';
    	$data_save['wl']['wl_proc']=$data_save['content']['ppo'];
    	$data_save['wl']['wl_time_end']=date('Y-m-d H:i:s',strtotime('+30 day'));
    	$data_save['wl']['wl_note']='【'.$this->title.'】'
    		.',系统所有人:'.$data_save['content']['offl_c_id_s']
    		;

    	$data_save['wl']['wl_event']='注销信息系统';
    	$data_save['wl']['wl_combine']=1;
    	
    	$rtn['c_accept'] = $accept;
    	
    	if(count($arr_wl_combine) > 0)
    	{
    		$arr_wl_accept=array();
    		
    		foreach ($arr_wl_combine as $v) {
    			
    			$data_save['wl']['c_accept'] = $v;//array_diff($v,$arr_wl_accept) ;

				if(count($data_save['wl']['c_accept']) > 0 )
				{
					$this->m_work_list->add($data_save['wl']);
					
					$arr_wl_accept=array_values(array_merge($arr_wl_accept,$v));
				}
    		}
    		
    		$data_save['wl']['c_accept']=array_unique($arr_wl_accept);
    	}
    	else
    	{
    		$data_save['wl']['c_accept'] = $accept;
    		$this->m_work_list->add($data_save['wl']);
    	}

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
	 * 结束信息系统注销申请
	 * @param $arr 包含offl_id的数组
	 */
	public function end_offl($arr)
	{
		/************模型载入*****************/
		$this->load->model('proc_office/m_proc_office');
		/************变量初始化****************/
		$data_save=array();//
		$rtn=array();//结果
		$rtn['rtn']=TRUE;
		$where='';
		/************数据处理*****************/
		
		if( ! element('offl_id', $arr) ) {
			$rtn['rtn']=FALSE;
			
			return $rtn['rtn'];
		}
		
		$data_db['content'] = $this->get($arr['offl_id']);
		
		if( $data_db['content']['ppo'] == OA_OFFL_PPO_END)
		return $rtn;
		
		$data_save['content'] = $data_db['content'];
		$data_save['content']['offl_id'] = $arr['offl_id'];
        $data_save['content']['ppo'] = OA_OFFL_PPO_END;
        $this->update($data_save['content']);
    	
		$arr_log_content=array();
		$arr_log_content['new']['content'] = $data_save['content'];
		$arr_log_content['old']['content'] = $data_db['content'];

		//操作日志
		$data_save['content_log']['log_note'] = '流程终止';
		$data_save['content_log']['op_id']=$arr['offl_id'];
		$data_save['content_log']['log_act']=STAT_ACT_EDIT;
		$data_save['content_log']['log_url']=$this->url_conf.'/'.$this->pk_id.'/'.$arr['offl_id'];
		$data_save['content_log']['log_content']=json_encode($arr_log_content);
		$data_save['content_log']['log_module']=$this->title;
		$data_save['content_log']['log_p_id']=$this->proc_id;
		
		$this->m_log_operate->add($data_save['content_log']);
		
		//取消工单信息
        $this->m_work_list->cancel_wl($arr['offl_id'],$this->model_name);
	        
		return $rtn;
	}
}