<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 配置类
 */
class M_proc_doc extends CI_Model {
	
	private $acl_list;
	private $p_id='PROC_DOC';
	
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
    	define('ACL_'.$p_id.'_AUDIT', 4);//归档-审核权限
    	define('ACL_'.$p_id.'_APPROVAL', 5);//归档-审批权限
    	define('ACL_'.$p_id.'_BORROW_FCHECK', 6);//借阅-复核权限
    	define('ACL_'.$p_id.'_BORROW_AUDIT', 7);//借阅-审核权限
    	define('ACL_'.$p_id.'_BORROW_APPROVAL', 8);//借阅-审批权限
//    	define('ACL_'.$p_id.'_LOST_AUDIT', 9);//遗失-审核权限
    	define('ACL_'.$p_id.'_LOST_APPROVAL', 9);//遗失-审批权限

    	$GLOBALS[$p_id]['text']['d_acl'] = array(
			ACL_PROC_DOC_SUPER=>'超级',
			ACL_PROC_DOC_ACL=>'权限分配',
			ACL_PROC_DOC_USER=>'操作',
			ACL_PROC_DOC_AUDIT=>'归档（遗失）-审核',
			ACL_PROC_DOC_APPROVAL=>'归档-审批',
			ACL_PROC_DOC_BORROW_FCHECK=>'借阅-复核',
			ACL_PROC_DOC_BORROW_AUDIT=>'借阅-审核',
			ACL_PROC_DOC_BORROW_APPROVAL=>'借阅',
//			ACL_PROC_DOC_LOST_AUDIT=>'遗失-审核',
			ACL_PROC_DOC_LOST_APPROVAL=>'遗失-审批',
		);
		
		$GLOBALS[$p_id]['text']['d_acl_note'] = array(
			ACL_PROC_DOC_SUPER=>'超级',
			ACL_PROC_DOC_ACL=>'权限分配',
			ACL_PROC_DOC_USER=>'操作',
			ACL_PROC_DOC_AUDIT=>'归档（遗失）-审核',
			ACL_PROC_DOC_APPROVAL=>'归档-审批',
            ACL_PROC_DOC_BORROW_FCHECK=>'借阅-复核',
            ACL_PROC_DOC_BORROW_AUDIT=>'借阅-审核',
            ACL_PROC_DOC_BORROW_APPROVAL=>'借阅',
//			ACL_PROC_DOC_LOST_AUDIT=>'遗失-审核',
			ACL_PROC_DOC_LOST_APPROVAL=>'遗失-审批',
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
		$this->load->model($this->p_id.'/m_doc');
    	$this->m_doc->create_import_xlsx();
    	
    	$this->load->model($this->p_id.'/m_doc_borrow');
    	$this->m_doc_borrow->create_import_xlsx();
    }
}