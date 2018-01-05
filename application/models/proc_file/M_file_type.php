<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 *  
    文件属性
 */
class M_file_type extends CI_Model {
	
	//@todo 主表配置
	private $table_name='sys_file_type';
	private $pk_id='f_t_id';
	private $table_form;
	private $arr_table_form=array();
	private $title='文件属性';
	private $model_name = 'm_file_type';
	private $url_conf = 'proc_file/file_type/edit';
	private $proc_id = 'proc_file';
	
 	public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->m_define();
        
         //读取表结构
        $this->config->load('db_table/'.$this->table_name, FALSE,TRUE);
        $this->table_form=$this->config->item($this->table_name);
    }
    
	/**
     * 
     * 定义
     */
	public function m_define()
    {
    	//@todo 定义
    	if( defined('LOAD_M_FILE_TYPE') ) return;
    	define('LOAD_M_FILE_TYPE', 1);
    	
    	//define
    	//相关验证
		define('F_T_CHECK_GFC_REVIEW', 1); // 合同评审
		define('F_T_CHECK_GFC_RETURN', 2); // 合同归还
    	$GLOBALS['m_file_type']['text']['f_t_check']=array(
    		F_T_CHECK_GFC_REVIEW=>'合同评审',
    		F_T_CHECK_GFC_RETURN=>'合同归还',
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
    	$acl_list= $this->m_proc_file->get_acl();

    	$msg='';
    	/************权限验证*****************/

    	//如果有超级权限，TRUE
    	if( ($acl_list & pow(2,ACL_PROC_FILE_SUPER)) != 0 )
    	{
    		return TRUE;
    	}

    	$check_acl=FALSE;

    	if( ! $check_acl
    	 && ($acl_list & pow(2,ACL_PROC_FILE_USER)) != 0
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

		if(isset($data_save['content']['f_t_parent']) )
		{
			if( empty( element('f_t_parent',$data_save['content']) ) )
			{
				$data_save['content']['f_t_parent']='base';
				$data_save['content']['f_t_parent_path']=$data_save['content']['f_t_id'];
			}
			else
			{
				$data_save['content']['f_t_parent_path']=$this->m_base->get_parent_path('sys_file_type','f_t_id','f_t_parent',$data_save['content']['f_t_parent']);
				$data_save['content']['f_t_parent_path'].=','.$data_save['content']['f_t_id'];
				$data_save['content']['f_t_parent_path']=trim($data_save['content']['f_t_parent_path'],',');
			}

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
		if(isset($data_save['content']['f_t_parent']) )
		{
			if( empty( element('f_t_parent',$data_save['content']) ) )
			{
				$data_save['content']['f_t_parent']='base';
				$data_save['content']['f_t_parent_path']=$data_save['content']['f_t_id'];
			}
			else
			{
				$data_save['content']['f_t_parent_path']=$this->m_base->get_parent_path('sys_file_type','f_t_id','f_t_parent',$data_save['content']['f_t_parent']);
				$data_save['content']['f_t_parent_path'].=','.$data_save['content']['f_t_id'];
				$data_save['content']['f_t_parent_path']=trim($data_save['content']['f_t_parent_path'],',');
			}
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
	 * 清除文件属性排序
	 * @param $arr_id
	 */
	public function clear_f_t_sn($arr_id)
	{
		 $sql="UPDATE sys_file_type 
		SET f_t_sn =  NULL
		WHERE f_t_sn IS NOT NULL AND f_t_id IN ? ";
		
		$value[]=$arr_id;
		
		$this->m_db->exec_sql($sql,$value);
		
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
    		'sys_link.link_id'
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
        
        $sql="UPDATE sys_file_type 
		SET f_t_parent_path =  REPLACE (f_t_parent_path , '{$data_db['content']['f_t_parent_path']},' ,''),
			f_t_parent = 'base'
		WHERE find_in_set ('{$id}' ,f_t_parent_path) ";
		
		if($rtn['rtn'])
		$rtn=$this->m_db->exec_sql($sql);
        
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
			'sys_file_type[f_t_name]',
			'sys_file_type[f_t_parent]',
			'sys_file_type[f_t_note]',
    	);
    	
    	$conf['field_required']=array(
			'sys_file_type[f_t_name]'
    	);
    	
    	$conf['field_define']=array(
    	);
    	
    	$conf['table_form']=array(
			'sys_file_type'=>$this->table_form,
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
			'content[f_t_name]',
		);
		
		//编辑数组
		$data_out['field_edit']=array(
			'content[db_time_update]',
			'content[f_t_name]',
			'content[f_t_sn]',
			'content[f_t_parent]',
			'content[f_t_parent_s]',
			'content[f_t_note]',
			'content[f_t_unique]',
			'content[f_t_check]',
			'content[f_t_parent_path]',
			'content[f_t_proc]',
		);
		
		//只读数组
		$data_out['field_view']=array();
		
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
		$data_out['json_field_define']['f_t_check']=get_html_json_for_arr($GLOBALS['m_file_type']['text']['f_t_check'] );
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
										case 'f_t_proc':

											$diff='';

											$arr_f=array();
											if( $data_db['content']['f_t_proc_data'] )
												$arr_f = json_decode($data_db['content']['f_t_proc_data'] ,TRUE);

											if(count($arr_f)>0)
											{
												foreach ($arr_f as $v1) {
													$diff.='<br>'.$v1['text'];
												}

											}

											$data_out['log']['content['.$k.']']='变更前:'.$diff;

											$data_db['content'][$k] = explode(',', $v) ;

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

						//获取适用流程
						$arr_search_link=array();
						$arr_search_link['rows']=0;
						$arr_search_link['field']='link_id';
						$arr_search_link['from']='sys_link';
						$arr_search_link['where']=" AND op_id = ? AND op_table = ? AND op_field = ? AND content = ?";
						$arr_search_link['value'][]=element('f_t_id',$data_db['content']);
						$arr_search_link['value'][]='sys_file_type';
						$arr_search_link['value'][]='f_t_id';
						$arr_search_link['value'][]='f_t_proc';
						$rs_link=$this->m_db->query($arr_search_link);
						$data_db['content']['f_t_proc']=array();
						$data_db['content']['f_t_proc_data']=array();

						if(count($rs_link['content'])>0)
						{
							foreach ( $rs_link['content'] as $v ) {
								$data_db['content']['f_t_proc'][]=$v['link_id'];

							}
						}

						if($data_db['content']['f_t_parent'])
						$data_db['content']['f_t_parent_s']=$this->m_base->get_field_where('sys_file_type','f_t_name',"AND f_t_id = '{$data_db['content']['f_t_parent']}'");
					}
				} catch (Exception $e) {
				}
			break;
		}
		/************工单信息*****************/

		/************权限验证*****************/
		//@todo 权限验证
		$acl_list= $this->m_proc_file->get_acl();

		$this->check_acl($data_db,$acl_list);
		
		/************显示配置*****************/
		//@todo 显示配置
		$title_field='-'.element('f_t_name',$data_db['content']);;
		
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
			
			$data_out['op_disable'][] = 'content[f_t_name]';
			
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
				}

				//验证上下级属性
				if( ! empty(element('f_t_parent',$data_post['content'])) 
				 && element('f_t_parent',$data_post['content']) != 'base')
				{
					$arr_search_ac=array();
					$arr_search_ac['page']=1;
					$arr_search_ac['rows']=1;
					$arr_search_ac['field']='sys_file_type.f_t_name';
					$arr_search_ac['from']='sys_file_type';
					$arr_search_ac['where']=" AND f_t_id = ? ";
					$arr_search_ac['value'][]=$data_post['content']['f_t_parent'];

					if( !empty(element('f_t_id',$data_db['content']))){
						$arr_search_ac['where'].=" AND ! FIND_IN_SET('{$data_db['content']['f_t_id']}' ,f_t_parent_path)";
					}

					$rs_ac=$this->m_db->query($arr_search_ac);

					if(count($rs_ac['content']) ==0){
						$rtn['err']['content[f_t_parent_s]']='上级属性输入不合法';
						$check_data=FALSE;
					}
				}

				//验证关联子系统
				if(  ! empty(element('f_t_proc',$data_db['content'])))
				{
					$arr_tmp = array();
					if( ! is_array(element('f_t_proc',$data_post['content'])) )
					{
						$arr_tmp = explode(',', $data_post['content']['f_t_proc']);
					}
					
					$arr_tmp = array_diff($data_db['content']['f_t_proc'], $arr_tmp);
					
					$proc='';
					
					if( count($arr_tmp) > 0)
					{
						foreach ($arr_tmp as $v) {
							
							$this->config->load('proc/'.$v.'/conf', FALSE, TRUE);
							
							$p_table_list = $this->config->item('p_table_list');
							$p_conf = $this->config->item('p_conf');
							
							$arr_search=array();
							$arr_search['field']='lt.link_id';
							$arr_search['from']="sys_link lf
												 LEFT JOIN sys_link lt ON
												 (lt.op_id = lf.link_id AND lt.content = 'f_type') ";
							$arr_search['where']= "AND lf.content = 'link_file'  AND lf.op_table IN ? AND lt.link_id = ? ";
							$arr_search['value'][] = $p_table_list ;
							$arr_search['value'][] = element($this->pk_id,$data_get);
							$rs=$this->m_db->query($arr_search);
							
							if(count($rs['content'])>0)
							{
								$proc.=$p_conf['p_name'].',';
							}
						}
					}
					
					if( ! empty($proc))
					{
						$rtn['err']['content[f_t_proc]']='子系统【'.trim($proc,',').'】存在此文件属性的关联文件，不可删除！';
						$check_data=FALSE;
					}
				}
				
//				//验证唯一
//				if( ! empty(element('f_t_name',$data_post['content'])) )
//				{
//					$where_check=' AND f_t_id != \''.element('f_t_id',$data_db['content']).'\'';
//
//					$check=$this->m_check->unique('sys_file_type','f_t_name',element('f_t_name',$data_post['content']),$where_check);
//					if( ! $check )
//					{
//						$rtn['err']['content[f_t_name]']='文件属性'.element('f_t_name',$data_post['content']).'已存在，不可重复创建！';
//						$check_data=FALSE;
//					}
//				}

				
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

				if( ! empty(element('f_t_proc',$data_save['content'])) )
				{
					if( ! is_array(element('f_t_proc',$data_save['content'])) )
					{
						$data_save['content']['f_t_proc'] = explode(',', $data_save['content']['f_t_proc']);
					}
				}

				if( ! element('f_t_sn', $data_db['content']) )
				$data_save['content']['f_t_sn']=$this->m_db->get_m_value('sys_file_type','f_t_sn') + 1;

				//批量编辑
				if( element('flag_edit_more', $data_post) 
				 && ! empty(element('f_t_proc', $data_save['content']) ) )
				{
					switch (element('f_t_proc_operate', $data_post['content']))
					{
						case 'add':
							$data_save['content']['f_t_proc'] = array_unique(array_values(array_merge($data_db['content']['f_t_proc'],$data_save['content']['f_t_proc'])));
							break;
						case 'del':
							$data_save['content']['f_t_proc'] = array_values(array_diff($data_db['content']['f_t_proc'],$data_save['content']['f_t_proc']));
							break;
					}
					
				}
				/************事件处理*****************/
				switch ($data_get['act']) {
					case STAT_ACT_CREATE:
						
						$rtn=$this->add($data_save['content']);

						if( is_array(element('f_t_proc',$data_save['content']))
						 && count( element('f_t_proc',$data_save['content']) ) > 0 )
						{
							foreach ($data_save['content']['f_t_proc'] as $v) {
								$data_save['link']=array();
								$data_save['link']['op_id']=$rtn['id'];
								$data_save['link']['op_table']='sys_file_type';
								$data_save['link']['op_field']='f_t_id';
								$data_save['link']['content']='f_t_proc';
								$data_save['link']['link_id']=$v;

								$this->m_link->add($data_save['link']);
							}
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

						if( is_array(element('f_t_proc',$data_save['content'])) 
						 && count( element('f_t_proc',$data_save['content']) ) > 0 )
						{
							$cond_link=array();
							$cond_link['op_id']=element($this->pk_id,$data_get);
							$cond_link['op_table']='sys_file_type';
							$cond_link['op_field']='f_t_id';
							$cond_link['content']='f_t_proc';
							$this->m_link->del_where($cond_link);

							$data_save['content']['f_t_proc_data']=array();

							foreach ($data_save['content']['f_t_proc'] as $v) {

								$data_save['link']=array();
								$data_save['link']['op_id']=$data_save['content'][$this->pk_id];
								$data_save['link']['op_table']='sys_file_type';
								$data_save['link']['op_field']='f_t_id';
								$data_save['link']['content']='f_t_proc';
								$data_save['link']['link_id']=$v;

								$this->m_link->add($data_save['link']);

							}

							$data_save['content']['f_t_proc_data']=json_encode($data_save['content']['f_t_proc_data']);
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
		
		$this->m_view->load_view($arr_view,$data_out);
	}
}