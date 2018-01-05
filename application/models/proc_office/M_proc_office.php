<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 配置类
 */
class M_proc_office extends CI_Model {
	
	private $acl_list;
	private $p_id='PROC_OFFICE';
	
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
    	define('ACL_'.$p_id.'_ACCOUNT', 4);//账户开通权限
    	define('ACL_'.$p_id.'_CHECK', 5);//审核权限
    	define('ACL_'.$p_id.'_EDIT', 6);//编辑权限
    	define('ACL_'.$p_id.'_ALL', 7);//查看权限
    	
    	$GLOBALS[$p_id]['text']['d_acl'] = array(
			ACL_PROC_OFFICE_SUPER=>'超级',
			ACL_PROC_OFFICE_ACL=>'权限分配',
			ACL_PROC_OFFICE_USER=>'操作',
			ACL_PROC_OFFICE_ACCOUNT=>'账户开通',
			ACL_PROC_OFFICE_CHECK=>'审核',
			ACL_PROC_OFFICE_EDIT=>'信息系统-编辑',
//			ACL_PROC_OFFICE_ALL=>'信息系统-全部',
		);
		
		$GLOBALS[$p_id]['text']['d_acl_note'] = array(
			ACL_PROC_OFFICE_SUPER=>'超级',
			ACL_PROC_OFFICE_ACL=>'权限分配',
			ACL_PROC_OFFICE_USER=>'操作',
			ACL_PROC_OFFICE_ACCOUNT=>'账户开通',
			ACL_PROC_OFFICE_CHECK=>'审核',
			ACL_PROC_OFFICE_EDIT=>'信息系统-编辑',
//			ACL_PROC_OFFICE_ALL=>'信息系统-全部',
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
    	$this->load->model($this->p_id.'/m_oa_office');
        $this->m_oa_office->create_import_xlsx();

        $this->load->model($this->p_id.'/m_oa_contact');
        $this->m_oa_contact->create_import_xlsx();
    }
}