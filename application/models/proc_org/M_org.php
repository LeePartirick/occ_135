<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 *  
    机构
 */
class M_org extends CI_Model {
	
	//@todo 主表配置
	private $table_name='sys_org';
	private $pk_id='o_id';
	private $table_form;
	private $arr_table_form=array();
	private $title='机构';
	private $model_name = 'm_org';
	private $url_conf = 'proc_org/org/edit';
	private $proc_id = 'proc_org';
	
 	public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->m_define();
        
         //读取表结构
        $this->config->load('db_table/'.$this->table_name, FALSE,TRUE);
        $this->table_form=$this->config->item($this->table_name);
        
         //读取表结构
        $this->config->load('db_table/sys_org_detail', FALSE,TRUE);
        $this->arr_table_form['sys_org_detail']=$this->config->item('sys_org_detail');
    }
    
	/**
     * 
     * 定义
     */
	public function m_define()
    {
    	//@todo 定义
    	if( defined('LOAD_M_ORG') ) return;
    	define('LOAD_M_ORG', 1);
    	
    	//define

		// 机构类型
		define('O_TYPE_OU', 0);  //
		define('O_TYPE_OTHER', 1); //

		$GLOBALS['m_org']['text']['o_type'] = array(
			O_TYPE_OU=>'分支机构',
			O_TYPE_OTHER=>'其他机构'
		);
		
		// 营业执照类型
		define('O_LICENCE_1', 1);  //

		$GLOBALS['m_org']['text']['o_licence'] = array(
			O_LICENCE_1=>'类型1',
		);

		// 状态
		define('O_STATUS_YES', 1); //
		define('O_STATUS_NO', 2); // 

		$GLOBALS['m_org']['text']['o_status']=array(
			O_STATUS_YES=>'有效',
			O_STATUS_NO=>'无效',
		);

		//标签
		define('O_TAG_S', 1); //
		define('O_TAG_C', 2); //

		$GLOBALS['m_org']['text']['o_tag']=array(
			O_TAG_S=>'供应商',
			O_TAG_C=>'客户',
		);
        $this->load->model('proc_contact/m_contact');
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
			$acl_list= $this->m_proc_org->get_acl();

		$msg='';
		/************权限验证*****************/

		//如果有超级权限，TRUE
		if( ($acl_list & pow(2,ACL_PROC_ORG_SUPER)) != 0 )
		{
			return TRUE;
		}

		$check_acl=FALSE;

		if( ! $check_acl
			&& ($acl_list & pow(2,ACL_PROC_ORG_USER)) != 0
		)
		{
			$check_acl=TRUE;
		}

		if( ! $check_acl )
		{
			if( ! $msg )
				$msg = '您没有【机构管理】的【操作】权限不可进行操作！' ;

			redirect('base/main/show_err/msg/'.fun_urlencode($msg));
		}
	}
    
	/**
     *
     */
	public function get_code($data_save=array())
    {
    	$where='';
    	 
    	$pre='ORG'.date("Ym");
    	$where .= " AND o_code LIKE  '{$pre}%'"; 
    	
    	$max_code=$this->m_db->get_m_value('sys_org','o_code',$where);
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
        if( empty(element('o_id_standard',$data_save['content'])) )
        $data_save['content']['o_id_standard'] = $data_save['content'][$this->pk_id];
         
        $data_save['content']['db_time_update']=date("Y-m-d H:i:s"); 
        $data_save['content']['db_time_create']=date("Y-m-d H:i:s"); 
        $data_save['content']['db_person_create']=$this->sess->userdata('c_id') ;
		/************数据处理*****************/
		
    	$this->db->trans_begin();
		
		if($rtn['rtn'])
        $rtn=$this->m_db->insert($data_save['content'],$this->table_name);
        
        if($rtn['rtn'])
        $rtn=$this->m_db->insert($data_save['content'],'sys_org_detail');

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
        	
        if($rtn['rtn'])
        $rtn=$this->m_db->update('sys_org_detail',$data_save['content'],$where);

        
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
   			'sys_contact.c_org',
    		'sys_contact.c_hr_org',
    		'sys_ou.ou_org',
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
        $rtn=$this->m_db->delete('sys_org_detail',$where);

		if($rtn['rtn'])
		$rtn=$this->m_db->delete('sys_org_addr',$where);

		if($rtn['rtn'])
		$rtn=$this->m_db->delete('sys_org_account',$where);
		
		if($rtn['rtn'])
		{
			$where = array();
			$where['o_id_standard']=$id;
			$rtn=$this->m_db->delete('sys_org',$where);
		}
        
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
    		'sys_org[o_name]',
    		'sys_org[o_code_register]',
    		'sys_org_detail[o_legal_person]',
    		'sys_org_detail[o_code_taxpayer]',
    		'sys_org_detail[o_sum_register]',
    		'sys_org_detail[o_tel]',
    		'sys_org_detail[o_fax]',
    		'sys_org_detail[o_post_code]',
    		'sys_org_detail[o_addr]',
    		'sys_org_detail[o_web]',
    		'sys_org_detail[o_email]',
    		'sys_org[o_note]',
    	);
    	
    	$conf['field_required']=array(
    		'sys_org[o_name]',
    		'sys_org[o_code_register]',
    	);
    	
    	$conf['field_define']=array(
    	);
    	
    	$conf['table_form']=array(
    		'sys_org'=>$this->table_form,
    		'sys_org_detail'=>$this->arr_table_form['sys_org_detail'],
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
			'content[o_name]',
			'content[o_code_register]'
		);
		
		//编辑数组
		$data_out['field_edit']=array(
			'content[db_time_update]',
			'content[o_name]',
			'content[o_code_register]',
			'content[o_code_taxpayer]',
			'content[o_type]',
			'content[o_legal_person]',
			'content[o_sum_register]',
			'content[a_login_type]',
			'content[o_date_run]',
			'content[o_addr_register]',
			'content[o_range]',
			'content[o_addr]',
			'content[o_tel]',
			'content[o_post_code]',
			'content[o_web]',
			'content[o_id_standard_s]',
			'content[o_id_standard]',
			'content[o_tag]',
			'content[o_licence]',
			
			'content[org_c]',
			'content[org_addr]',
			'content[org_account]',
		
		);

		//只读数组
		$data_out['field_view']=array(
			'content[o_type]'
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
		$data_out['json_field_define']['o_type']=get_html_json_for_arr($GLOBALS['m_org']['text']['o_type']);
		$data_out['json_field_define']['o_licence']=get_html_json_for_arr($GLOBALS['m_org']['text']['o_licence']);
		$data_out['json_field_define']['o_tag']=get_html_json_for_arr($GLOBALS['m_org']['text']['o_tag']);
		/************数据读取*****************/
		$data_db['content']=array();
		
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
                                        case 'org_addr':

                                            $data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('o_addr_id',$v,element($k,$data_db['content']));
                                            $data_db['content'][$k] =$v ;
                                            break;
                                        case 'org_account':

                                            $data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('oacc_id',$v,element($k,$data_db['content']));
                                            $data_db['content'][$k] =$v ;
                                            break;
                                        case 'org_c':

                                            $data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('c_id',$v,element($k,$data_db['content']),'m_contact','show_change_org_c');
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
						
						$this->m_table_op->load('sys_org_detail');
						$data_db['content_d'] =  $this->m_table_op->get(element($this->pk_id,$data_get));
						
						$data_db['content']= array_merge($data_db['content_d'],$data_db['content']);
						
						if( empty($data_db['content'][$this->pk_id]) )
						{
							$msg= '机构【'.element($this->pk_id,$data_get).'】不存在！';
							
							if($flag_more)
							{
								$rtn['result'] = FALSE;
								$rtn['msg_err'] = $msg;
									
								if( $flag_more )
								return $rtn;
							}
							
							redirect('base/main/show_err/msg/'.fun_urlencode($msg));
						}
						
						//非分支机构
						$data_db['content']['org_c']='[]';
						if( $data_db['content']['o_type'] != O_TYPE_OU)
						{
							//获取联系人信息
							$arr_search=array();
							$arr_search['field']='c.*
												  ,c_add.c_addr
												  ,c_add.c_post_code
												  ,c_add.c_note';
							$arr_search['from']='sys_contact  c
					    						LEFT JOIN sys_contact_add c_add ON
					    						( c_add.c_id = c.c_id )';
							$arr_search['where']=' AND c_org = ?';
							$arr_search['value'][]=element('o_id',$data_get);
							$rs=$this->m_db->query($arr_search);
	
							$data_db['content']['org_c']=json_encode($rs['content']);
						}
						else
						{
							$data_out['op_disable'][] = 'title_org_c';
						}

						//获取地址信息
						$arr_search=array();
						$arr_search['field']='*';
						$arr_search['from']='sys_org_addr';
						$arr_search['where']=' AND o_id = ?';
						$arr_search['value'][]=element('o_id',$data_get);
						$rs=$this->m_db->query($arr_search);

						$data_db['content']['org_addr']=json_encode($rs['content']);

						//获取账户信息
						$arr_search=array();
						$arr_search['field']='*';
						$arr_search['from']='sys_org_account';
						$arr_search['where']=' AND o_id = ?';
						$arr_search['value'][]=element('o_id',$data_get);
						$rs=$this->m_db->query($arr_search);

						$data_db['content']['org_account']=json_encode($rs['content']);

						if($data_db['content']['o_id_standard'])
							$data_db['content']['o_id_standard_s']=$this->m_base->get_field_where('sys_org','o_name',"AND o_id = '{$data_db['content']['o_id_standard']}'");
					
					}
				} catch (Exception $e) {
				}
			break;
		}
		/************权限验证*****************/
		//@todo 权限验证
		$acl_list= $this->m_proc_org->get_acl();

		$this->check_acl($data_db,$acl_list);
		
		/************显示配置*****************/
		//@todo 显示配置
		$title_field='';
		
		switch ($data_get['act']) {
			case STAT_ACT_CREATE:
				$data_out['title']='创建'.$this->title;
				
				$data_out['op_disable'][]='btn_del';
				$data_out['op_disable'][]='btn_log';

				//创建默认值
				$data_db['content']['o_type']=O_TYPE_OTHER;

				//个性化配置
				$data_out['url_conf']=str_replace('/', '-', $this->url_conf);

				//创建个性化配置
				$path_conf_person=PATH_PERSON_CONF.'/create/'.$data_out['url_conf'].'/'.$this->sess->userdata('a_login_id');
                //个性化配置保存在config/person/create中
				$conf_person=array();
				if(file_exists($path_conf_person))//检查文件或目录是否存在
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
				
				//为零则说明没有该权限,有值则说明有这个权限
				if( ($acl_list & pow(2,ACL_PROC_ORG_CHECK) ) == 0
				 && ($acl_list & pow(2,ACL_PROC_ORG_SUPER) ) == 0
				)
				{
					$data_out['op_disable'][]='btn_del';
					
					$data_out['field_view'][]='content[o_id_standard]';
					$data_out['field_view'][]='content[o_id_standard_s]';
				}

			break;
			case STAT_ACT_VIEW:
				$data_out['title']='查看'.$this->title.$title_field;
				
				$data_out['op_disable'][]='btn_save';
				$data_out['op_disable'][]='btn_del';
				$data_out['op_disable'][]='btn_person';
				$data_out['op_disable'][]='btn_import';
				
				$data_out['field_view']=array_unique(array_merge($data_out['field_view'],$data_out['field_edit']));
				
			break;
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

					//验证机构代码
					if( ! empty( element('o_code_register',$data_post['content']) ) )
					{

						if(  empty(element('o_id_exist',$data_post['content']))){

							$where_check=' AND o_id != \''.element('o_id',$data_db['content']).'\'';

							$check=$this->m_check->unique('sys_org','o_code_register',element('o_code_register',$data_post['content']),$where_check);
							
							if( ! $check )
							{
								$rtn['err']['content[o_code_register]']='组织机构代码 【'.element('o_code_register',$data_post['content']).'】已存在，不可重复创建！';
								
								if($data_get['act'] == STAT_ACT_CREATE)
								$rtn['err']['o_id_exist']='组织机构代码 【'.element('o_code_register',$data_post['content']).'】已存在，<br>是否存为【机构别名】?';
								
								$check_data=FALSE;
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
						
						$data_save['content']['o_code']=$this->get_code($data_save['content']);
						$data_save['content']['o_status'] = O_STATUS_YES;
						
						if( ! empty(element('o_id_exist',$data_post['content']))){
							
							$data_save['content']['o_name']= element('o_name',$data_post['content']);
							
							$data_save['content']['o_id_standard']=$this->m_base->get_field_where('sys_org','o_id_standard',
								" AND o_code_register = '{$data_save['content']['o_code_register']}'");
							
							$data_save['content']['o_code_register']='';
						}

						$rtn=$this->add($data_save['content']);

						if( ! empty(element('o_id_exist',$data_post['content']))){
							$rtn['id']=$data_save['content']['o_id_standard'];
							$data_save['content_log']['log_note']='创建机构别名';
						}
						
						//联系人
						if( ! empty(element('org_c',$data_save['content']) ) )
						{
							$arr_save=array(
								'c_org' => $rtn['id'],
							);
							
							$this->m_base->save_datatable('sys_contact',
							$data_save['content']['org_c'],
							'[]',
							$arr_save,
							'm_org',
							'save_org_c',
							'act');
						}

						//收货信息
						if( ! empty(element('org_addr',$data_save['content']) ) )
						{
							$list_addr_save = json_decode($data_save['content']['org_addr'],TRUE);
	
							if(count( $list_addr_save ) > 0 )
							{
								$this->m_table_op->load('sys_org_addr');
								foreach ($list_addr_save as $v) {
	
									$data_save['org_addr']=$v;
									$data_save['org_addr']['o_id'] = $rtn['id'];
									$this->m_table_op->add($data_save['org_addr']);
								}
							}
						}
						//账户信息
						if( ! empty(element('org_account',$data_save['content']) ) )
						{
							$list_account_save = json_decode($data_save['content']['org_account'],TRUE);
	
							if(count( $list_account_save ) > 0 )
							{
								$this->m_table_op->load('sys_org_account');
								foreach ($list_account_save as $v) {
	
									$data_save['org_account']=$v;
									$data_save['org_account']['o_id'] = $rtn['id'];
									$this->m_table_op->add($data_save['org_account']);
								}
							}
						}

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
						
						$rtn=$this->update($data_save['content']);

						//联系人
						if( ! empty(element('org_c',$data_save['content']) ) )
						{
							$arr_save=array(
								'c_org' => element('o_id',$data_get),
							);
							
							$this->m_base->save_datatable('sys_contact',
							$data_save['content']['org_c'],
							$data_db['content']['org_c'],
							$arr_save,
							'm_org',
							'save_org_c',
							'act');
						}
						
						//收货信息
						if( ! empty(element('org_addr',$data_save['content']) ) )
						{
							$list_addr_save = json_decode($data_save['content']['org_addr'],TRUE);
							$list_addr_db = json_decode($data_db['content']['org_addr'],TRUE);

							if(count( $list_addr_db ) > 0 )
							{
								foreach ($list_addr_db as $k=>$v) {
									unset($list_addr_db[$k]);
									$list_addr_db[$v['o_addr_id']]=$v;
								}
							}

							if(count( $list_addr_save ) > 0 )
							{
								$this->m_table_op->load('sys_org_addr');
								foreach ($list_addr_save as $v) {

									$data_save['org_addr']=$v;
									$data_save['org_addr']['o_id'] = element('o_id',$data_get);
									if(isset($v['o_addr_id']) && isset($list_addr_db[$v['o_addr_id']]))
									{
										$this->m_table_op->update($data_save['org_addr']);

										unset($list_addr_db[$v['o_addr_id']]);
									}
									else
									{
										$this->m_table_op->add($data_save['org_addr']);
									}
								}
							}
							if(count( $list_addr_db ) > 0 )
							{
								$this->m_table_op->load('sys_org_addr');
								foreach ($list_addr_db as $k=>$v) {
									$this->m_table_op->del($k);
								}
							}
						}

						//账户信息
						if( ! empty(element('org_account',$data_save['content']) ) )
						{
							$list_account_save = json_decode($data_save['content']['org_account'],TRUE);
							$list_account_db = json_decode($data_db['content']['org_account'],TRUE);

							if(count( $list_account_db ) > 0 )
							{
								foreach ($list_account_db as $k=>$v) {
									unset($list_account_db[$k]);
									$list_account_db[$v['oacc_id']]=$v;
								}
							}

							if(count( $list_account_save ) > 0 )
							{
								$this->m_table_op->load('sys_org_account');
								foreach ($list_account_save as $v) {

									$data_save['org_account']=$v;
									$data_save['org_account']['o_id'] = element('o_id',$data_get);
									if(isset($v['oacc_id']) && isset($list_account_db[$v['oacc_id']]))
									{
										$this->m_table_op->update($data_save['org_account']);

										unset($list_account_db[$v['oacc_id']]);
									}
									else
									{
										$this->m_table_op->add($data_save['org_account']);
									}
								}
							}
							if(count( $list_account_db ) > 0 )
							{
								$this->m_table_op->load('sys_org_account');
								foreach ($list_account_db as $k=>$v) {
									$this->m_table_op->del($k);
								}
							}
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
				
				$rtn=$this->del(element('o_id',$data_get));

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
	    
	    $data_out['log']=json_encode(element('log', $data_out));
		
		$data_out['log_time']=$this->input->post('log_time');
		$data_out['log_a_login_id']=$this->input->post('log_a_login_id');
		$data_out['log_c_name']=$this->input->post('log_c_name');
		$data_out['log_act']=$this->input->post('log_act');
		$data_out['log_note']=$this->input->post('log_note');
	    
	    $data_out['db_time_create']=element('db_time_create', $data_db['content']);
	    $data_out['code']=element('o_code', $data_db['content']);
	    
	    $data_out[$this->pk_id]=element($this->pk_id,$data_get);
	    
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
	 * 机构联系人
	 * @param  $data_save
	 */
	function save_org_c($arr_save,$act)
	{
		$this->load->model('proc_contact/m_proc_contact');
		$this->load->model('proc_contact/m_contact');
		
		$arr_get=array();
		$arr_post=array();
				
		switch ($act) {
			case STAT_ACT_CREATE:
				$arr_get['act']=STAT_ACT_CREATE;
				$arr_post['btn']='save';
				$arr_post['content']=$arr_save;
				$arr_post['flag_more']=TRUE;
				$rtn = $this->m_contact->load($arr_get,$arr_post);
				break;
			case STAT_ACT_EDIT:
				
				$arr_get['c_id']=$arr_save['c_id'];
				$arr_get['act']=STAT_ACT_EDIT;
				$arr_post['content']=$arr_save;
				$arr_post['btn']='save';
				$arr_post['flag_more']=TRUE;
				
				$this->m_contact->load($arr_get,$arr_post);
				
				break;
			case STAT_ACT_REMOVE:
				
				$arr_get['c_id']=$arr_save['c_id'];
				$arr_get['act']=STAT_ACT_EDIT;
				$arr_post=array();
				$arr_post['btn']='del';
				$arr_post['flag_more']=TRUE;
				
				$this->m_contact->load($arr_get,$arr_post);
				
				break;
		}
	}

}