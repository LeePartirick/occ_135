<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * sys_link 
        数据关联表 
         
 
 */
class M_link extends CI_Model {
	
	private $table_name='sys_link';
	private $table_form;
	
 	public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->m_define();
        
         //读取表结构
        $this->config->load('db_table/'.$this->table_name, FALSE,TRUE);
        $this->table_form=$this->config->item($this->table_name);
    }
    
	/**
     * 
     * 定义
     */
	public function m_define()
    {
    	if( defined('LOAD_M_LINK') ) return;
    	define('LOAD_M_LINK', 1);
    	
    	//define
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
     * 验证权限
     */
	public function check()
    {
    	
    }
    
	/**
	 * 
	 * @param $id
	 */
	public function get($op_id,$link_id,$sn=1)
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$data_db=array();//数据库数组
		$arr_search=array();
		$rtn=array();//结果
		
		/************变量赋值*****************/
		$arr_search['field']='*';
    	$arr_search['from']=$this->table_name;
		$arr_search['where']='AND op_id = ? AND sn= ? AND link_id= ?';
		$arr_search['value']=array();
		$arr_search['value'][]=$op_id;
		$arr_search['value'][]=$link_id;
		$arr_search['value'][]=$sn;
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
		
		/************变量赋值*****************/
		$data_save['content']=$content;
        
    	$sn=$this->m_db->get_m_value('sys_link','sn'," AND op_id='{$data_save['content']['op_id']}' AND link_id='{$data_save['content']['link_id']}' ");
    	$data_save['content']['sn']=$sn+1;					
    									
		/************数据处理*****************/
		$rtn=$this->m_db->insert($data_save['content'],$this->table_name);
		
		if($rtn['rtn'])
		{
			$rtn['id']=$data_save['content']['op_id'];
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
		$where='';
		/************变量赋值*****************/
		$data_save['content']=$content;
    	
		$where=" 1=1 AND op_id = '{$data_save['content']['op_id']}'
					 AND sn = '{$data_save['content']['sn']}'
					 AND link_id = '{$data_save['content']['link_id']}'
		";
		
		/************数据处理*****************/
		$rtn=$this->m_db->update($this->table_name,$data_save['content'],$where);
		
    	/************返回数据*****************/
		return $rtn;
    }
    
	/**
	 * 
	 * 删除
	 * @param $content
	 */
	public function del($op_id,$link_id,$sn=1)
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$where=array();
		
		/************变量赋值*****************/
		$where['op_id']=$op_id;
    	$where['sn']=$sn;
    	$where['link_id']=$link_id;
		/************数据处理*****************/
		$rtn=$this->m_db->delete($this->table_name,$where);
		
    	/************返回数据*****************/
		return $rtn;
    }
    
	/**
	 * 
	 * 删除
	 * @param $content
	 */
	public function del_where($where=array())
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		
		/************变量赋值*****************/
    	
		/************数据处理*****************/
    	if( count($where) == 0)
    	return ;
    	
		$rtn=$this->m_db->delete($this->table_name,$where);
		
    	/************返回数据*****************/
		return $rtn;
    }
    
	/**
	 * 
	 * 删除
	 * @param $content
	 */
	public function del_all($op_id)
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$where=array();
		
		/************变量赋值*****************/
		$where['op_id']=$op_id;
		/************数据处理*****************/
		$rtn=$this->m_db->delete($this->table_name,$where);
		
		$where=array();
		$where['link_id']=$op_id;
		$rtn=$this->m_db->delete($this->table_name,$where);
    	/************返回数据*****************/
		return $rtn;
    }
}