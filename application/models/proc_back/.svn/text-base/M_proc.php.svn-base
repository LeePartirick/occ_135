<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 流程类
 */
class M_proc extends CI_Model {
	
	private $table_name='sys_proc';
	private $table_form;
	
 	public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        
        $table_name=$this->table_name;
        
   	 	//读取表结构
        $this->config->load('db_table/'.$table_name, FALSE,TRUE);
        $table_form=$this->config->item($table_name);
        
        //不存在表
        if ( ! $this->db->table_exists($table_name.date("Y")))
        {
        	 $this->m_db->update_db_table( $table_name );
        }
        
		$this->table_form=$table_form;
		
        $this->m_define();
        
    }
    
	/**
     * 
     * 定义
     */
	public function m_define()
    {
    	if( defined('LOAD_M_PROC') ) return;
    	define('LOAD_M_PROC', 1);
    	
    	//可查询字段
    	$GLOBALS['m_proc']['text']['field_search'] = array(
			'p_id'=>'id',
			'p_name'=>'流程名称',
    		'p_status_run'=>'启用状态',
    		'p_class'=>'分类',
    		'p_note'=>'流程描述',
    		'db_time_create'=>'创建时间',
    		'db_time_update'=>'更新时间',
		);
		
		// 启用状态
		define('P_STATUS_RUN_STOP', 0);  // 停用
		define('P_STATUS_RUN_START', 1); // 启用
		
		$GLOBALS['m_proc']['text']['p_status_run'] = array(
			P_STATUS_RUN_STOP=>'停用',
			P_STATUS_RUN_START=>'启用'
		);
		
		// 流程分类
		define('P_CLASS_OA', 'OA');  // 
		define('P_CLASS_CRM', 'CRM'); // 
		define('P_CLASS_HR', 'HR'); // 
		define('P_CLASS_SM', 'SM'); // 
		define('P_CLASS_PM', 'PM'); // 
		define('P_CLASS_FM', 'FM'); // 
		define('P_CLASS_ZC', 'ZC'); // 
		define('P_CLASS_BI', 'BI'); // 
		define('P_CLASS_OTHER', 'OTHER'); // 
		$GLOBALS['m_proc']['text']['p_class'] = array(
			P_CLASS_OA=>'OA',
			P_CLASS_CRM=>'CRM',
			P_CLASS_HR=>'HR',
			P_CLASS_SM=>'SM',
			P_CLASS_PM=>'PM',
			P_CLASS_FM=>'FM',
			P_CLASS_ZC=>'ZC',
			P_CLASS_BI=>'BI',
			P_CLASS_OTHER=>'其他',
		);
		
		//可查询字段规则
    	$GLOBALS['m_proc']['text']['field_search_rule'] ='
    		{"id":"p_id","text":"p_id","rule":{"field":"p_id","table":"sys_proc","field_s":"p_id","rule":"like","value":"","group":"search","editor":"text"}},
			{"id":"p_name","text":"流程名称","rule":{"field":"p_name","table":"sys_proc","field_s":"流程名称","rule":"like","value":"","group":"search","editor":"text"}},
			{"id":"p_note","text":"流程描述","rule":{"field":"p_note","table":"sys_proc","field_s":"流程描述","rule":"like","value":"","group":"search","editor":"text"}},
			{"id":"p_status_run","text":"启用状态","rule":{"field":"p_status_run","table":"sys_proc","field_s":"启用状态","rule":"in","value":"","group":"search","editor":{
								"type":"combotree",
								"options":{
								"valueField": "id",
								"textField": "text",
								"panelHeight":"auto",
								"multiple":"true",
								"data":['.get_json_for_arr($GLOBALS['m_proc']['text']['p_status_run'] ).']
								}
							}} },
			{"id":"p_class","text":"分类","rule":{"field":"p_class","table":"sys_proc","field_s":"分类","rule":"in","value":"","group":"search","editor":{
								"type":"combotree",
								"options":{
								"valueField": "id",
								"textField": "text",
								"panelHeight":"auto",
								"multiple":"true",
								"data":['.get_json_for_arr($GLOBALS['m_proc']['text']['p_class'] ).']
								}
							}} },
    		{"id":"db_time_create_start","text":"创建时间(始)","rule":{"field":"db_time_create_start","field_r":"db_time_create","table":"sys_proc","field_s":"创建时间(始)","rule":">=","value":"","group":"search","editor":"datebox"}},
    		{"id":"db_time_create_end","text":"创建时间(止)","rule":{"field":"db_time_create_end","field_r":"db_time_create","table":"sys_proc","field_s":"创建时间(止)","rule":"<=","value":"","group":"search","editor":"datebox"}}
		';
		
    	$GLOBALS['m_proc']['text']['field_search_rule_default']='{"field":"p_id","field_s":"p_id","rule":"like","value":"","group":"search","editor":"text"}';
    	
    	//初始查询字段
    	$GLOBALS['m_proc']['text']['field_search_start'] =array(
    		'p_id',
			'p_name',
    		'p_class',
    		'p_status_run',
    		'p_note',
    	);
    	
		//数据字典
		$GLOBALS['m_proc']['text']['field_search_value_dispaly']=array(
			'p_status_run'=>$GLOBALS['m_proc']['text']['p_status_run'],
			'p_class'=>$GLOBALS['m_proc']['text']['p_class']
		);
		
		//显示方法
		$GLOBALS['m_proc']['text']['show_by_rule'] = array();
    }
    
	/**
	 * 
	 * 获取流程
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
		$arr_search['where']='AND p_id = ? ';
		$arr_search['value'][]=$id;
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
		$data_save['content']['db_time_create']=date("Y-m-d H:i:s");
		$data_save['content']['db_time_update']=date("Y-m-d H:i:s");
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
		$where=" 1=1 AND p_id = '{$data_save['content']['p_id']}'";
		
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
    	$where['p_id']=$id;
    	
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
	 * 获取流程列表
	 * @param $content
	 */
	public function get_list_proc()
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$where=array();
		$arr_search=array();
		$list_proc=array();
		/************变量赋值*****************/
    	
		/************数据处理*****************/
		
		$arr_search['field']='p_id,
							  p_name,
							  p_note,
							  p_class';
		
		$arr_search['from']='sys_proc ';
		$arr_search['where']='';
		$arr_search['value']=array();
		
		$rs=$this->m_db->query($arr_search);
		
		$list_proc_exist=array();
		
		if(count($rs['content'])>0)
		{
			foreach ($rs['content'] as $v) {
				$list_proc_exist[$v['p_id']]=$v;
			}
		}
		
    	$path=str_replace('\\', '/', APPPATH).'config/proc';
		$list_proc_conf = directory_map($path, 1);
		if(count($list_proc_conf)>0)
		{
			foreach ($list_proc_conf as $k=>$v) {
				
				$v = trim($v,'\\');
				
				$this->config->load('proc/'.$v.'/conf', FALSE, TRUE);
				
				$data_save['content'] = $this->config->item('p_conf');
				$data_save['content']['p_id'] =$v ;
				
				if(isset($list_proc_exist[$v]))
				{
//					$this->update($data_save['content']);
				}
				else 
				{
					$this->add($data_save['content']);
				}
				
				unset($list_proc_exist[$v]);
			}
		}
		
		if(count($list_proc_exist) > 0 )
		{
			foreach ($list_proc_exist as $k=>$v) {
				$this->del($k);
			}
		}
		
    	/************返回数据*****************/
		return $list_proc;
    }
}