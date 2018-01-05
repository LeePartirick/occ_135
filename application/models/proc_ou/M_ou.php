<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 *  
    团队
 */
class M_ou extends CI_Model {
	
	//@todo 主表配置
	private $table_name='sys_ou';
	private $pk_id='ou_id';
	private $table_form;
	private $arr_table_form=array();
	private $title='团队';
	private $model_name = 'm_ou';
	private $url_conf = 'proc_ou/ou/edit';
	private $proc_id = 'proc_ou';
	
 	public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->m_define();
        
         //读取表结构
        $this->config->load('db_table/'.$this->table_name, FALSE,TRUE);
        $this->table_form=$this->config->item($this->table_name);
        
        $this->load->model('proc_org/m_org');
        
          //读取表结构
        $this->config->load('db_table/sys_org', FALSE,TRUE);
        $this->arr_table_form['sys_org']=$this->config->item('sys_org');
        
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
    	if( defined('LOAD_M_OU') ) return;
    	define('LOAD_M_OU', 1);
    	
    	//define
    	
    	// 团队分类
		define('OU_CLASS_OU', 1); // 组织架构
		define('OU_CLASS_GP', 2); // 团队
		
    	$GLOBALS['m_ou']['text']['ou_class']=array(
    		OU_CLASS_OU=>'组织架构',
			OU_CLASS_GP=>'团队'
    	);
    	
    	// 组织架构
		define('OU_LEVEL_WEB', 1); // 服务网
		define('OU_LEVEL_ORG', 2); // 分公司
		define('OU_LEVEL_CORG',3); // 子公司
		define('OU_LEVEL_BSC', 4); // 办事处
		define('OU_LEVEL_BM', 5); // 部门
		
    	$GLOBALS['m_ou']['text']['ou_level']=array(
    		OU_LEVEL_WEB=>'服务网',
			OU_LEVEL_ORG=>'分公司',
			OU_LEVEL_CORG=>'子公司',
			OU_LEVEL_BSC=>'办事处',
			OU_LEVEL_BM=>'部门',
    	);
    	
    	// 标签
		define('OU_TAG_BUD', 1); //预算部门
		define('OU_TAG_HR', 2); // 人事部门
		
    	$GLOBALS['m_ou']['text']['ou_tag']=array(
    		OU_TAG_BUD=>'预算',
			OU_TAG_HR=>'人事',
    	);
    	
    	// 状态
		define('OU_STATUS_RUN', 1); //运行
		define('OU_STATUS_FQ', 2); // 废弃
		
    	$GLOBALS['m_ou']['text']['ou_status']=array(
    		OU_STATUS_RUN=>'运行',
			OU_STATUS_FQ=>'废弃',
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
    	$acl_list= $this->m_proc_ou->get_acl();
    	
    	$msg='';
    	/************权限验证*****************/
    	
    	//如果有超级权限，TRUE
    	if( ($acl_list & pow(2,ACL_PROC_OU_SUPER)) != 0 )
    	{
    		return TRUE;
    	}
    	
    	$check_acl=FALSE;
    	
    	if( ! $check_acl 
    	 && ($acl_list & pow(2,ACL_PROC_OU_USER)) != 0 
    	)
	    {
	     	$check_acl=TRUE;
	    }
	    
	    if( ! $check_acl )
	    {
			if( ! $msg )
			$msg = '您没有【团队管理】的【操作】权限不可进行操作！' ;
			
			redirect('base/main/show_err/msg/'.fun_urlencode($msg));
	    }
    }
    
	/**
     * 
     */
	public function get_code($data_save=array())
    {
    	$where='';
    	 
    	$pre='OU'.date("Ym");
    	$where .= " AND ou_code LIKE  '{$pre}%'"; 
    	
    	$max_code=$this->m_db->get_m_value('sys_ou','ou_code',$where);
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
        
    	//树形路径			
		if(isset($data_save['content']['ou_parent']) )
		{
			if( empty( element('ou_parent',$data_save['content']) ) )	
			{
				$data_save['content']['ou_parent']='base';
				$data_save['content']['ou_parent_path']=$data_save['content']['ou_id'];
			}
			else
			{
				$data_save['content']['ou_parent_path']=$this->m_base->get_parent_path('sys_ou','ou_id','ou_parent',$data_save['content']['ou_parent']);
				$data_save['content']['ou_parent_path'].=','.$data_save['content']['ou_id'];
				$data_save['content']['ou_parent_path']=trim($data_save['content']['ou_parent_path'],',');
			}
			
			$arr_search=array();
			$arr_search['field']='ou_id';
			$arr_search['from']='sys_ou';
			$arr_search['where']=' AND ou_level in ? AND ou_id IN ? ';
			$arr_search['value'][]=array(OU_LEVEL_ORG,OU_LEVEL_CORG);
			$arr_search['value'][]=explode(',', $data_save['content']['ou_parent_path']);
			$rs=$this->m_db->query($arr_search);
			if(count($rs['content']) > 0)
			$data_save['content']['ou_org'] = $rs['content'][0]['ou_id'];
		}
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
		
    	//树形路径			
		if(isset($data_save['content']['ou_parent']) )
		{
			if( empty( element('ou_parent',$data_save['content']) ) )	
			{
				$data_save['content']['ou_parent']='base';
				$data_save['content']['ou_parent_path']=$data_save['content']['ou_id'];
			}
			else
			{
				$data_save['content']['ou_parent_path']=$this->m_base->get_parent_path('sys_ou','ou_id','ou_parent',$data_save['content']['ou_parent']);
				$data_save['content']['ou_parent_path'].=','.$data_save['content']['ou_id'];
				$data_save['content']['ou_parent_path']=trim($data_save['content']['ou_parent_path'],',');
			}
			
			$arr_search=array();
			$arr_search['field']='ou_id';
			$arr_search['from']='sys_ou';
			$arr_search['where']=' AND ou_level in ? AND ou_id IN ? ';
			$arr_search['value'][]=array(OU_LEVEL_ORG,OU_LEVEL_CORG);
			$arr_search['value'][]=explode(',', $data_save['content']['ou_parent_path']);
			$rs=$this->m_db->query($arr_search);
			if(count($rs['content']) > 0)
			$data_save['content']['ou_org'] = $rs['content'][0]['ou_id'];
		}
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
   			'sys_contact.c_ou_2',
    		'sys_contact.c_ou_3',
    		'sys_contact.c_ou_4',
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
		
    	//树形路径			
		$data_db['content']=$this->get($id);
		
		if($rtn['rtn'])
        $rtn=$this->m_db->delete($this->table_name,$where);
        
        $sql="UPDATE sys_ou 
		SET ou_parent_path =  REPLACE (ou_parent_path , '{$data_db['content']['ou_parent_path']},' ,''),
			ou_parent = 'base'
		WHERE find_in_set ('{$id}' ,ou_parent_path) ";
		
		if($rtn['rtn'])
		$rtn=$this->m_db->exec_sql($sql);
        
        //删除对应机构
        $where=array();
        $where['o_id']=$id;
        if($rtn['rtn'])
        $rtn=$this->m_db->delete('sys_org',$where);
        
        if($rtn['rtn'])
        $rtn=$this->m_db->delete('sys_org_detail',$where);
        
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
    		'sys_ou[ou_name]',
    		'sys_ou[ou_class]',
    		'sys_ou[ou_level]',
    		'sys_ou[ou_org]',
    		'sys_ou[ou_parent]',
    		'sys_ou[ou_note]',
    	);
    	
    	$conf['field_required']=array(
    		'sys_ou[ou_name]',
    		'sys_ou[ou_status]',
    		'sys_ou[ou_class]',
    	);
    	
    	$conf['field_define']=array(
    		'sys_ou[ou_class]'=>$GLOBALS['m_ou']['text']['ou_class'],
    		'sys_ou[ou_level]'=>$GLOBALS['m_ou']['text']['ou_level'],
    		'sys_ou[ou_status]'=>$GLOBALS['m_ou']['text']['ou_status'],
    	);
    	
    	 //读取表结构
        $this->config->load('db_table/sys_org', FALSE,TRUE);
        
    	$conf['table_form']=array(
    		'sys_ou'=>$this->table_form,
    		'sys_org'=>$this->config->item('sys_org')
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
			'content[ou_name]',
			'content[ou_class]',
			'content[ou_level]',
		);
		
		//编辑数组
		$data_out['field_edit']=array(
			'content[ou_org]',
			'content[ou_org_s]',
			'content[db_time_update]',
			'content[ou_name]',
			'content[ou_class]',
			'content[ou_parent_s]',
			'content[ou_parent]',
			'content[ou_level]',
			'content[ou_status]',
			'content[ou_tag]',
			'content[ou_note]',
		
			'content[ou_org_pre]',
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
			'content[o_web]'
		);
		
		//只读数组
		$data_out['field_view']=array(
			'content[ou_org_s]',
			'content[o_type]',
		);
		
		$data_out['op_disable']=array(
		);
		
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
		$data_out['json_field_define']['ou_class']=get_html_json_for_arr($GLOBALS['m_ou']['text']['ou_class']);
		$data_out['json_field_define']['ou_level']=get_html_json_for_arr($GLOBALS['m_ou']['text']['ou_level']);
		$data_out['json_field_define']['ou_tag']=get_html_json_for_arr($GLOBALS['m_ou']['text']['ou_tag']);
		$data_out['json_field_define']['ou_status']=get_html_json_for_arr($GLOBALS['m_ou']['text']['ou_status']);
		$data_out['json_field_define']['o_type']=get_html_json_for_arr($GLOBALS['m_org']['text']['o_type']);
		$data_out['json_field_define']['o_licence']=get_html_json_for_arr($GLOBALS['m_org']['text']['o_licence']);
		
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
										case 'ou_tag':
										
											if( ! is_array($data_db['content'][$k] ))
											$data_db['content'][$k] =explode(',', $data_db['content'][$k] );
											
											$data_out['log']['content['.$k.']']='变更前:';
											
											if(count($data_db['content'][$k] ) > 0)
											{
												foreach ($data_db['content'][$k] as $v1) {
													$data_out['log']['content['.$k.']'].=element($v1, $GLOBALS[$this->model_name]['text'][$k]).',';
												}
												
												$data_out['log']['content['.$k.']']=trim($data_out['log']['content['.$k.']'],',');
											}
											
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
						
						if( empty($data_db['content'][$this->pk_id]) )
						{
							$msg= '团队【'.element($this->pk_id,$data_get).'】不存在！';
							
							if($flag_more)
							{
								$rtn['result'] = FALSE;
								$rtn['msg_err'] = $msg;
									
								if( $flag_more )
								return $rtn;
							}
							
							redirect('base/main/show_err/msg/'.fun_urlencode($msg));
						}
						
					 	$this->m_table_op->load('sys_org');
					 	$data_db['content_o']=$this->m_table_op->get(element($this->pk_id,$data_get));
						
						$this->m_table_op->load('sys_org_detail');
						$data_db['content_od']=$this->m_table_op->get(element($this->pk_id,$data_get));
						
						$data_db['content'] = array_merge($data_db['content_o'],$data_db['content_od'],$data_db['content']);
					}
					
					$data_db['content']['ou_tag']=explode(',', $data_db['content']['ou_tag']);
					
					if($data_db['content']['ou_parent'])
					$data_db['content']['ou_parent_s']=$this->m_base->get_field_where('sys_ou','ou_name',"AND ou_id = '{$data_db['content']['ou_parent']}'");
					
					if($data_db['content']['ou_org'])
					$data_db['content']['ou_org_s']=$this->m_base->get_field_where('sys_ou','ou_name',"AND ou_id = '{$data_db['content']['ou_org']}'");
					
					$data_db['content']['o_type']=O_TYPE_OU;
					
				} catch (Exception $e) {
				}
			break;
		}
		
		/************权限验证*****************/
		//@todo 权限验证
		$acl_list= $this->m_proc_ou->get_acl();
		
		$this->check_acl($data_db,$acl_list);
		
		/************显示配置*****************/
		//@todo 显示配置
		$title_field='';
		
		switch ($data_get['act']) {
			case STAT_ACT_CREATE:
				$data_out['title']='创建'.$this->title;
				
				$data_out['op_disable'][]='btn_del';
				$data_out['op_disable'][]='btn_log';
				
				$data_out['field_view'][]='content[ou_class]';
				
				//创建默认值
				$data_db['content']['ou_class']=OU_CLASS_OU;
				$data_db['content']['ou_level']=OU_LEVEL_BM;
				$data_db['content']['ou_status']=OU_STATUS_RUN;
				
				$data_db['content']['o_type']=O_TYPE_OU;
				
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
				
				$data_out['field_view'][]='content[ou_class]';
				
				
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
					//分公司、子公司、办事处填写简写
					if( element('ou_level',$data_post['content']) == OU_LEVEL_ORG 
					 || element('ou_level',$data_post['content']) == OU_LEVEL_CORG 
					 || element('ou_level',$data_post['content']) == OU_LEVEL_BSC)
					{
						$data_out['field_required'][]='content[ou_org_pre]';
					}
					
					//分公司、子公司填写机构信息
					if( element('ou_level',$data_post['content']) == OU_LEVEL_ORG 
					 || element('ou_level',$data_post['content']) == OU_LEVEL_CORG )
					{
					 	$data_out['field_required'][]='content[o_code_register]';
					 	
					 	if( mb_strlen( element('ou_name',$data_post['content']) ) < 8 )
					 	{
					 		$rtn['err']['content[ou_name]']='分公司/子公司名称长度应大于8！';
							$check_data=FALSE;
					 	}
					}
					
					//必填验证
					if(count($data_out['field_required'])>0)
					{
						foreach ($data_out['field_required'] as $v) {
							
							$arr_tmp=split_table_field($v);
							
							if(empty(element($arr_tmp['field'],$data_post['content'])))
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
					
				}
				
				//验证唯一
				if( ! empty(element('o_code_register',$data_post['content'])) )
				{
					$where_check=' AND o_id != \''.element('o_id',$data_db['content']).'\'';
							
					$check=$this->m_check->unique('sys_org','o_code_register',element('o_code_register',$data_post['content']),$where_check);
					if( ! $check )
					{
						$rtn['err']['content[o_code_register]']='组织机构代码【'.element('o_code_register',$data_post['content']).'】已存在，不可重复创建！';
						$check_data=FALSE;
					}
				}
				
				if( ! empty( element('ou_parent',$data_post['content']) ) 
				 && element('ou_parent',$data_post['content']) != 'base')
				{
					$arr_search_ac=array();
			        $arr_search_ac['page']=1;
					$arr_search_ac['rows']=1;
					$arr_search_ac['field']='sys_ou.ou_name';
					$arr_search_ac['from']='sys_ou';
					$arr_search_ac['where']=" AND ou_id = ? ";
					$arr_search_ac['value'][]=$data_post['content']['ou_parent'];
					
					if( ! empty( element( 'ou_id' , $data_db['content'] )) )
					{
						$arr_search_ac['where'].=" AND ! FIND_IN_SET('{$data_db['content']['ou_id']}' ,ou_parent_path) ";
					}
					
					$rs_ac=$this->m_db->query($arr_search_ac);
					
					if(count($rs_ac['content']) == 0 )
					{
						$rtn['err']['content[ou_parent_s]']='上级团队输入值不合法！';
						$check_data=FALSE;
					}
				}
				
				//验证唯一
				if( ! empty(element('ou_name',$data_post['content'])) )
				{
					if( ! element('ou_parent',$data_post['content']) )
					$data_post['content']['ou_parent']='base';
					
					$where_check=' AND ou_id != \''.element('ou_id',$data_db['content']).'\' AND ou_parent =\''.element('ou_parent',$data_post['content']).'\'';
							
					$check=$this->m_check->unique('sys_ou','ou_name',element('ou_name',$data_post['content']),$where_check);
					if( ! $check )
					{
						$rtn['err']['content[ou_name]']='团队名称【'.element('ou_name',$data_post['content']).'】在其上级团队中已存在，不可重复创建！';
						$check_data=FALSE;
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
				
				if( ! empty(element('ou_tag',$data_save['content'])) )
				{
					if( is_array(element('ou_tag',$data_save['content'])) )
					{
						$data_save['content']['ou_tag'] = implode(',', $data_save['content']['ou_tag']);
					}
					else
					{
						$data_save['content']['ou_tag'] = trim($data_save['content']['ou_tag'],',');
					}
				}
				
				/************事件处理*****************/
				switch ($data_get['act']) {
					case STAT_ACT_CREATE:
						
						$data_save['content']['ou_code']=$this->get_code($data_save['content']);
						$rtn=$this->add($data_save['content']);
						
						$data_db['content'][$this->pk_id]=$rtn['id'];
						
						if( $data_save['content']['ou_level'] == OU_LEVEL_ORG
						 || $data_save['content']['ou_level'] == OU_LEVEL_CORG )
						{
						 	$data_save['content']['o_id'] = $data_db['content'][$this->pk_id];
						 	$data_save['content']['o_name'] =  $data_save['content']['ou_name'];
						 	$data_save['content']['o_code'] =  $data_save['content']['ou_code'];
						 	
						 	$this->m_table_op->load('sys_org');
						 	$this->m_table_op->add($data_save['content']);
							
							$this->m_table_op->load('sys_org_detail');
							$this->m_table_op->add($data_save['content']);
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
						
					 	$data_save['content']['o_id'] = $data_db['content'][$this->pk_id];
					 	$data_save['content']['o_name'] =  $data_save['content']['ou_name'];
					 	$data_save['content']['o_code'] =  $data_save['content']['ou_code'];
						
						if( $data_save['content']['ou_level'] == OU_LEVEL_ORG
						 || $data_save['content']['ou_level'] == OU_LEVEL_CORG )
						{
						 	$data_save['content']['o_status'] = 1;//O_STATUS_YES
						 	
						 	if($data_save['content']['ou_status'] == OU_STATUS_FQ)
						 	$data_save['content']['o_status'] = 2;//O_STATUS_NO
						 	
						 	if( empty($data_db['content_o']) )
						 	{
							 	$this->m_table_op->load('sys_org');
							 	$this->m_table_op->add($data_save['content']);
								
								$this->m_table_op->load('sys_org_detail');
								$this->m_table_op->add($data_save['content']);
						 	}
						 	else 
						 	{
						 		$this->m_table_op->load('sys_org');
							 	$this->m_table_op->update($data_save['content']);
								
								$this->m_table_op->load('sys_org_detail');
								$this->m_table_op->update($data_save['content']);
						 	}
						}
						elseif( ! empty($data_db['content_o']) )
						{
							$data_save['content']['o_status'] = 2;//O_STATUS_NO
							$this->m_table_op->load('sys_org');
						 	$this->m_table_op->update($data_save['content']);
							
							$this->m_table_op->load('sys_org_detail');
							$this->m_table_op->update($data_save['content']);
						}
						
						if( ! empty(element('ou_tag',$data_db['content'])) )
						{
							$data_db['content']['ou_tag']=implode(',', $data_db['content']['ou_tag']);
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
		$data_out['fun_open']=element('fun_open', $data_get);
	    $data_out['fun_open_id']=element('fun_open_id', $data_get);
	    
	    $data_out['log']=json_encode(element('log', $data_out));
		
		$data_out['log_time']=$this->input->post('log_time');
		$data_out['log_a_login_id']=$this->input->post('log_a_login_id');
		$data_out['log_c_name']=$this->input->post('log_c_name');
		$data_out['log_act']=$this->input->post('log_act');
		$data_out['log_note']=$this->input->post('log_note');
	    
	    $data_out['db_time_create']=element('db_time_create', $data_db['content']);
	    $data_out['code']=element('ou_code',$data_db['content']);
	    
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
}