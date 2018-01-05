<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * sys_work_list 
         
         
 
 */
class M_work_list extends CI_Model {
	
	private $table_name='sys_work_list';
	private $pk_id='wl_id';
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
    	if( defined('LOAD_M_WORK_LIST') ) return;
    	define('LOAD_M_WORK_LIST', 1);
    	
    	//define
    	define('WL_TYPE_I', 1); //我发起的
    	define('WL_TYPE_YJ', 2); //移交工单
    	
    	define('WL_STATUS_READ', 1); //已读
    	define('WL_STATUS_FINISH', 2); //完成
    	define('WL_STATUS_GUOQI', 3); //过期
    	define('WL_STATUS_FAIL', 4); //失效
    	
    	define('WLP_TYPE_ACCEPT', 0); // 接收人
    	define('WLP_TYPE_CARE', 1); // 关注人
    	
    	define('WL_RESULT_BACK', 0); // 退回
    	define('WL_RESULT_SUCCESS', 1); // 通过
    	define('WL_RESULT_YJ', 2); // 移交
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
        
        if( ! empty(element('wl_comment', $data_save['content'])) )
        $data_save['content']['wl_comment'] = $this->m_base->filter_img($data_save['content']['wl_comment']);
        
        if( ! empty(element('wl_comment_new', $data_save['content'])) )
        $data_save['content']['wl_comment_new'] = $this->m_base->filter_img($data_save['content']['wl_comment_new']);
        
        if( empty(element('wl_code', $data_save['content'])) )
        {
        	$data_save['content']['wl_code'] = $this->m_base->get_field_where('sys_work_list','wl_code'
        	," AND wl_type ='".WL_TYPE_I."' AND wl_id = '{$data_save['op_id']}' ");
        }
		/************数据处理*****************/
		
    	$this->db->trans_begin();
		
		if($rtn['rtn'])
        $rtn=$this->m_db->insert($data_save['content'],$this->table_name);
        
        if( $rtn['rtn'] 
         && is_array(element('c_accept', $data_save['content'])) 
         && count($data_save['content']['c_accept']) > 0 )
        {
        	$this->m_table_op->load('sys_wl_person');
        	
        	$arr_tmp=array();
        	
        	foreach ($data_save['content']['c_accept'] as $v) {
        		
        		if( in_array($v, $arr_tmp) )
        		continue;
        		$arr_tmp[]=$v;
        		
        		$data_save['wlp']=array();
        		$data_save['wlp']['wl_id'] = $data_save['content'][$this->pk_id];
        		$data_save['wlp']['wl_op_id'] = $data_save['content']['op_id'];
        		$data_save['wlp']['wl_pp_id'] = $data_save['content']['pp_id'];
        		$data_save['wlp']['wlp_person'] = $v ;
        		
        		$this->m_table_op->add($data_save['wlp']);
        	}
        }
        
   	 	if( $rtn['rtn'] 
   	 	 && is_array(element('c_care', $data_save['content'])) 
   	 	 && count($data_save['content']['c_care']) > 0 )
        {
        	$this->m_table_op->load('sys_wl_person');
        	$arr_tmp=array();
        	
        	foreach ($data_save['content']['c_care'] as $v) {
        		
        		if( in_array($v, $arr_tmp) )
        		continue;
        		$arr_tmp[]=$v;
        		
        		$data_save['wlp']=array();
        		$data_save['wlp']['wl_id'] = $data_save['content'][$this->pk_id];
        		$data_save['wlp']['wl_op_id'] = $data_save['content']['op_id'];
        		$data_save['wlp']['wl_pp_id'] = $data_save['content']['pp_id'];
        		$data_save['wlp']['wlp_person'] = $v ;
        		$data_save['wlp']['wlp_type'] = WLP_TYPE_CARE ;
        		
        		$this->m_table_op->add($data_save['wlp']);
        	}
        }
        	
    	if( ! $rtn['rtn'] )
	    {
		    $this->db->trans_rollback();
		}
		else
		{
		    $this->db->trans_commit();
		    $rtn['id']=$data_save['content'][$this->pk_id];
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
    	 
        $data_save['content']['db_time_update']=date("Y-m-d H:i:s");
		$where=" 1=1 AND {$this->pk_id} = '{$data_save['content'][$this->pk_id]}'";
		
		/************数据处理*****************/
    	$this->db->trans_begin();
		
		if($rtn['rtn'])
        $rtn=$this->m_db->update($this->table_name,$data_save['content'],$where);
        	
    	if( $rtn['rtn'] 
         && is_array(element('c_accept', $data_save['content'])) 
         && count($data_save['content']['c_accept']) > 0 )
        {
        	$this->m_table_op->load('sys_wl_person');
        	
        	$arr_tmp=array();
        	
        	foreach ($data_save['content']['c_accept'] as $v) {
        		
        		if( in_array($v, $arr_tmp) )
        		continue;
        		$arr_tmp[]=$v;
        		
        		$check_exist = $this->m_base->get_field_where('sys_wl_person','wlp_id'
        		," AND wl_id = '{$data_save['content'][$this->pk_id]}' AND wlp_person = '{$v}'");
        		 
        		if($check_exist) continue;
        		
        		$data_save['wlp']=array();
        		$data_save['wlp']['wl_id'] = $data_save['content'][$this->pk_id];
        		$data_save['wlp']['wl_op_id'] = $data_save['content']['op_id'];
        		$data_save['wlp']['wl_pp_id'] = $data_save['content']['pp_id'];
        		$data_save['wlp']['wlp_person'] = $v ;
        		
        		$this->m_table_op->add($data_save['wlp']);
        	}
        }
        
   	 	if( $rtn['rtn'] 
   	 	 && is_array(element('c_care', $data_save['content'])) 
   	 	 && count($data_save['content']['c_care']) > 0 )
        {
        	$this->m_table_op->load('sys_wl_person');
        	$arr_tmp=array();
        	
        	foreach ($data_save['content']['c_care'] as $v) {
        		
        		if( in_array($v, $arr_tmp) )
        		continue;
        		$arr_tmp[]=$v;
        		
        		$check_exist = $this->m_base->get_field_where('sys_wl_person','wlp_id'
        		," AND wl_id = '{$data_save['content'][$this->pk_id]}' AND wlp_person = '{$v}'");
        		 
        		if($check_exist) continue;
        		
        		$data_save['wlp']=array();
        		$data_save['wlp']['wl_id'] = $data_save['content'][$this->pk_id];
        		$data_save['wlp']['wl_op_id'] = $data_save['content']['op_id'];
        		$data_save['wlp']['wl_pp_id'] = $data_save['content']['pp_id'];
        		$data_save['wlp']['wlp_person'] = $v ;
        		$data_save['wlp']['wlp_type'] = WLP_TYPE_CARE ;
        		
        		$this->m_table_op->add($data_save['wlp']);
        	}
        }
        
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
		$where[$this->pk_id]=$id;
    	
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
	 * 获取当前单据的待完成工单
	 * @param $id
	 * @param $pp_id
	 */
	public function get_wl_to_do($id,$pp_id)
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$data_db=array();//数据库数组
		$arr_search=array();
		$rtn=array();//结果
		$wl_list=array();
		/************变量赋值*****************/
		$arr_search['field']='wl.*,wlp.wlp_id,wlp.wlp_person,wlp.wlp_time_read,c.c_name,c.c_login_id';
    	$arr_search['from']=$this->table_name.' wl
    						LEFT JOIN sys_wl_person wlp ON
    						( wlp.wl_id = wl.wl_id AND wlp_type = '.WLP_TYPE_ACCEPT.')
    						LEFT JOIN sys_contact c ON
    						(c.c_id = wlp.wlp_person )';
		$arr_search['where']=' AND wl.op_id = ? AND wl.pp_id = ? AND wl.wl_type != '.WL_TYPE_I.' AND wl.wl_status < '.WL_STATUS_FINISH.'';
		$arr_search['value'][]=$id;
		$arr_search['value'][]=$pp_id;
    	$rs=$this->m_db->query($arr_search);
    	
    	if(count($rs['content'])>0)
    	$wl_list=$rs['content'];
    	
    	/************返回数据*****************/
		return $wl_list;
    }
    
	/**
	 * 获取当前单据的关注人员,及所有人员
	 * @param $id
	 * @param $pp_id
	 */
	public function get_wl_care_accept($id,$pp_id)
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$data_db=array();//数据库数组
		$arr_search=array();
		$rtn=array();//结果
		$wl_person=array();
		$wl_person['care']=array();
		$wl_person['accept']=array();
		/************变量赋值*****************/
		$arr_search['field']='wlp.wlp_person,wlp.wlp_type';
    	$arr_search['from']=$this->table_name.' wl
    						LEFT JOIN sys_wl_person wlp ON
    						( wlp.wl_id = wl.wl_id )';
		$arr_search['where']=' AND wl.op_id = ? AND wl.pp_id = ? AND wl.wl_type = '.WL_TYPE_I.' ';
		$arr_search['value'][]=$id;
		$arr_search['value'][]=$pp_id;
    	$rs=$this->m_db->query($arr_search);
    	
    	if(count($rs['content'])>0)
    	{
    		foreach ($rs['content'] as $v )
    		{
    			if($v['wlp_type'] == WLP_TYPE_ACCEPT )
    			{
    				$wl_person['accept'][]=$v['wlp_person'];
    			}
    			else 
    			{
    				$wl_person['care'][]=$v['wlp_person'];
    			}
    		}
    	}
    	
    	/************返回数据*****************/
		return $wl_person;
    }
    
    /**
	 * 获取当前单据的待完成工单
	 * @param $id
	 * @param $pp_id
	 */
	public function get_wl_info($data_out,$data_db)
    {
    	$data_out['wl_comment_new']='';
		$data_out['wl_info']='';
		$data_out['wl_list_to_do']='';
		$data_out['acl_wl_yj'] = 0 ;
		$data_out['arr_wl_accept'] = array() ;
		$data_out['arr_wl_i_to_do'] = array() ;
		
		if( count($data_db['wl_list']) > 0 )
		{
			$arr_yj=array();
			$flag_wl='';
			
			$this->m_table_op->load('sys_wl_person');
			
			foreach ($data_db['wl_list'] as $v) {
				
				//更新当前登陆人工单已读
				if( $v['wlp_person'] == $this->sess->userdata('c_id') )
				{
					//获取移交人权限
					if( $v['wl_type'] == WL_TYPE_YJ && ! in_array($v['db_person_create'], $arr_yj))
					{
						$arr_yj[] = $v['db_person_create'];
						
						$a_id_yj = $this->m_base->get_field_where('sys_contact','a_id'," AND c_id = '{$v['db_person_create']}'");
						
						$data_out['acl_wl_yj'] = $data_out['acl_wl_yj'] | $this->m_acl->get_acl($v['p_id'],$a_id_yj);
					}
					
					if( ! stristr($data_out['wl_list_to_do'], $v['wl_event']) )
					$data_out['wl_list_to_do'].=$v['wl_event'].',';
					
					$data_out['arr_wl_i_to_do'][] = $v['wl_id'];
					
					if( empty($v['wlp_time_read']) )
					{
						$data_save['wlp']=array();
						$data_save['wlp']['wlp_id'] = $v['wlp_id'];
						$data_save['wlp']['wlp_time_read'] = $v['wlp_time_read']= date("Y-m-d H:i:s");
						$this->m_table_op->update($data_save['wlp']);
					}
				}
				
				if( ! $v['c_login_id'] 
				 || in_array($v['wlp_person'], $data_out['arr_wl_accept']) )
				continue;
				
				$data_out['arr_wl_accept'][] = $v['wlp_person'];
				
				if( $flag_wl != $v['wl_id'])
				{
					$data_out['wl_info'].='由 ';
					$flag_wl = $v['wl_id'];
				}
				
				$data_out['wl_info'].=$v['c_name'].'['.$v['c_login_id'].']';
				
				if($v['wlp_time_read'])
				$data_out['wl_info'].='(已读),';
				else
				$data_out['wl_info'].='(未读),';
				
				
				$arr_wl[]=$v['wl_id'];
				
				if( $flag_wl != $v['wl_id'] )
				{
					$data_out['wl_info']=trim($data_out['wl_info'],',');
					
					if( ! $v['wl_event'] )
					$v['wl_event'] = '处理单据' ;
					
					$data_out['wl_info'].=' '.$v['wl_event'].',';
					
					$data_out['wl_comment_new'].=$v['wl_comment_new'];
				}
			}
			
			$data_out['wl_info']=trim($data_out['wl_info'],',');
					
			if( ! $v['wl_event'] )
			$v['wl_event'] = '处理单据' ;
			
			$data_out['wl_info'].=' '.$v['wl_event'].',';
			
			$data_out['wl_comment_new'].=$v['wl_comment_new'];
			
			$data_out['wl_info']=trim($data_out['wl_info'],',');
		
			if( ! $data_out['wl_info'] )
			$data_out['wl_info'] = '无人接收工单，请联系相关人员处理。';
			
			$data_out['wl_comment_new'] = str_replace('data-original', 'src', $data_out['wl_comment_new']);
			
		}
		
		return $data_out;
    }
    
	/**
	 * 更新我的工单
	 * @param $id
	 * @param $pp_id
	 */
	public function update_wl_i($id,$pp_id,$content=array())
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$data_db=array();//数据库数组
		$arr_search=array();
		$rtn=array();//结果
		$rtn['rtn']=TRUE;
		/************变量赋值*****************/
    	$data_save['content']=$content;
    	$data_save['content']['db_time_update'] = date("Y-m-d H:i:s");
		
    	$where=" 1=1 AND wl_id = '{$id}' AND pp_id = '{$pp_id}' ";
		
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
    }
    
	/**
	 * 更新我的工单所有人
	 * @param $id
	 * @param $pp_id
	 */
	public function update_wl_i_person($id,$wlp_person_o,$wlp_person_n)
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$data_db=array();//数据库数组
		$arr_search=array();
		$rtn=array();//结果
		$rtn['rtn']=TRUE;
		/************变量赋值*****************/
    	$data_save['content']=array();
    	$data_save['content']['db_time_update'] = date("Y-m-d H:i:s");
		$data_save['content']['wlp_person'] = $wlp_person_n;
		$data_save['content']['wlp_time_read'] = '';
		
    	$where=" 1=1 AND wl_id = '{$id}' AND wlp_person = '{$wlp_person_o}' ";
		
		/************数据处理*****************/
    	$this->db->trans_begin();
		
		if($rtn['rtn'])
        $rtn=$this->m_db->update('sys_wl_person',$data_save['content'],$where);
        	
    	if( ! $rtn['rtn'] )
	    {
		    $this->db->trans_rollback();
		}
		else
		{
		    $this->db->trans_commit();
		}
    	/************返回数据*****************/
    }
    
	/**
	 * 更新接收工单所有人
	 * @param $id
	 * @param $pp_id
	 */
	public function update_wl_person($id,$wlp_person_o,$wlp_person_n)
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$data_db=array();//数据库数组
		$arr_search=array();
		$rtn=array();//结果
		$rtn['rtn']=TRUE;
		/************变量赋值*****************/
		
		$arr_field_search=array(
			'group_concat(wlp_id) wlp_id',
		);

		$arr_search['field']=implode(',', $arr_field_search);
		
		$arr_search['from']='sys_wl_person wlp 
							 LEFT JOIN sys_work_list wl ON
							 (wl.wl_id = wlp.wl_id)';
		
		$arr_search['where'] = ' AND wlp.wl_op_id = ? 
								 AND wlp.wlp_type =0 
								 AND wlp.wlp_person = ? 
								 AND wl.wl_status < 2 
								 AND wl.wl_type != 1
								 GROUP BY wlp.wl_op_id';
		$arr_search['value'][] = $id;
		$arr_search['value'][] = $wlp_person_o;						 
		$rs=$this->m_db->query($arr_search);
		
		$str_wlp_id = "''";
		if(count($rs['content'])>0)
		{
			$str_wlp_id = $rs['content'][0]['wlp_id'];
			$str_wlp_id =str_replace(',', "','", $str_wlp_id);
		}
		else 
		return ;
		
    	$data_save['content']=array();
    	$data_save['content']['db_time_update'] = date("Y-m-d H:i:s");
		$data_save['content']['wlp_person'] = $wlp_person_n;
		$data_save['content']['wlp_time_read'] = '';
		
    	$where=" 1=1 AND wl_op_id = '{$id}' AND wlp_person = '{$wlp_person_o}' AND wlp_id IN ('{$str_wlp_id}') ";
		
		/************数据处理*****************/
    	$this->db->trans_begin();
		
    	if($rtn['rtn'])
        $rtn=$this->m_db->update('sys_wl_person',$data_save['content'],$where);
        	
    	if( ! $rtn['rtn'] )
	    {
		    $this->db->trans_rollback();
		}
		else
		{
		    $this->db->trans_commit();
		}
    	/************返回数据*****************/
    }
    
	/**
	 * 更新已完成工单
	 * @param $id
	 * @param $pp_id
	 */
	public function update_wl_have_do($id,$pp_id,$content=array())
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$data_db=array();//数据库数组
		$arr_search=array();
		$rtn=array();//结果
		$rtn['rtn']=TRUE;
		/************变量赋值*****************/
    	$data_save['content']=$content;
    	$data_save['content']['wl_person_do'] = $this->sess->userdata('c_id');
    	$data_save['content']['wl_time_do'] = date("Y-m-d H:i:s");
		$data_save['content']['wl_comment_new']='';
		
		if( element('wl_status', $data_save['content']) != WL_STATUS_FAIL)
		$data_save['content']['wl_status']=WL_STATUS_FINISH;
		
		if( ! empty(element('wl_comment', $data_save['content'])) )
        $data_save['content']['wl_comment'] = $this->m_base->filter_img($data_save['content']['wl_comment']);
		
    	$where=" 1=1 AND op_id = '{$id}' AND pp_id = '{$pp_id}' AND wl_type != ".WL_TYPE_I." AND wl_status < ".WL_STATUS_FINISH;
		
    	if( isset($data_save['content']['wl_id_i_do'])
    	 && element('wl_id_i_do',$data_save['content']))
    	{
    		$data_save['content']['wl_id_i_do'] = implode("','", $data_save['content']['wl_id_i_do']);
    		$where.=" AND wl_id IN ('{$data_save['content']['wl_id_i_do']}')";
    	}
    	
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
    }
    
	/**
	 * 
	 * 判断联合工单是否全部完成
	 * @param $content
	 */
	public function check_wl_combine_finish($id,$pp_id,$arr_wl_id)
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$data_db=array();//数据库数组
		$arr_search=array();
		$rtn=FALSE;//结果
		
		/************变量赋值*****************/
		$arr_search['field']='wl.wl_id';
    	$arr_search['from']=$this->table_name.' wl';
		$arr_search['where']='AND op_id = ? AND pp_id = ?  AND wl_status <2 AND wl_combine = 1 AND wl_id NOT IN ? ';
		$arr_search['value'][]=$id;
		$arr_search['value'][]=$pp_id;
		$arr_search['value'][]=$arr_wl_id;
    	$rs=$this->m_db->query($arr_search);
    	if(count($rs['content'])==0)
    	$rtn=TRUE;
    	
    	/************返回数据*****************/
		return $rtn;
    }
    
	/**
	 * 
	 * 取消工单
	 * @param $content
	 */
	public function cancel_wl($id,$pp_id)
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$where=array();
		
		/************变量赋值*****************/
//		$where['wl_id']=$id;
    	
		/************数据处理*****************/
    
//		$sql="update sys_work_list set wl_status ='".WL_STATUS_FAIL."' where op_id = '{$id}'";
//		$this->m_db->exec_sql($sql);
//		
//		$arr_search['field']='count(*) msg_num';
//		$arr_search['from']='im_msg';
//		$arr_search['where']=' AND im_id = ? ';
//		$arr_search['value'][]=$id;
//		$rs=$this->m_db->query($arr_search);
//		
//		if($rs['content'][0]['msg_num'] > 0)
//		{
//			$data_save['im']['im_status']=IM_MSTATUS_FAIL;
//			$data_save['im']['im_id']=$id;
//			$data_db['im']=$this->m_im_main->update($data_save['im']);
//		}
//		else 
//		{
//			$where=array();
//			$where['im_id']=$id;
//			$this->m_db->delete('im_main',$where);
//			$this->m_db->delete('im_user',$where);
//		}
		
		$where=array();
		$where['op_id']=$id;
		$where['pp_id']=$pp_id;
		$this->m_db->delete('sys_work_list',$where);
		$where=array();
		$where['wl_op_id']=$id;
		$where['wl_pp_id']=$pp_id;
		$this->m_db->delete('sys_wl_person',$where);
//		$this->m_db->delete('sys_wl_alert',$where);
    	/************返回数据*****************/
    }
}