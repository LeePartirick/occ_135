<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 *  
    回款
 */
class M_bs extends CI_Model {
	
	//@todo 主表配置
	private $table_name='fm_back_section';
	private $pk_id='bs_id';
	private $table_form;
	private $arr_table_form=array();
	private $title='回款';
	private $model_name = 'm_bs';
	private $url_conf = 'proc_bs/bs/edit';
	private $proc_id = 'proc_bs';
	
 	public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->m_define();
        
        //读取表结构
        $this->config->load('db_table/sys_contact', FALSE,TRUE);
        $this->arr_table_form['sys_contact']=$this->config->item('sys_contact');
        
         //读取表结构
        $this->config->load('db_table/'.$this->table_name, FALSE,TRUE);
        $this->table_form=$this->config->item($this->table_name);
        
        $this->load->model('proc_gfc/m_bp');
    }
    
	/**
     * 
     * 定义
     */
	public function m_define()
    {
    	//@todo 定义
    	if( defined('LOAD_M_BS') ) return;
    	define('LOAD_M_BS', 1);
    	
    	//define
    	
    	// 节点
    	define('BS_PPO_END', 0); // 流程结束
		define('BS_PPO_START', 1); // 起始
		define('BS_PPO_LINK', 2); // 关联
    	
    	$GLOBALS['m_bs']['text']['ppo']=array(
    		BS_PPO_START=>'起始',
    		BS_PPO_LINK=>'关联',
    		BS_PPO_END=>'流程结束'
    	);
    	
    	//发票送达方式
    	define('BSI_TYPE_BILL', 1); // 
		define('BSI_TYPE_LOAN', 2); //
		define('BSI_TYPE_BP', 3); //
		
    	$GLOBALS['m_bs']['text']['bsi_type']=array(
    		BSI_TYPE_BILL=>'开票',
    		BSI_TYPE_LOAN=>'非开票',
    		BSI_TYPE_BP=>'回款计划',
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
    	$acl_list= $this->m_proc_bs->get_acl();
    	
    	$msg='';
    	/************权限验证*****************/
    	
    	//如果有超级权限，TRUE
    	if( ($acl_list & pow(2,ACL_PROC_BS_SUPER)) != 0 )
    	{
    		return TRUE;
    	}
    	
    	$check_acl=FALSE;
    	
    	if( ! $check_acl
         && ($acl_list & pow(2,ACL_PROC_BS_USER)) != 0
        )
        {
            $check_acl=TRUE;
        }
	    
	    if( ! $check_acl )
	    {
			if( ! $msg )
			$msg = '您没有【回款管理】的【操作】权限不可进行操作！' ;
			
			redirect('base/main/show_err/msg/'.fun_urlencode($msg));
	    }
    }
    
	/**
     * 
     */
	public function get_code($data_save=array())
    {
    	$where='';
    	 
    	$pre = $this->m_base->get_field_where('sys_ou','ou_org_pre'," AND ou_id ='{$data_save['content']['bs_org_owner']}'");
    	
    	$pre.='-BS'.date("Ym");
    	$where .= " AND bs_code LIKE  '{$pre}%'";
    	
    	$max_code=$this->m_db->get_m_value('fm_back_section','bs_code',$where);
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
    	
    	//回款关联明细
		$arr_search=array();
		$arr_search['field']='*';
		$arr_search['from']="fm_bs_item bsi";
		$arr_search['where']=' AND bs_id = ? ';
		$arr_search['value'][]=element('bs_id',$content);
		
		$rs=$this->m_db->query($arr_search);
		if(count($rs['content']) > 0)
		{
			foreach ($rs['content'] as $v) {
				
				$bsi_sum_all = $this->m_base->get_field_where('fm_bs_item','sum(bsi_sum)'," AND ppo = 0 AND bsi_link_id = '{$v['bsi_link_id']}'");
				
				switch ($v['bsi_type'])
				{
					case BSI_TYPE_BILL:
						
						$this->m_table_op->load('fm_bill');
						$arr_bill =  $this->m_table_op->get(element('bsi_link_id',$v));
						
						$data_save['bill']=array();
						$data_save['bill']['bill_id'] = element('bsi_link_id',$v);
						$data_save['bill']['bill_sum_return'] = $bsi_sum_all;
						$this->m_table_op->update($data_save['bill']);
						
						$this->m_table_op->load('pm_bill_plan');
						
						$data_save['bp']=array();
						$data_save['bp']['bp_id'] = element('bp_id',$arr_bill);
						$data_save['bp']['bp_sum_hk'] = $this->m_base->get_field_where('fm_bs_item','sum(bsi_sum)'," AND ppo = 0 AND bsi_link_id = '{$arr_bill['bp_id']}'");
						$data_save['bp']['bp_sum_hk'] += $this->m_base->get_field_where('fm_bill','sum(bill_sum_return)'," AND ppo = 0 AND bp_id = '{$arr_bill['bp_id']}'");
						
						$this->m_table_op->update($data_save['bp']);
						
						$this->m_table_op->load('pm_given_financial_code');
						
						$data_save['gfc']=array();
						$data_save['gfc']['gfc_id'] = $v['bsi_gfc_id'];
						$data_save['gfc']['gfc_sum_hk'] = $this->m_base->get_field_where('pm_bill_plan','sum(bp_sum_hk)'," AND gfc_id = '{$v['bsi_gfc_id']}'");
						
						$this->m_table_op->update($data_save['gfc']);
						
						break;
					case BSI_TYPE_LOAN:
						
						$this->m_table_op->load('fm_loan');
						
						$data_save['loan']=array();
						$data_save['loan']['loan_id'] = element('bsi_link_id',$v);
						$data_save['loan']['loan_sum_return'] = $bsi_sum_all; 
						$data_save['loan']['loan_sum_return'] += $this->m_base->get_field_where('fm_bali_link','sum(bl_sum)'," AND ppo = 0 AND loan_id = '{$v['bsi_link_id']}'");
						
						$this->m_table_op->update($data_save['loan']);
						
						break;
					case BSI_TYPE_BP:
						
						$this->m_table_op->load('pm_bill_plan');
						
						$data_save['bp']=array();
						$data_save['bp']['bp_id'] = element('bsi_link_id',$v);
						$data_save['bp']['bp_sum_hk'] = $this->m_base->get_field_where('fm_bs_item','sum(bsi_sum)'," AND ppo = 0 AND bsi_link_id = '{$v['bsi_link_id']}'");
						$data_save['bp']['bp_sum_hk'] += $this->m_base->get_field_where('fm_bill','sum(bill_sum_return)'," AND ppo = 0 AND bp_id = '{$v['bsi_link_id']}'");
						
						$this->m_table_op->update($data_save['bp']);
						
						$this->m_table_op->load('pm_given_financial_code');
						
						$data_save['gfc']=array();
						$data_save['gfc']['gfc_id'] = $v['bsi_gfc_id'];
						$data_save['gfc']['gfc_sum_hk'] = $this->m_base->get_field_where('pm_bill_plan','sum(bp_sum_hk)'," AND gfc_id = '{$v['bsi_gfc_id']}'");
						
						$this->m_table_op->update($data_save['gfc']);
						
						break;
				}
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
        $rtn=$this->m_db->update('fm_bs_item',$data_save['content']," 1=1 AND {$this->pk_id} = '{$data_save['content'][$this->pk_id]}'");
        
        if($rtn)
        $this->update_ltable($data_db['content']);
        
        if($rtn['rtn'])
        $rtn=$this->m_db->delete('fm_bs_item',$where);
        
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
    		'fm_back_section[bs_time]',
			'fm_back_section[bs_company_out]',
			'fm_back_section[bs_sum]',
    		'fm_back_section[bs_contact_manager]',
    		'sys_contact[c_login_id]',
    		'fm_back_section[bs_org_owner]',
    		'fm_back_section[bs_note]',
		);

		$conf['field_required']=array(
			'fm_back_section[bs_time]',
			'fm_back_section[bs_company_out]',
			'fm_back_section[bs_sum]',
    		'fm_back_section[bs_contact_manager]',
			'sys_contact[c_login_id]',
    		'fm_back_section[bs_org_owner]',
		);

		$conf['field_define']=array(
    	);

    	$this->arr_table_form['sys_contact']['fields']['c_login_id']['comment']='统计人账号';
		$conf['table_form']=array(
			'fm_back_section'=>$this->table_form,
			'sys_contact'=>$this->arr_table_form['sys_contact']
		);
    	
    	$path=str_replace('\\', '/', APPPATH).'models/'.$this->proc_id.'/'.$this->model_name.'.xlsx';
    	
    	$this->m_excel->create_import_file($path,$conf);
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
			'content[bs_org_owner]',
			'content[bs_time]',
			'content[bs_sum]',
			'content[bs_company_out]',
			'content[bs_company_out_s]',
			'content[bs_contact_manager]',
			'content[bs_contact_manager_s]',
		);
		
		//编辑数组
		$data_out['field_edit']=array(
			'content[db_time_update]',
			'content[bs_org_owner]',
			'content[bs_time]',
			'content[bs_sum]',
			'content[bs_company_out]',
			'content[bs_company_out_s]',
			'content[bs_contact_manager]',
			'content[bs_contact_manager_s]',
			'content[bs_note]',
		
			'content[bsi]',
		);
		
		//只读数组
		$data_out['field_view']=array(
			'content[bsi_prog]',
			'content[bsi_prog_text]',
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
		$data_out['json_field_define']['bsi_type']=get_html_json_for_arr($GLOBALS['m_bs']['text']['bsi_type']);
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
										case 'bs_org_owner':
											
											if(element('bs_org_owner', $data_db['content']))
											$data_db['content']['bs_org_owner_s'] = $this->m_base->get_field_where('sys_org','o_name', " AND o_id ='{$data_db['content']['bs_org_owner']}'");
											
											$data_out['log']['content['.$k.']']='变更前:'. element('bs_org_owner_s', $data_db['content']);
											$data_db['content'][$k] =$v ;
											
											break;
											
										case 'bsi':
											
											$data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('bsi_id',$v,element($k,$data_db['content']),'m_bs','show_change_bsi');
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
						
						if( ! empty($data_db['content']['bs_contact_manager']) )
						$data_db['content']['bs_contact_manager_s']=$this->m_base->get_c_show_by_cid($data_db['content']['bs_contact_manager']);
						
						if( ! empty($data_db['content']['bs_company_out']) )
						$data_db['content']['bs_company_out_s']=$this->m_base->get_field_where('sys_org','o_name'," AND o_id = '{$data_db['content']['bs_company_out']}'");
					
						//回款关联明细
						$arr_search=array();
						$arr_search['field']='*';
						$arr_search['from']="fm_bs_item";
						$arr_search['where']=' AND bs_id = ? ';
						$arr_search['value'][]=element('bs_id',$data_get);
						$arr_search['sort']=array("bsi_type");
						$arr_search['order']=array('asc');
						
						$rs=$this->m_db->query($arr_search);

						$data_db['content']['bsi'] = array();
						
						$bsi_sum_all = 0;
						
						if(count($rs['content'])>0)
						{
							foreach ($rs['content'] as $v) {
								$bsi_sum_all+=$v['bsi_sum'];
								
								$v['bsi_type_s'] = $GLOBALS['m_bs']['text']['bsi_type'][$v['bsi_type']];
								
								switch ($v['bsi_type'])
								{
									case BSI_TYPE_BILL:
										
										$this->m_table_op->load('fm_bill');
										$arr_bill=  $this->m_table_op->get($v['bsi_link_id']);
										
										$this->m_table_op->load('pm_given_financial_code');
										$arr_gfc =  $this->m_table_op->get($v['bsi_gfc_id']);
										
										$v['bsi_link_id_s'] = '开票编号:'.$arr_bill['bill_code'].'<br>'
															 .'开票金额:'.number_format($arr_bill['bill_sum'],2).'<br>'
															 .'统计时间:'.$arr_bill['bill_time_node_kp'].'<br>'
															 .'财务编号:'.$arr_gfc['gfc_finance_code'].'<br>'
															 .'项目名称:'.$arr_gfc['gfc_name'].'<br>'
															 ;
										$v['bsi_sum_nolink'] = $arr_bill['bill_sum'] - $arr_bill['bill_sum_return'] ;
										break;
									case BSI_TYPE_LOAN:
										
										$this->m_table_op->load('fm_loan');
										$arr_loan=  $this->m_table_op->get($v['bsi_link_id']);
										
										
										$v['bsi_link_id_s'] = '单据编号:'.$arr_loan['loan_code'].'<br>'
															 .'借款金额:'.number_format($arr_loan['loan_sum'],2).'<br>'
															 .'时间:'.$arr_loan['loan_time_node'].'<br>'
															 ;
										if( $arr_loan['loan_gfc_id'] )
										{
											$this->m_table_op->load('pm_given_financial_code');
											$arr_gfc =  $this->m_table_op->get($arr_loan['loan_gfc_id']);
										
											$this->m_table_op->load('pm_given_financial_code');
											$arr_gfc =  $this->m_table_op->get($arr_loan['loan_gfc_id']);
											
											$v['bsi_link_id_s'] .= '财务编号:'.$arr_gfc['gfc_finance_code'].'<br>'
															 .'项目名称:'.$arr_gfc['gfc_name'].'<br>'
															 ;
										}						 
															 
										$v['bsi_sum_nolink'] = $arr_loan['loan_sum'] - $arr_loan['loan_sum_return'] ;
										
										break;
									case BSI_TYPE_BP:
										
										$this->m_table_op->load('pm_bill_plan');
										$arr_bp=  $this->m_table_op->get($v['bsi_link_id']);
										
										$this->m_table_op->load('pm_given_financial_code');
										$arr_gfc =  $this->m_table_op->get($v['bsi_gfc_id']);
										
										$v['bsi_link_id_s'] = '财务编号:'.$arr_gfc['gfc_finance_code'].'<br>'
															 .'项目名称:'.$arr_gfc['gfc_name'].'<br>'
															 .'货款性质:'.$GLOBALS['m_bp']['text']['bp_type'][$arr_bp['bp_type']].'<br>'
															 .'回款金额:'.number_format($arr_bp['bp_sum']).'<br>'
															 .'回款时间:'.$arr_bp['bp_time_back'].'<br>'
															 ;
										$v['bsi_sum_nolink'] = $arr_bp['bp_sum'] - $arr_bp['bp_sum_hk'] ;
										
										break;
								}
								
								$data_db['content']['bsi'][]=$v;
							}
						}
						
						$data_db['content']['bsi'] = json_encode($data_db['content']['bsi']);
						$data_db['content']['bsi_sum'] = $data_db['content']['bs_sum'];
						$data_db['content']['bsi_prog'] = 0;
						$data_db['content']['bsi_prog'] = $bsi_sum_all/$data_db['content']['bs_sum']*100 ;
						$data_db['content']['bsi_prog_text'] = number_format($bsi_sum_all,'2');
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
			case BS_PPO_START:
				$data_out['ppo_btn_next']='提交';
				break;
		}
				
		if( $data_get['act'] == STAT_ACT_EDIT 
		 && element('ppo', $data_db['content']) != BS_PPO_END )
		{
			$data_out['flag_wl'] = TRUE;
		}
		
		$data_out=$this->m_work_list->get_wl_info($data_out,$data_db);
			
		/************权限验证*****************/
		
		//@todo 权限验证
		$acl_list= $this->m_proc_bs->get_acl();
		
		if( ! empty (element('acl_wl_yj', $data_out)) ) 
		$acl_list= $acl_list | $data_out['acl_wl_yj'];
		
		$this->check_acl($data_db,$acl_list);
		
		/************显示配置*****************/
		//@todo 显示配置
		$title_field='-'.element('bs_code',$data_db['content']);
		
		if(element('bs_sum',$data_db['content']))
		$title_field.='-'.element('bs_sum',$data_db['content']);
		
		if(element('bs_company_out_s',$data_db['content']))
		$title_field.='-'.element('bs_company_out_s',$data_db['content']);
		
		switch ($data_get['act']) {
			case STAT_ACT_CREATE:
				$data_out['title']='创建'.$this->title;
				
				$data_out['op_disable'][]='btn_del';
				$data_out['op_disable'][]='btn_log';
				
				$data_out['op_disable'][]='btn_next';
				$data_out['op_disable'][]='btn_pnext';
				
				$data_out['op_disable'][]='btn_wl';
				$data_out['op_disable'][]='btn_im';
				
				//创建默认值
				$data_db['content']['ppo'] = BS_PPO_START;
				$data_db['content']['bs_time'] = date("Y-m-d");
				$data_db['content']['bs_contact_manager'] = $this->sess->userdata('c_id');
				$data_db['content']['bs_contact_manager_s'] = $this->sess->userdata('c_show');
				
				$data_db['content']['bs_org_owner'] = $this->sess->userdata('c_org');
				
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
				
				$data_out['field_view'][]='content[bs_org_owner]';
				
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
		
		if( element( 'ppo',$data_db['content']) == BS_PPO_START )
		{
			$data_out['op_disable'][]='btn_pnext';
			$data_out['op_disable'][]='title_bsi';
		}
		
		if( element( 'ppo',$data_db['content']) != BS_PPO_START )
		{
			$data_out['op_disable'][]='btn_del';
		}
		
		if( element( 'ppo',$data_db['content']) == BS_PPO_LINK)
		{
			$data_out['field_view'] = array_unique(array_merge($data_out['field_view'],array(
				'content[bs_org_owner]',
				'content[bs_time]',
				'content[bs_sum]',
				'content[bs_company_out]',
				'content[bs_company_out_s]',
				'content[bs_contact_manager]',
				'content[bs_contact_manager_s]',
			)));
				
			$data_out['op_disable'][]='btn_save';
			
			$data_out['wl_info']='由 项目负责人 回款关联';
		}
		
		if( $data_get['act'] == STAT_ACT_EDIT
		&& element( 'ppo',$data_db['content']) == 0  )
		{
			if( ($acl_list & pow(2,ACL_PROC_BS_SUPER) ) == 0)
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
		elseif( element( 'ppo',$data_db['content']) == BS_PPO_END )
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
					
					if( element('ppo', $data_db['content']) == BS_PPO_LINK 
					 && $btn == 'next')
					{
						$bsi_sum_all = 0;
						
					 	if( ! empty(element('bsi',$data_post['content'])) )
						{
							$arr_tmp = element('bsi',$data_post['content']);
										
							if( ! is_array($arr_tmp) )
							$arr_tmp = json_decode($arr_tmp,TRUE);
							
							if( count($arr_tmp) > 0)
							{
								$arr_bp = array();
								$arr_bp_sum = array();
								
								$arr_bill = array();
								$arr_bill_sum = array();
								$arr_bill_wei = array();
								
								$arr_loan = array();
								$arr_loan_sum = array();
								$arr_loan_wei = array();
								
								foreach ($arr_tmp as $v) {
									
									switch ($v['bsi_type']) {
										case BSI_TYPE_LOAN:
											
											if( ! element($v['bsi_link_id'], $arr_loan) )
											$arr_loan[$v['bsi_link_id']] = 0;
											
											$arr_loan[$v['bsi_link_id']] += $v['bsi_sum'];
											
											if( ! element($v['bsi_link_id'], $arr_loan_sum) )
											$arr_loan_sum[$v['bsi_link_id']] = $this->m_base->get_field_where('fm_loan','loan_sum - loan_sum_return'," AND loan_id = '{$v['bsi_link_id']}'");
										
											if( bccomp($arr_loan[$v['bsi_link_id']],$arr_loan_sum[$v['bsi_link_id']],2) > 0 )
				 							{
												$rtn['err']['content[bsi]'][] = array(
												'id' => $v['bsi_id'],
												'field' => 'bsi_sum',
												'act' => STAT_ACT_EDIT,
												'err_msg'=>'本次单据中非开票关联金额超出可关联金额【'.$arr_loan_sum[$v['bsi_link_id']].'】！'
												);
												$check_data=FALSE;
												
												break 2 ;
											}
											break;
											
										case BSI_TYPE_BILL:
											$v['bp_id'] = $this->m_base->get_field_where('fm_bill','bp_id'," AND bill_id = '{$v['bsi_link_id']}'");
											
											if( ! element($v['bsi_link_id'], $arr_bill) )
											$arr_bill[$v['bsi_link_id']] = 0;
											
											$arr_bill[$v['bsi_link_id']] += $v['bsi_sum'];
											
											if( ! element($v['bsi_link_id'], $arr_bill_sum) )
											$arr_bill_sum[$v['bsi_link_id']] = $this->m_base->get_field_where('fm_bill','bill_sum - bill_sum_return'," AND bill_id = '{$v['bsi_link_id']}'");
											
											if( bccomp($arr_bill[$v['bsi_link_id']],$arr_bill_sum[$v['bsi_link_id']],2) > 0 )
				 							{
				 								
												$rtn['err']['content[bsi]'][] = array(
												'id' => $v['bsi_id'],
												'field' => 'bsi_sum',
												'act' => STAT_ACT_EDIT,
												'err_msg'=>'本次单据中开票关联金额超出可关联金额【'.$arr_bill_sum[$v['bsi_link_id']].'】！'
												);
												$check_data=FALSE;
												
												break 2 ;
											}
											
										case BSI_TYPE_BP:
											
											if( ! element('bp_id', $v) )
											{
												$v['bp_id'] = $v['bsi_link_id'];
											}
											
											if( ! element($v['bp_id'], $arr_bp) )
											$arr_bp[$v['bp_id']] = 0;
											
											$arr_bp[$v['bp_id']] += $v['bsi_sum'];
											
											if( ! element($v['bp_id'], $arr_bp_sum) )
											{
												$arr_bp_sum[$v['bp_id']] = $this->m_base->get_field_where('pm_bill_plan','bp_sum - bp_sum_hk'," AND bp_id = '{$v['bp_id']}'");

												$bp_sum_kp_wei = $arr_bp_sum[$v['bp_id']] ;
												
												if($v['bsi_type'] == BSI_TYPE_BP)
												$bp_sum_kp_wei = $this->m_base->get_field_where('pm_bill_plan','bp_sum - bp_sum_kp'," AND bp_id = '{$v['bp_id']}'");
												
												if($bp_sum_kp_wei < $arr_bp_sum[$v['bp_id']]) 
												{
													$arr_bp_sum[$v['bp_id']] = $bp_sum_kp_wei;
													$arr_bill_wei[$v['bp_id']] = $bp_sum_kp_wei;
												}
											}
											
											if( bccomp($arr_bp[$v['bp_id']],$arr_bp_sum[$v['bp_id']],2) > 0 )
				 							{
				 								$err_msg = '本次单据中回款计划关联金额超出可关联金额！';
				 								
				 								if(element($v['bp_id'], $arr_bill_wei))
				 								$err_msg = '回款计划关联金额超出未开票金额'.$arr_bill_wei[$v['bp_id']].'！';
				 								
												$rtn['err']['content[bsi]'][] = array(
												'id' => $v['bsi_id'],
												'field' => 'bsi_sum',
												'act' => STAT_ACT_EDIT,
												'err_msg'=> $err_msg
												);
												$check_data=FALSE;
												
												break 2 ;
											}
											
											break;
									}
									
									$bsi_sum_all += $v['bsi_sum'];
								}
							}
						}
						
						if( $check_data && bccomp($bsi_sum_all , element('bs_sum', $data_post['content']),2) != 0)
						{
							$rtn['err']['content[bsi]']='与回款金额【'.element('bs_sum', $data_post['content']).'】不匹配！';
							$check_data=FALSE;
						}
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
						
						$data_save['content']['bs_code']=$this->get_code($data_save);
						$data_save['content']['ppo']=BS_PPO_START;
						
						$rtn=$this->add($data_save['content']);
						
						//回款关联明细
						if( ! empty(element('bsi',$data_save['content']) ) )
						{
							$arr_save=array(
								'bs_id' => $rtn['id']
							);

							$this->m_base->save_datatable('fm_bs_item',
								$data_save['content']['bsi'],
								'[]',
								$arr_save);
						}
						
						//创建我的工单
	    				$data_save['wl']['wl_id'] = $rtn['id'];
	    				$data_save['wl']['wl_type'] = WL_TYPE_I;
	    				$data_save['wl']['wl_code']=$data_save['content']['bs_code'];
		    			$data_save['wl']['wl_op_table']='fm_back_section';
		    			$data_save['wl']['wl_op_field']='bs_id';
		    			$data_save['wl']['op_id']=$rtn['id'];
	    				$data_save['wl']['p_id']=$this->proc_id;
	    				$data_save['wl']['pp_id']=$this->model_name;
	    				$data_save['wl']['wl_proc']=$data_save['content']['ppo'];
		    			$data_save['wl']['wl_url']=$this->url_conf.'/act/2';
		    			$data_save['wl']['wl_note']='【'.$this->title.'】'
		    				.','.$data_save['content']['bs_sum']
		    				.','.$data_save['content']['bs_time']
            				.','.$this->m_base->get_field_where('sys_org','o_name'," AND o_id = '{$data_save['content']['bs_company_out']}'")
		    				;
	    				$data_save['wl']['c_accept'][] = $this->sess->userdata('c_id');
	    				$data_save['wl']['c_accept'][] = $data_save['content']['bs_contact_manager'];
	    				
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
						$data_save['wl']['wl_code']=$data_db['content']['bs_code'];
		    			$data_save['wl']['wl_op_table']='fm_back_section';
		    			$data_save['wl']['wl_op_field']='bs_id';
		    			$data_save['wl']['op_id']=$data_save['content'][$this->pk_id];
	    				$data_save['wl']['p_id']=$this->proc_id;
	    				$data_save['wl']['pp_id']=$this->model_name;
		    			$data_save['wl']['wl_url']=$this->url_conf.'/act/2';
		    			$data_save['wl']['wl_proc']=$data_save['content']['ppo'];
		    			$data_save['wl']['wl_time_end']=date('Y-m-d H:i:s',strtotime('+30 day'));
		    			$data_save['wl']['c_accept'] = array();
		    			$data_save['wl']['wl_note']='【'.$this->title.'】'
		    				.','.$data_save['content']['bs_sum']
		    				.','.$data_save['content']['bs_time']
    	    				.','.$this->m_base->get_field_where('sys_org','o_name'," AND o_id = '{$data_save['content']['bs_company_out']}'")
		    				;
						
						//工单流转
						switch (element('ppo',$data_db['content']))
						{
							case BS_PPO_START:
								
								if($btn == 'next')
								{
	    							$data_save['content']['ppo'] = BS_PPO_LINK;
										
									$data_save['wl']['wl_event']='回款关联';
									
									//添加流程接收人
	    							$c_accept=array();
	    							
	    							$c_accept = $this->m_base->get_field_where('pm_given_financial_code','gfc_c'
	    							," AND gfc_org = '{$data_save['content']['bs_org_owner']}' AND (gfc_finance_code IS NOT NULL and gfc_finance_code != '') AND gfc_sum_hk != gfc_sum"
	    							,array()
	    							,TRUE);
	    							
	    							$data_save['wl']['c_accept']=$c_accept;
	    							
								}
								
								break;
							case BS_PPO_LINK:
								
								if($btn == 'next')
								{
									$data_save['content']['ppo'] = BS_PPO_END;
								}
								elseif($btn == 'pnext')
								{
									$data_save['content']['ppo'] = BS_PPO_START;
									
									$data_save['wl']['wl_event']='修改单据';
									$data_save['wl']['c_accept'][] = $data_db['content']['db_person_create'];
									$data_save['wl']['c_accept'][] = $data_db['content']['bs_contact_manager'];
								}
								
								break;
						}
						
						//回款关联明细
						if( $btn != 'pnext'
						 && ! empty(element('bsi',$data_save['content']) ) )
						{
							$arr_save=array(
								'bs_id' => element('bs_id',$data_get),
								'ppo' => $data_save['content']['ppo']
							);

							$this->m_base->save_datatable('fm_bs_item',
								$data_save['content']['bsi'],
								$data_db['content']['bsi'],
								$arr_save,
								'm_bs',
								'save_bsi');
						}
						
						$rtn=$this->update($data_save['content']);
						
						//工单日志
						if( $btn == 'yj' )
						{
							$data_save['content_log']['log_note']=
						'【'.$this->sess->userdata('c_name').'['.$this->sess->userdata('a_login_id').']】'
						.'于节点【'.$GLOBALS['m_bs']['text']['ppo'][$data_db['content']['ppo']].'】'
						.',将【'.$this->title.'】移交于【'.$data_post['content']['person_yj_s'].'】';
						
							$data_save['wl']['wl_type']=WL_TYPE_YJ;
							$data_save['wl']['wl_event']=element('wl_list_to_do', $data_out);
							$data_save['wl']['c_accept'][]=$data_post['content']['person_yj'];
							
						}
						elseif( $btn == 'next' || $btn == 'pnext' )
						{
							$data_save['content_log']['log_note']=
						'于节点【'.$GLOBALS['m_bs']['text']['ppo'][$data_db['content']['ppo']].'】'.$ppo_btn_text
						.',流转至节点【'.$GLOBALS['m_bs']['text']['ppo'][$data_save['content']['ppo']].'】';
						
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
								$this->m_work_list->update_wl_have_do(element($this->pk_id,$data_get),$this->model_name,$data_save['wl_have_do']);
								
								//更新我的工单
								$data_save['wl_i'] = array();
								$data_save['wl_i']['wl_log_note']=$data_save['content_log']['log_note'];
								
								if($data_save['content']['ppo'] == BS_PPO_END)
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
								
								if($data_save['content']['ppo'] != BS_PPO_END)
								$this->m_work_list->add($data_save['wl']);
								
								//获取工单关注人与所有人
								$arr_wl_person = $this->m_work_list->get_wl_care_accept(element($this->pk_id,$data_get),$this->model_name);
								
								$rtn['wl_end'] = array();
								$rtn['wl_accept'] = $data_save['wl']['c_accept'];
								$rtn['wl_accept'][] = $this->sess->userdata('c_id');
								
								if( count( element('arr_wl_accept', $data_out)) > 0 )
								$rtn['wl_accept'] = array_values(array_merge($rtn['wl_accept'],$data_out['arr_wl_accept']));
								
								$rtn['wl_accept'] = array_values(array_unique($rtn['wl_accept']));
								
								$rtn['wl_care'] = $arr_wl_person['care'];
								$rtn['wl_i'] = array_values($arr_wl_person['accept']);
								$rtn['wl_op_id'] = element($this->pk_id,$data_get);
								$rtn['wl_pp_id'] = $this->model_name;
								
								if($data_save['content']['ppo'] == BS_PPO_END)
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
	    $data_out['code']=element('bs_code', $data_db['content']);
	    
	    $data_out['ppo']=element('ppo', $data_db['content']);
	    $data_out['ppo_name']=$GLOBALS['m_bs']['text']['ppo'][element('ppo', $data_db['content'])];
	    
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
	 * 回款明细
	 * @param unknown_type $data_save
	 */
	function save_bsi($arr_save)
	{
		switch ($arr_save['bsi_type'])
		{
			case BSI_TYPE_BILL:
				$arr_save['bsi_gfc_id'] = $this->m_base->get_field_where('fm_bill','gfc_id',"AND bill_id = '{$arr_save['bsi_link_id']}'");
				break;
			case BSI_TYPE_BP:
				$arr_save['bsi_gfc_id'] = $this->m_base->get_field_where('pm_bill_plan','gfc_id',"AND bp_id = '{$arr_save['bsi_link_id']}'");
				break;
			case BSI_TYPE_LOAN:
				$arr_save['bsi_gfc_id'] = $this->m_base->get_field_where('fm_loan','loan_gfc_id',"AND loan_id = '{$arr_save['bsi_link_id']}'");
				break;
		}
		
		return $arr_save;
	}
	
	/**
	 * 
	 * 显示回款明细变更
	 * @param $arr bsi数据数组
	 */
	public function show_change_bsi($id,$field,$v)
	{
		$rtn=array();
		$rtn['id'] = $id;
		$rtn['field'] = $field;
		$rtn['act'] = STAT_ACT_EDIT;
		$rtn['err_msg']= $v[$field];
		
		switch ($field)
		{
			case 'bsi_type':

				$rtn['err_msg'] = $GLOBALS['m_bs']['text']['bsi_type'][$v[$field]];

				break;
				
			case 'bsi_link_id':

				switch ($v['bsi_type'])
				{
					case BSI_TYPE_BILL:
						
						$this->m_table_op->load('fm_bill');
						$arr_bill=  $this->m_table_op->get($v['bsi_link_id']);
						
						$this->m_table_op->load('pm_given_financial_code');
						$arr_gfc =  $this->m_table_op->get($arr_bill['gfc_id']);
						
						$v['bsi_link_id_s'] = '开票编号:'.$arr_bill['bill_code'].'<br>'
											 .'开票金额:'.number_format($arr_bill['bill_sum'],2).'<br>'
											 .'统计时间:'.$arr_bill['bill_time_node_kp'].'<br>'
											 .'财务编号:'.$arr_gfc['gfc_finance_code'].'<br>'
											 .'项目名称:'.$arr_gfc['gfc_name'].'<br>'
											 ;
						$v['bsi_sum_nolink'] = $arr_bill['bill_sum'] - $arr_bill['bill_sum_return'] ;
						break;
					case BSI_TYPE_LOAN:
						
						$this->m_table_op->load('fm_loan');
						$arr_loan=  $this->m_table_op->get($v['bsi_link_id']);
						
						$v['bsi_link_id_s'] = '单据编号:'.$arr_loan['loan_code'].'<br>'
											 .'借款金额:'.number_format($arr_loan['loan_sum'],2).'<br>'
											 .'时间:'.$arr_loan['loan_time_node'].'<br>'
											 ;
				
						if( $arr_loan['loan_gfc_id'] )
						{
							$this->m_table_op->load('pm_given_financial_code');
							$arr_gfc =  $this->m_table_op->get($arr_loan['loan_gfc_id']);
							
							$v['bsi_link_id_s'] .= '财务编号:'.$arr_gfc['gfc_finance_code'].'<br>'
											 .'项目名称:'.$arr_gfc['gfc_name'].'<br>'
											 ;
						}					 
											 
						$v['bsi_sum_nolink'] = $arr_loan['loan_sum'] - $arr_loan['loan_sum_return'] ;
						
						break;
					case BSI_TYPE_BP:
						
						$this->m_table_op->load('pm_bill_plan');
						$arr_bp=  $this->m_table_op->get($v['bsi_link_id']);
						
						$this->m_table_op->load('pm_given_financial_code');
						$arr_gfc =  $this->m_table_op->get($arr_bp['gfc_id']);
						
						$v['bsi_link_id_s'] = '财务编号:'.$arr_gfc['gfc_finance_code'].'<br>'
											 .'项目名称:'.$arr_gfc['gfc_name'].'<br>'
											 .'货款性质:'.$GLOBALS['m_bp']['text']['bp_type'][$arr_bp['bp_type']].'<br>'
											 .'回款金额:'.number_format($arr_bp['bp_sum']).'<br>'
											 .'回款时间:'.$arr_bp['bp_time_back'].'<br>'
											 ;
						$v['bsi_sum_nolink'] = $arr_bp['bp_sum'] - $arr_bp['bp_sum_hk'] ;
						
						break;
				}
								
				$rtn['err_msg'] = $v['bsi_link_id_s'];

				break;
		}
		
		$rtn['err_msg']='变更前:'.$rtn['err_msg'];
		
		return $rtn;
	}
}