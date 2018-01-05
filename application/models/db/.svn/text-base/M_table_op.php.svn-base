<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 *  
      数据表操作
 */
class M_table_op extends CI_Model {
	
	private $table_name='';
	private $pk_id='';
	private $table_form;
	
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
		
    }
    
	/**
     * 
     * 载入表
     */
    public function load($table)
    {
    	$this->table_name=$table;
    	 //读取表结构
        $this->config->load('db_table/'.$this->table_name, FALSE,TRUE);
        $this->table_form=$this->config->item($this->table_name);
        $this->pk_id=current($this->table_form['primary_key']);
    }
    
    /**
     * 
     * 获取结构
     */
    public function get_table_form()
    {
		return $this->table_form;    
    }
    
	/**
	 * 
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
		$arr_search['where']='AND '.$this->pk_id.' = ? ';
		$arr_search['value'][]=$id;
    	$rs=$this->m_db->query($arr_search);
    	
    	if(count($rs['content'])>0)
    	$rtn=current($rs['content']);
    	
    	/************返回数据*****************/
		return $rtn;
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
         
        if( empty(element($this->pk_id,$data_save['content'])) ) $data_save['content'][$this->pk_id]=get_guid(); 
        $data_save['content']['db_time_update']=date("Y-m-d H:i:s"); 
        $data_save['content']['db_time_create']=date("Y-m-d H:i:s"); 
        $data_save['content']['db_person_create']=$this->sess->userdata('c_id') ;
		/************数据处理*****************/
		
		if($rtn['rtn'])
        $rtn=$this->m_db->insert($data_save['content'],$this->table_name);
		
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
		$where=" 1=1 AND {$this->pk_id} = '{$data_save['content'][$this->pk_id]}'";
		
		/************数据处理*****************/
		
		if($rtn['rtn'])
        $rtn=$this->m_db->update($this->table_name,$data_save['content'],$where);
        	
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
		$where[$this->pk_id]=$id;
		/************数据处理*****************/
		if($rtn['rtn'])
        $rtn=$this->m_db->delete($this->table_name,$where);
        	
    	/************返回数据*****************/
		return $rtn;
    }
	
}