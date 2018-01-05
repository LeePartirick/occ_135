<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 配置类
 */
class M_proc_hr extends CI_Model {
	
	private $acl_list;
	private $p_id='PROC_HR';
	
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
    	define('ACL_'.$p_id.'_OFFER_FCHECK', 4);//员工录用审核
    	define('ACL_'.$p_id.'_OFFER_CHECK', 5);//员工录用审核
    	define('ACL_'.$p_id.'_INFO_CHECK', 6);//信息修改-审核
    	define('ACL_'.$p_id.'_DIM_FCHECK', 7);//员工离职-复核
    	define('ACL_'.$p_id.'_DIM_CHECK', 8);//员工离职-审核
    	define('ACL_'.$p_id.'_VIEW_ALL', 9);//人事索引-查看全部
    	define('ACL_'.$p_id.'_INFO', 10);//员工信息-全部
    	define('ACL_'.$p_id.'_VIEW', 11);//员工信息-查看
    	
    	$GLOBALS[$p_id]['text']['d_acl'] = array(
			ACL_PROC_HR_SUPER=>'超级',
			ACL_PROC_HR_ACL=>'权限分配',
			ACL_PROC_HR_USER=>'操作',
			ACL_PROC_HR_VIEW=>'员工信息-查看',
			ACL_PROC_HR_INFO=>'员工信息-全部',
			ACL_PROC_HR_VIEW_ALL=>'员工索引-全部',
			ACL_PROC_HR_OFFER_FCHECK=>'员工录用-复核',
			ACL_PROC_HR_OFFER_CHECK=>'员工录用-审核',
			ACL_PROC_HR_INFO_CHECK=>'信息修改-审核',
			ACL_PROC_HR_DIM_FCHECK=>'员工离职-复核',
			ACL_PROC_HR_DIM_CHECK=>'员工离职-审核',
		);
		
		$GLOBALS[$p_id]['text']['d_acl_note'] = array(
			ACL_PROC_HR_SUPER=>'超级',
			ACL_PROC_HR_ACL=>'权限分配',
			ACL_PROC_HR_USER=>'可以创建员工录用<br>编辑所属机构的员工信息<br>创建员工离职<br>编辑职位、职务、技术方向',
			ACL_PROC_HR_VIEW=>'可以查看可见部门的员工部分信息',
			ACL_PROC_HR_INFO=>'可以查看员工的完整信息',
			ACL_PROC_HR_VIEW_ALL=>'可以搜索到所有员工',
			ACL_PROC_HR_OFFER_FCHECK=>'员工录用-复核',
			ACL_PROC_HR_OFFER_CHECK=>'员工录用-审核',
			ACL_PROC_HR_INFO_CHECK=>'信息修改-审核',
			ACL_PROC_HR_DIM_FCHECK=>'员工离职-复核',
			ACL_PROC_HR_DIM_CHECK=>'员工离职-审核',
		);
		
		//获取对应权限
    	$this->acl_list = $this->m_acl->get_acl($p_id);
    }
    
	/**
     * 
     * 验证权限
     */
	public function get_acl($c_id=NULL)
    {
    	return $this->acl_list;
    }
    
	/**
     * 
     * 生成导入xlsx
     */
	public function create_import_xlsx()
    {
    	$this->load->model($this->p_id.'/m_hr_job');
    	$this->m_hr_job->create_import_xlsx();
    	
		//生成技术方向xlsx
		$this->load->model($this->p_id.'/m_hr_tec');
		$this->m_hr_tec->create_import_xlsx();
		
		//生成职务管理xlsx
		$this->load->model($this->p_id.'/m_hr_zw');
		$this->m_hr_zw->create_import_xlsx();
		
		//生成合同xlsx
		$this->load->model($this->p_id.'/m_hr_contract');
		$this->m_hr_contract->create_import_xlsx();
		
		//生成离职人员xlsx
		$this->load->model($this->p_id.'/m_hr_dim');
		$this->m_hr_dim->create_import_xlsx();

        $this->load->model($this->p_id.'/m_hr_info');
        $this->m_hr_info->create_import_xlsx();

        $this->load->model($this->p_id.'/m_hr_card');
        $this->m_hr_card->create_import_xlsx();
    }
}