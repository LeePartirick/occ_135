<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 *  
   文件
 */
class M_file extends CI_Model {
	
	//@todo 主表配置
	private $table_name='sys_file';
	private $pk_id='f_id';
	private $table_form;
	private $arr_table_form=array();
	private $title='文件';
	private $model_name = 'm_file';
	private $url_conf = 'proc_file/file/edit';
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
    	if( defined('LOAD_M_FILE') ) return;
    	define('LOAD_M_FILE', 1);
    	
    	//define
    	
    	//文件密级定义
		define('F_SECRECY_GK', 0);//公开
		define('F_SECRECY_NEIBU', 1);//内部
		define('F_SECRECY_SM_3', 2);//商密3级
		define('F_SECRECY_SM_2', 3);//商密2级
		define('F_SECRECY_SM_1', 4);//商密1级
		define('F_SECRECY_MINGAN', 5);//敏感
		
		//密级
		$GLOBALS['m_file']['text']['f_secrecy'] = array(
			F_SECRECY_GK=>'公开',
			F_SECRECY_NEIBU=>'内部',
			F_SECRECY_SM_3=>'商密3级',
			F_SECRECY_SM_2=>'商密2级',
			F_SECRECY_SM_1=>'商密1级',
		);
		
		$GLOBALS['m_file']['text']['f_secrecy_all'] = array(
			F_SECRECY_GK=>'公开',
			F_SECRECY_NEIBU=>'内部',
			F_SECRECY_SM_3=>'商密3级',
			F_SECRECY_SM_2=>'商密2级',
			F_SECRECY_SM_1=>'商密1级',
			F_SECRECY_MINGAN=>'敏感',
    	);
		
		$GLOBALS['m_file']['text']['f_secrecy_all']= $GLOBALS['m_file']['text']['f_secrecy'] ;
		$GLOBALS['m_file']['text']['f_secrecy_all'][F_SECRECY_MINGAN]='敏感';
		
		//密级定义
		$GLOBALS['m_file']['text']['f_secrecy_define'] = array(
			F_SECRECY_GK=>'可对社会公开的信息，公用的信息处理设备和系统资源等。例如公司宣传资料等。',
			F_SECRECY_NEIBU=>'仅能在组织内部或在组织内某一部门内公开的信息，向外扩散有可能对组织的利益造成轻微损害。例如公司管理制度。',
			F_SECRECY_SM_3=>'组织的一般性秘密，其泄露会使组织的安全和利益受到损害。例如项目方案、合同、报价、人员档案、工资信息等。',
			F_SECRECY_SM_2=>'包含组织的重要秘密，其泄露会使组织的安全和利益受到严重损害。例如公司重要人员信息等。',
			F_SECRECY_SM_1=>'包含组织最重要的秘密，关系未来发展的前途命运，对组织根本利益有着决定性的影响，如果泄露会造成灾难性的损害。例如公司的重大商业决策等。',
			F_SECRECY_MINGAN=>'敏感',
		);
		
		//密级等级
		$GLOBALS['m_file']['text']['f_secrecy_level'] = array(
			F_SECRECY_GK=>'低',
			F_SECRECY_NEIBU=>'',
			F_SECRECY_SM_3=>'',
			F_SECRECY_SM_2=>'',
			F_SECRECY_SM_1=>'高',
			F_SECRECY_MINGAN=>'敏感',
		);
		
		$json_f_secrecy='';
		foreach ($GLOBALS['m_file']['text']['f_secrecy'] as $k=>$v) {
			$json_f_secrecy.='{'
						   .'"f_secrecy":"'.$k.'",'
						   .'"f_secrecy_show":"'.$v.'",'
						   .'"f_secrecy_level":"'.$GLOBALS['m_file']['text']['f_secrecy_level'][$k].'",'
						   .'"f_secrecy_define":"'.$GLOBALS['m_file']['text']['f_secrecy_define'][$k].'"'
						   .'},';
		}
		
		$json_f_secrecy=trim($json_f_secrecy,',');
	
		$GLOBALS['m_file']['text']['json_f_secrecy']=$json_f_secrecy;
    	
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
     * 添加关联文件
     */
	public function add_file_link($content)
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$data_save=array();//
		$rtn=array();//结果
		$json = array();
		$arr_rtn = array();
		/************变量赋值*****************/
		$data_save['content']=$content;
		
		//验证方法
    	if( element('fun_m', $content) && element('fun_ck', $content) )
	    {
	    	$m = $content['fun_m'];
	    	$f = $content['fun_ck'];
	    	$this->load->model($content['proc'].'/'.$content['fun_m']);
	    	$arr_rtn = $this->$m->$f($content);
	    	
	    	if( ! $arr_rtn['rtn'] )
	    	{
				$json['msg'] = fun_urlencode($arr_rtn['msg']);
				@unlink($data_save['content']['filePath']);
				return $json;
	    	}
	    }
		
		//验证关联文件是否存在唯一文件属性文件
		if( ! empty($data_save['content']['op_id'] ) 
		 && ! empty($data_save['content']['f_type'] ) )
		{
			$f_t_unique = $this->m_base->get_field_where('sys_file_type','f_t_unique' ," AND f_t_id = '{$data_save['content']['f_type']}'");
			
			if($f_t_unique == 1)
			{
				//查询主体关联文件
				$arr_search=array();
				$arr_search['field']='link_id';
				$arr_search['from']="sys_link";
				$arr_search['where']= ' AND op_id = ? AND content = \'link_file\'';
				$arr_search['value'][] = $data_save['content']['op_id'];
				
				$rs=$this->m_db->query($arr_search);
				
				if(count($rs['content'])>0)
				{
					$arr_tmp = array();
					
					foreach ($rs['content'] as $v) {
						$arr_tmp [] = $v['link_id'];
					}
					
					//查询是否存在唯一属性文件
					$arr_search=array();
					$arr_search['field']='l.op_id,t.f_t_name,f.f_name,f.f_link_noedit';
					$arr_search['from']="sys_link l
										 LEFT JOIN sys_file_type t ON
										 (l.content = 'f_type' AND t.f_t_id = l.link_id )
										 LEFT JOIN sys_file f ON
										 ( f.f_id = l.op_id )";
					$arr_search['where']= ' AND op_id IN ? AND t.f_t_id = ?  GROUP BY l.op_id';
					$arr_search['value'][] = $arr_tmp;
					$arr_search['value'][] = $data_save['content']['f_type'];
					
					$rs=$this->m_db->query($arr_search);
					
					if( count($rs['content']) == 1 )
					{
						if( $rs['content'][0]['f_link_noedit'] == 1 )
						{
							$json['msg'] = '【'.$rs['content'][0]['f_t_name'].'】已存在，【'.$data_save['content']['f_name'].'】且不可更新版本！文件上传失败！';
							$json['msg'] = fun_urlencode($json['msg']);
							@unlink($data_save['content']['filePath']);
							return $json;
						}
						
						$data_save['content']['f_id'] = $rs['content'][0]['op_id'];
						$data_save['content']['msg'] = '【'.$rs['content'][0]['f_t_name'].'】已存在，【'.$data_save['content']['f_name'].'】作为最新版本覆盖【'.$rs['content'][0]['f_name'].'】';
						$data_save['content']['f_v_note'] = $data_save['content']['msg'];
						$this->add_file_verson($data_save['content']);
						
						$json['msg'] = fun_urlencode($data_save['content']['msg']);
						
						return $json;
					}
				}
			}
		}
		
		$data_save['content']['f_v_sn']=1;
		$rtn=$this->add($data_save['content']);
		
		$this->m_table_op->load('sys_file_verson');
		
		$data_save['f_v']=array();
		$data_save['f_v']['f_id']=$rtn['id'];
		$data_save['f_v']['f_v_id']=$data_save['content']['f_v_id'];
		$data_save['f_v']['f_v_size']=$data_save['content']['f_size'];
		$data_save['f_v']['f_v_sn']=$data_save['content']['f_v_sn'];
		$data_save['f_v']['f_v_path']=date("Y-m");
		$this->m_table_op->add($data_save['f_v']);
		
		if( ! empty($data_save['content']['op_id'] ) )
		{
			$data_save['link']=array();
			$data_save['link']['op_id']=$data_save['content']['op_id'];
			$data_save['link']['op_table']=$data_save['content']['op_table'];
			$data_save['link']['op_field']=$data_save['content']['op_field'];
			$data_save['link']['link_id']=$rtn['id'];
			$data_save['link']['link_table']='sys_file';
			$data_save['link']['link_field']='f_id';
			$data_save['link']['content']='link_file';
			
			$rtn_check=$this->m_link->get($data_save['content']['op_id'],$rtn['id']);
			
			if(empty($rtn_check['op_id']))
			$this->m_link->add($data_save['link']);
		}
		
		if( ! empty($data_save['content']['f_type'] ) )
		{
			$arr_f_type=explode(',', $data_save['content']['f_type']);
			
			if(count($arr_f_type)>0)
			{
				foreach ($arr_f_type as $v) {
					$data_save['link']=array();
					$data_save['link']['op_id']=$rtn['id'];
					$data_save['link']['op_table']='sys_file';
					$data_save['link']['op_field']='f_id';
					$data_save['link']['link_id']=$v;
					$data_save['link']['link_table']=$data_save['content']['op_table'];
					$data_save['link']['content']='f_type';
					$this->m_link->add($data_save['link']);
				}
			}
		}
		
		$arr_log_content=array();
		$arr_log_content['new']['content']=$data_save['content'];
		$arr_log_content['old']['content'][$this->pk_id]=$rtn['id'];
		
		//操作日志
		$data_save['content_log']['op_id']=$rtn['id'];
		$data_save['content_log']['log_act']=STAT_ACT_CREATE;
		$data_save['content_log']['log_url']=$this->url_conf.'/'.$this->pk_id.'/'.$rtn['id'];
		$data_save['content_log']['log_content']=json_encode($arr_log_content);
		$data_save['content_log']['log_module']=$this->title;
		$data_save['content_log']['log_p_id']=$this->proc_id;
		$this->m_log_operate->add($data_save['content_log']);
		
		$path=$this->config->item('base_file_path').date("Y-m").'/';
		
		if(!file_exists($path))
	    	mkdir($path);//创建目录
	    	
	    if( element('fun_m', $content) && element('fun_up', $content))
	    {
	    	$this->load->model($content['proc'].'/'.$content['fun_m']);
	    	
	    	$m = $content['fun_m'];
	    	$f = $content['fun_up'];
	    	
	    	$this->$m->$f($rtn['id']);
	    }
		
		rename($data_save['content']['filePath'], $path.$data_save['content']['f_v_id']);
		
		return $json;
    }
    
	/**
     * 
     * 添加文件版本
     */
	public function add_file_verson($content)
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$data_save=array();//
		$rtn=array();//结果
		$json = array();
		/************变量赋值*****************/
		$data_save['content']=$content;

		$data_db['content']=$this->get($data_save['content']['f_id']);
		
		$data_save['content']['f_v_sn']=$this->m_db->get_m_value('sys_file_verson','f_v_sn',' AND f_id = \''.$data_save['content']['f_id'].'\'');
		$data_save['content']['f_v_sn']+=1;
		$rtn=$this->update($data_save['content']);
		
		$this->m_table_op->load('sys_file_verson');
		
		$data_save['f_v']=array();
		$data_save['f_v']['f_id']=$data_save['content']['f_id'];
		$data_save['f_v']['f_v_id']=$data_save['content']['f_v_id'];
		$data_save['f_v']['f_v_size']=$data_save['content']['f_size'];
		$data_save['f_v']['f_v_sn']=$data_save['content']['f_v_sn'];
		$data_save['f_v']['f_v_note']=$data_save['content']['f_v_note'];
		$data_save['f_v']['f_v_path']=date("Y-m");
		$this->m_table_op->add($data_save['f_v']);
		
		//操作日志
		$data_save['content_log']['op_id']=$data_save['content']['f_id'];
		$data_save['content_log']['log_act']=STAT_ACT_EDIT;
		$data_save['content_log']['log_url']=$this->url_conf.'/'.$this->pk_id.'/'.$data_save['content']['f_id'];
		
		$arr_log_content=array();
		$arr_log_content['new']['content']=$data_save['content'];
		$arr_log_content['old']['content']=$data_db['content'];
						
		$data_save['content_log']['log_content']=json_encode($arr_log_content);
		$data_save['content_log']['log_module']=$this->title;
		$data_save['content_log']['log_p_id']=$this->proc_id;
		$data_save['content_log']['log_note']='上传新版本-'.$data_save['f_v']['f_v_sn'];
		$this->m_log_operate->add($data_save['content_log']);
		
		$path=$this->config->item('base_file_path').date("Y-m").'/';
		
		if(!file_exists($path))
	    	mkdir($path);//创建目录
		
		rename($data_save['content']['filePath'], $path.$data_save['content']['f_v_id']);

		if( ! empty(element('msg', $content)));
		$json['msg'] = fun_urlencode(element('msg', $content));
		
		return $json;
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
	 * 更新关联文件不可更新
	 * @param $op_id
	 */
	public function update_link_noedit($op_id,$f_link_noedit,$f_type = '')
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$data_save=array();//
		$rtn=array();//结果
		$rtn['rtn']=TRUE;
		$where='';
		/************变量赋值*****************/
		
		/************数据处理*****************/
    	$this->db->trans_begin();
		
    	$sql = '';
    	
    	if($f_type)
    	{
    		$arr_tmp = explode(',', $f_type);
			$arr_search=array();
			$arr_search['field']='lf.link_id';
			$arr_search['from']="sys_link lf
								 LEFT JOIN sys_link lt ON
								 (lt.op_id = lf.link_id AND lt.content = 'f_type') ";
			$arr_search['where']= " AND lf.op_id = ? AND lf.content = 'link_file' AND lt.link_id IN ? GROUP BY lt.link_id";
			$arr_search['value'][] = $op_id;
			$arr_search['value'][] = $arr_tmp ;
			$rs=$this->m_db->query($arr_search);
			
			if(count($rs['content'])>0)
			{
				$f_id = '';
				foreach ($rs['content'] as $v) {
					$f_id.="'".$v['link_id']."',";
				}
				$f_id = trim($f_id,',');
				
				$sql="UPDATE sys_file 
			SET f_link_noedit =  '{$f_link_noedit}'
			WHERE f_id IN ({$f_id}) ";
			}
    	}
    	else 
    	{
			$sql="UPDATE sys_file 
			SET f_link_noedit =  '{$f_link_noedit}'
			WHERE f_id IN (
				SELECT link_id FROM sys_link WHERE op_id = '{$op_id}'
											   AND content ='link_file'
			) ";
    	}
		
    	if( ! $sql )return $rtn;
    	
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
    	$arr_link=array();
		
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
        {
	
			$arr_search['field']='f_v_id,f_v_path';
			$arr_search['from']='sys_file_verson';
			$arr_search['where']=" AND f_id = ? ";
			$arr_search['value'][]=$id;
	
			$rs=$this->m_db->query($arr_search);
			
			if(count($rs['content'])>0)
	    	{
	    		foreach ($rs['content'] as $v) {
	    			$path_file = $this->config->item('base_file_path').$v['f_v_path'].'/'.$v['f_v_id'];
	    			
	    			@unlink($path_file);
	    		}
	    	}
        }
        
        if($rtn['rtn'])
        $rtn=$this->m_db->delete('sys_file_verson',$where);
        
    	if( ! $rtn['rtn'] )
	    {
		    $this->db->trans_rollback();
		}
		else
		{
		    $this->db->trans_commit();
		    
		    //删除所有关联数据
			$this->m_link->del_all($id);
		}
		
    	/************返回数据*****************/
		return $rtn;
    }
    
    /**
	 * 
	 * 删除关联文件
	 * @param $content
	 */
	public function del_link_file($id,$table,$field)
    {
    	$arr_search = array();
    	
    	$arr_search['where']='';
		$arr_search['value']=array();
		
		$arr_search['where'] = ' AND f_id IN ( 
									select link_id 
									FROM sys_link 
									WHERE op_id = ? 
										  AND op_table = ?
										  AND op_field = ?
								)';
		$arr_search['value'][] =  $id;
		$arr_search['value'][] =  $table;
		$arr_search['value'][] =  $field;
		
		$arr_field_search=array(
			'f_id',
		);
		
		$arr_search['field']=implode(',', $arr_field_search);

		$arr_search['from']='sys_file';

		$rs=$this->m_db->query($arr_search);
		
		if (count($rs['content']) > 0)
		{
			foreach($rs['content'] as $k => $v)
			{
				$this->del($v['f_id']);
			}
		}
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
    	);
    	
    	$conf['field_required']=array(
    	);
    	
    	$conf['field_define']=array(
    	);
    	
    	$conf['table_form']=array(
    	);
    	
    	$path=str_replace('\\', '/', APPPATH).'models/'.$this->proc_id.'/'.$this->model_name.'.xlsx';
    	
//    	$this->m_excel->create_import_file($path,$conf);
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
			'content[f_type]',
			'content[f_secrecy]',
		);
		
		//编辑数组
		$data_out['field_edit']=array(
			'content[db_time_update]',
			'content[f_name]',
			'content[f_type]',
			'content[f_secrecy]',
			'content[f_note]',
		);
		
		//只读数组
		$data_out['field_view']=array(
			'content[f_v_sn]',
			'content[f_size_s]',
			'content[db_time_create]',
			'content[db_person_create_s]',
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
		
		$data_out['search_f_t_proc'] = 'proc_file';
		if(element('search_f_t_proc', $data_get))
		$data_out['search_f_t_proc'] = $data_get['search_f_t_proc'];
		
		$data_out['flag_f_type_more'] = 'true';
		if(element('flag_f_type_more', $data_get))
		$data_out['flag_f_type_more'] = $data_get['flag_f_type_more'];
		
		$data_out['link_op_id'] = element('link_op_id', $data_get);
		$data_out['link_op_table'] = element('link_op_table', $data_get);
		$data_out['link_op_field'] = element('link_op_field', $data_get);
		
		$data_out['fun_m'] = element('fun_m', $data_get);
		$data_out['fun_up'] = element('fun_up', $data_get);
		$data_out['fun_ck'] = element('fun_ck', $data_get);
		  
		/************字段定义*****************/
		//@todo 字段定义
		$arr_field=array_unique(array_merge($data_out['field_edit'], $data_out['field_view']));
		
		$data_out['json_field_define']=array();
		$data_out['json_field_define']['f_secrecy']=$GLOBALS['m_file']['text']['json_f_secrecy'];
		/************数据读取*****************/
		$data_db['content']=array();
		$data_db['wl_list']=array();
		$arr_link_op = array();
		
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
					
						//非数据库，页面调用
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
						
						//获取文件属性
						$arr_search_link=array();
						$arr_search_link['rows']=0;
						$arr_search_link['field']='link_id';
						$arr_search_link['from']='sys_link';
						$arr_search_link['where']=" AND op_id = ? AND op_table = ? AND op_field = ? AND content = ?";
						$arr_search_link['value'][]=element('f_id',$data_db['content']);
						$arr_search_link['value'][]='sys_file';
						$arr_search_link['value'][]='f_id';
						$arr_search_link['value'][]='f_type';
						$rs_link=$this->m_db->query($arr_search_link);
						$data_db['content']['f_type']=array();

						if(count($rs_link['content'])>0)
						{
							foreach ( $rs_link['content'] as $v ) {
								$data_db['content']['f_type'][]=$v['link_id'];
							}
						}
					
					}
					
					$data_db['content']['db_person_create_s']=$this->m_base->get_c_show_by_cid(element('db_person_create', $data_db['content']));
					$data_db['content']['f_size_s']=byte_format(element('f_size', $data_db['content']),2);
				
					$arr_link_op = $this->m_base->get_field_where('sys_link','op_id'," AND link_id = '{$data_get['f_id']}' AND content= 'link_file'",array(),TRUE);
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
		$title_field='';
		
		switch ($data_get['act']) {
			case STAT_ACT_CREATE:
				$data_out['title']='创建'.$this->title;
				
				$data_out['op_disable'][]='btn_del';
				$data_out['op_disable'][]='btn_log';
				
				$data_out['op_disable'][]='btn_person';
				$data_out['op_disable'][]='btn_import';
				
				$data_out['op_disable'][]='btn_save';
				$data_out['op_disable'][]='btn_next';
				$data_out['op_disable'][]='btn_pnext';
				
				$data_out['op_disable'][]='btn_download';
				
				$data_out['op_disable'][]='btn_wl';
				$data_out['op_disable'][]='btn_im';
				
				$data_out['op_disable'][]='content[f_name]';
				$data_out['op_disable'][]='content[f_v_sn]';
				$data_out['op_disable'][]='content[f_size]';
				$data_out['op_disable'][]='content[db_person_create]';
				$data_out['op_disable'][]='content[db_time_create]';
				
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
				
				$data_out['op_disable'][]='btn_select';
				$data_out['op_disable'][]='btn_upload';
				
				if( count($arr_link_op) > 0
				  && (  ($acl_list & pow(2,ACL_PROC_FILE_SUPER)) == 0 
				 	&& ($acl_list & pow(2,ACL_PROC_FILE_LFILE_DEL)) == 0 )
				    )
		    	{
		    		$data_out['op_disable'][]='btn_del';
		    	}
		    	
			break;
			case STAT_ACT_VIEW:
				$data_out['title']='查看'.$this->title.$title_field;
				
				$data_out['op_disable'][]='btn_save';
				$data_out['op_disable'][]='btn_del';
				$data_out['op_disable'][]='btn_person';
				$data_out['op_disable'][]='btn_import';
				$data_out['op_disable'][]='btn_select';
				$data_out['op_disable'][]='btn_upload';
				
				$data_out['op_disable'][]='btn_next';
				$data_out['op_disable'][]='btn_pnext';
				
				$data_out['field_view']=array_unique(array_merge($data_out['field_view'],$data_out['field_edit']));
				
			break;
		}
		
		if($flag_log)
		$data_out['op_disable'][]='tab_verson';
		
		if(element('f_link_noedit', $data_db['content']))
		{
			$data_out['op_disable'][]='btn_del';	
			$data_out['op_disable'][]='btn_save';
			$data_out['op_disable'][]='btn_verson';
			
			$data_out['field_view']=array_unique(array_merge($data_out['field_view'],$data_out['field_edit']));
		}
		
		if(element('flag_edit_more', $data_get))
		{
			$data_out['field_required']=array();
			
			$data_out['op_disable'][] = 'content[f_name]';
			$data_out['op_disable'][] = 'content[f_v_sn]';
			$data_out['op_disable'][] = 'content[f_size]';
			$data_out['op_disable'][] = 'content[db_person_create]';
			$data_out['op_disable'][] = 'content[db_time_create]';
			$data_out['op_disable'][] = 'tab_verson';
			
			$data_out['op_disable'][]='btn_download';
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
			case 'zip':
				$this->load->library('zip');
				
				$path_zip=str_replace('\\', '/', APPPATH).'tmp/'.element('zip', $data_post).'.zip';
				
				if( ! file_exists($path_zip)){
			    	copy(str_replace('\\', '/', APPPATH).'sysfile/tmp.zip', $path_zip);
			    }
			    
			    $arr_tmp = get_arr_by_filename($data_db['content']['f_name']);
				    
			    $this->m_table_op->load('sys_file_verson');
			    $data_db['f_v']=$this->m_table_op->get($data_db['content']['f_v_id']);
			    
			    $data_db['content']['f_name']='['.$GLOBALS['m_file']['text']['f_secrecy_all'][$data_db['content']['f_secrecy']].']'
													.$arr_tmp['filename'].'-'.$data_db['content']['f_v_sn']
													.'-'.date("Ymd",strtotime($data_db['content']['db_time_create'])).'.'.$arr_tmp['ext'];
													
				$path_file = $this->config->item('base_file_path').$data_db['f_v']['f_v_path'].'/'.$data_db['content']['f_v_id'];

				$data_db['content']['f_name']=iconv('utf-8','gb2312',$data_db['content']['f_name']);

				$zip = new ZipArchive;
			    $res = $zip->open($path_zip, ZipArchive::CREATE);
			    $zip->addfile($path_file, $data_db['content']['f_name']);
				$zip->close();
			    
			    $rtn['result']=TRUE;
			    $rtn['msg_err']='';
					
				return $rtn;
				break;
			case 'save':
				
				$rtn=array();//结果
				$check_data=TRUE;
				$rtn['err'] = array();
				
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
					
					if( count($arr_link_op) > 0 )
					{
						//查询主体关联文件
						if( ! empty(element('f_type',$data_post['content']))
						 && ! is_array(element('f_type',$data_post['content'])) 
						 )
						{
							$m_fiel_check = 'm_'.$data_out['search_f_t_proc'];
							$this->load->model($data_out['search_f_t_proc'].'/'.$m_fiel_check);
							if(method_exists($m_fiel_check,'check_file'))
							{
								$arr_check = $this->$m_fiel_check->check_file(element('f_id', $data_get),$arr_link_op,element('f_type',$data_db['content']),element('f_type',$data_post['content']));
							
								if($arr_check['msg'])
								$rtn['err']['content[f_type]']=$arr_check['msg'];
										
								$check_data = $arr_check['rtn'];
							}
							
							$f_type = element('f_type',$data_post['content']);
							$f_t_unique = $this->m_base->get_field_where('sys_file_type','f_t_unique' ," AND f_t_id = '{$f_type}'");
							
							if($f_t_unique)
							{
								//查询主体关联文件
								$arr_search=array();
								$arr_search['field']='link_id';
								$arr_search['from']="sys_link";
								$arr_search['where']= " AND op_id IN ? AND content = 'link_file' AND link_id != ? ";
								$arr_search['value'][] = $arr_link_op;
								$arr_search['value'][] = element('f_id', $data_get);
								$rs=$this->m_db->query($arr_search);
								
								if(count($rs['content'])>0)
								{
									
									$arr_tmp = array();
					
									foreach ($rs['content'] as $v) {
										$arr_tmp [] = $v['link_id'];
									}
									
									//查询是否存在唯一属性文件
									$arr_search=array();
									$arr_search['field']='l.op_id,t.f_t_name,f.f_name';
									$arr_search['from']="sys_link l
														 LEFT JOIN sys_file_type t ON
														 (l.content = 'f_type' AND t.f_t_id = l.link_id )
														 LEFT JOIN sys_file f ON
														 ( f.f_id = l.op_id )";
									$arr_search['where']= ' AND op_id IN ? AND t.f_t_id = ?  GROUP BY l.op_id';
									$arr_search['value'][] = $arr_tmp;
									$arr_search['value'][] = $f_type;
									
									$rs=$this->m_db->query($arr_search);
									if( count($rs['content']) > 0 )
									{
										$rtn['err']['content[f_type]']='该文件属性的关联对象已存在，不可重复关联！';
										
										$check_data=FALSE;
									}
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
				
				if( ! empty(element('f_type',$data_save['content'])) )
				{
					if( ! is_array(element('f_type',$data_save['content'])) )
					{
						$data_save['content']['f_type'] = explode(',', $data_save['content']['f_type']);
					}
				}
				
				/************事件处理*****************/
				switch ($data_get['act']) {
					case STAT_ACT_CREATE:
						
						$rtn=$this->add($data_save['content']);
							
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
						
						if( is_array(element('f_type',$data_save['content'])) 
						 && count( element('f_type',$data_save['content']) ) > 0 )
						{
							$cond_link=array();
							$cond_link['op_id']=element($this->pk_id,$data_get);
							$cond_link['op_table']='sys_file';
							$cond_link['op_field']='f_id';
							$cond_link['content']='f_type';
							$this->m_link->del_where($cond_link);

							foreach ($data_save['content']['f_type'] as $v) {

								$data_save['link']=array();
								$data_save['link']['op_id']=$data_save['content'][$this->pk_id];
								$data_save['link']['op_table']='sys_file';
								$data_save['link']['op_field']='f_id';
								$data_save['link']['content']='f_type';
								$data_save['link']['link_id']=$v;

								$this->m_link->add($data_save['link']);

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
	    $data_out['flag_wl_win']=element('flag_wl_win', $data_get);
	    
	    $data_out['log']=json_encode(element('log', $data_out));
		
		$data_out['log_time']=$this->input->post('log_time');
		$data_out['log_a_login_id']=$this->input->post('log_a_login_id');
		$data_out['log_c_name']=$this->input->post('log_c_name');
		$data_out['log_act']=$this->input->post('log_act');
		$data_out['log_note']=$this->input->post('log_note');
	    
	    $data_out['db_time_create']=element('db_time_create', $data_db['content']);
	    $data_out['code']='';
	    $data_out['ppo']=element('ppo', $data_db['content']);
	    
	    $data_out['fun_no_db']=element('fun_no_db', $data_get);
	    $data_out['data_db_post'] = $this->input->post('data_db');
	    
	    $data_out['flag_edit_more']=element('flag_edit_more', $data_get);
	     
	    $data_out[$this->pk_id]=element($this->pk_id,$data_get);
	    $data_out['f_v_id']=element('f_v_id', $data_db['content']);
	    
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