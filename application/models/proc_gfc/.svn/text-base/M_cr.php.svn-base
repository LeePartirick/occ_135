<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 *  
    合同评审项
 */
class M_cr extends CI_Model {
	
	//@todo 主表配置
	private $table_name='pm_contract_review';
	private $pk_id='cr_id';
	private $table_form;
	private $arr_table_form=array();
	private $title='合同评审项';
	private $model_name = 'm_cr';
	private $url_conf = 'proc_gfc/cr/edit';
	private $proc_id = 'proc_gfc';
	
 	public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->m_define();
        
         //读取表结构
        $this->config->load('db_table/'.$this->table_name, FALSE,TRUE);
        $this->table_form=$this->config->item($this->table_name);

        $this->load->model('proc_gfc/m_gfc');
    }
    
	/**
     * 
     * 定义
     */
	public function m_define()
    {
    	//@todo 定义
    	if( defined('LOAD_M_CR') ) return;
    	define('LOAD_M_CR', 1);
    	
    	//define
    	
    	// 评审类型
		DEFINE('CR_TYPE_GFC_CODE', '1');// 财务编号
		DEFINE('CR_TYPE_BUD_ALTER', '2');// 预算表变更
		$GLOBALS['m_cr']['text']['cr_default'] = array(
			CR_TYPE_GFC_CODE => '财务编号',
			CR_TYPE_BUD_ALTER => '预算变更',
		);
		
		// 字段关联评审
		DEFINE('CR_LINK_FIELD_ELI', '1');// 设备清单
		DEFINE('CR_LINK_FIELD_KG', '2');// 开工申请单
		$GLOBALS['m_cr']['text']['cr_link_field'] = array(
			CR_LINK_FIELD_ELI => '设备清单',
			CR_LINK_FIELD_KG => '预算表-人力成本',
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
    	$acl_list= $this->m_proc_gfc->get_acl();

    	$msg='';
    	/************权限验证*****************/

    	//如果有超级权限，TRUE
    	if( ($acl_list & pow(2,ACL_PROC_GFC_SUPER)) != 0 )
    	{
    		return TRUE;
    	}

    	$check_acl=FALSE;

    	if( ! $check_acl
    	 && ($acl_list & pow(2,ACL_PROC_GFC_USER)) != 0
    	)
	    {
	     	$check_acl=TRUE;
	    }

	    if( ! $check_acl )
	    {
			if( ! $msg )
			$msg = '您没有【'.$this->title.'】的【操作】权限不可进行操作！' ;

			redirect('base/main/show_err/msg/'.fun_urlencode($msg));
	    }
    }
    
	/**
     * 
     */
	public function get_code($data_save=array())
    {
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
		
		//@todo 删除关联数据验证
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
					$rtn['msg_err']=$rtn['err']['msg'] = '于【'.$arr_tmp[0].'】存在关联数据,不可删除!';
					return $rtn;
				}
			}
		}
		
    	$this->db->trans_begin();
    	
    	if($rtn['rtn'])
        $rtn=$this->m_db->delete($this->table_name,$where);
        
        if($rtn['rtn'])
        $rtn=$this->m_db->delete('pm_cr_person',$where);
        
        $cond_link=array();
        
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
     * 生成导入xlsx
     */
	public function create_import_xlsx()
    {
    	$this->load->model('base/m_excel');
    	
    	$conf=array();
    	
    	//@todo 导入xlsx配置
    	$conf['field_edit']=array(
			'pm_contract_review[cr_name]',
    		'pm_contract_review[cr_ppo]',
    		'pm_contract_review[cr_default]',
    		'pm_contract_review[cr_note]',
    	);
    	
    	$conf['field_required']=array(
			'pm_contract_review[cr_name]',
    		'pm_contract_review[cr_ppo]',
    	);
    	
    	$conf['field_define']=array(
    		'pm_contract_review[cr_default]'=>$GLOBALS['m_base']['text']['base_yn_0'],
    	);
    	
    	$conf['table_form']=array(
			'pm_contract_review'=>$this->table_form,
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
			'content[cr_name]',
			'content[cr_ppo]',
		);
		
		//编辑数组
		$data_out['field_edit']=array(
			'content[db_time_update]',
			'content[cr_name]',
			'content[cr_ppo]',
			'content[cr_default]',
			'content[cr_person_empty]',
			'content[cr_pass_alter]',
			'content[cr_link_field]',
			'content[cr_link_file]',
			'content[cr_link_file_data]',
			'content[cr_sn]',
			'content[cr_note]',
			
			'content[crp]',
		);
		
		//只读数组
		$data_out['field_view']=array(
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
		
		if( empty( element('wl', $data_post) ) )
		$data_post['wl']=trim_array($this->input->post('wl'));
		
		$flag_more=element('flag_more', $data_post);
		/************字段定义*****************/
		//@todo 字段定义
		$arr_field=array_unique(array_merge($data_out['field_edit'], $data_out['field_view']));
		
		$data_out['json_field_define']=array();
		$data_out['json_field_define']['cr_default']=get_html_json_for_arr($GLOBALS['m_cr']['text']['cr_default'] );
		$data_out['json_field_define']['cr_link_field']=get_html_json_for_arr($GLOBALS['m_cr']['text']['cr_link_field'] );
		$data_out['json_field_define']['gfc_category_main']=get_html_json_for_arr($GLOBALS['m_gfc']['text']['gfc_category_main'] );
		
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
								if( is_array($v) ) {
									$v = implode(',', $v);

									if(element($k,$data_db['content']))
										$data_db['content'][$k] = implode(',', $data_db['content'][$k]);
								}

								if( $v != element($k,$data_db['content']) )
								{
									switch ($k)
									{
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
						//批量编辑
						if(  element('flag_edit_more', $data_get) )
						{
							$data_db['content'] = array();
							break;
						}
						
						//非数据库页面调用
						if(  element('fun_no_db', $data_get) )
						{
							$data_db['content'] = json_decode(fun_urldecode($this->input->post('data_db')),TRUE);
							break;
						}
						
						$data_db['content'] = $this->get(element($this->pk_id,$data_get));
						
						if( empty($data_db['content'][$this->pk_id]) )
						{
							$msg= $this->title.'【'.element($this->pk_id,$data_get).'】不存在！';
							
							if($flag_more)
							{
								$rtn['result'] = FALSE;
								$rtn['msg_err'] = $msg;
									
								if( $flag_more )
								return $rtn;
							}
							
							redirect('base/main/show_err/msg/'.fun_urlencode($msg));
						}
						
						//获取评审人
						$arr_search=array();
						$arr_search['field']='crp_id
											 ,crp_c_id
											 ,crp_note
											 ,cr_gfc_ou
											 ,cr_gfc_category_main
											 ,c_name
											 ,c_login_id
											 ,c_tel
											 ,ou_name';
						$arr_search['from']="pm_cr_person crp
											 LEFT JOIN sys_contact c ON
											 (c.c_id = crp.crp_c_id)
											 LEFT JOIN sys_ou ou ON
											 (ou.ou_id = c.c_ou_bud)";
						$arr_search['where']=' AND cr_id = ? ';
						$arr_search['value'][]=element('cr_id',$data_get);
						$arr_search['sort']=array("crp_sn");
						$arr_search['order']=array('asc');
						
						$rs=$this->m_db->query($arr_search);
						
						$data_db['content']['crp'] = array();
						
						if(count($rs['content']) > 0 )
						{
							foreach ($rs['content'] as $v) {
								
								$v['crp_c_id_s'] = $v['c_name'];
								
								if($v['c_login_id']) $v['crp_c_id_s'] .= '['.$v['c_login_id'].']';
								elseif($v['c_tel']) $v['crp_c_id_s'] .= '['.$v['c_tel'].']';
								
								$arr_tmp = explode(',', $v['cr_gfc_category_main']);
								
								$v['cr_gfc_category_main_s'] = '';
								foreach ($arr_tmp as $v1) {
									if($v1)
									$v['cr_gfc_category_main_s'] .= element($v1, $GLOBALS['m_gfc']['text']['gfc_category_main']).',';
								}
								
								$v['cr_gfc_ou'] = '';
								$v['cr_gfc_ou_s'] = '';
								$v['cr_gfc_ou_data'] = '';
								
								$arr_search_link=array();
								$arr_search_link['rows']=0;
								$arr_search_link['field']='ou_name,ou_id';
								$arr_search_link['from']='sys_link l
														  LEFT JOIN sys_ou ou ON
														  (ou.ou_id = l.link_id)';
								$arr_search_link['where']=" AND op_id = ? AND op_table = ? AND content = ?";
								$arr_search_link['value'][]=$v['crp_id'];
								$arr_search_link['value'][]='pm_cr_person';
								$arr_search_link['value'][]='cr_gfc_ou';
								
								$rs_link=$this->m_db->query($arr_search_link);
								
								if(count($rs_link['content'])>0)
								{
									foreach ($rs_link['content'] as $v1) {
										$v['cr_gfc_ou'] .= $v1['ou_id'].',';
										$v['cr_gfc_ou_s'] .= $v1['ou_name'].',';
										$v['cr_gfc_ou_data'] .= '{"id":"'.$v1['ou_id'].'","text":"'.$v1['ou_name'].'"},';
									}
								}
								$v['cr_gfc_ou_data'] = '['.trim($v['cr_gfc_ou_data'],',').']';
								
								$data_db['content']['crp'][] = $v;
							}
							
						}

						$data_db['content']['crp'] = json_encode($data_db['content']['crp']);
						
					}
					
					$data_db['content']['cr_link_file_data'] = array();
						
					if(element('cr_link_file',$data_db['content']) )
					{
						$arr_tmp = explode(',', $data_db['content']['cr_link_file']);
						
						$arr_search=array();
						$arr_search['field']='f_t_id,f_t_name';
						$arr_search['from']="sys_file_type";
						$arr_search['where']= ' AND f_t_id IN ? ';
						$arr_search['value'][] = $arr_tmp;
						
						$rs=$this->m_db->query($arr_search);
						
						if(count($rs['content'])>0)
						{
							foreach ($rs['content'] as $v) {
								$data_db['content']['cr_link_file_data'][]=array(
									'id'=>$v['f_t_id'],
									'text'=>$v['f_t_name']
								);
							}
						}
					}
					
					$data_db['content']['cr_link_file_data'] = json_encode($data_db['content']['cr_link_file_data']);
					
				} catch (Exception $e) {
				}
			break;
		}
		/************工单信息*****************/

		/************权限验证*****************/
		//@todo 权限验证
		$acl_list= $this->m_proc_gfc->get_acl();

		$this->check_acl($data_db,$acl_list);
		
		/************显示配置*****************/
		//@todo 显示配置
		$title_field='-'.element('cr_name',$data_db['content']);;
		
		switch ($data_get['act']) {
			case STAT_ACT_CREATE:
				$data_out['title']='创建'.$this->title;
				
				$data_out['op_disable'][]='btn_del';
				$data_out['op_disable'][]='btn_log';
				
				$data_out['op_disable'][]='btn_next';
				$data_out['op_disable'][]='btn_pnext';
				
				$data_out['op_disable'][]='btn_wl';
				$data_out['op_disable'][]='btn_im';
				
				//创建默认值
				
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
				$data_out['op_disable'][]='btn_person';
				$data_out['op_disable'][]='btn_import';
				
				$data_out['op_disable'][]='btn_next';
				$data_out['op_disable'][]='btn_pnext';
				
				$data_out['field_view']=array_unique(array_merge($data_out['field_view'],$data_out['field_edit']));
				
			break;
		}
		
		//@todo 节点权限显示隐藏
		if(element('flag_edit_more', $data_get))
		{
			$data_out['field_required']=array();
			
			$data_out['op_disable'][] = 'content[cr_name]';
			$data_out['op_disable'][] = 'content[crp]';
			$data_out['op_disable'][] = 'title_crp';
			
			$data_out['op_disable'][]='btn_log';
			$data_out['op_disable'][]='btn_del';
			
			$data_out['title'] = '批量编辑'.$this->title.'-请勾选要保存的字段';
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
			case 'sort':
				
				$rtn=array();//结果
				$check_data=TRUE;
				
				/************数据验证*****************/
				//@todo 数据验证
				if($btn == 'save')
				{
					//必填验证
					if(count($data_out['field_required'])>0)
					{
						foreach ($data_out['field_required'] as $v) {
							
							$arr_tmp=split_table_field($v);
							
							if( ! is_array(element('content', $data_post)) 
							 || (
							 		empty(element($arr_tmp['field'],$data_post['content']))
							 	 && element($arr_tmp['field'],$data_post['content']) != '0'
							 	)
							 )
							$data_post['content'][$arr_tmp['field']] = element($arr_tmp['field'],$data_db['content']);
							
							if( empty(element($arr_tmp['field'],$data_post['content'])) 
							 && element($arr_tmp['field'],$data_post['content']) != '0'
							 )
							{
								$field_s='';
								if(isset($this->table_form['fields'][$arr_tmp['field']]))
								$field_s = $this->table_form['fields'][$arr_tmp['field']]['comment'];
								elseif(count($this->arr_table_form)>0)
								{
									foreach ($this->arr_table_form as $k=>$v1) {
										
										if(isset($v1['fields'][$arr_tmp['field']]))
										{
											$field_s = $v1['fields'][$arr_tmp['field']]['comment'];
											break;
										}
									}
								}
								
								$rtn['err']['content['.$arr_tmp['field'].']']='请输入'.$field_s.'！';
								$check_data=FALSE;
							}
						}
					}
					
					//合同内容唯一
					if( ! empty( element('cr_name',$data_post['content']) ) )
					{ 
						$where_check=' AND cr_id != \''.element('cr_id',$data_db['content']).'\'';
								
						$check=$this->m_check->unique('pm_contract_review','cr_name',element('cr_name',$data_post['content']),$where_check);
						if( ! $check )
						{
							$rtn['err']['content[cr_name]']='评审内容【 '.element('cr_name',$data_post['content']).'】已存在，不可重复创建！';
							$check_data=FALSE;
						}
					}
					
//					if(count(json_decode(element('crp',$data_post['content']))) == 0)
//					{
//						$rtn['err']['content[crp]']='评审人不可为空！';
//						$check_data=FALSE;
//					}
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
				
				if(element('fun_no_db', $data_get))
				{
					$rtn['rtn']=TRUE;
					echo json_encode($rtn);
					exit; 
				}
				
				/************数据处理*****************/
				$data_save['content']=$data_db['content'];
				
				if(count(element('content',$data_post))>0)
				{
					foreach ($data_post['content'] as $k=>$v) {
						
						if( element('flag_edit_more', $data_post) 
						 && element($k.'_check', $data_post['content']) != 1 )
						 continue;
						 
						if( ! in_array('content['.$k.']',$data_out['field_view'])
						 && ! in_array('content['.$k.']',$data_out['op_disable'])
						 && in_array('content['.$k.']',$data_out['field_edit']) )
						$data_save['content'][$k]=$v;
					}
				}
				
				if( ! element('cr_ppo', $data_save['content'] ) )
				$data_save['content']['cr_ppo']=1;
				else 
				{
					$check_cr_ppo = $this->m_base->get_field_where('pm_contract_review','cr_ppo'
					," AND cr_ppo = '{$data_save['content']['cr_ppo']}' AND cr_id != '".element('cr_id', $data_get)."'");
					
					if( ! $check_cr_ppo)
					{
						$cr_ppo = $this->m_db->get_m_value('pm_contract_review','cr_ppo');
						if($data_save['content']['cr_ppo'] > $cr_ppo +1)
						$data_save['content']['cr_ppo'] =  $cr_ppo + 1 ;
					}
				}
				
				if( ! element('cr_sn', $data_db['content']) )
				$data_save['content']['cr_sn']=$this->m_db->get_m_value('pm_contract_review','cr_sn') + 1;
				
				$data_save['content']['cr_name'] = str_replace('（', '(', $data_save['content']['cr_name'] );
				$data_save['content']['cr_name'] = str_replace('）', ')', $data_save['content']['cr_name'] );
				/************事件处理*****************/
				switch ($data_get['act']) {
					case STAT_ACT_CREATE:
						$rtn=$this->add($data_save['content']);
						
						//评审人
						if( ! empty(element('crp',$data_save['content']) ) )
						{
							$arr_save=array(
								'cr_id' => $rtn['id']
							);

							$this->m_base->save_datatable('pm_cr_person',
								$data_save['content']['crp'],
								'[]',
								$arr_save,
								'm_cr',
								'save_crp',
								'act');
						}
						
						$arr_log_content=array();
						$arr_log_content['new']['content']=$data_save['content'];
						$arr_log_content['old']['content'][$this->pk_id]=$rtn['id'];
						
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
						
						$rtn=$this->update($data_save['content']);
						
						//评审人
						if( ! empty(element('crp',$data_save['content']) ) )
						{
							$arr_save=array(
								'cr_id' => element($this->pk_id,$data_get)
							);
							
							$this->clear_crp_sn(element($this->pk_id,$data_get));
							
							$this->m_base->save_datatable('pm_cr_person',
								$data_save['content']['crp'],
								$data_db['content']['crp'],
								$arr_save,
								'm_cr',
								'save_crp',
								'act');
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
				
				$rtn=$this->del(element($this->pk_id,$data_get));
				
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
		if( ! empty(element('time', $data_get)) )
		$data_out['time']=element('time', $data_get);
		
		$data_out['fun_open']=element('fun_open', $data_get);
	    $data_out['fun_open_id']=element('fun_open_id', $data_get);
	    
	    $data_out['log']=json_encode(element('log', $data_out));
		
		$data_out['log_time']=$this->input->post('log_time');
		$data_out['log_a_login_id']=$this->input->post('log_a_login_id');
		$data_out['log_c_name']=$this->input->post('log_c_name');
		$data_out['log_act']=$this->input->post('log_act');
		$data_out['log_note']=$this->input->post('log_note');
	    
	    $data_out['db_time_create']=element('db_time_create', $data_db['content']);
	    $data_out['code']=element('gfc_code', $data_db['content']);
	    
	    $data_out['fun_no_db']=element('fun_no_db', $data_get);
	    $data_out['data_db_post'] = $this->input->post('data_db');
	    
	    $data_out['flag_edit_more']=element('flag_edit_more', $data_get);
	    
	    $data_out[$this->pk_id]=element($this->pk_id,$data_get);
	    
	    $data_out['data']=array();
	    
		if( count($data_out['field_out'])>0)
		{
			foreach ($data_out['field_out'] as $k=>$v) {
				$arr_f = split_table_field($v);
				$data_out['data'][$v] = element($arr_f['field'], $data_db['content']);
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
	 * 清除项目评审人排序
	 * @param $arr_id
	 */
	public function clear_crp_sn($cr_id)
	{
		 $sql="UPDATE pm_cr_person 
		SET crp_sn =  NULL
		WHERE crp_sn IS NOT NULL AND cr_id = ? ";
		
		$value[]=$cr_id;
		
		$this->m_db->exec_sql($sql,$value);
	}
	
	/**
	 * 
	 * 合同评审人
	 * @param unknown_type $data_save
	 */
	function save_crp($arr_save,$act)
	{
		if($act != STAT_ACT_REMOVE)
		$arr_save['crp_sn'] = 1 + $this->m_db->get_m_value('pm_cr_person','crp_sn'," AND cr_id = '{$arr_save['cr_id']}'");
		
		$this->m_table_op->load('pm_cr_person');
		switch ($act)
		{
			case STAT_ACT_CREATE:
				
				$this->m_table_op->add($arr_save);
				
				if(count($arr_save['cr_gfc_ou']) > 0)
				{
					foreach ($arr_save['cr_gfc_ou'] as $v) {
						if( ! $v ) continue;
						
						$data_save['link']=array();
						$data_save['link']['op_id']=$arr_save['crp_id'];
						$data_save['link']['op_table']='pm_cr_person';
						$data_save['link']['op_field']='crp_id';
						$data_save['link']['content']='cr_gfc_ou';
						$data_save['link']['link_id']=$v;
						
						$this->m_link->add($data_save['link']);
					}
				}
				
				break;
				
			case STAT_ACT_EDIT:
				
				$this->m_table_op->update($arr_save);
				
				$cond_link=array();
				$cond_link['op_id']=$arr_save['crp_id'];
        		$cond_link['op_table']='pm_cr_person';
				$cond_link['op_field']='crp_id';
				$cond_link['content']='cr_gfc_ou';
        		$this->m_link->del_where($cond_link);
			        		
        		if ( ! is_array($arr_save['cr_gfc_ou']) )
        		$arr_save['cr_gfc_ou'] = explode(',', $arr_save['cr_gfc_ou']);
        		
				if(count($arr_save['cr_gfc_ou']) > 0)
				{
					foreach ($arr_save['cr_gfc_ou'] as $v) {
						if( ! $v ) continue;
						$data_save['link']=array();
						$data_save['link']['op_id']=$arr_save['crp_id'];
						$data_save['link']['op_table']='pm_cr_person';
						$data_save['link']['op_field']='crp_id';
						$data_save['link']['content']='cr_gfc_ou';
						$data_save['link']['link_id']=$v;
						
						$this->m_link->add($data_save['link']);
					}
				}
				
				break;
				
			case STAT_ACT_REMOVE:
				
				$this->m_table_op->del($arr_save['crp_id']);
				
				$cond_link=array();
				$cond_link['op_id']=$arr_save['crp_id'];
        		$cond_link['op_table']='pm_cr_person';
				$cond_link['op_field']='crp_id';
				$cond_link['content']='cr_gfc_ou';
        		$this->m_link->del_where($cond_link);
				
				break;
			
		}
	}
}