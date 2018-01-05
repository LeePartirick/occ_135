<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 配置类
 */
class M_proc_gfc extends CI_Model {
	
	private $acl_list;
	private $p_id='PROC_GFC';
	
 	public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
		
        $this->m_define();
        
    }
    
	/**
     * 
     * 定义
     */
	public function m_define()
    {
    	$p_id=$this->p_id;
    	
    	if( defined('LOAD_M_'.$p_id) ) return;
    	define('LOAD_M_'.$p_id, 1);
    	
    	define('ACL_'.$p_id.'_MANAGE', 0);//管理权限
    	define('ACL_'.$p_id.'_SUPER', 1);//超级权限
    	define('ACL_'.$p_id.'_ACL', 2);//权限分配权限
    	define('ACL_'.$p_id.'_USER', 3);//操作人权限
    	define('ACL_'.$p_id.'_REVIEW_EDIT', 4);//评审流程设计
    	define('ACL_'.$p_id.'_REVIEW', 5);//评审权限
    	define('ACL_'.$p_id.'_CODE', 6);//编号生成
    	define('ACL_'.$p_id.'_RETURN', 7);//合同归还审核
    	define('ACL_'.$p_id.'_SECRET', 8);//标密审核
    	define('ACL_'.$p_id.'_SECRET_MSG', 9);//标密审核通知
    	
    	$GLOBALS[$p_id]['text']['d_acl'] = array(
			ACL_PROC_GFC_SUPER=>'超级',
			ACL_PROC_GFC_ACL=>'权限分配',
			ACL_PROC_GFC_USER=>'操作',
			ACL_PROC_GFC_REVIEW_EDIT=>'评审设置',
			ACL_PROC_GFC_REVIEW=>'合同评审',
			ACL_PROC_GFC_CODE=>'编号生成',
			ACL_PROC_GFC_RETURN=>'合同归还审核',
			ACL_PROC_GFC_SECRET=>'标密审核',
			ACL_PROC_GFC_SECRET_MSG=>'标密审核通知',
		);
		
		$GLOBALS[$p_id]['text']['d_acl_note'] = array(
			ACL_PROC_GFC_SUPER=>'超级',
			ACL_PROC_GFC_ACL=>'权限分配',
			ACL_PROC_GFC_USER=>'操作',
			ACL_PROC_GFC_REVIEW_EDIT=>'评审设置',
			ACL_PROC_GFC_REVIEW=>'合同评审',
			ACL_PROC_GFC_CODE=>'编号生成',
			ACL_PROC_GFC_RETURN=>'合同归还审核',
			ACL_PROC_GFC_SECRET=>'标密审核',
			ACL_PROC_GFC_SECRET_MSG=>'标密审核通知',
		);
		
		//获取对应权限
    	$this->acl_list = $this->m_acl->get_acl($p_id);
    }
    
	/**
     * 
     * 验证权限
     */
	public function get_acl()
    {
    	return $this->acl_list;
    }
    
	/**
     * 
     * 生成导入xlsx
     */
	public function create_import_xlsx()
    {
//    	$this->load->model($this->p_id.'/m_gfc');
//    	$this->m_gfc->create_import_xlsx();
    	
    	$this->load->model($this->p_id.'/m_eli');
    	$this->m_eli->create_import_xlsx();
    	
    	$this->load->model($this->p_id.'/m_cr');
    	$this->m_cr->create_import_xlsx();
    }
    
 	/**
     * 
     * 检查文件
     */
    public function check_file($f_id,$op_id,$f_type_db,$f_type)
    {
    	$rtn=array();
    	$rtn['rtn']=TRUE;
    	$rtn['msg']='';
    	
    	return $rtn;
    	
    	if(is_array($f_type_db))
    	$f_type_db = implode('', $f_type_db);
    	
    	if(is_array($f_type))
    	$f_type_db = implode('', $f_type);
    	
    	if($f_type_db != $f_type)
    	{
    		//合同评审
			$arr_search=array();
			$arr_search['field']='gfcc_cr_id,gfc_id';
			$arr_search['from']="pm_gfc_cr gfcc";
			$arr_search['where']=' AND gfc_id IN ? GROUP BY gfcc_cr_id';
			$arr_search['value'][]=$op_id;
			
			$rs=$this->m_db->query($arr_search);
			
			if(count($rs['content'])>0)
			{
				$arr_cr_id = array();
				
				$gfc_id = '';
				
				foreach ($rs['content'] as $v) {
					$gfc_id = $v['gfc_id'];
					$arr_cr_id[] = $v['gfcc_cr_id'];
				}
				
				//验证是否存在必须上传文件
				$arr_search=array();
				$arr_search['field']='cr_link_file';
				$arr_search['from']="pm_contract_review";
				$arr_search['where']= " AND cr_id IN ? AND FIND_IN_SET('{$f_type_db}',cr_link_file) ";
				$arr_search['value'][] = $arr_cr_id;
				
				$rs=$this->m_db->query($arr_search);
				
				if(count($rs['content'])>0)
				{
					$arr_search=array();
					$arr_search['field']='lt.link_id';
					$arr_search['from']="sys_link lf
										 LEFT JOIN sys_link lt ON
										 (lt.op_id = lf.link_id AND lt.content = 'f_type') ";
					$arr_search['where']= " AND lf.op_id = ? AND lf.content = 'link_file' AND lt.link_id = ? GROUP BY lt.link_id";
					$arr_search['value'][] = $gfc_id;
					$arr_search['value'][] = $f_type_db ;
					$rs=$this->m_db->query($arr_search);
					
					if( count($rs['content']) == 1 )
					{
						$rtn['rtn']=FALSE;
    					$rtn['msg']='文件属性修改后，不符合【财务编号】-【合同评审】要求!';
					}
				}
			}
    	}
    	
    	return $rtn;
    }
}