<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 基础日志(操作日志)类
 */
class M_log_operate extends CI_Model {
	
	private $table_name;
	private $table_form;
	
 	public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        
        $table_name='sys_log_operate';
        
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
    	if( defined('LOAD_M_LOG_OPERATE') ) return;
    	define('LOAD_M_LOG_OPERATE', 1);
    	
    	//可查询字段
    	$GLOBALS['m_log_operate']['text']['field_search'] = array(
    		'log_time'=>'操作时间',
    		'a_login_id'=>'账户',
			'c_name'=>'操作人',
    		'log_client_ip'=>'来源IP',
    		'log_user_agent'=>'客户端',
    		'log_act'=>'类型',
    		'log_note'=>'备注',
    		'log_content'=>'',
    		'log_url'=>'',
		);
		
		$GLOBALS['m_log_operate']['text']['log_act'] = array(
			STAT_ACT_CREATE=>'创建',
			STAT_ACT_EDIT=>'编辑',
			STAT_ACT_VIEW=>'查看',
			STAT_ACT_REMOVE=>'删除',
			STAT_ACT_PRINT=>'打印'
		);
		
		//可查询字段规则
    	$GLOBALS['m_log_operate']['text']['field_search_rule'] ='
    		{"id":"log_time","text":"操作时间(始)","rule":{"field":"log_time","field_s":"操作时间(始)","rule":">=","value":"","group":"search","editor":"datetimebox"}},
    		{"id":"log_time_end","text":"操作时间(止)","rule":{"field":"log_time_end","field_r":"log_time","field_s":"操作时间(止)","rule":"<=","value":"","group":"search","editor":"datetimebox"}},
			{"id":"a_login_id","text":"账户","rule":{"field":"a_login_id","field_s":"账户","rule":"like","value":"","group":"search","editor":"text"}},
			{"id":"log_client_ip","text":"来源IP","rule":{"field":"log_client_ip","field_s":"来源IP","rule":"like","value":"","group":"search","editor":"text"}},
			{"id":"log_user_agent","text":"客户端","rule":{"field":"log_user_agent","field_s":"客户端","rule":"like","value":"","group":"search","editor":"text"}},
			{"id":"c_name","text":"操作人","rule":{"field":"c_name","field_r":"CONCAT(c_name,a_login_id)","field_s":"操作人","rule":"like","value":"","group":"search","editor":"text"}},
			{"id":"log_act","text":"操作类型","rule":{"field":"log_act","field_s":"操作类型","rule":"in","value":"","group":"search","editor":{
								"type":"combotree",
								"options":{
								"valueField": "id",
								"textField": "text",
								"panelHeight":"auto",
								"multiple":"true",
								"data":['.get_json_for_arr($GLOBALS['m_log_operate']['text']['log_act'] ).']
								}
							}} },
    		{"id":"log_note","text":"备注","rule":{"field":"log_note","field_s":"备注","rule":"like","value":"","group":"search","editor":"text"}},
		';
		
    	$GLOBALS['m_log_operate']['text']['field_search_rule_default']='{"field":"a_login_id","field_s":"账户","rule":"like","value":"","group":"search","editor":"text"}';
    	
    	//初始查询字段
    	$GLOBALS['m_log_operate']['text']['field_search_start'] =array(
    		'c_name',
    		'log_time',
			'log_time_end',
    		'log_client_ip',
    		'log_act',
    	);
    	
		//数据字典
		$GLOBALS['m_log_operate']['text']['field_search_value_dispaly']=array(
			'log_act'=>$GLOBALS['m_log_operate']['text']['log_act']
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
        $data_save['content']['a_id']=$this->sess->userdata('a_id') ;
        $data_save['content']['a_login_id']=$this->sess->userdata('a_login_id') ;
        $data_save['content']['c_id']=$this->sess->userdata('c_id') ;
        $data_save['content']['c_name']=$this->sess->userdata('c_name') ;
        $data_save['content']['log_time']=date("Y-m-d H:i:s"); 
        $data_save['content']['db_time_update']=date("Y-m-d H:i:s"); 
        
        $data_save['content']['log_client_ip']=get_ip(); 
        $data_save['content']['log_user_agent']=$this->ua->agent_string(); 
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