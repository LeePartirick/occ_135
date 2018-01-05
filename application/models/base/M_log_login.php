<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 基础日志(登陆日志)类
 */
class M_log_login extends CI_Model {
	
	private $table_name;
	private $table_form;
	
 	public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        
        $table_name='sys_log_login';
        
   	 	//读取表结构
        $this->config->load('db_table/'.$table_name, FALSE,TRUE);
        $table_form=$this->config->item($table_name);
        
        //不存在表
        if ( ! $this->db->table_exists($table_name.date("Y")))
        {
        	 $this->m_db->update_db_table( $table_name );
        }
        
        $this->table_name=$table_name;
		$this->table_form=$table_form;
		
		$this->m_define();
    }
    
	/**
     * 
     * 定义
     */
	public function m_define()
    {
    	if( defined('LOAD_M_LOG_LOGIN') ) return;
    	define('LOAD_M_LOG_LOGIN', 1);
    	
    	// 结果
		define('LOG_RESULT_FAIL', 1);  // 成功
		define('LOG_RESULT_SUCCESS', 0); // 失败
		
		$GLOBALS['m_log_login']['text']['log_result'] = array(
			LOG_RESULT_SUCCESS=>'成功',
			LOG_RESULT_FAIL=>'失败'
		);
		
		// 登陆类型
		define('LOG_UA_TYPE_B', 1);  // 浏览器
		define('LOG_UA_TYPE_M', 2); // 移动端
		define('LOG_UA_TYPE_O', 3); // 其他
		
		$GLOBALS['m_log_login']['text']['log_ua_type'] = array(
			LOG_UA_TYPE_B=>'浏览器',
			LOG_UA_TYPE_M=>'移动端',
			LOG_UA_TYPE_O=>'其他'
		);
		
    }
    
	/**
     * 
     * 验证权限
     */
	public function check()
    {
    	
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
         
        $data_save['content']['log_id']=get_guid(); 
        $data_save['content']['log_time']=date("Y-m-d H:i:s"); 
        $data_save['content']['db_time_update']=date("Y-m-d H:i:s"); 
        
        $data_save['content']['log_client_ip']=get_ip(); 
        $data_save['content']['log_user_agent']=$this->ua->agent_string(); 
        
        if($this->ua->is_browser())
        {
        	$data_save['content']['log_ua_type']=LOG_UA_TYPE_B; 
        	$data_save['content']['log_ua_name']=$this->ua->browser().' '.$this->ua->version(); 
        }
        elseif($this->ua->is_mobile())
        {
        	$data_save['content']['log_ua_type']=LOG_UA_TYPE_B; 
        	$data_save['content']['log_ua_name']=$this->ua->mobile(); 
        }
        else 
        {
        	$data_save['content']['log_ua_type']=LOG_UA_TYPE_O; 
        }
        
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
    
}