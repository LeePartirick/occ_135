<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 *  
    联系人
 */
class M_contact extends CI_Model {
	
	//@todo 主表配置
	private $table_name='sys_contact';
	private $pk_id='c_id';
	private $table_form;
	private $arr_table_form=array();
	private $title='联系人';
	private $model_name = 'm_contact';
	private $url_conf = 'proc_contact/contact/edit';
	private $proc_id = 'proc_contact';
	
 	public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->m_define();
        
         //读取表结构
        $this->config->load('db_table/'.$this->table_name, FALSE,TRUE);
        $this->table_form=$this->config->item($this->table_name);
        
         //读取表结构
        $this->config->load('db_table/sys_contact_add', FALSE,TRUE);
        $this->arr_table_form['sys_contact_add']=$this->config->item('sys_contact_add');
    }
    
	/**
     * 
     * 定义
     */
	public function m_define()
    {
    	//@todo 定义
    	if( defined('LOAD_M_CONTACT') ) return;
    	define('LOAD_M_CONTACT', 1);
    	
    	//define
    	$GLOBALS['m_contact']['text']=array();
    	
    	// 性别
		define('C_SEX_M', 1); // 男
		define('C_SEX_W', 2); // 女
		
    	$GLOBALS['m_contact']['text']['c_sex']=array(
    		C_SEX_M=>'男',
			C_SEX_W=>'女'
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
    	$acl_list= $this->m_proc_contact->get_acl();
    	
    	$msg='';
    	/************权限验证*****************/
    	
    	//如果有超级权限，TRUE
    	if( ($acl_list & pow(2,ACL_PROC_CONTACT_SUPER)) != 0 )
    	{
    		return TRUE;
    	}
    	
    	$check_acl=FALSE;
    	
    	if( element('c_id', $data_db['content']) == $this->sess->userdata('c_id') )
        {
        	$check_acl=TRUE;
        }
    	
    	if( ! $check_acl 
    	 && ($acl_list & pow(2,ACL_PROC_CONTACT_USER)) != 0 
    	)
	    {
	     	$check_acl=TRUE;
	    }
	    
	    if( ! $check_acl )
	    {
			if( ! $msg )
			$msg = '您没有【联系人】的【操作】权限不可进行操作！' ;
			
			redirect('base/main/show_err/msg/'.fun_urlencode($msg));
	    }
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
		$arr_search['field']='c.*
							  ,c_add.c_addr
							  ,c_add.c_post_code
							  ,c_add.c_note';
    	$arr_search['from']=$this->table_name.' c
    						LEFT JOIN sys_contact_add c_add ON
    						( c_add.c_id = c.c_id )';
		$arr_search['where']='AND c.'.$this->pk_id.' = ? ';
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
        
        if($rtn['rtn'])
        $rtn=$this->m_db->insert($data_save['content'],'sys_contact_add');
        	
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
        $rtn=$this->m_db->update('sys_contact_add',$data_save['content'],$where);
        
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
			'hr_offer.c_id',
			'hr_info.c_id'
		);
		
		if(count($arr_link) > 0)
		{
			foreach ($arr_link as $v ) {
				$arr_tmp = explode('.', $v);
				
			}
		}
		
    	$this->db->trans_begin();
		
		if($rtn['rtn'])
        $rtn=$this->m_db->delete($this->table_name,$where);
        
        if($rtn['rtn'])
        $rtn=$this->m_db->delete('sys_contact_add',$where);
        	
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
     * 显示年龄
     */
    public function show_c_age($v,$v_arr=array())
    {
    	$age=date("Y")-date('Y', strtotime($v));
    	return $age;
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
    		'sys_contact[c_name]',
    		'sys_contact[c_login_id]',
    		'sys_contact[c_sex]',
    		'sys_contact[c_code_person]',
    		'sys_contact[c_birthday]',
    		'sys_contact[c_tel]',
    		'sys_contact[c_email]',
    		'sys_contact[c_phone]',
    		'sys_contact_add[c_post_code]',
    		'sys_contact_add[c_addr]',
    		'sys_contact_add[c_note]',
    	);
    	
    	$conf['field_required']=array(
    		'sys_contact[c_name]',
    		'sys_contact[c_sex]',
    	);
    	
    	$conf['field_define']=array(
    		'sys_contact[c_sex]'=>$GLOBALS['m_contact']['text']['c_sex'],
    	);
    	
    	$conf['table_form']=array(
    		$this->table_name=>$this->table_form,
    		'sys_contact_add'=>$this->arr_table_form['sys_contact_add'],
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
			'content[c_name]',
			'content[c_sex]',
			'content[c_org]',
		);
		
		//编辑数组
		$data_out['field_edit']=array(
			'content[db_time_update]',
			'content[c_org]',
			'content[c_org_s]',
			'content[c_name]',
			'content[c_sex]',
			'content[c_code_person]',
			'content[c_birthday]',
			'content[c_img]',
			'content[c_img_show]',
			'content[c_login_id]',
			'content[a_id]',
			'content[c_tel]',
			'content[c_tel_info]',
			'content[c_phone]',
			'content[c_post_code]',
			'content[c_email]',
			'content[c_addr]',
			'content[c_note]',
		);
		
		//只读数组
		$data_out['field_view']=array(
			'content[c_id]'
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
		$data_out['json_field_define']['c_sex']=get_html_json_for_arr($GLOBALS['m_contact']['text']['c_sex']);
		
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
							$msg= '联系人【'.element($this->pk_id,$data_get).'】不存在！';
							
							if($flag_more)
							{
								$rtn['result'] = FALSE;
								$rtn['msg_err'] = $msg;
									
								if( $flag_more )
								return $rtn;
							}
							
							redirect('base/main/show_err/msg/'.fun_urlencode($msg));
						}
					
					}
					
					if( ! empty($data_db['content']['c_birthday']) )
					{
						$data_db['content']['c_age']=date("Y")-date('Y', strtotime($data_db['content']['c_birthday']));
						$data_db['content']['c_age'].='岁';
					}
					
					$path_img=$this->config->item('base_photo_path').element('c_img',$data_db['content']).'.jpg';
					if(file_exists($path_img))
	        		$data_db['content']['c_img_show']='data:image/jpeg;base64,'.getImgBaseStr($path_img);
	        		
	        		if($data_db['content']['c_org'])
					$data_db['content']['c_org_s']=$this->m_base->get_field_where('sys_org','o_name',"AND o_id = '{$data_db['content']['c_org']}'");
					
				} catch (Exception $e) {
				}
			break;
		}
		
		/************权限验证*****************/
		//@todo 权限验证
		$acl_list= $this->m_proc_contact->get_acl();
		
		$this->check_acl($data_db,$acl_list);
		
		/************显示配置*****************/
		//@todo 显示配置
		$title_field='';
		
		switch ($data_get['act']) {
			case STAT_ACT_CREATE:
				$data_out['title']='创建'.$this->title;
				
				$data_out['op_disable'][]='btn_del';
				$data_out['op_disable'][]='btn_log';
				
				$data_out['field_view'][]='content[c_login_id]';
				
				//创建默认值
				$data_db['content']['c_sex'] = C_SEX_M;
				
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
						
						switch ($arr_tmp['field'])
						{
							case 'c_org_s':
								$data_db['content'][$arr_tmp['field']]=fun_urldecode(element($arr_tmp['field'] ,$data_get));
								break;
							default:
								$data_db['content'][$arr_tmp['field']]=urldecode(element($arr_tmp['field'] ,$data_get));
						}
					}
				}
			break;
			case STAT_ACT_EDIT:
				$data_out['title']='编辑'.$this->title.$title_field;
				
				$data_out['op_disable'][]='btn_person';
				$data_out['op_disable'][]='btn_import';
				
//				if( ! empty(element('c_code_person', $data_db['content'])) )
//				$data_out['field_view'][]='content[c_birthday]';
				
				$data_out['field_view'][]='content[c_login_id]';
				
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
		
		//@todo 节点权限显示隐藏
		if(element('flag_edit_more', $data_get))
		{
			$data_out['field_required']=array();
			
			$data_out['op_disable'][] = 'content[c_name]';
			$data_out['op_disable'][] = 'content[c_sex]';
			$data_out['op_disable'][] = 'content[c_img]';
			
			$data_out['op_disable'][]='btn_log';
			$data_out['op_disable'][]='btn_del';
			
			$data_out['title'] = '批量编辑'.$this->title.'-请勾选要保存的字段';
		}
		
		if(  element('fun_no_db', $data_get) )
		{
			$data_out['op_disable'][] = 'content[c_img]';
			$data_out['op_disable'][]='btn_log';
		}
		
		switch(  element('from', $data_get) )
		{
			case 'org':
				$data_out['field_view'][]='content[c_org_s]';
				$data_out['field_view'][]='content[c_org]';
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
							
							if( ! is_array(element('content', $data_post)) 
							 || empty(element($arr_tmp['field'],$data_post['content'])))
							$data_post['content'][$arr_tmp['field']] = element($arr_tmp['field'],$data_db['content']);
							
							if( empty(element($arr_tmp['field'],$data_post['content'])) 
							 && element($arr_tmp['field'],$data_post['content']) !== '0'
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
					
					//验证身份证
					if( ! empty( element('c_code_person',$data_post['content']) ) )
					{ 
						$info_c_code_person = getIDCardInfo($data_post['content']['c_code_person']);
						
						if( $info_c_code_person['error'] != 2 ) 
						{
							$rtn['err']['content[c_code_person]']='身份证 【'.element('c_code_person',$data_post['content']).'】不合法！';
							$check_data=FALSE;
						}
						else 
						{
							$where_check=' AND c_id != \''.element('c_id',$data_db['content']).'\'';
									
							$check=$this->m_check->unique('sys_contact','c_code_person',element('c_code_person',$data_post['content']),$where_check);
							if( ! $check )
							{
								$rtn['err']['content[c_code_person]']='身份证【 '.element('c_code_person',$data_post['content']).'】已存在，不可重复创建！';
								$check_data=FALSE;
							}
						}
					}
					
					//验证手机
					if( ! empty( element('c_tel',$data_post['content']) ) )
					{ 
						$where_check=' AND c_id != \''.element('c_id',$data_db['content']).'\'';
						$check=$this->m_check->unique('sys_contact','c_tel',element('c_tel',$data_post['content']),$where_check);
						if( ! $check )
						{
							$rtn['err']['content[c_tel]']='手机 【'.element('c_tel',$data_post['content']).'】已存在，不可重复创建！';
							$check_data=FALSE;
						}
						
						if( empty( element('c_tel_info',$data_post['content']) ) )
						{
							$check=$this->m_check->tele(element('c_tel',$data_post['content']),'');
							
							if( ! $check )
							{
								$rtn['err']['content[c_tel]']='手机【'.element('c_tel',$data_post['content']).'】不合法！';
								$check_data=FALSE;
							}
						}
					}
					
					//验证关联账户
					if( ! empty( element('c_login_id',$data_post['content']) ) )
					{ 
						$where_check=' AND c_id != \''.element('c_id',$data_db['content']).'\'';
								
						$check=$this->m_check->unique('sys_contact','c_login_id',element('c_login_id',$data_post['content']),$where_check);
						if( ! $check )
						{
							$rtn['err']['content[c_login_id]']='关联账户【 '.element('c_login_id',$data_post['content']).'】已存在，不可重复创建！';
							$check_data=FALSE;
						}
						
					}
					
					switch(  element('from', $data_get) )
					{
						case 'org':
							if( empty( element('c_tel',$data_post['content']) ) 
							 && empty( element('c_phone',$data_post['content']) ) )
							{
								$rtn['err']['content[c_tel]']='请填写手机或固定电话！';
								$rtn['err']['content[c_phone]']='请填写手机或固定电话！';
								$check_data=FALSE;
							}
						break;
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
						if( ! in_array('content['.$k.']',$data_out['field_view'])
							&& ! in_array('content['.$k.']',$data_out['op_disable'])
							&& in_array('content['.$k.']',$data_out['field_edit']) )
							$data_save['content'][$k]=$v;
					}
				}
				
				if( ! empty( element('c_code_person', $data_save['content']) ) )
				$data_save['content']['c_birthday'] = $info_c_code_person['birthday'];
				
				if( ! empty($data_save['content']['c_img_show']) )
        		{
        			if(strstr($data_save['content']['c_img_show'] ,','))
        			$data_img=substr(strstr($data_save['content']['c_img_show'] ,','),1);
        			else 
        			$data_img=$data_save['content']['c_img_show'];
        			
        			if( empty(element('c_img',$data_db['content'])) )
        			{
        				$data_save['content']['c_img'] =$data_db['content']['c_img'] =get_guid();
        			}
        			
        			$path_img=$this->config->item('base_photo_path').$data_db['content']['c_img'].'.jpg';
        			
        			$data_img= base64_decode($data_img);
        			
        			write_file($path_img, $data_img, 'w');
        			
        			$data_save['content']['c_img_show']='';
        		}
        		
        		$data_db['content']['c_img_show']='';
        		
        		if( ! empty( element('c_login_id', $data_save['content']) ) 
        		 && empty( element('a_id', $data_save['content']) ) )
				{
					$data_save['content']['a_id']=$this->m_base->get_field_where('sys_account','a_id'," AND a_login_id = '{$data_save['content']['c_login_id']}'");
				}
				
				/************事件处理*****************/
				switch ($data_get['act']) {
					case STAT_ACT_CREATE:
						
						$rtn=$this->add($data_save['content']);

						if( ! empty( element('a_id', $data_save['content']) ) )
						{
							$data_save['content_a']['a_id']=element('a_id', $data_save['content']);
							$data_save['content_a']['a_name']=$data_save['content']['c_name'];
							$this->m_table_op->load('sys_account');
							$this->m_table_op->update($data_save['content_a']);
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
						
						if( ! empty( element('a_id', $data_save['content']) ) )
						{
							$data_save['content_a']['a_id']=element('a_id', $data_save['content']);
							$data_save['content_a']['a_name']=$data_save['content']['c_name'];
							$this->m_table_op->load('sys_account');
							$this->m_table_op->update($data_save['content_a']);
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
					$path_img=$this->config->item('base_photo_path').element('c_img',$data_db['content']).'.jpg';
					if(file_exists($path_img))
					@unlink($path_img);
					
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
	    $data_out['code']='';
	    
	    $data_out['fun_no_db']=element('fun_no_db', $data_get);
	    $data_out['data_db_post'] = $this->input->post('data_db');
	    
	    $data_out['flag_edit_more']=element('flag_edit_more', $data_get);
	    
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
		$arr_view[]='proc_contact/fun_js';
		
		$this->m_view->load_view($arr_view,$data_out);
	}
    public function show_change_org_c($id,$field,$v)
    {
        $rtn=array();
        $rtn['id'] = $id;
        $rtn['field'] = $field;
        $rtn['act'] = STAT_ACT_EDIT;
        $rtn['err_msg']= $v[$field];

        switch ($field)
        {

        }

        $rtn['err_msg']='变更前:'.$rtn['err_msg'];

        return $rtn;
    }
}