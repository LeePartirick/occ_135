<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 *  
    费用报销
 */
class M_bal extends CI_Model {
	
	//@todo 主表配置
	private $table_name='fm_balance';
	private $pk_id='bal_id';
	private $table_form;
	private $arr_table_form=array();
	private $title='费用报销';
	private $model_name = 'm_bal';
	private $url_conf = 'proc_bal/bal/edit';
	private $proc_id = 'proc_bal';
	
 	public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->m_define();
        
         //读取表结构
        $this->config->load('db_table/'.$this->table_name, FALSE,TRUE);
        $this->table_form=$this->config->item($this->table_name);
        
        $this->load->model('proc_gfc/m_gfc');
        $this->load->model('proc_loan/m_loan');
        $this->load->model('proc_bud/m_subject');
        $this->load->model('proc_bud/m_bl_ppo');
    }
    
	/**
     * 
     * 定义
     */
	public function m_define()
    {
    	//@todo 定义
    	if( defined('LOAD_M_BAL') ) return;
    	define('LOAD_M_BAL', 1);
    	
    	//define
    	
    	// 节点
        define('BAL_PPO_END', 0); // 流程结束
        define('BAL_PPO_START', 1); // 起始
        define('BAL_PPO_FH', 2); // 审核
        define('BAL_PPO_SH', 3); // 审核
        define('BAL_PPO_GZ', 4); // 过账
        define('BAL_PPO_SP', 5); // 总经理审批

        $GLOBALS['m_bal']['text']['ppo']=array(
            BAL_PPO_START=>'起始',
            BAL_PPO_FH=>'复核',
            BAL_PPO_SH=>'审核',
            BAL_PPO_GZ=>'过账',
            BAL_PPO_SP=>'审批',
            BAL_PPO_END=>'流程结束',
        );
        
        //统计属性
        define('BALI_CATEGORY_STATISTICS_PAY', '1');	//付款（特指非固定资产）
		define('BALI_CATEGORY_STATISTICS_GUDING', '2');	//固定资产（折旧）
		define('BALI_CATEGORY_STATISTICS_BEIPING', '3');	//备品备件
		define('BALI_CATEGORY_STATISTICS_CUNHUO', '4');	//存货（含耗材）
		define('BALI_CATEGORY_STATISTICS_FENTAN', '5');	//关联分摊
		$GLOBALS['m_bal']['text']['bali_category_statistics'] = array(
			BALI_CATEGORY_STATISTICS_PAY => '付款(特指非固定资产)',
			BALI_CATEGORY_STATISTICS_GUDING => '固定资产(折旧)',
			BALI_CATEGORY_STATISTICS_BEIPING => '备品备件',
			BALI_CATEGORY_STATISTICS_CUNHUO => '存货(含耗材)',
			BALI_CATEGORY_STATISTICS_FENTAN => '关联分摊',
		);	
		
		 //人员类型
        define('BALTR_C_TYPE_CCR', 1); // 出差人
        define('BALTR_C_TYPE_DFR', 2); // 垫付人

        $GLOBALS['m_bal']['text']['baltr_c_type']=array(
            BALTR_C_TYPE_CCR=>'出差人',
            BALTR_C_TYPE_DFR=>'垫付人',
        );
    }
    
	/**
	 * 
	 * 权限验证
	 * @param $content
	 */
	public function check_acl( $data_db=array() ,$acl_list = NULL)
    {
    	/************变量初始化****************/
    	
    	$data_get=trim_array($this->uri->uri_to_assoc(4));
    	$act=element('act', $data_get);
    	
    	if( ! $acl_list )
    	$acl_list= $this->m_proc_bal->get_acl();
    	
    	$msg='';
    	/************权限验证*****************/
    	
    	//如果有超级权限，TRUE
    	if( ($acl_list & pow(2,ACL_PROC_BAL_SUPER)) != 0 )
    	{
    		return TRUE;
    	}
    	
    	$check_acl=FALSE;
    	
    	if( ! $check_acl
         && ($acl_list & pow(2,ACL_PROC_BAL_USER)) != 0
        )
        {
            $check_acl=TRUE;
        }
	    
	    if( ! $check_acl )
	    {
			if( ! $msg )
			$msg = '您没有【费用报销】的【操作】权限不可进行操作！' ;
			
			redirect('base/main/show_err/msg/'.fun_urlencode($msg));
	    }
    }
    
	/**
     * 
     */
	public function get_code($data_save=array())
    {
    	$where='';
    	 
    	$pre = $this->m_base->get_field_where('sys_ou','ou_org_pre'," AND ou_id ='{$data_save['content']['bal_org_owner']}'");
    	
    	$pre.='-BAL'.date("Ym");
    	$where .= " AND bal_code LIKE  '{$pre}%'";
    	
    	$max_code=$this->m_db->get_m_value('fm_balance','bal_code',$where);
    	$code=$pre.str_pad((intval(substr($max_code, (strlen($pre))))+1), 5, '0', STR_PAD_LEFT);
    	
    	return $code;
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
        	
        if($rtn)
        $this->update_ltable($data_save['content']);
        
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
	 * 更新关联单据
	 * @param $content
	 */
	public function update_ltable($content)
    {
    	$data_save = array();
    	$data_save['content'] = $content;
    	
    	//费用报销明细
		$arr_search=array();
		$arr_search['field']='*';
		$arr_search['from']="fm_bal_item";
		$arr_search['where']=' AND bal_id = ?  
		   				   	   AND bali_gfc_id != \'\' AND bali_gfc_id IS NOT NULL 
		   				   	   AND bali_pay_type != ? ';
		$arr_search['value'][]=element('bal_id',$data_save['content']);
		$arr_search['value'][]=LOAN_PAY_TYPE_CHARGEOFFS;
		$arr_search['sort']=array("bali_sum_total");
		$arr_search['order']=array('asc');
		
		$rs=$this->m_db->query($arr_search);

		$data_db['content']['bali'] = array();
		
		if(count($rs['content'])>0)
		{
			foreach ($rs['content'] as $v) {
				$this->m_gfc->update_gbud(element('bali_gfc_id', $v),element('bali_sub', $v));
			}
		}
    	
    	//冲账关联
		$arr_search=array();
		$arr_search['field']='bl.*,loan_sum,loan_sum_return';
		$arr_search['from']="fm_bali_link bl
							 LEFT JOIN fm_loan loan ON
							 (bl.loan_id = loan.loan_id)";
		$arr_search['where']=' AND bal_id = ? ';
		$arr_search['value'][]=element('bal_id',$data_save['content']);
		
		$rs=$this->m_db->query($arr_search);
		
		$data_db['content']['bl'] = array();
		
		if(count($rs['content'])>0)
		{
			foreach ($rs['content'] as $v) 
			{
				$this->m_table_op->load('fm_loan');
				
				$data_save['loan']=array();
				$data_save['loan']['loan_id'] = element('loan_id',$v);
				
				$data_save['loan']['loan_sum_return'] = $this->m_base->get_field_where('fm_bali_link','sum(bl_sum)'," AND ppo = 0 AND loan_id = '{$v['loan_id']}'");
				$data_save['loan']['loan_sum_return'] += $this->m_base->get_field_where('fm_bs_item','sum(bsi_sum)'," AND ppo = 0 AND bsi_link_id = '{$v['loan_id']}'");
				
				$this->m_table_op->update($data_save['loan']);
			}
		}
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
		
		//@todo 删除关联数据验证
    	$arr_link=array();
		
		if(count($arr_link) > 0)
		{
			foreach ($arr_link as $v ) {
				$arr_tmp = explode('.', $v);
				$field=$this->m_base->get_field_where($arr_tmp[0],$arr_tmp[1]," AND {$arr_tmp[1]} = '{$id}' ");
				if($field)
				{
					$rtn['rtn'] = FALSE;
					$rtn['msg_err'] = $rtn['err']['msg'] = '于【'.$arr_tmp[0].'】存在关联数据,不可删除!';
					return $rtn;
				}
			}
		}
		
		$data_db['content']=$this->get($id);
		
    	$this->db->trans_begin();
		
		if($rtn['rtn'])
        $rtn=$this->m_db->delete($this->table_name,$where);
        
        $data_save['content']['ppo'] = 2;
        $data_save['content'][$this->pk_id] = $id;
        
        if($rtn['rtn'])
        $rtn=$this->m_db->update('fm_bal_item',$data_save['content']," 1=1 AND {$this->pk_id} = '{$data_save['content'][$this->pk_id]}'");
        
        if($rtn['rtn'])
        $rtn=$this->m_db->update('fm_bali_link',$data_save['content']," 1=1 AND {$this->pk_id} = '{$data_save['content'][$this->pk_id]}'");
        
        if($rtn)
        $this->update_ltable($data_db['content']);
        
        if($rtn['rtn'])
        $rtn=$this->m_db->delete('fm_bal_item',$where);
        
        if($rtn['rtn'])
        $rtn=$this->m_db->delete('fm_bali_link',$where);
        
        if($rtn['rtn'])
        $rtn=$this->m_db->delete('fm_bali_trip',$where);
        
        if($rtn['rtn'])
        $rtn=$this->m_db->delete('fm_bali_trip_c',$where);
        
        if($rtn['rtn'])
        $rtn=$this->m_db->delete('fm_bali_trip_sub',$where);
        
    	if( ! $rtn['rtn'] )
	    {
		    $this->db->trans_rollback();
		}
		else
		{
		    $this->db->trans_commit();
		    
		    //取消工单信息
	        $this->m_work_list->cancel_wl($id,$this->model_name);
	        
	        //删除关联文件
	        $this->m_file->del_link_file($id,$this->table_name,$this->pk_id);
	        
	        //删除所有关联数据
			$this->m_link->del_all($id);
		}
		
    	/************返回数据*****************/
		return $rtn;
    }
    
	/**
     * 
     * 生成导入xlsx
     */
	public function create_import_xlsx()
    {
    	$this->load->model('base/m_excel');
    	
    	$conf=array();
    	
    	//@todo 导入xlsx配置
    	$conf['field_edit']=array(
		);

		$conf['field_required']=array(
		);

		$conf['field_define']=array(
    	);

    	$this->arr_table_form['sys_contact']['fields']['c_login_id']['comment']='统计人账号';
		$conf['table_form']=array(
		);
    	
    	$path=str_replace('\\', '/', APPPATH).'models/'.$this->proc_id.'/'.$this->model_name.'.xlsx';
    	
//    	$this->m_excel->create_import_file($path,$conf);
    }
    
    /**
	 * 
	 * 载入编辑界面
	 * @param $content
	 */
	public function load($data_get=array(),$data_post=array())
	{
		/************变量初始化****************/
		$arr_view = array();//视图数组
		$data_out = array();//输出数组
		$data_db  = array();//数据库数据
		
		//@todo 必填只读配置
		//必填数组
		$data_out['field_required']=array(
			'content[bal_org_owner]',
			'content[bal_time_node]',
			'content[bal_ou]',
			'content[bal_ou_s]',
			'content[bal_contact_manager]',
			'content[bal_contact_manager_s]',
		);
		
		//编辑数组
		$data_out['field_edit']=array(
			'content[db_time_update]',
			
			'content[bal_org_owner]',
			'content[bal_code]',
			'content[bal_time_node]',
			'content[bal_time_post_node]',
			'content[bal_total_sum]',
			'content[rei_total_sum]',
			'content[bal_ou]',
			'content[bal_ou_s]',
			'content[bal_contact_manager]',
			'content[bal_contact_manager_s]',
		
			'content[bal_category_bumen]',
		
			'content[bal_note]',
		
			'content[bali]',
		
			'content[trip]',
			'content[trip_c]',
			'content[trip_sub]',
			
			'content[bl]',
		);
		
		//只读数组
		$data_out['field_view']=array(
		);
		
		$data_out['op_disable']=array();
		
		//输出数据数组
		$data_out['field_out']=array_unique(array_merge($data_out['field_view'],$data_out['field_edit']));
		
		/************变量赋值*****************/
		
		$flag_log=$this->input->post('flag_log');//日志标签
		
		if( empty($data_get) )
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		
		if( ! isset($data_get['act']) )
		$data_get['act'] = STAT_ACT_CREATE;
		
		if( empty( element('btn', $data_post) ) )
		$data_post['btn']=$this->input->post('btn');//按钮
		
		$btn=$data_post['btn'];
		
		if( empty( element('content', $data_post) ) )
		$data_post['content']=trim_array($this->input->post('content'));
		
		if( empty( element('wl', $data_post) ) )
		$data_post['wl']=trim_array($this->input->post('wl'));
		
		$flag_more=element('flag_more', $data_post);
		
		/************字段定义*****************/
		//@todo 字段定义
		$arr_field=array_unique(array_merge($data_out['field_edit'], $data_out['field_view']));
		
		$data_out['json_field_define']=array();
		$data_out['json_field_define']['bal_category_bumen']=get_html_json_for_arr($GLOBALS['m_base']['text']['base_yn_0']);
		$data_out['json_field_define']['bali_pay_type']=get_html_json_for_arr($GLOBALS['m_loan']['text']['loan_pay_type']);
		$data_out['json_field_define']['baltr_pay_type']=get_html_json_for_arr($GLOBALS['m_loan']['text']['loan_pay_type']);
		$data_out['json_field_define']['baltr_c_type']=get_html_json_for_arr($GLOBALS['m_bal']['text']['baltr_c_type']);
		/************数据读取*****************/
		$data_db['content']=array();
		$data_db['wl_list']=array();

		switch ($data_get['act']) {
			case STAT_ACT_EDIT:
			case STAT_ACT_VIEW:
				try {
					
					//日志读取
					if( ! empty($flag_log))
					{
						$data_get['act'] = STAT_ACT_VIEW;
						$data_out['op_disable'][]='btn_log';
						
						$log_content=json_decode($this->input->post('log_content'),TRUE);
						$data_old=element('old', $log_content);
						$data_db['content']=$data_old['content'];
						$data_change=element('new', $log_content);
						
						if( count(element('content',$data_change))>0)
						{
							foreach (element('content',$data_change) as $k=>$v) 
							{
								if( $v != element($k,$data_db['content']) )
								{
									switch ($k)
									{
										case 'bali':
											
											$data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('bali_id',$v,element($k,$data_db['content']),'m_bal','show_change_bali');
											$data_db['content'][$k] =$v ;
											
											break;	
											
										default:
											if( (element($k,$data_db['content']) || element($k,$data_db['content']) == '0' )
									         && isset($GLOBALS[$this->model_name]['text'][$k][$v]) )
											$data_db['content'][$k]=$GLOBALS[$this->model_name]['text'][$k][element($k,$data_db['content'])];
									
											$data_out['log']['content['.$k.']']='变更前:'.element($k,$data_db['content']);
											$data_db['content'][$k] =$v ;
									}
								}
							}
						}
					}
					else 
					{
					
						$data_db['content'] = $this->get(element($this->pk_id,$data_get));
						
						if( empty($data_db['content'][$this->pk_id]) )
						{
							$msg= $this->title.'【'.element($this->pk_id,$data_get).'】不存在！';
							
							if($flag_more)
							{
								$rtn['result'] = FALSE;
								$rtn['msg_err'] = $msg;
									
								if( $flag_more )
								return $rtn;
							}
							
							redirect('base/main/show_err/msg/'.fun_urlencode($msg));
						}
						
						$data_db['wl_list']=$this->m_work_list->get_wl_to_do(element($this->pk_id,$data_get),$this->model_name);
						
						if( ! empty($data_db['content']['bal_contact_manager']) )
						$data_db['content']['bal_contact_manager_s']=$this->m_base->get_c_show_by_cid($data_db['content']['bal_contact_manager']);
						
						if( ! empty($data_db['content']['bal_ou']) )
						$data_db['content']['bal_ou_s']=$this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id = '{$data_db['content']['bal_ou']}'");
					
						//费用报销明细
						$arr_search=array();
						$arr_search['field']='*';
						$arr_search['from']="fm_bal_item";
						$arr_search['where']=' AND bal_id = ? ';
						$arr_search['value'][]=element('bal_id',$data_get);
						$arr_search['sort']=array("bali_sum_total");
						$arr_search['order']=array('asc');
						
						$rs=$this->m_db->query($arr_search);

						$data_db['content']['bali'] = array();
						
						if(count($rs['content'])>0)
						{
							foreach ($rs['content'] as $v) {
								
								if($v['bali_category_statistics'])
								$v['bali_category_statistics_s'] = $GLOBALS['m_bal']['text']['bali_category_statistics'][$v['bali_category_statistics']];
								
								$v['bali_pay_type_s'] = $GLOBALS['m_loan']['text']['loan_pay_type'][$v['bali_pay_type']];
								
								$v['bali_sub_s'] = $this->m_base->get_field_where('fm_subject','sub_name'," AND sub_id = '{$v['bali_sub']}'");
								
								$v['sub_tag'] = $this->m_base->get_field_where('fm_subject','sub_tag'," AND sub_id = '{$v['bali_sub']}'");
								
								$v['bali_abstract_s'] = $this->m_base->get_field_where('fm_subject','sub_name'," AND sub_id = '{$v['bali_abstract']}'");
								if( ! $v['bali_abstract_s'] )
								$v['bali_abstract_db'] = $v['bali_abstract'];
								
								$v['bali_ou_tj_s'] = $this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id = '{$v['bali_ou_tj']}'");
								
								if( $v['bali_gfc_id'] )
								{
									$arr_gfc = $this->m_gfc->get($v['bali_gfc_id']);
									$v['bali_gfc_id_s'] = $arr_gfc['gfc_finance_code'];
									//$v['bali_gfc_name'] = $arr_gfc['gfc_name'];
								}
								
								$data_db['content']['bsi'][]=$v;
							}
						}
						
						$data_db['content']['bali'] = json_encode($data_db['content']['bsi']);
						
						//差旅费报销
						$arr_search=array();
						$arr_search['field']='*';
						$arr_search['from']="fm_bali_trip";
						$arr_search['where']=' AND bal_id = ? ';
						$arr_search['value'][]=element('bal_id',$data_get);
						$arr_search['sort']=array("baltr_time_out");
						$arr_search['order']=array('asc');
						
						$rs=$this->m_db->query($arr_search);
						
						$data_db['content']['trip'] = json_encode($rs['content']);
						
						//出差人
						$arr_search=array();
						$arr_search['field']='*';
						$arr_search['from']="fm_bali_trip_c";
						$arr_search['where']=' AND bal_id = ? ';
						$arr_search['value'][]=element('bal_id',$data_get);
						$arr_search['sort']=array("baltr_c_id");
						$arr_search['order']=array('asc');
						
						$rs=$this->m_db->query($arr_search);

						$data_db['content']['trip_c'] = array();
						
						if(count($rs['content'])>0)
						{
							foreach ($rs['content'] as $v) {
								
								$v['baltr_c_type_s'] = $GLOBALS['m_bal']['text']['baltr_c_type'][$v['baltr_c_type']];
								$v['baltr_pay_type_s'] = $GLOBALS['m_loan']['text']['loan_pay_type'][$v['baltr_pay_type']];
								$v['baltr_c_id_s'] = $this->m_base->get_c_show_by_cid($v['baltr_c_id']);
								
								$v['c_bank'] = $this->m_base->get_field_where('sys_contact','c_bank'," AND c_id = '{$v['baltr_c_id']}'");
								
								$data_db['content']['trip_c'][]=$v;
							}
						}
						
						$data_db['content']['trip_c'] = json_encode($data_db['content']['trip_c']);
						
						//补贴
						$arr_search=array();
						$arr_search['field']='*';
						$arr_search['from']="fm_bali_trip_sub";
						$arr_search['where']=' AND bal_id = ? ';
						$arr_search['value'][]=element('bal_id',$data_get);
						$arr_search['sort']=array("baltrs_c_id");
						$arr_search['order']=array('asc');
						
						$rs=$this->m_db->query($arr_search);

						$data_db['content']['trip_sub'] = array();
						
						if(count($rs['content'])>0)
						{
							foreach ($rs['content'] as $v) {
								
								$v['baltrs_c_id_s'] = $this->m_base->get_c_show_by_cid($v['baltrs_c_id']);
								
								$data_db['content']['trip_sub'][]=$v;
							}
						}
						
						$data_db['content']['trip_sub'] = json_encode($data_db['content']['trip_sub']);
						
						//冲账关联
						$arr_search=array();
						$arr_search['field']='bl.*,loan_code,loan_sum,loan_sum_return';
						$arr_search['from']="fm_bali_link bl
											 LEFT JOIN fm_loan loan ON
											 (bl.loan_id = loan.loan_id)";
						$arr_search['where']=' AND bal_id = ? ';
						$arr_search['value'][]=element('bal_id',$data_get);
						
						$rs=$this->m_db->query($arr_search);
						
						$data_db['content']['bl'] = array();
						
						if(count($rs['content'])>0)
						{
							foreach ($rs['content'] as $v) {
								
								if($v['gfc_id'])
								$v['gfc_id_s'] = $this->m_base->get_field_where('pm_given_financial_code','gfc_finance_code'," AND gfc_id = '{$v['gfc_id']}'");

								$v['loan_id_s'] = $v['loan_code'];
								$v['loan_ending_sum'] = $v['loan_sum'] - $v['loan_sum_return'];
								$data_db['content']['bl'][]=$v;
							}
						}
						
						$data_db['content']['bl'] = json_encode($data_db['content']['bl']);
						
					}
					
				} catch (Exception $e) {
				}
				
			break;
		}
		/************工单信息*****************/

		//工单控件展示标记
		$data_out['flag_wl'] = FALSE;
		$data_out['pp_id']=$this->model_name;
		
		$data_out['ppo_btn_next']='通过';
		$data_out['ppo_btn_pnext']='退回';
		
		switch (element('ppo', $data_db['content'])) {
			case BAL_PPO_START:
				$data_out['ppo_btn_next']='提交';
				break;
		}
				
		if( $data_get['act'] == STAT_ACT_EDIT 
		 && element('ppo', $data_db['content']) != BAL_PPO_END )
		{
			$data_out['flag_wl'] = TRUE;
		}
		
		$data_out=$this->m_work_list->get_wl_info($data_out,$data_db);
			
		/************权限验证*****************/
		
		//@todo 权限验证
		$acl_list= $this->m_proc_bal->get_acl();
		
		if( ! empty (element('acl_wl_yj', $data_out)) ) 
		$acl_list= $acl_list | $data_out['acl_wl_yj'];
		
		$this->check_acl($data_db,$acl_list);
		
		/************显示配置*****************/
		//@todo 显示配置
		$title_field='-'.element('bal_code',$data_db['content']);
		
		if(element('bal_sum',$data_db['content']))
		$title_field.='-'.element('bal_sum',$data_db['content']);
		
		if(element('bal_contact_manager_s',$data_db['content']))
		$title_field.='-'.element('bal_contact_manager_s',$data_db['content']);
		
		switch ($data_get['act']) {
			case STAT_ACT_CREATE:
				$data_out['title']='创建'.$this->title;
				
				$data_out['op_disable'][]='btn_import';
				
				$data_out['op_disable'][]='btn_del';
				$data_out['op_disable'][]='btn_log';
				
				$data_out['op_disable'][]='btn_next';
				$data_out['op_disable'][]='btn_pnext';
				
				$data_out['op_disable'][]='btn_wl';
				$data_out['op_disable'][]='btn_im';
				
				//创建默认值
				$data_db['content']['ppo'] = BAL_PPO_START;
				$data_db['content']['bal_time_node'] = date("Y-m-d");
				$data_db['content']['bal_contact_manager'] = $this->sess->userdata('c_id');
				$data_db['content']['bal_contact_manager_s'] = $this->sess->userdata('c_show');
				
				$data_db['content']['bal_org_owner'] = $this->sess->userdata('c_org');
				
				//个性化配置
				$data_out['url_conf']=str_replace('/', '-', $this->url_conf);
				
				//创建个性化配置
				$path_conf_person=PATH_PERSON_CONF.'/create/'.$data_out['url_conf'].'/'.$this->sess->userdata('a_login_id');
				
				$conf_person=array();
				if(file_exists($path_conf_person))
				{
					$conf_person=json_decode(file_get_contents($path_conf_person),TRUE);
					$data_conf_person=json_decode(fun_urldecode(element('data', $conf_person)),TRUE);
					
					if(count($data_conf_person)>0)
					{
						foreach ($data_conf_person as $k=>$v) {
							$arr_f=split_table_field($k);
							$data_db[$arr_f['table']][$arr_f['field']]=$v;
						}
					}
				}
				
				//GET参数赋值
				if(count($data_out['field_edit'])>0)
				{
					foreach ($data_out['field_edit'] as $v) {
						$arr_tmp=split_table_field($v);
						if(element($arr_tmp['field'] ,$data_get))
						$data_db['content'][$arr_tmp['field']]=element($arr_tmp['field'] ,$data_get);
					}
				}
				
			break;
			case STAT_ACT_EDIT:
				$data_out['title']='编辑'.$this->title.$title_field;
				
				$data_out['op_disable'][]='btn_person';
				$data_out['op_disable'][]='btn_import';
				
				$data_out['field_view'][]='content[bal_org_owner]';
				
			break;
			case STAT_ACT_VIEW:
				$data_out['title']='查看'.$this->title.$title_field;
				
				$data_out['op_disable'][]='btn_save';
				$data_out['op_disable'][]='btn_del';
				$data_out['op_disable'][]='btn_person';
				$data_out['op_disable'][]='btn_import';
				$data_out['op_disable'][]='btn_reload';
				
				$data_out['op_disable'][]='btn_next';
				$data_out['op_disable'][]='btn_pnext';
				
				$data_out['field_view']=array_unique(array_merge($data_out['field_view'],$data_out['field_edit']));
				
			break;
		}
		
		if( element( 'ppo',$data_db['content']) == BAL_PPO_START )
		{
			$data_out['op_disable'][]='btn_pnext';
		}
		
		if( element( 'ppo',$data_db['content']) != BAL_PPO_START )
		{
			$data_out['op_disable'][]='btn_del';
		}
		
		if( element('bal_code_type', $data_db['content']) == 1)
		{
			$data_out['field_view'][]='content[bal_code]';
		}
		
		if( $data_get['act'] == STAT_ACT_EDIT
		&& element( 'ppo',$data_db['content']) == 0  )
		{
			if( ($acl_list & pow(2,ACL_PROC_BAL_SUPER) ) == 0)
			{
				$data_out['op_disable'][]='btn_save';
				$data_out['op_disable'][]='btn_del';
			}
			else 
			{
				$data_out['op_disable'] = array_values(array_unique($data_out['op_disable']));
				$data_out['op_disable'] =  array_diff($data_out['op_disable'],array(
					'btn_del'
				));
			}
			
			$data_out['op_disable'][]='btn_next';
			$data_out['op_disable'][]='btn_pnext';
		}
		
		//批量编辑
		if(element('flag_edit_more', $data_get))
		{
			$data_out['field_required']=array();
			
			$data_out['op_disable'][]='btn_log';
			$data_out['op_disable'][]='btn_del';
			
			$data_out['op_disable'][]='btn_wl';
			$data_out['op_disable'][]='btn_im';
			$data_out['op_disable'][]='btn_file';
			
			$data_out['op_disable'][]='btn_next';
			$data_out['op_disable'][]='btn_pnext';
			
			$data_out['title'] = '批量编辑'.$this->title.'-请勾选要保存的字段';
		}
		elseif( element( 'ppo',$data_db['content']) == BAL_PPO_END )
		{
			$data_out['field_view'] = array_unique(array_merge($data_out['field_view'],$data_out['field_edit']));
		}
		/************事件处理*****************/

		if(in_array('btn_'.$btn,$data_out['op_disable']))
		{
			$rtn['result'] = FALSE;
			
			switch($btn)
			{
				case 'next':
				case 'pnext':
					$rtn['msg_err'] = '禁止'.$data_out['ppo_btn_'.$btn].'！';
				case 'del':
					$rtn['msg_err'] = '禁止删除！';
					break;
			}
			
			$rtn['err'] = array();
				
			if( $flag_more )
			return $rtn;
					
			exit;
		}
		
		switch ($btn)
		{
			case 'save':
			case 'next':
			case 'pnext':
			case 'yj':
				
				$rtn=array();//结果
				$check_data=TRUE;
				
				/************数据验证*****************/
				//@todo 数据验证
				if( $btn == 'yj' 
				 && empty(element('person_yj' ,$data_post['content'])))
				{
					$rtn['err']['msg']='请选择移交人！';
					$check_data=FALSE;
				}
				
				if($btn == 'save' || $btn == 'next')
				{
					//必填验证
					if(count($data_out['field_required'])>0)
					{
						foreach ($data_out['field_required'] as $v) {
							
							$arr_tmp=split_table_field($v);
							
							if( ! is_array(element('content', $data_post)) 
							 || empty(element($arr_tmp['field'],$data_post['content'])))
							$data_post['content'][$arr_tmp['field']] = element($arr_tmp['field'],$data_db['content']);
							
							if( empty(element($arr_tmp['field'],$data_post['content'])) 
							 && element($arr_tmp['field'],$data_post['content']) !== '0'
							 )
							{
								$field_s='';
								if(isset($this->table_form['fields'][$arr_tmp['field']]))
								$field_s = $this->table_form['fields'][$arr_tmp['field']]['comment'];
								
								$rtn['err']['content['.$arr_tmp['field'].']']='请输入'.$field_s.'！';
								$check_data=FALSE;
							}
						}
					}
					
					if( ! empty( element('bal_code', $data_post['content'])))
					{
						$where_check=' AND bal_id != \''.element('bal_id',$data_db['content']).'\'';

						$check=$this->m_check->unique('fm_balance','bal_code',element('bal_code',$data_post['content']),$where_check);
						if( ! $check )
						{
							$rtn['err']['content[bal_code]']='单据编号【 '.element('bal_code',$data_post['content']).'】已存在，不可重复创建！';
							$check_data=FALSE;
						}
					}
					
					//差旅费明细
					$arr_trip = array();
					
					if( ! empty(element('bali', $data_post['content'])))
					$arr_trip = json_decode($data_post['content']['trip'],TRUE);
					
					$total_trip_sum = 0;
					if( count($arr_trip) > 0 )
					{
						foreach ($arr_trip as $v) {
							$total_trip_sum += $v['baltr_tatal_sum'];
						}
					}
					
					//费用报销明细
					$arr_trip_bali_id = array();
					$sum_trip_total_cz = 0;
					$sum_total_cz = 0;
					
					if( ! empty(element('bali', $data_post['content'])))
					{
						$arr_bali = json_decode($data_post['content']['bali'],TRUE);
						
						$total_bali_trip_sum = 0;
						
						if(count($arr_bali) == 0)
						{
							$rtn['err']['content[bali]']='费用报销明细请填写！';
							$check_data=FALSE;
						}
						else 
						{
							foreach ($arr_bali as $v) {
								
								if( $v['sub_tag'] == SUB_TAG_TRIP || strstr($v['sub_tag'], SUB_TAG_TRIP)  )
								{
									if( count($arr_trip) == 0)
									{
										$rtn['err']['content[trip]']='差旅费费用报销明细请填写！';
										$check_data=FALSE;
									}
									
									$total_bali_trip_sum += $v['bali_sum_total'];
									
									$arr_trip_bali_id[] = $v['bali_id'];
									
									if($v['bali_pay_type'] == LOAN_PAY_TYPE_CHARGEOFFS)
									$sum_trip_total_cz += $v['bali_sum_total'];
								}
								
								if($v['bali_pay_type'] == LOAN_PAY_TYPE_CHARGEOFFS)
								$sum_total_cz += $v['bali_sum_total'];
								
								if( ! empty($v['gfc_id']) && ! empty($v['bali_sum_total']) && ! empty($v['bali_sub']))
								{
									$arr_check = $this->m_gfc->check_bud($v['gfc_id']
			                    	,$v['bali_sub']
			                    	,$v['bali_id']
			                    	,$v['bali_sum_total']);
			                    	
									if( ! $arr_check['rtn']){
										
			                           $rtn['err']['content[bali]'][] = array(
										'id' => $v['bali_id'],
										'field' => 'bali_sum_total',
										'act' => STAT_ACT_EDIT,
										'err_msg'=>$arr_check['msg']
										);
										
			                           $check_data=FALSE;
			                        }
								}
								
								if( element('ppo', $data_db['content']) == BAL_PPO_END || element('ppo', $data_db['content']) >= BAL_PPO_GZ)
								{
									if( ! $this->m_base->get_field_where('fm_subject','sub_id'," AND sub_id = '{$v['bali_abstract']}'"))
									{
										$rtn['err']['content[bali]'][] = array(
										'id' => $v['bali_id'],
										'field' => 'bali_abstract',
										'act' => STAT_ACT_EDIT,
										'err_msg'=>'请选择内容摘要!'
										);
										
			                            $check_data=FALSE;
									}
								}
							}
						}
						
						if( $total_bali_trip_sum != $total_trip_sum)
						{
							$rtn['err']['content[trip]']='差旅费费用报销合计【'.$total_bali_trip_sum.'】与费用报销相关科目合计【'.$total_bali_trip_sum.'】不想等！';
							$check_data=FALSE;
						}
					}
					
					//冲账
					$sum_total_bl = 0;
					if( ! empty(element('bl', $data_post['content'])))
					{
						$arr_bl = json_decode($data_post['content']['bl'],TRUE);
						
						if(count($arr_bl) > 0)
						{
							foreach ($arr_bl as $v) {
								
								if(in_array($v['bali_id'], $arr_trip_bali_id))
								{
									
								}
								
								$sum_total_bl += $v['bl_sum'];
							}
						}
					}
					
					if($sum_total_bl != $sum_total_cz)
					{
						$rtn['err']['content[bl]']='冲账金额合计【'.$sum_total_bl.'】与费用报销冲账合计【'.$sum_total_cz.'】不想等！';
						$check_data=FALSE;
					}
					
					//出差人垫付人
					if( ! empty(element('trip_c', $data_post['content'])))
					{
//						$arr_trip_c = json_decode($data_post['content']['trip_c'],TRUE);
//						
//						$total_trip_c_sum = 0;
//						if(count($arr_trip_c) > 0)
//						{
//							foreach ($arr_trip_c as $v) {
//								$total_trip_c_sum += $v['baltr_c_sum'];
//							}
//						}
//						
//						if($total_trip_c_sum != $total_trip_sum - $sum_trip_total_cz)
//						{
//							$rtn['err']['content[trip_c]']='报销单金额和【'.$total_trip_sum.'】出差人打卡金额【'.$sum_total_cz.'】不一致。！';
//							$check_data=FALSE;
//						}
					}
				}
				
				if( ! $check_data)
				{
					$rtn['result']=FALSE;
					
					if( $flag_more )
					{
						$rtn['msg_err']='';
						foreach($rtn['err'] as $v )
						{
							$rtn['msg_err'].=$v.'<br/>';
						}
						
						return $rtn;
					}
					
					echo json_encode($rtn);
					exit; 
				}
				
				/************数据处理*****************/
				$data_save['content']=$data_db['content'];
				
				if(count(element('content',$data_post))>0)
				{
					foreach ($data_post['content'] as $k=>$v) {
						if( ! in_array('content['.$k.']',$data_out['field_view'])
						 && ! in_array('content['.$k.']',$data_out['op_disable'])
						 && in_array('content['.$k.']',$data_out['field_edit']) )
						$data_save['content'][$k]=$v;
					}
				}
				 
				/************事件处理*****************/
				switch ($data_get['act']) {
					case STAT_ACT_CREATE:
						
						if( empty(element('bal_code', $data_save['content']) ) )
						{
							$data_save['content']['bal_code']=$this->get_code($data_save);
							$data_save['content']['bal_code_type'] = 1;
						}
						
						$data_save['content']['ppo']=BAL_PPO_START;
						
						$rtn=$this->add($data_save['content']);
						
						//费用报销明细
						if( ! empty(element('bali',$data_save['content']) ) )
						{
							$arr_save=array(
								'bal_id' => $rtn['id'],
								'ppo' => $data_save['content']['ppo']
							);

							$this->m_base->save_datatable('fm_bal_item',
								$data_save['content']['bali'],
								'[]',
								$arr_save);
						}
						
						//费用报销差旅费
						if( ! empty(element('trip',$data_save['content']) ) )
						{
							$arr_save=array(
								'bal_id' => $rtn['id'],
								'ppo' => $data_save['content']['ppo']
							);

							$this->m_base->save_datatable('fm_bali_trip',
								$data_save['content']['trip'],
								'[]',
								$arr_save);
						}
						
						if( ! empty(element('trip_c',$data_save['content']) ) )
						{
							$arr_save=array(
								'bal_id' => $rtn['id'],
								'ppo' => $data_save['content']['ppo']
							);

							$this->m_base->save_datatable('fm_bali_trip_c',
								$data_save['content']['trip_c'],
								'[]',
								$arr_save);
						}
						
						if( ! empty(element('trip_sub',$data_save['content']) ) )
						{
							$arr_save=array(
								'bal_id' => $rtn['id'],
								'ppo' => $data_save['content']['ppo']
							);

							$this->m_base->save_datatable('fm_bali_trip_sub',
								$data_save['content']['trip_sub'],
								'[]',
								$arr_save);
						}
						
						//费用报销明细关联
						if( ! empty(element('bl',$data_save['content']) ) )
						{
							$arr_save=array(
								'bal_id' => $rtn['id'],
								'ppo' => $data_save['content']['ppo']
							);

							$this->m_base->save_datatable('fm_bali_link',
								$data_save['content']['bl'],
								'[]',
								$arr_save);
						}
						
						//创建我的工单
	    				$data_save['wl']['wl_id'] = $rtn['id'];
	    				$data_save['wl']['wl_type'] = WL_TYPE_I;
	    				$data_save['wl']['wl_code']=$data_save['content']['bal_code'];
		    			$data_save['wl']['wl_op_table']='fm_balance';
		    			$data_save['wl']['wl_op_field']='bal_id';
		    			$data_save['wl']['op_id']=$rtn['id'];
	    				$data_save['wl']['p_id']=$this->proc_id;
	    				$data_save['wl']['pp_id']=$this->model_name;
	    				$data_save['wl']['wl_proc']=$data_save['content']['ppo'];
		    			$data_save['wl']['wl_url']=$this->url_conf.'/act/2';
		    			$data_save['wl']['wl_note']='【'.$this->title.'】'
		    				.','.$data_save['content']['bal_total_sum']
		    				.','.$data_save['content']['bal_time_node']
		    				.','.$this->m_base->get_c_show_by_cid($data_save['content']['bal_contact_manager'])
            				.','.$this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id = '{$data_save['content']['bal_ou']}'")
		    				;
	    				$data_save['wl']['c_accept'][] = $this->sess->userdata('c_id');
	    				$data_save['wl']['c_accept'][] = $data_save['content']['bal_contact_manager'];
	    				
	    				$this->m_work_list->add($data_save['wl']);
	    				
	    				$data_save['wl']['wl_id']=get_guid();
	    				$data_save['wl']['wl_type'] = 0 ;
	    				$data_save['wl']['wl_event']='补全、提交单据';
	    				$data_save['wl']['wl_proc'] = 1;
	    				$this->m_work_list->add($data_save['wl']);
	    				
	    				$rtn['wl_i'] = $data_save['wl']['c_accept'];
	    				$rtn['wl_accept'] = $data_save['wl']['c_accept'];
	    				$rtn['wl_care']=array();
	    				$rtn['wl_end'] = array();
							
						$arr_log_content=array();
						$arr_log_content['new']['content']=$data_save['content'];
						$arr_log_content['old']['content'][$this->pk_id]=$rtn['id'];
						
						//操作日志
						$data_save['content_log']['op_id']=$rtn['id'];
						$data_save['content_log']['log_act']=$data_get['act'];
						$data_save['content_log']['log_url']=$this->url_conf.'/'.$this->pk_id.'/'.$rtn['id'];
						$data_save['content_log']['log_content']=json_encode($arr_log_content);
						$data_save['content_log']['log_module']=$this->title;
						$data_save['content_log']['log_p_id']=$this->proc_id;
						
						$this->m_log_operate->add($data_save['content_log']);
						
						break;
					case STAT_ACT_EDIT:
						//验证数据更新时间
						if($data_save['content']['db_time_update'] != $data_db['content']['db_time_update'])
						{
							$rtn['result']=FALSE;
							$rtn['err']['db_time_update']='后台数据刷新中，请重新操作！';
							echo json_encode($rtn);
							exit; 
						}
						
						$data_save['content'][$this->pk_id]=element($this->pk_id,$data_get);
						
						//流程工单
						$ppo_btn_text = $data_out['ppo_btn_next'];
						if($btn == 'pnext')
						$ppo_btn_text = $data_out['ppo_btn_pnext'];
						
						//工单基本信息
						$data_save['wl']['wl_code']=$data_db['content']['bal_code'];
		    			$data_save['wl']['wl_op_table']='fm_balance';
		    			$data_save['wl']['wl_op_field']='bal_id';
		    			$data_save['wl']['op_id']=$data_save['content'][$this->pk_id];
	    				$data_save['wl']['p_id']=$this->proc_id;
	    				$data_save['wl']['pp_id']=$this->model_name;
		    			$data_save['wl']['wl_url']=$this->url_conf.'/act/2';
		    			$data_save['wl']['wl_proc']=$data_save['content']['ppo'];
		    			$data_save['wl']['wl_time_end']=date('Y-m-d H:i:s',strtotime('+30 day'));
		    			$data_save['wl']['c_accept'] = array();
		    			$data_save['wl']['wl_note']='【'.$this->title.'】'
		    				.','.$data_save['content']['bal_total_sum']
		    				.','.$data_save['content']['bal_time_node']
		    				.','.$this->m_base->get_c_show_by_cid($data_save['content']['bal_contact_manager'])
            				.','.$this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id = '{$data_save['content']['bal_ou']}'")
		    				;
						
		    			//费用报销明细
						$arr_wl_combine = array();
						$arr_wl_combine_tmp = array();
						$arr_event = array();
						$c_accept = array();
						
						$arr_bali = json_decode($data_save['content']['bali'],TRUE);
						
						//工单流转
                        switch (element('ppo',$data_db['content']))
                        {
                            case BAL_PPO_START:

                                if($btn == 'next')
                                {
                                    $data_save['content']['ppo'] = BAL_PPO_FH;

                                    $data_save['wl']['wl_event']='复核单据';

                                    //添加流程接收人
                                    $data_save['wl']['c_accept']=array();
                                    
                                 	$c_accept = $this->m_acl->get_acl_person($this->proc_id,ACL_PROC_BAL_FCHECK);
	                                    		
                                    if(count($c_accept)>0){
                                        $arr_v=array();
                                        $arr_v[]=$c_accept;
                                        $arr_v[]=$data_save['content']['bal_ou'];
                                        $arr_v[]=$data_save['content']['bal_ou'];
                                        $arr_v[]=$data_save['content']['bal_ou'];
                                        $c_accept=$this->m_base->get_field_where('sys_contact','c_id'
                                            ," AND c_id IN ? AND ( c_ou_2 = ? OR c_ou_3 = ? OR c_ou_4 = ?) ",$arr_v,1);
                                    }
                                    
									foreach ($arr_bali as $k=>$v) 
									{
										if( $v['bali_ou_tj'] != $data_save['content']['bal_ou'] )
										{
											$arr_wl_combine[$v['bali_id']] = $this->m_bl_ppo->get_c_person($v['bali_sub'],$data_save['content']['bal_ou']
	                                    	,$v['bali_sum_total'],BAL_PPO_FH);
	                                    	
	                                    	if(count($arr_wl_combine[$v['bali_id']]) > 0)
	                                    	{
	                                    		$arr_v=array();
		                                        $arr_v[]=$data_save['content']['bal_org_owner'];
		                                        $arr_v[]=$arr_wl_combine[$v['bali_id']];
		                                        $arr_wl_combine[$v['bali_id']]=$this->m_base->get_field_where('sys_contact','c_id'
		                                            ,"AND c_org = ? AND c_id IN ? ",$arr_v,1);
		                                            
		                                        if(count($arr_wl_combine[$v['bali_id']]) == 0)
		                                    	unset($arr_wl_combine[$v['bali_id']]);
		                                    	else 
	                                    		$arr_bali[$k]['blp_ppo_person'] = implode(',',  $arr_wl_combine[$v['bali_id']]);
	                                    		
	                                    		$arr_bali[$k]['blp_ppo'] = BAL_PPO_FH;
	                                    	}
	                                    	else 
	                                    	{
	                                    		$arr_wl_combine[$v['bali_id']] = $c_accept;
	                                    		$arr_bali[$k]['blp_ppo_person'] = implode(',',  $arr_wl_combine[$v['bali_id']]);
	                                    		$arr_bali[$k]['blp_ppo'] = BAL_PPO_FH;
	                                    	}
										}
										else 
										{
											//添加流程接收人
		                                    $arr_wl_combine_tmp[$v['bali_id']] = $this->m_bl_ppo->get_c_person($v['bali_sub'],$v['bali_ou_tj']
	                                    	,$v['bali_sum_total'],BAL_PPO_SH);
	                                    	
											if(count($arr_wl_combine_tmp[$v['bali_id']]) == 0)
	                                    	unset($arr_wl_combine_tmp[$v['bali_id']]);
	                                    	else 
	                                    	{
	                                    		$arr_bali[$k]['blp_ppo_person'] = implode(',',  $arr_wl_combine_tmp[$v['bali_id']]);
	                                    		$arr_bali[$k]['blp_ppo'] = BAL_PPO_SH;
	                                    	}
										}
										
										$arr_bali[$k]['blp_ppo_num'] = 1;
									}
									
									if(count($arr_wl_combine) == 0 && count($arr_wl_combine_tmp) != 0)
									{
										$arr_wl_combine = $arr_wl_combine_tmp;
										
										$data_save['content']['ppo'] = BAL_PPO_SH;

                                    	$data_save['wl']['wl_event']='审核单据';
									}	
                                }

                                break;
                            case BAL_PPO_FH:

                                if($btn == 'next')
                                {
                                	$flag_fh = FALSE;
                                	
                                	$flag_wl_combine_finish = TRUE;
                                	
                                	if( count(element('arr_wl_i_to_do', $data_out)) > 0 )//
									{
										//验证联合工单是否全部完成
										$flag_wl_combine_finish=$this->m_work_list->check_wl_combine_finish(
										$data_save['content']['bal_id'],$this->model_name,element('arr_wl_i_to_do', $data_out));
									}
									
                                	$c_accept = $this->m_acl->get_acl_person($this->proc_id,ACL_PROC_BAL_CHECK);
	                                    		
                                    if(count($c_accept)>0){
                                        $arr_v=array();
                                        $arr_v[]=$data_save['content']['bal_org_owner'];
                                        $arr_v[]=$c_accept;
                                        $c_accept=$this->m_base->get_field_where('sys_contact','c_id'
                                            ,"AND c_org = ? AND c_id IN ? ",$arr_v,1);
                                    }
									                                	
									foreach ($arr_bali as $k=>$v) 
									{
										if( strstr($v['blp_ppo_person'], $this->sess->userdata('c_id') ) 
										 || count(element('arr_wl_i_to_do', $data_out)) == 0 )
										{
											$arr_wl_combine[$v['bali_id']] = $this->m_bl_ppo->get_c_person($v['bali_sub'],$data_save['content']['bal_ou']
                                    		,$v['bali_sum_total'],BAL_PPO_FH,$v['blp_ppo_num']+1);
                                    		
                                    		if(count($arr_wl_combine[$v['bali_id']]) > 0 )
                                    		{
                                    			$flag_fh = TRUE;
                                    			$arr_bali[$k]['blp_ppo_num']++;
                                    			
                                    			$arr_event[$v['bali_id']] = '复核单据'.$arr_bali[$k]['blp_ppo_num'].'阶段';
                                    			$arr_bali[$k]['blp_ppo_person'] = implode(',',  $arr_wl_combine[$v['bali_id']]);
                                    			
                                    			$arr_bali[$k]['blp_ppo'] = BAL_PPO_FH;
                                    		}
                                    		else
                                    		{
                                    			$arr_bali[$k]['blp_ppo_num'] = 1;
                                    			
                                    			$arr_wl_combine_tmp[$v['bali_id']] = $this->m_bl_ppo->get_c_person($v['bali_sub'],$v['bali_ou_tj']
                                    			,$v['bali_sum_total'],BAL_PPO_SH,$arr_bali[$k]['blp_ppo_num'] );
                                    			
                                    			if(count($arr_wl_combine_tmp[$v['bali_id']]) == 0)
                                    			$arr_wl_combine_tmp[$v['bali_id']] = $c_accept;
                                    			
                                    			$arr_event[$v['bali_id']] = '审核单据';
                                    			$arr_bali[$k]['blp_ppo_person'] = implode(',',  $arr_wl_combine_tmp[$v['bali_id']]);
                                    		
                                    			$arr_bali[$k]['blp_ppo'] = BAL_PPO_SH;
                                    			
                                    			unset($arr_wl_combine[$v['bali_id']]);
                                    		}
										}
										elseif($v['blp_ppo'] == BAL_PPO_SH)
										{
											$arr_wl_combine_tmp[$v['bali_id']] = explode(',', $v['blp_ppo_person']);
										}
									}
									
									if( ! $flag_fh && $flag_wl_combine_finish)
									{
										$arr_wl_combine = $arr_wl_combine_tmp;
										
										$data_save['content']['ppo'] = BAL_PPO_SH;
                                    	$data_save['wl']['wl_event']='审核单据';
									}
									
                                }
                                elseif($btn == 'pnext')
                                {
                                    $data_save['content']['ppo'] = BAL_PPO_START;

                                    $data_save['wl']['wl_event']='修改单据';
                                    $data_save['wl']['c_accept'][] = $data_db['content']['db_person_create'];
                                }

                                break;
                            case BAL_PPO_SH:

                                if($btn == 'next')
                                {
                                	$flag_sh = FALSE;
                                	
                                	$flag_wl_combine_finish = TRUE;
                                	
                                	if( count(element('arr_wl_i_to_do', $data_out)) > 0 )//
									{
										//验证联合工单是否全部完成
										$flag_wl_combine_finish=$this->m_work_list->check_wl_combine_finish(
										$data_save['content']['bal_id'],$this->model_name,element('arr_wl_i_to_do', $data_out));
									}
									
                                	$c_accept = $this->m_acl->get_acl_person($this->proc_id,ACL_PROC_BAL_POSTED);
	                                    		
                                    if(count($c_accept)>0){
                                        $arr_v=array();
                                        $arr_v[]=$data_save['content']['bal_org_owner'];
                                        
                                        $arr_v[]=$c_accept;
                                        
                                        $c_accept=$this->m_base->get_field_where('sys_contact','c_id'
                                            ,"AND c_org = ? AND c_id IN ? ",$arr_v,1);
                                    }
                                	
                                	foreach ($arr_bali as $k=>$v) 
									{
										if( strstr($v['blp_ppo_person'], $this->sess->userdata('c_id') ) 
										 || count(element('arr_wl_i_to_do', $data_out)) == 0 )
										{
											$arr_wl_combine[$v['bali_id']] = $this->m_bl_ppo->get_c_person($v['bali_sub'],$v['bali_ou_tj']
                                    		,$v['bali_sum_total'],BAL_PPO_SH,$v['blp_ppo_num']+1);
                                    		
                                    		if(count($arr_wl_combine[$v['bali_id']]) > 0 )
                                    		{
                                    			$flag_sh = TRUE;
                                    			$arr_bali[$k]['blp_ppo_num']++;
                                    			
                                    			$arr_event[$v['bali_id']] = '审核单据'.$arr_bali[$k]['blp_ppo_num'].'阶段';
                                    			$arr_bali[$k]['blp_ppo_person'] = implode(',',  $arr_wl_combine[$v['bali_id']]);
                                    			
                                    			$arr_bali[$k]['blp_ppo'] = BAL_PPO_SH;
                                    		}
                                    		else
                                    		{
                                    			unset($arr_wl_combine[$v['bali_id']]);
                                    			$arr_bali[$k]['blp_ppo'] = BAL_PPO_GZ;
                                    			$arr_bali[$k]['blp_ppo_person'] = implode(',',$c_accept);
                                    		}
										}
									}
									
									if( ! $flag_sh && $flag_wl_combine_finish)
									{
										$data_save['content']['ppo'] = BAL_PPO_GZ;
                                    	$data_save['wl']['wl_event']='过账';
                                    	
                                    	$data_save['wl']['c_accept']=$c_accept;
									}
                                }
                                elseif($btn == 'pnext')
                                {
                                    $data_save['content']['ppo'] = BAL_PPO_START;

                                    $data_save['wl']['wl_event']='修改单据';
                                    $data_save['wl']['c_accept'][] = $data_db['content']['db_person_create'];
                                    $data_save['wl']['c_accept'][] = $data_save['content']['bal_contact_manager'];
                                }

                                break;
                            case BAL_PPO_GZ:

                                if($btn == 'next')
                                {
                                    //添加流程接收人
                                    $c_accept=$this->m_acl->get_acl_person($this->proc_id,ACL_PROC_BAL_FINAL);
                                    $data_save['wl']['c_accept']=$c_accept;
                                    
                                	foreach ($arr_bali as $k=>$v) 
									{
										if( strstr($v['blp_ppo_person'], $this->sess->userdata('c_id') ) 
										 || count(element('arr_wl_i_to_do', $data_out)) == 0 )
										{
											$arr_wl_combine[$v['bali_id']] = $this->m_bl_ppo->get_c_person($v['bali_sub'],$v['bali_ou_tj']
                                    		,$v['bali_sum_total'],BAL_PPO_SP,$v['blp_ppo_num']);
                                    		
                                    		if(element('bali_abstract_db', $v))
                                    		$arr_bali[$k]['bali_note'] .= $v['bali_abstract_db'];
                                    		
                                    		if(count($arr_wl_combine[$v['bali_id']]) == 0 )
                                    		{
                                    			$arr_bali[$k]['bl_ppo'] = BAL_PPO_END;
                                    			$arr_bali[$k]['blp_ppo_person'] = '';
                                    			unset($arr_wl_combine[$v['bali_id']]);
                                    		}
                                    		else 
                                    		{
                                    			$arr_bali[$k]['bl_ppo'] = BAL_PPO_SP;
                                    			$arr_bali[$k]['blp_ppo_person'] = implode(',', $c_accept) ;
                                    		}
										}
									}
									
									if(count($arr_wl_combine) > 0)
									{
										$data_save['content']['ppo'] = BAL_PPO_SP;
                                    	$data_save['wl']['wl_event']='审批';
									}
									else
									{
										$data_save['content']['ppo'] = BAL_PPO_END;
									}

                                }
                                elseif($btn == 'pnext')
                                {
                                    $data_save['content']['ppo'] = BAL_PPO_START;

                                    $data_save['wl']['wl_event']='修改单据';
                                    $data_save['wl']['c_accept'][] = $data_db['content']['db_person_create'];
                                    $data_save['wl']['c_accept'][] = $data_save['content']['bal_contact_manager'];
                                }

                                break;
                            case BAL_PPO_SP:

                                if($btn == 'next')
                                {
                               	 	$flag_sp = FALSE;
                                	
                                	$flag_wl_combine_finish = TRUE;
                                	
                                	if( count(element('arr_wl_i_to_do', $data_out)) > 0 )//
									{
										//验证联合工单是否全部完成
										$flag_wl_combine_finish=$this->m_work_list->check_wl_combine_finish(
										$data_save['content']['bal_id'],$this->model_name,element('arr_wl_i_to_do', $data_out));
									}
                                	
                                	foreach ($arr_bali as $k=>$v) 
									{
										if( strstr($v['blp_ppo_person'], $this->sess->userdata('c_id') ) 
										 || count(element('arr_wl_i_to_do', $data_out)) == 0 )
										{
											$arr_wl_combine[$v['bali_id']] = $this->m_bl_ppo->get_c_person($v['bali_sub'],$v['bali_ou_tj']
                                    		,$v['bali_sum_total'],BAL_PPO_SP,$v['blp_ppo_num']+1);
                                    		
                                    		if(count($arr_wl_combine[$v['bali_id']]) > 0 )
                                    		{
                                    			$flag_sp = TRUE;
                                    			$arr_bali[$k]['blp_ppo_num']++;
                                    			
                                    			$arr_event[$v['bali_id']] = '审批单据'.$arr_bali[$k]['blp_ppo_num'].'阶段';
                                    			$arr_bali[$k]['blp_ppo_person'] = implode(',',  $arr_wl_combine[$v['bali_id']]);
                                    			
                                    			$arr_bali[$k]['blp_ppo'] = BAL_PPO_SP;
                                    		}
                                    		else
                                    		{
                                    			$arr_bali[$k]['blp_ppo'] = BAL_PPO_END;
                                    			unset($arr_wl_combine[$v['bali_id']]);
                                    		}
										}
									}
									
									if( ! $flag_sp && $flag_wl_combine_finish)
									{
										$data_save['content']['ppo'] = BAL_PPO_END;
									}

                                }
                                elseif($btn == 'pnext')
                                {
                                    $data_save['content']['ppo'] = BAL_PPO_START;

                                    $data_save['wl']['wl_event']='修改单据';
                                    $data_save['wl']['c_accept'][] = $data_db['content']['db_person_create'];
                                    $data_save['wl']['c_accept'][] = $data_save['content']['bal_contact_manager'];
                                }

                                break;

                        }
						
						if(  ! empty(element('bali',$data_save['content']) ) )
						{
							
							$data_save['content']['bali'] = json_encode($arr_bali);
							
							$arr_save=array(
								'bal_id' => element('bal_id',$data_get),
								'ppo' => $data_save['content']['ppo']
							);
							
							$this->m_base->save_datatable('fm_bal_item',
								$data_save['content']['bali'],
								$data_db['content']['bali'],
								$arr_save,
								'm_bal',
								'save_bali');
							
						}
						
						//差旅费费用报销明细
						if(  ! empty(element('trip',$data_save['content']) ) )
						{
							$arr_save=array(
								'bal_id' => element('bal_id',$data_get),
								'ppo' => $data_save['content']['ppo']
							);

							$this->m_base->save_datatable('fm_bali_trip',
								$data_save['content']['trip'],
								$data_db['content']['trip'],
								$arr_save);
						}
						
						if(  ! empty(element('trip_c',$data_save['content']) ) )
						{
							$arr_save=array(
								'bal_id' => element('bal_id',$data_get),
								'ppo' => $data_save['content']['ppo']
							);

							$this->m_base->save_datatable('fm_bali_trip_c',
								$data_save['content']['trip_c'],
								$data_db['content']['trip_c'],
								$arr_save);
						}
						
						if(  ! empty(element('trip_sub',$data_save['content']) ) )
						{
							$arr_save=array(
								'bal_id' => element('bal_id',$data_get),
								'ppo' => $data_save['content']['ppo']
							);

							$this->m_base->save_datatable('fm_bali_trip_sub',
								$data_save['content']['trip_sub'],
								$data_db['content']['trip_sub'],
								$arr_save);
						}
						
						//费用报销明细关联
						if(  ! empty(element('bl',$data_save['content']) ) )
						{
							$arr_save=array(
								'bal_id' => element('bal_id',$data_get),
								'ppo' => $data_save['content']['ppo']
							);

							$this->m_base->save_datatable('fm_bali_link',
								$data_save['content']['bl'],
								$data_db['content']['bl'],
								$arr_save);
						}
						
						$rtn=$this->update($data_save['content']);
						
						//工单日志
						if( $btn == 'yj' )
						{
							$data_save['content_log']['log_note']=
						'【'.$this->sess->userdata('c_name').'['.$this->sess->userdata('a_login_id').']】'
						.'于节点【'.$GLOBALS['m_bal']['text']['ppo'][$data_db['content']['ppo']].'】'
						.',将【'.$this->title.'】移交于【'.$data_post['content']['person_yj_s'].'】';
						
							$data_save['wl']['wl_type']=WL_TYPE_YJ;
							$data_save['wl']['wl_event']=element('wl_list_to_do', $data_out);
							$data_save['wl']['c_accept'][]=$data_post['content']['person_yj'];
							
						}
						elseif( $btn == 'next' || $btn == 'pnext' )
						{
							$data_save['content_log']['log_note']=
						'于节点【'.$GLOBALS['m_bal']['text']['ppo'][$data_db['content']['ppo']].'】'.$ppo_btn_text
						.',流转至节点【'.$GLOBALS['m_bal']['text']['ppo'][$data_save['content']['ppo']].'】';
						
						}	
						
						//工单更新
						switch ($btn)
						{
							case 'yj':
								$data_save['wl_have_do']['wl_result']=WL_RESULT_YJ;
							case 'next':
								$data_save['wl_have_do']['wl_result']=WL_RESULT_SUCCESS;
							case 'pnext':
								
								$wl_comment='';
								if( is_array(element('wl', $data_post) ) 
								 && ! empty(element('wl_comment', $data_post['wl'])) )
								$wl_comment = element('wl_comment', $data_post['wl']);
								
								//更新工单已完成
								$data_save['wl_have_do']=array();
								$data_save['wl_have_do']['wl_comment']=$wl_comment;
								$data_save['wl_have_do']['wl_log_note']=$data_save['content_log']['log_note'];
								
								if( count(element('arr_wl_i_to_do', $data_out)) > 0 )
								$data_save['wl_have_do']['wl_id_i_do'] = $data_out['arr_wl_i_to_do'];
								
								$this->m_work_list->update_wl_have_do(element($this->pk_id,$data_get),$this->model_name,$data_save['wl_have_do']);
								
								//更新我的工单
								$data_save['wl_i'] = array();
								$data_save['wl_i']['wl_log_note']=$data_save['content_log']['log_note'];
								
								if($data_save['content']['ppo'] == BAL_PPO_END)
								{
									$data_save['wl_i']['wl_status']=WL_STATUS_FINISH;
									$data_save['wl_i']['wl_result']=WL_RESULT_SUCCESS;
									$data_save['wl_i']['wl_person_do'] = $this->sess->userdata('c_id');
    								$data_save['wl_i']['wl_time_do'] = date('Y-m-d H:i:s');
								}
								
								$this->m_work_list->update_wl_i(element($this->pk_id,$data_get),$this->model_name,$data_save['wl_i']);
								
								$data_save['wl']['wl_proc'] = $data_save['content']['ppo'];
								$data_save['wl']['wl_comment_new'] = 
								'<p>'.date("Y-m-d H:i:s").' '.$this->sess->userdata('c_name').'['.$this->sess->userdata('a_login_id').']</p>'
								.'<p>'.$data_save['content_log']['log_note'].'</p>';
								
								if( ! empty($wl_comment) )
								$data_save['wl']['wl_comment_new'] = '<p>'.$wl_comment.'</p>';
								
								if($data_save['content']['ppo'] != BAL_PPO_END)
								{
									if($btn == 'next' && count($arr_wl_combine) > 0 )
									{
										//联合工单
										$data_save['wl']['wl_combine']=1;
										
										$event = element('wl_event', $data_save['wl']);
										$arr_wl_accept=array();

										foreach ($arr_wl_combine as $k=>$v) {
											$data_save['wl']['c_accept'] =$v;//array_diff($v,$arr_wl_accept) ;

											if(element($k, $arr_event))
											$data_save['wl']['wl_event'] =element($k, $arr_event);
											else 
											$data_save['wl']['wl_event'] = $event;
											
											if(count($data_save['wl']['c_accept']) > 0 )
											{
												$this->m_work_list->add($data_save['wl']);
												
												$arr_wl_accept=array_values(array_merge($arr_wl_accept,$v));
											}
										}
										
										$data_save['wl']['c_accept']=array_unique($arr_wl_accept);
									}
									else
									$this->m_work_list->add($data_save['wl']);
								}
								
								//获取工单关注人与所有人
								$arr_wl_person = $this->m_work_list->get_wl_care_accept(element($this->pk_id,$data_get),$this->model_name);
								
								$rtn['wl_end'] = array();
								$rtn['wl_accept'] = $data_save['wl']['c_accept'];
								$rtn['wl_accept'][] = $this->sess->userdata('c_id');
								
								if( count( element('arr_wl_accept', $data_out)) > 0 )
								$rtn['wl_accept'] = array_values(array_merge($rtn['wl_accept'],$data_out['arr_wl_accept']));
								
								$rtn['wl_accept'] =array_unique($rtn['wl_accept']);
								
								$rtn['wl_care'] = $arr_wl_person['care'];
								$rtn['wl_i'] = $arr_wl_person['accept'];
								$rtn['wl_op_id'] = element($this->pk_id,$data_get);
								$rtn['wl_pp_id'] = $this->model_name;
								
								if($data_save['content']['ppo'] == BAL_PPO_END)
								$rtn['wl_end'] = $arr_wl_person['accept'];
								
								break;
						}
						
						$arr_log_content=array();
						$arr_log_content['new']['content']=$data_save['content'];
						$arr_log_content['old']['content']=$data_db['content'];
						
						//操作日志
						$data_save['content_log']['op_id']=element($this->pk_id, $data_get);
						$data_save['content_log']['log_act']=$data_get['act'];
						$data_save['content_log']['log_url']=$this->url_conf.'/'.$this->pk_id.'/'.element($this->pk_id, $data_get);
						$data_save['content_log']['log_content']=json_encode($arr_log_content);
						$data_save['content_log']['log_module']=$this->title;
						$data_save['content_log']['log_p_id']=$this->proc_id;
						$this->m_log_operate->add($data_save['content_log']);
						
						$rtn['db_time_update'] = date("Y-m-d H:i:s"); 
						
						break;
				}
				
				if( $flag_more )
					return $rtn;
				
				echo json_encode($rtn);
				exit; 
				break;
			case 'del':
				
				$rtn=$this->del(element($this->pk_id,$data_get));
				
				$arr_wl_person = $this->m_work_list->get_wl_care_accept(element($this->pk_id,$data_get),$this->model_name);
								
				$rtn['wl_end'] = array();
				
				if( count( element('arr_wl_accept', $data_out)) > 0 )
				$rtn['wl_accept'] =$data_out['arr_wl_accept'];
								
				$rtn['wl_accept'][] = $this->sess->userdata('c_id');
				
				$rtn['wl_care'] = $arr_wl_person['care'];
				$rtn['wl_i'] = $arr_wl_person['accept'];
				$rtn['wl_op_id'] = element($this->pk_id,$data_get);
				$rtn['wl_pp_id'] = $this->model_name;
				
				if( element('rtn',$rtn) )
				{
					//操作日志
					$data_save['content_log']['op_id']=element($this->pk_id, $data_get);
					$arr_log_content=array();
					$arr_log_content['old']['content']=$data_db['content'];
					$data_save['content_log']['log_url']=$this->url_conf.'/'.$this->pk_id.'/'.element($this->pk_id, $data_get);
					$data_save['content_log']['log_act']=STAT_ACT_REMOVE;
					$data_save['content_log']['log_module']=$this->title;
					$data_save['content_log']['log_p_id']=$this->proc_id;
					$this->m_log_operate->add($data_save['content_log']);
				}
				
				if( $flag_more )
					return $rtn;
					
				echo json_encode($rtn);
				exit; 
				break;
		}
		
		/************只读/必填****************/
		$data_out['field_required']=json_encode($data_out['field_required']);
		
		$data_out['field_edit']=array_values(array_diff($data_out['field_edit'],$data_out['field_view']));
		$data_out['field_edit']=json_encode($data_out['field_edit']);
		
		$data_out['field_view']=array_values($data_out['field_view']);
		$data_out['field_view']=json_encode($data_out['field_view']);
		
		$data_out['op_disable']=json_encode($data_out['op_disable']);
		
		/************模板赋值*****************/
		
		$data_out['act']=$data_get['act'];
		$data_out['url']=current_url();
		$data_out['time']=time();
		$data_out['fun_open']=element('fun_open', $data_get);
	    $data_out['fun_open_id']=element('fun_open_id', $data_get);
	    $data_out['flag_wl_win']=element('flag_wl_win', $data_get);
	    
	    $data_out['log']=json_encode(element('log', $data_out));
		
		$data_out['log_time']=$this->input->post('log_time');
		$data_out['log_a_login_id']=$this->input->post('log_a_login_id');
		$data_out['log_c_name']=$this->input->post('log_c_name');
		$data_out['log_act']=$this->input->post('log_act');
		$data_out['log_note']=$this->input->post('log_note');
	    
	    $data_out['db_time_create']=element('db_time_create', $data_db['content']);
	    $data_out['code']=element('bal_code', $data_db['content']);
	    
	    $data_out['ppo']=element('ppo', $data_db['content']);
	    $data_out['ppo_name']=$GLOBALS['m_bal']['text']['ppo'][element('ppo', $data_db['content'])];
	    
	    $data_out[$this->pk_id]=element($this->pk_id,$data_get);
	    
	    $data_out['data']=array();
	    
		if( count(element('content',$data_db))>0)
		{
			foreach ($data_db['content'] as $k=>$v) {
				if( in_array('content['.$k.']',$data_out['field_out']))
				{
					$data_out['data']['content['.$k.']']=$v;
				}
			}
		}
		
		$data_out['data']=json_encode($data_out['data']);
		/************载入视图 *****************/
		$arr_view[]=$this->url_conf;
		$arr_view[]=$this->url_conf.'_js';
		$this->m_view->load_view($arr_view,$data_out);
	}
	
	/**
	 * 
	 * 费用报销明细
	 * @param unknown_type $data_save
	 */
	function save_bali($arr_save)
	{
		switch ($arr_save)
		{
			case 'bali_sum_total':
				$arr_save['bali_sum'] = $arr_save['bali_sum_total'] - $arr_save['bali_sum_zzs'];
				break;
		}
		
		return $arr_save;
	}
	
	/**
	 * 
	 * 显示费用报销明细变更
	 * @param $arr bali数据数组
	 */
	public function show_change_bali($id,$field,$v)
	{
		$rtn=array();
		$rtn['id'] = $id;
		$rtn['field'] = $field;
		$rtn['act'] = STAT_ACT_EDIT;
		$rtn['err_msg']= $v[$field];
		
		switch ($field)
		{
			case 'bali_category_statistics':

				if($v[$field])
				$rtn['err_msg'] = $GLOBALS['m_bal']['text']['bali_category_statistics'][$v[$field]];

				break;
		}
		
		$rtn['err_msg']='变更前:'.$rtn['err_msg'];
		
		return $rtn;
	}
}