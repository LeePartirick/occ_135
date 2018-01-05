<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 基础验证类
 */
class M_check extends CI_Model {
	
 	public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }
    
	/**
     * 
     * 定义
     */
	public function m_define()
    {
    	if( defined('LOAD_M_CHECK') ) return;
    	define('LOAD_M_CHECK', 1);
    	
    	//可查询字段
    	$GLOBALS['m_check']['text']['fun_check'] = array(
    		'field'=>'field'
    	);
    	
//    	//可查询字段
//    	$GLOBALS['m_check']['text']['fun_check_regex'] = array(
//    		'field'=>'field'
//    	);
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
     * 唯一性验证
     */
	public function unique($table,$field,$value,$where)
    {
    	$rtn=TRUE;
    	
    	$arr_search=array();
    	$arr_search['page']=1;
		$arr_search['rows']=1;
		
		$arr_search['where']=' AND '.$field.'= ? '.$where;
		$arr_search['value']=array($value);
		
    	$arr_search['field']=$field;
		
		$arr_search['from']=$table;
		$rs=$this->m_db->query($arr_search);
		
		if($rs['total']>0)
		$rtn = FALSE;
		
		return $rtn;
    }
    
	/**
     * 
     * 时间冲突验证
     */
	public function time_unique($table,$field_start,$field_end,$time_start,$time_end,$where)
    {
    	$rtn=TRUE;
    	
    	$arr_search=array();
    	$arr_search['page']=1;
		$arr_search['rows']=1;
		
		$arr_search['where']=' AND (
									('.$field_start.'> ? AND '.$field_start.' < ? )
								OR  ('.$field_start.' < ? AND '.$field_end.' > ?)   
								OR  ('.$field_end.' > ? AND '.$field_end.' < ?) 
								)'.$where;
		$arr_search['value']=array();
		$arr_search['value'][]=$time_start;
		$arr_search['value'][]=$time_end;
		$arr_search['value'][]=$time_start;
		$arr_search['value'][]=$time_end;
		$arr_search['value'][]=$time_start;
		$arr_search['value'][]=$time_end;
		
    	$arr_search['field']=$field_start;
		$arr_search['from']=$table;
		$rs=$this->m_db->query($arr_search);
		
		if($rs['total']>0)
		$rtn = FALSE;
		
		return $rtn;
    }
    
	/**
     * 
     * 字段格式验证
     */
	public function field($v)
    {
    	$rtn=FALSE;
    	
    	$regex1 = "/^[a-z]{1}/";
    	$regex2 = "/^[A-Za-z0-9_]+$/";
		
		if( preg_match($regex1, $v) && preg_match($regex2, $v))
		$rtn = TRUE;
		
		return $rtn;
    }
    
	/**
     * 
     * 电话格式验证
     */
	public function phone($v)
    {
    	$rtn=FALSE;
    	
    	$regex1 = "/^0\d{2,3}-?\d{7,8}$/";
		
		if( preg_match($regex1, $v) )
		$rtn = TRUE;
    	
		return $rtn;
    }
    
	/**
     * 
     * 手机格式验证
     */
	public function tele($v,$check='')
    {
    	$this->load->model('base/m_web_info');
    	
    	$rtn=FALSE;
    	
    	$info=$this->m_web_info->get_tele_info($v);
    	
		if( ! empty($info) )
		$rtn=$info;
		else 
		{
			$regex = "/^(1\d{10}$/";//"/^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\d{8}$/";
			
			$rtn = preg_match($regex, $v);// 用正则进行文本格式检查
			
			return $rtn;
		}
		
		$arr_check=array();
		
		if($check)
		$arr_check=explode(',', fun_urldecode($check));
		
		if(count($arr_check)>0)
		{
			foreach ($arr_check as $value) {
				if($value && ! strstr($info, $value))
				{
					return FALSE;
				}
			}
		}
    	
		return $rtn;
    }
    
    
}