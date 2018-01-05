<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 配置类
 */
class M_proc_bill extends CI_Model {
	
	private $acl_list;
	private $p_id='PROC_BILL';
	
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
    	define('ACL_'.$p_id.'_CHECK', 4);//复核权限
    	define('ACL_'.$p_id.'_BILL', 5);//审核权限
    	
    	$GLOBALS[$p_id]['text']['d_acl'] = array(
			ACL_PROC_BILL_SUPER=>'超级',
			ACL_PROC_BILL_ACL=>'权限分配',
			ACL_PROC_BILL_USER=>'操作',
			ACL_PROC_BILL_CHECK=>'审核',
			ACL_PROC_BILL_BILL=>'开票',
		);
		
		$GLOBALS[$p_id]['text']['d_acl_note'] = array(
			ACL_PROC_BILL_SUPER=>'超级',
			ACL_PROC_BILL_ACL=>'权限分配',
			ACL_PROC_BILL_USER=>'操作',
			ACL_PROC_BILL_CHECK=>'审核',
			ACL_PROC_BILL_BILL=>'开票',
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
    	$this->load->model($this->p_id.'/m_bill');
        $this->m_bill->create_import_xlsx();
    }
}