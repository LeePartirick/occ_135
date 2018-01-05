<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 基础权限类
 */
class M_acl extends CI_Model {
	
	private $table_name='sys_acl';
	private $table_form;
	
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
    	
    }
    
	/**
	 * 
	 * @param $id
	 */
	public function get($op_id,$ra_id)
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$data_db=array();//数据库数组
		$arr_search=array();
		$rtn=array();//结果
		
		/************变量赋值*****************/
		$arr_search['field']='*';
    	$arr_search['from']=$this->table_name;
		$arr_search['where']='AND op_id = ? ';
		$arr_search['where'].='AND ra_id = ? ';
		$arr_search['value'][]=$op_id;
		$arr_search['value'][]=$ra_id;
    	$rs=$this->m_db->query($arr_search);
    	
    	/************返回数据*****************/
		return current($rs['content']);
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
        
		if( empty($data_save['content']['op_id']) 
		 || empty($data_save['content']['ra_id']) )
		 return $rtn['rtn']=FALSE;
		
        $data_save['content']['db_time_update']=date("Y-m-d H:i:s");
        
		/************数据处理*****************/
    	$this->db->trans_begin();
        
        if( $rtn['rtn'] )
        $rtn=$this->m_db->insert($data_save['content'],$this->table_name,$this->table_form);
        
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
		$where=" 1=1 AND op_id = '{$data_save['content']['op_id']}' AND ra_id = '{$data_save['content']['ra_id']}'";
		
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
	 * 批量更新
	 * @param $content
	 */
	public function update_list($acl,$op_id,$field_ra,$arr_ra,$act)
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$rtn=array();//结果
		$rtn['rtn']=TRUE;
		$value=array();
		/************变量赋值*****************/
		
		$acl_sn=pow(2, $acl);
		
		if($act == STAT_ACT_CREATE)
		{
			$sql="UPDATE {$this->table_name} 
				  SET a_acl=a_acl+{$acl_sn} 
				  WHERE op_id = '{$op_id}' 
				  	AND a_acl & {$acl_sn} = 0
				  	AND $field_ra IN ? ";
		}
		else 
		{
			$sql="UPDATE {$this->table_name} 
				  SET a_acl=a_acl-{$acl_sn} 
				  WHERE op_id = '{$op_id}' 
				  	AND a_acl & {$acl_sn} 
				  	AND $field_ra IN ? ";
		}
		
		$value[]=$arr_ra;
		
		/************数据处理*****************/
		$this->db->trans_begin();
		
		if($rtn['rtn'])
		$rtn=$this->m_db->exec_sql($sql,$value);
		
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
	public function del($op_id,$ra_id)
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$where=array();
		$rtn=array();//结果
		$rtn['rtn']=TRUE;
		
		/************变量赋值*****************/
		$where['op_id']=$op_id;
    	$where['ra_id']=$ra_id;
    	
		/************数据处理*****************/
    	
    	$this->db->trans_begin();
		
		if($rtn['rtn'])
        $rtn=$this->m_db->delete($this->table_name,$where);
        	
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
     * 获取角色
     */
	public function get_role($a_id=NULL)
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$arr_search=array();
		$arr_ra_id=array();//结果
		
		/************变量赋值*****************/
    	
    	if( empty($a_id) )
    		$a_id=$this->sess->userdata('a_id');
    		
    	/************数据处理*****************/
    		
    	//获取关联角色
		$arr_search=array();
		$arr_search['where']=" AND a_id = ? ";
		$arr_search['value']=array();
		$arr_search['value'][]=$a_id;
		$arr_search['field']='role_id';
		$arr_search['from']='sys_ra_link';
		$rs=$this->m_db->query($arr_search);
		
		$arr_ra_id[]=$a_id;
		
		if(count($rs['content'])>0)
		{
			foreach ($rs['content'] as $v) {
				$arr_ra_id[]=$v['role_id'];
			}
		}
		
		/************返回结果*****************/
		return $arr_ra_id;
    }
    
    /**
     * 
     * 获取权限
     */
	public function get_acl($op_id,$a_id=NULL)
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$arr_search=array();
		$acl=array();//结果
		
		/************变量赋值*****************/
    	
    	if( empty($a_id) )
    		$a_id=$this->sess->userdata('a_id');
    		
    	/************数据处理*****************/
    		
    	//获取关联角色
		$arr_ra_id=$this->get_role($a_id);
			
    	//查询权限
		$arr_search=array();
		$arr_search['where']="AND op_id = ?  AND ra_id IN ? ";
		$arr_search['value']=array();
		$arr_search['value'][]=$op_id;
		$arr_search['value'][]=$arr_ra_id;
		$arr_search['field']='a_acl';
		$arr_search['from']='sys_acl';
		$rs=$this->m_db->query($arr_search);
		
		$acl=0;
		
//		if($this->sess->userdata('a_login_id') == 'admin')
//		$acl = 2;
		
		if($rs['content']>0)
		{
			foreach ($rs['content'] as $v) {
				$acl=$acl|$v['a_acl'];
			}
		}
		
		/************返回结果*****************/
		return $acl;
    	
    }
    
	/**
     * 
     * 验证权限
     */
	public function check_acl($op_id,$acl,$a_id=NULL)
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$arr_search=array();
		$rtn=FALSE;//结果
		
		/************变量赋值*****************/
    	
    	if( empty($a_id) )
    		$a_id=$this->sess->userdata('a_id');
    		
    	/************数据处理*****************/

//    	if($this->sess->userdata('a_login_id') == 'admin')
//    	return TRUE;
    	
    	//获取关联角色
		$arr_ra_id=$this->get_role($a_id);
		
		//查询权限
		$arr_search=array();
		$arr_search['where']="AND op_id = ? AND a_acl & ? AND ra_id IN ? ";
		$arr_search['value']=array();
		$arr_search['value'][]=$op_id;
		$arr_search['value'][]=pow(2,$acl);
		$arr_search['value'][]=$arr_ra_id;
		$arr_search['rows']=1;
		$arr_search['page']=1;
		$arr_search['field']='a_acl';
		$arr_search['from']='sys_acl';
		$rs=$this->m_db->query($arr_search);
		
		if( count($rs['content'])>0)
		{
			$rtn=TRUE;
		}
		
		/************返回结果*****************/
		return $rtn;
    }
    
    /**
     * 
     * 获取权限相关人
     */
	public function get_acl_person($op_id,$acl)
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$arr_search=array();
		$rtn=array();//结果
		
		/************变量赋值*****************/
    		
    	/************数据处理*****************/
    	
    	$arr_search['where']=' AND op_id= ? AND a_acl & ?';
		$arr_search['value'][]=$op_id;
		$arr_search['value'][]=pow(2, $acl);
		
    	$arr_search['field']='acl.op_id,
							  c.c_id,
							  a.a_id,
							  a.a_name,
							  a.a_login_id ra_login_id';
		
		$arr_search['from']='sys_acl acl
							 LEFT JOIN sys_ra_link ra ON
							 (ra.role_id = acl.ra_id)
							 LEFT JOIN sys_account a ON
							 (a.a_status = 2 AND (a.a_id =ra.a_id OR a.a_id = acl.ra_id))
							 LEFT JOIN sys_contact c ON
							 (c.a_id = a.a_id)';
		$arr_search['where'].=' GROUP BY a.a_id'; 
		
		$rs=$this->m_db->query($arr_search);
		
		if (count($rs['content']) > 0)
		{
			foreach($rs['content'] as $k => $v)
			{
				if($v['c_id'])
				$rtn[]=$v['c_id'];
			}
		}
		
		return array_unique($rtn);
    }
}