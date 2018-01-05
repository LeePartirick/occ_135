<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 配置类
 */
class M_proc_back extends CI_Model {
	
	private $acl_list;
	private $p_id='PROC_BACK';
	
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
    	define('ACL_'.$p_id.'_MODEL', 2);//权限分配权限
    	define('ACL_'.$p_id.'_ACCOUNT', 3);//账户管理
    	define('ACL_'.$p_id.'_ROLE', 4);//角色管理
    	define('ACL_'.$p_id.'_ACL', 5);//权限管理
    	
    	$GLOBALS[$p_id]['text']['d_acl'] = array(
			ACL_PROC_BACK_SUPER=>'超级',
			ACL_PROC_BACK_MODEL=>'模块管理',
			ACL_PROC_BACK_ACCOUNT=>'账户管理',
			ACL_PROC_BACK_ROLE=>'角色管理',
			ACL_PROC_BACK_ACL=>'权限管理',
		);
		
		$GLOBALS[$p_id]['text']['d_acl_note'] = array(
			ACL_PROC_BACK_SUPER=>'超级',
			ACL_PROC_BACK_MODEL=>'模块管理',
			ACL_PROC_BACK_ACCOUNT=>'账户管理',
			ACL_PROC_BACK_ROLE=>'角色管理',
			ACL_PROC_BACK_ACL=>'权限管理',
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
    	$this->load->model($this->p_id.'/m_account');
    	$this->m_account->create_import_xlsx();
    	
    	$this->load->model($this->p_id.'/m_role');
    	$this->m_role->create_import_xlsx();
    	
    }
}