<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 *  
    开票
 */
class M_bill extends CI_Model {
	
	//@todo 主表配置
	private $table_name='fm_bill';
	private $pk_id='bill_id';
	private $table_form;
	private $title='开票';
	private $model_name = 'm_bill';
	private $url_conf = 'proc_bill/bill/edit';
	private $proc_id = 'proc_bill';
	
 	public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->m_define();
        
         //读取表结构
        $this->config->load('db_table/'.$this->table_name, FALSE,TRUE);
        $this->table_form=$this->config->item($this->table_name);
        
        $this->load->model('proc_gfc/m_bp');
        $this->load->model('proc_gfc/m_gfc');
    }
    
	/**
     * 
     * 定义
     */
	public function m_define()
    {
    	//@todo 定义
    	if( defined('LOAD_M_BILL') ) return;
    	define('LOAD_M_BILL', 1);
    	
    	//define
    	
    	// 节点
    	define('BILL_PPO_END', 0); // 流程结束
		define('BILL_PPO_START', 1); // 起始
		define('BILL_PPO_SH', 2); // 审核
		define('BILL_PPO_BILL', 3); // 开票
    	
    	$GLOBALS['m_bill']['text']['ppo']=array(
    		BILL_PPO_START=>'起始',
    		BILL_PPO_SH=>'审核',
    		BILL_PPO_BILL=>'开票',
    		BILL_PPO_END=>'流程结束',
    	);
    	
    	//发票送达方式
    	define('BILL_SEND_TYPE_SP', 1); // 
		define('BILL_SEND_TYPE_KD', 2); //
		
    	$GLOBALS['m_bill']['text']['bill_send_type']=array(
    		BILL_SEND_TYPE_SP=>'送票',
    		BILL_SEND_TYPE_KD=>'快递',
    	);
    	
    	//发票类型
		define('BILL_CATEGORY_FWS', '1');// 服务业统一发票
		define('BILL_CATEGORY_JZS', '2');// 建筑营业税建筑安装行业统一发票
		define('BILL_CATEGORY_ZZP', '3');// 17%增值税普通发票
		define('BILL_CATEGORY_ZZZ', '4');// 17%增值税专用发票
		define('BILL_CATEGORY_ZZP_11', '5');// 11%增值税普通发票
		define('BILL_CATEGORY_ZZZ_11', '6');// 11%增值税专用发票
		define('BILL_CATEGORY_ZZP_6', '7');// 6%增值税普通发票
		define('BILL_CATEGORY_ZZZ_6', '8');// 6%增值税专用发票
		define('BILL_CATEGORY_SYLS', '9');// 商业零售统一发票
		define('BILL_CATEGORY_SJ',  '10');// 收据
		define('BILL_CATEGORY_JS',  '11');// 技术开发
		define('BILL_CATEGORY_YF',  '12');// 研发
		define('BILL_CATEGORY_ZZP_3', '13');// 3%增值税普通发票
		define('BILL_CATEGORY_ZZZ_3', '14');// 3%增值税专用发票
		define('BILL_CATEGORY_TYJD', '15');// 通用机打发票
		
    	$GLOBALS['m_bill']['text']['bill_category']=array(
    		BILL_CATEGORY_FWS => '服务业统一发票',
			BILL_CATEGORY_JZS => '建筑营业税建筑安装行业统一发票',
			BILL_CATEGORY_ZZP => '17%增值税普通发票',
			BILL_CATEGORY_ZZZ => '17%增值税专用发票',
			BILL_CATEGORY_ZZP_11 => '11%增值税普通发票',
			BILL_CATEGORY_ZZZ_11 => '11%增值税专用发票',
			BILL_CATEGORY_ZZP_6 => '6%增值税普通发票',
			BILL_CATEGORY_ZZZ_6 => '6%增值税专用发票',
			BILL_CATEGORY_ZZP_3 => '3%增值税普通发票',
			BILL_CATEGORY_ZZZ_3 => '3%增值税专用发票',
			BILL_CATEGORY_SJ => '收据',
			BILL_CATEGORY_JS => '技术开发',
			BILL_CATEGORY_YF=> '研发',
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
    	$acl_list= $this->m_proc_bill->get_acl();
    	
    	$msg='';
    	/************权限验证*****************/
    	
    	//如果有超级权限，TRUE
    	if( ($acl_list & pow(2,ACL_PROC_BILL_SUPER)) != 0 )
    	{
    		return TRUE;
    	}
    	
    	$check_acl=FALSE;
    	
    	if( ! $check_acl
         && ($acl_list & pow(2,ACL_PROC_BILL_USER)) != 0
        )
        {
            $check_acl=TRUE;
        }
	    
	    if( ! $check_acl )
	    {
			if( ! $msg )
			$msg = '您没有【开票管理】的【操作】权限不可进行操作！' ;
			
			redirect('base/main/show_err/msg/'.fun_urlencode($msg));
	    }
    }
    
	/**
     * 
     */
	public function get_code($data_save=array())
    {
    	$where='';
    	 
    	$pre = $this->m_base->get_field_where('sys_ou','ou_org_pre'," AND ou_id ='{$data_save['content']['bill_org_owner']}'");
    	
    	$pre .='-KP'.date("Ym");
    	$where .= " AND bill_code LIKE  '{$pre}%'";
    	
    	$max_code=$this->m_db->get_m_value('fm_bill','bill_code',$where);
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
        
        if($rtn['rtn'])
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
    	$arr_link=array(
    		'fm_bs_item.bsi_link_id'
    	);
		
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
        
        if($rtn['rtn'])
        $rtn=$this->m_db->delete('fm_bill_eqi',$where);
        
        if($rtn['rtn'])
        $rtn=$this->m_db->delete('fm_bill_detail_item',$where);
        
    	if( ! $rtn['rtn'] )
	    {
		    $this->db->trans_rollback();
		}
		else
		{
		    $this->db->trans_commit();
		    
       	 	$this->update_ltable($data_db['content']);
        
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
	 * 更新关联单据
	 * @param $content
	 */
	public function update_ltable($content)
    {
    	$data_save['content'] = $content;
    	
    	if( ! element('bp_id', $data_save['content']))
        $data_save['content']['bp_id'] = $this->m_base->get_field_where('fm_bill','bp_id',
        								" AND bill_id = '{$data_save['content'][$this->pk_id]}' ");
        
        $data_save['content_bp']=array();
        $data_save['content_bp']['bp_id'] = $data_save['content']['bp_id'];
        $data_save['content_bp']['bp_sum_kp'] = $this->m_base->get_field_where('fm_bill','sum(bill_sum)',
        										" AND bp_id = '{$data_save['content']['bp_id']}' 
        										  AND (ppo = 0 OR ppo > 1 )");
        $this->m_bp->update($data_save['content_bp']);
        
        if( ! element('gfc_id', $data_save['content']))
        $data_save['content']['gfc_id'] = $this->m_base->get_field_where('fm_bill','gfc_id',
        								" AND bill_id = '{$data_save['content'][$this->pk_id]}' ");
        
        $data_save['content_gfc']=array();
        $data_save['content_gfc']['gfc_id'] = $data_save['content']['gfc_id'];
        $data_save['content_gfc']['gfc_sum_kp'] = $this->m_base->get_field_where('fm_bill','sum(bill_sum)',
        										" AND gfc_id = '{$data_save['content']['gfc_id']}' 
        										  AND (ppo = 0 OR ppo > 1 )");
        
        $this->m_gfc->update($data_save['content_gfc']);
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
			'content[bill_org_owner]',
		
			'content[bill_sum]',
			'content[bill_tax_sum_s]',
			'content[bill_takings_s]',
			'content[bill_tax_sum]',
			'content[bill_tax]',
			'content[bill_takings]',
			'content[bill_org_customer]',
			'content[bill_org_customer_s]',
			'content[bill_send_type]',
			'content[bill_category]',
			'content[bill_time_node_kp]',
			'content[bill_time_return]',
		
			'content[gfc_name]',
			'content[gfc_id]',
			'content[bp_id]',
		);
		
		//编辑数组
		$data_out['field_edit']=array(
			'content[db_time_update]',
		
			'content[bill_org_owner]',
			'content[bill_sum]',
			'content[bill_tax_sum_s]',
			'content[bill_takings_s]',
			'content[bill_tax_sum]',
			'content[bill_tax]',
			'content[bill_tax_s]',
			'content[bill_takings]',
			'content[bill_org_customer]',
			'content[bill_org_customer_s]',
			'content[bill_contact_manager]',
			'content[bill_contact_manager_s]',
			'content[bill_send_type]',
			'content[bill_category]',
			'content[bill_time_node_kp]',
			'content[bill_time_return]',
			'content[bp_note]',
		
			'content[gfc_name]',
			'content[gfc_id]',
			'content[bp_id]',
		
			'content[bsi]',
		
			'content[bei]',
		
			'content[bdi]',
		);
		
		//只读数组
		$data_out['field_view']=array(
			'content[gfc_finance_code]',
			'content[gfc_org_s]',
			'content[gfc_org_jia_s]',
			'content[gfc_sum]',
			'content[gfc_c_s]',
		
			'content[bill_tax_sum_s]',
			'content[bill_takings_s]',
			'content[bill_ending_sum]',
//			'content[bill_contact_manager]',
//			'content[bill_contact_manager_s]',
		
			'content[gfc_bp_prog]]',
			'content[gfc_bp_prog_text]',
		
			'content[bei_prog]',
			'content[bei_prog_text]',
		
			'content[bdi_prog]',
			'content[bdi_prog_text]',
		);
		
		$data_out['op_disable']=array(
		);
		
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
		$data_out['json_field_define']['bill_send_type']=get_html_json_for_arr($GLOBALS['m_bill']['text']['bill_send_type']);
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
										case 'bill_org_owner':
											
											if(element('bill_org_owner', $data_db['content']))
											$data_db['content']['bill_org_owner'] = $this->m_base->get_field_where('sys_org','o_name', " AND o_id ='{$data_db['content']['bill_org_owner']}'");
											
											$data_out['log']['content['.$k.']']='变更前:'. element('bill_org_owner', $data_db['content']);
											$data_db['content'][$k] =$v ;
											
											break;
											
										case 'bill_category':
											
											if(element('bill_category', $data_db['content']))
											$data_db['content']['bill_category'] = $this->m_base->get_field_where('fm_invoice_type','it_name', " AND it_id ='{$data_db['content']['bill_category']}'");
											
											$data_out['log']['content['.$k.']']='变更前:'. element('bill_category', $data_db['content']);
											$data_db['content'][$k] =$v ;
											
											break;	
											
										case 'bp_id':
											
											if(element('bp_id', $data_db['content']))
											{
												$arr_bp = $this->m_bp->get($data_db['content']['bp_id']);
												
												$data_db['content']['bp_id'] = $arr_bp['bp_time'].','.$GLOBALS['m_bp']['text']['bp_type'][$arr_bp['bp_type']].','.$arr_bp['bp_sum'];
											}
											
											$data_out['log']['content['.$k.']']='变更前:'. element('bp_id', $data_db['content']);
											$data_db['content'][$k] =$v ;
											
											break;	
											
//										case 'bsi':
//											$data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('bsi_id',$v,element($k,$data_db['content']));
//											$data_db['content'][$k] =$v ;
//											
//											break;
											
										case 'bei':	
											$data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('bei_id',$v,element($k,$data_db['content']));
											$data_db['content'][$k] =$v ;
											
											break;
										case 'bdi':
											$data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('bdi_id',$v,element($k,$data_db['content']));
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
						
						$this->m_table_op->load('pm_given_financial_code');
						$data_db['content_gfc'] =  $this->m_table_op->get(element('gfc_id',$data_db['content']));
						
						$this->m_table_op->load('pm_bill_plan');
						$data_db['content_bp'] =  $this->m_table_op->get(element('bp_id',$data_db['content']));
						
						$data_db['content']= array_merge($data_db['content_gfc'],$data_db['content_bp'],$data_db['content']);
						
						$data_db['wl_list']=$this->m_work_list->get_wl_to_do(element($this->pk_id,$data_get),$this->model_name);
						
						$data_db['content']['bill_takings_s'] = $data_db['content']['bill_takings'];
						$data_db['content']['bill_tax_sum_s'] = $data_db['content']['bill_tax_sum'];
						
						if($data_db['content']['ppo'] == 0)
						$data_db['content']['bill_ending_sum'] = $data_db['content']['bill_sum'] - $data_db['content']['bill_sum_return'];
						
						$data_db['content']['bill_tax_s']=$this->m_base->get_field_where('fm_tax_type','t_name'," AND t_id = '{$data_db['content']['bill_tax']}'");
						
						$bp_kp_sum = $data_db['content_bp']['bp_sum_kp'];
						if($data_db['content']['ppo'] == 1 )
						$bp_kp_sum += $data_db['content']['bill_sum'];
						
						$data_db['content']['gfc_bp_prog'] = $bp_kp_sum/$data_db['content']['bp_sum']*100 ;
						$data_db['content']['gfc_bp_prog_text'] = number_format($bp_kp_sum,'2');
						
//						$data_db['content']['bill_category_s'] =$this->m_base->get_field_where('fm_invoice_type','it_name'," AND it_id = '{$data_db['content']['bill_category']}'");
						
						if( ! empty($data_db['content']['gfc_c']) )
						$data_db['content']['gfc_c_s']=$this->m_base->get_c_show_by_cid($data_db['content']['gfc_c']);
						
						if( ! empty($data_db['content']['gfc_org']) )
						$data_db['content']['gfc_org_s']=$this->m_base->get_field_where('sys_org','o_name'," AND o_id = '{$data_db['content']['gfc_org']}'");
						
						if( ! empty($data_db['content']['gfc_org_jia']) )
						$data_db['content']['gfc_org_jia_s']=$this->m_base->get_field_where('sys_org','o_name'," AND o_id = '{$data_db['content']['gfc_org_jia']}'");
					
						if( ! empty($data_db['content']['bill_org_customer']) )
						$data_db['content']['bill_org_customer_s']=$this->m_base->get_field_where('sys_org','o_name'," AND o_id = '{$data_db['content']['bill_org_customer']}'");
						
						if( ! $data_db['content']['bill_contact_manager'])
						$data_db['content']['bill_contact_manager'] = $data_db['content']['gfc_c'];
						
						if( ! empty($data_db['content']['bill_contact_manager']) )
						$data_db['content']['bill_contact_manager_s']=$this->m_base->get_c_show_by_cid($data_db['content']['bill_contact_manager']);
						
						//预收账款
						$arr_search_link=array();
						$arr_search_link['field']='bsi.bsi_sum
												  ,bsi_id
												  ,bs.bs_id
												  ,bs_code
												  ,bs_company_out
												  ,bs_time
												  ,l.note bsi_sum_link
												  ';
						$arr_search_link['from']='fm_bs_item bsi
												  LEFT JOIN fm_back_section bs ON
												  (bs.bs_id = bsi.bs_id)
												  LEFT JOIN sys_link l ON
												  (l.link_id = bsi.bsi_id AND l.content = \'bsi_sum_link\' AND op_id = ?)
												  ';
						$arr_search_link['where']=" AND bsi.bsi_link_id = ? ";
						$arr_search_link['value'][]=element('bill_id',$data_db['content']);
						$arr_search_link['value'][]=element('bp_id',$data_db['content']);
						$rs_link=$this->m_db->query($arr_search_link);
						$data_db['content']['bsi']=array();
						
						if(count($rs_link['content'])>0)
						{
							foreach ( $rs_link['content'] as $v ) {
								$v['bs_company_out_s'] = $this->m_base->get_field_where('sys_org','o_name'," AND o_id = '{$v['bs_company_out']}'");
								$data_db['content']['bsi'][]=$v;
							}
						}
						
						$data_db['content']['bsi']=json_encode($data_db['content']['bsi']);
						
						//获取开票申请明细条目表
						$arr_search=array();
						$arr_search['field']='*';
						$arr_search['from']="fm_bill_eqi";
						$arr_search['where']=' AND bill_id = ? ';
						$arr_search['value'][]=element('bill_id',$data_get);
						$arr_search['sort']=array("db_time_create");
						$arr_search['order']=array('asc');
						
						$rs=$this->m_db->query($arr_search);

						$data_db['content']['bei'] = array();
						
						$bei_sum_all = 0;
						
						if(count($rs['content'])>0)
						{
							foreach ($rs['content'] as $v) {
								$bei_sum_all+=$v['bei_sum'];
								$data_db['content']['bei'][]=$v;
							}
						}
						$data_db['content']['bei'] = json_encode($data_db['content']['bei']);
						$data_db['content']['bei_sum'] = $data_db['content']['bill_sum'];
						$data_db['content']['bei_prog'] = 0;
						if($data_db['content']['gfc_sum'] != 0 && $data_db['content']['bill_sum'] > 0)
						$data_db['content']['bei_prog'] = $bei_sum_all/$data_db['content']['bill_sum']*100 ;
						$data_db['content']['bei_prog_text'] = number_format($bei_sum_all,'2');
						
						//开票批准发票条目表
						$arr_search=array();
						$arr_search['field']='*';
						$arr_search['from']="fm_bill_detail_item";
						$arr_search['where']=' AND bill_id = ? ';
						$arr_search['value'][]=element('bill_id',$data_get);
						$arr_search['sort']=array("bdi_time_kp");
						$arr_search['order']=array('asc');
						
						$rs=$this->m_db->query($arr_search);

						$data_db['content']['bdi'] = array();
						
						$bdi_sum_all = 0;
						
						if(count($rs['content'])>0)
						{
							foreach ($rs['content'] as $v) {
								$bdi_sum_all+=$v['bdi_invoice_sum'];
								$data_db['content']['bdi'][]=$v;
							}
						}
						
						$data_db['content']['bdi'] = json_encode($data_db['content']['bdi']);
						$data_db['content']['bdi_sum'] = $data_db['content']['bill_sum'];
						$data_db['content']['bdi_prog'] = 0;
						if($data_db['content']['gfc_sum'] != 0 && $data_db['content']['bill_sum'] > 0)
						$data_db['content']['bdi_prog'] = $bdi_sum_all/$data_db['content']['bill_sum']*100 ;
						$data_db['content']['bdi_prog_text'] = number_format($bdi_sum_all,'2');
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
			case BILL_PPO_START:
				$data_out['ppo_btn_next']='提交';
				break;
			case BILL_PPO_BILL:
				$data_out['ppo_btn_next']='开票';
				break;
		}
				
		if( $data_get['act'] == STAT_ACT_EDIT 
		 && element('ppo', $data_db['content']) != BILL_PPO_END )
		{
			$data_out['flag_wl'] = TRUE;
		}
		
		$data_out=$this->m_work_list->get_wl_info($data_out,$data_db);
			
		/************权限验证*****************/
		
		//@todo 权限验证
		$acl_list= $this->m_proc_bill->get_acl();
		
		if( ! empty (element('acl_wl_yj', $data_out)) ) 
		$acl_list= $acl_list | $data_out['acl_wl_yj'];
		
		$this->check_acl($data_db,$acl_list);
		
		/************显示配置*****************/
		//@todo 显示配置
		$title_field='-'.element('bill_code',$data_db['content'])
					.'-'.element('bill_sum',$data_db['content'])
					.'-'.element('bill_org_customer_s',$data_db['content'])
					.'-'.element('gfc_finance_code',$data_db['content']);
		
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
				$data_db['content']['ppo'] = BILL_PPO_START;
				$data_db['content']['bill_org_owner'] = $this->sess->userdata('c_org');
				$data_db['content']['bill_time_node_kp'] = date("Y-m-d");
				
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
				
				if( element('gfc_id', $data_db['content']) )
				{
					$this->m_table_op->load('pm_given_financial_code');
					$data_db['content_gfc'] =  $this->m_table_op->get(element('gfc_id',$data_db['content']));
					
					$data_db['content']['bill_tax'] = $data_db['content_gfc']['gfc_tax'];
					$data_db['content']['bill_tax_s']=$this->m_base->get_field_where('fm_tax_type','t_name'," AND t_id = '{$data_db['content']['bill_tax']}'");
				
					$data_db['content']= array_merge($data_db['content_gfc'],$data_db['content']);
				}
				
				if( element('bp_id', $data_db['content']) )
				{
					$this->m_table_op->load('pm_bill_plan');
					$data_db['content_bp'] =  $this->m_table_op->get(element('bp_id',$data_db['content']));
					
					$data_db['content']['gfc_bp_prog'] = 100 ;
					$data_db['content']['gfc_bp_prog_text'] = number_format($data_db['content_bp']['bp_sum'],'2');
					
					$data_db['content']= array_merge($data_db['content_bp'],$data_db['content']);
				}
						
				if( element('bp_sum',$data_db['content'] ))
				$data_db['content']['bill_sum'] = $data_db['content']['bp_sum'] - $data_db['content']['bp_sum_kp'];
				
				if( element('gfc_c',$data_db['content'] ))
				$data_db['content']['gfc_c_s']=$this->m_base->get_c_show_by_cid($data_db['content']['gfc_c']);
						
				if( element('gfc_org',$data_db['content'] ))
				$data_db['content']['gfc_org_s']=$this->m_base->get_field_where('sys_org','o_name'," AND o_id = '{$data_db['content']['gfc_org']}'");
				
				if( element('gfc_org_jia',$data_db['content'] ))
				$data_db['content']['gfc_org_jia_s']=$this->m_base->get_field_where('sys_org','o_name'," AND o_id = '{$data_db['content']['gfc_org_jia']}'");
				
				if( element('gfc_org_jia',$data_db['content'] ))
				$data_db['content']['bill_org_customer']=$data_db['content']['gfc_org_jia'];
				
				if( element('gfc_org_jia_s',$data_db['content'] ))
				$data_db['content']['bill_org_customer_s']=$data_db['content']['gfc_org_jia_s'];
				
				if( element('gfc_c',$data_db['content'] ))
				$data_db['content']['bill_contact_manager'] = $data_db['content']['gfc_c'];
				
				if( element('gfc_c_s',$data_db['content'] ))
				$data_db['content']['bill_contact_manager_s'] = $data_db['content']['gfc_c_s'];
				
			break;
			case STAT_ACT_EDIT:
				$data_out['title']='编辑'.$this->title.$title_field;
				
				$data_out['op_disable'][]='btn_person';
				$data_out['op_disable'][]='btn_import';
				
				$data_out['field_view'][]='content[bill_org_owner]';
				
				
			break;
			case STAT_ACT_VIEW:
				$data_out['title']='查看'.$this->title.$title_field;
				
				$data_out['op_disable'][]='btn_save';
				$data_out['op_disable'][]='btn_del';
				$data_out['op_disable'][]='btn_person';
				$data_out['op_disable'][]='btn_reload';
				$data_out['op_disable'][]='btn_import';
				
				$data_out['op_disable'][]='btn_next';
				$data_out['op_disable'][]='btn_pnext';
				
				$data_out['field_view']=array_unique(array_merge($data_out['field_view'],$data_out['field_edit']));
				
			break;
		}
		
		if( element( 'ppo',$data_db['content']) == BILL_PPO_START )
		{
			$data_out['op_disable'][]='btn_pnext';
		}
		
		if( element( 'ppo',$data_db['content']) != BILL_PPO_START )
		{
			$data_out['op_disable'][]='btn_del';
			
			$data_out['field_view'] = array_unique(array_merge($data_out['field_view'],array(
				'content[bsi]',
			)));
		}
		
		if( element( 'ppo',$data_db['content']) == BILL_PPO_BILL)
		{
			$data_out['field_view'] = array_unique(array_merge($data_out['field_view'],array(
				'content[bill_org_owner]',
				'content[bill_sum]',
				'content[bill_tax_sum_s]',
				'content[bill_takings_s]',
				'content[bill_tax_sum]',
				'content[bill_tax]',
				'content[bill_tax_s]',
				'content[bill_takings]',
				'content[bill_org_customer]',
				'content[bill_org_customer_s]',
				'content[bill_contact_manager]',
				'content[bill_contact_manager_s]',
				'content[bill_send_type]',
				'content[bill_category]',
				'content[bill_time_node_kp]',
				'content[bill_time_return]',
				'content[bp_note]',
			
				'content[gfc_name]',
				'content[gfc_id]',
				'content[bp_id]',
			
				'content[bei]',
			)));
				
//			$data_out['op_disable'][]='btn_pnext';
		}
		
		if( element( 'ppo',$data_db['content']) != 0)
		{
			if(element( 'ppo',$data_db['content']) < BILL_PPO_BILL)
			{
				$data_out['op_disable'][]='title_bdi';
			}
			
			$data_out['op_disable'][]='title_bill_link';
		}
		
		if( $data_get['act'] == STAT_ACT_EDIT
		&& element( 'ppo',$data_db['content']) == 0  )
		{
			if( ($acl_list & pow(2,ACL_PROC_BILL_SUPER) ) == 0)
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
			
			$data_out['op_disable'][] = 'content[gfc_name]';
			
			$data_out['op_disable'][]='btn_log';
			$data_out['op_disable'][]='btn_del';
			
			$data_out['op_disable'][]='btn_wl';
			$data_out['op_disable'][]='btn_im';
			$data_out['op_disable'][]='btn_file';
			
			$data_out['op_disable'][]='btn_next';
			$data_out['op_disable'][]='btn_pnext';
			
			$data_out['title'] = '批量编辑'.$this->title.'-请勾选要保存的字段';
		}
		elseif( element( 'ppo',$data_db['content']) == BILL_PPO_END )
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
					break;
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
					
					//预收账款
					$bsi_sum_all = 0;
					
					if( ! empty(element('bsi',$data_post['content'])) )
					{
						$arr_tmp = element('bsi',$data_post['content']);
						
						if( ! is_array($arr_tmp) )
						$arr_tmp = json_decode($arr_tmp,TRUE);
						
						if( count($arr_tmp) > 0)
						{
							foreach ($arr_tmp as $v) {
								
								$bsi_sum_link =  element('bsi_sum_link', $v,0);
								$bsi_sum_all += $bsi_sum_link;
								
								$bsi_sum = $this->m_base->get_field_where('fm_bs_item','bsi_sum'," AND bsi_id = '".fun_urldecode($v['bsi_id'])."'");
								
								if( $bsi_sum_link > $bsi_sum)
								{
									$err_msg = '本次单据中回款计划关联金额超出可关联金额'.$bsi_sum.'！';
	 								
									$rtn['err']['content[bsi]'][] = array(
									'id' => $v['bsi_id'],
									'field' => 'bsi_sum',
									'act' => STAT_ACT_EDIT,
									'err_msg'=> $err_msg
									);
									$check_data=FALSE;
									
									break;
								}
								
								//验证金额是否存在重复关联
								if( $btn == 'next' 
								 && element('ppo', $data_db['content']) == BILL_PPO_START 
								 && $bsi_sum_link > 0 
								)
								{
									$arr_search=array();
									$arr_search['field']='sum(l.note) sum';
									$arr_search['from']="sys_link l 
													     LEFT JOIN fm_bill bill ON
													     (bill.bill_id = l.op_id)";
									$arr_search['where']=' AND op_id != ? AND link_id = ? AND content = \'bsi_sum_link\' 
														   AND (bill.ppo > 1 OR bill.ppo = 0)  GROUP BY link_id';
									$arr_search['value'][]=element('bill_id',$data_get);
									
									if(strlen($v['bsi_id']) != 32 ) 
									$arr_search['value'][]=fun_urldecode($v['bsi_id']);
									else 
									$arr_search['value'][]=$v['bsi_id'];
									
									$rs=$this->m_db->query($arr_search);
									
									if( count($rs['content'])>0 
									 && $bsi_sum - $rs['content'][0]['sum'] < $bsi_sum_link
									)
									{
										$err_msg = '本次单据中回款计划关联金额超出可关联金额'.($bsi_sum - $rs['content'][0]['sum']).'！';
	 								
										$rtn['err']['content[bsi]'][] = array(
										'id' => $v['bsi_id'],
										'field' => 'bsi_sum',
										'act' => STAT_ACT_EDIT,
										'err_msg'=> $err_msg
										);
										$check_data=FALSE;
									}
								}
							}
						}
						
						if( bccomp($bsi_sum_all,$data_post['content']['bill_sum'],2) > 0 )
					 	{
					 		$rtn['err']['content[bill_sum]']='开票金额小于关联预收账款金额！';
					 		//$rtn['err']['content[bsi]']='开票金额小于关联预收账款金额！';
							$check_data=FALSE;
					 	}
					}
					
					$bill_id = element($this->pk_id, $data_get);
					$bill_sum = $this->m_base->get_field_where('fm_bill','sum(bill_sum)',"AND bp_id = '{$data_post['content']['bp_id']}' AND bill_id != '{$bill_id}' AND ppo != 1");
					$bill_sum +=element('bill_sum', $data_post['content'],0);
					
					if(  element('bp_sum', $data_db['content']) )
					$bill_sum_can = $data_db['content']['bp_sum'];
					else
					$bill_sum_can = $this->m_base->get_field_where('pm_bill_plan','bp_sum',"AND bp_id = '{$data_post['content']['bp_id']}'");
					
					if( bccomp($bill_sum,$bill_sum_can,2) > 0 )
				 	{
				 		$rtn['err']['content[bill_sum]']='开票金额超出开票计划允许金额【'.$bill_sum_can.'】！';
						$check_data=FALSE;
				 	}
				 	
					if( ! empty(element('bp_id', $data_post['content'])))
					{
						if(  element('bp_sum_hk', $data_db['content']) )
						$hk_sum = $data_db['content']['bp_sum_hk'];
						else
						$hk_sum = $this->m_base->get_field_where('pm_bill_plan','bp_sum_hk',"AND bp_id = '{$data_post['content']['bp_id']}'");
						
						if( bccomp(element('bill_sum', $data_post['content'],0) - $bsi_sum_all,$bill_sum_can - $hk_sum ) > 0 )
						{
							$rtn['err']['content[bill_sum]']='开票金额超出开票计划允许金额【'.$bill_sum_can.'】！';
							$rtn['err']['content[bsi]']='请关联预回款!';
							$check_data=FALSE;
						}
					}
					
					if( $btn == 'next' 
					 && element('ppo', $data_db['content']) == BILL_PPO_START )
					{
					 	$bei_sum_all = 0;
					 	
					 	if( ! empty(element('bei',$data_post['content'])) )
						{
							$arr_tmp = element('bei',$data_post['content']);
							
							if( ! is_array($arr_tmp) )
							$arr_tmp = json_decode($arr_tmp,TRUE);
							
							if( count($arr_tmp) > 0)
							{
								foreach ($arr_tmp as $v) {
									$bei_sum_all += $v['bei_sum'];
								}
							}
						}
						
						if( bccomp($bei_sum_all , element('bill_sum', $data_post['content']),2) != 0)
						{
							$rtn['err']['content[bei]']='与开票金额【'.element('bill_sum', $data_post['content']).'】不匹配！';
							$check_data=FALSE;
						}
					}
					
					if( $btn == 'next' 
					 && element('ppo', $data_db['content']) == BILL_PPO_BILL )
					{
						$bdi_sum_all = 0;
						
					 	if( ! empty(element('bdi',$data_post['content'])) )
						{
							$arr_tmp = element('bdi',$data_post['content']);
										
							if( ! is_array($arr_tmp) )
							$arr_tmp = json_decode($arr_tmp,TRUE);
							
							if( count($arr_tmp) > 0)
							{
								foreach ($arr_tmp as $v) {
									$bdi_sum_all += $v['bdi_invoice_sum'];
								}
							}
						}
						
						if( bccomp($bdi_sum_all , element('bill_sum', $data_post['content']),2) != 0)
						{
							$rtn['err']['content[bdi]']='与开票金额【'.element('bill_sum', $data_post['content']).'】不匹配！';
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
				
				if( ! empty(element('bsi',$data_save['content'])) 
				 && ! is_array($data_save['content']['bsi']) )
				{
					$data_save['content']['bsi'] = json_decode($data_save['content']['bsi'],TRUE);
				}
				/************事件处理*****************/
				switch ($data_get['act']) {
					case STAT_ACT_CREATE:
						
						$data_save['content']['bill_code']=$this->get_code($data_save);
						$data_save['content']['ppo']=BILL_PPO_START;
						
						$rtn=$this->add($data_save['content']);
						
						//预收账款
						if( is_array(element('bsi',$data_save['content'])) 
						 && count($data_save['content']['bsi']) > 0)
						{
			        		$this->load->model('proc_bs/m_bs');
			        		$this->m_table_op->load('fm_bs_item');
			        		
							foreach ( $data_save['content']['bsi'] as $v) {
								
								if(strlen($v['bsi_id']) != 32 ) $v['bsi_id'] = fun_urldecode($v['bsi_id']);
								
								if( ! element('bsi_sum_link', $v) ) continue;
								
								$data_save['link']=array();
								$data_save['link']['op_id']=$rtn['id'];
								$data_save['link']['op_table']='fm_bill';
								$data_save['link']['op_field']='bill_id';
								$data_save['link']['content']='bsi_sum_link';
								$data_save['link']['note']=$v['bsi_sum_link'];
								$data_save['link']['link_id']=$v['bsi_id'];
								$data_save['link']['link_table']='fm_bs_item';
								$data_save['link']['link_field']='bsi_id';
								
								$this->m_link->add($data_save['link']);
							}
							
							$data_save['content']['bsi']=json_encode($data_save['content']['bsi']);
						}
						
						//开票申请明细条目表
						if( ! empty(element('bei',$data_save['content']) ) )
						{
							$arr_save=array(
								'bill_id' => $rtn['id']
							);

							$this->m_base->save_datatable('fm_bill_eqi',
								$data_save['content']['bei'],
								'[]',
								$arr_save);
						}
						
						//开票批准发票条目表
						if( ! empty(element('bdi',$data_save['content']) ) )
						{
							$arr_save=array(
								'bill_id' => $rtn['id']
							);

							$this->m_base->save_datatable('fm_bill_detail_item',
								$data_save['content']['bdi'],
								'[]',
								$arr_save);
						}
						
						//创建我的工单
	    				$data_save['wl']['wl_id'] = $rtn['id'];
	    				$data_save['wl']['wl_type'] = WL_TYPE_I;
	    				$data_save['wl']['wl_code']=$data_save['content']['bill_code'];
		    			$data_save['wl']['wl_op_table']='fm_bill';
		    			$data_save['wl']['wl_op_field']='bill_id';
		    			$data_save['wl']['op_id']=$rtn['id'];
	    				$data_save['wl']['p_id']=$this->proc_id;
	    				$data_save['wl']['pp_id']=$this->model_name;
	    				$data_save['wl']['wl_proc']=$data_save['content']['ppo'];
		    			$data_save['wl']['wl_url']=$this->url_conf.'/act/2';
		    			$data_save['wl']['wl_note']='【'.$this->title.'】'
		    				.','.$data_save['content']['bill_sum']
		    				.','.$data_save['content']['bill_time_node_kp']
		    				.','.$this->m_base->get_field_where('sys_org','o_name'," AND o_id = '{$data_save['content']['bill_org_customer']}'")
		    				;
	    				$data_save['wl']['c_accept'][] = $this->sess->userdata('c_id');
	    				$data_save['wl']['c_accept'][] = $data_save['content']['bill_contact_manager'];
	    				
	    				$this->m_work_list->add($data_save['wl']);
	    				
	    				$data_save['wl']['wl_id']=get_guid();
	    				$data_save['wl']['wl_type'] = 0 ;
	    				$data_save['wl']['wl_event']='补全、提交单据';
	    				$data_save['wl']['wl_proc'] = 1;
	    				$this->m_work_list->add($data_save['wl']);
	    				
	    				$rtn['wl_i'][] = $this->sess->userdata('c_id');
	    				$rtn['wl_accept'][] = $this->sess->userdata('c_id');
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
						$data_save['wl']['wl_code']=$data_db['content']['bill_code'];
		    			$data_save['wl']['wl_op_table']='fm_bill';
		    			$data_save['wl']['wl_op_field']='bill_id';
		    			$data_save['wl']['op_id']=$data_save['content'][$this->pk_id];
	    				$data_save['wl']['p_id']=$this->proc_id;
	    				$data_save['wl']['pp_id']=$this->model_name;
		    			$data_save['wl']['wl_url']=$this->url_conf.'/act/2';
		    			$data_save['wl']['wl_proc']=$data_save['content']['ppo'];
		    			$data_save['wl']['wl_time_end']=date('Y-m-d H:i:s',strtotime('+30 day'));
		    			$data_save['wl']['c_accept'] = array();
		    			$data_save['wl']['wl_note']='【'.$this->title.'】'
		    				.','.$data_save['content']['bill_sum']
		    				.','.$data_save['content']['bill_time_node_kp']
    	    				.','.$this->m_base->get_field_where('sys_org','o_name'," AND o_id = '{$data_save['content']['bill_org_customer']}'")
		    				;
						
						//工单流转
						switch (element('ppo',$data_db['content']))
						{
							case BILL_PPO_START:
								
								if($btn == 'next')
								{
	    							$data_save['content']['ppo'] = BILL_PPO_SH;
										
									$data_save['wl']['wl_event']='审核单据';
									
									//添加流程接收人
	    							$c_accept=$this->m_acl->get_acl_person($this->proc_id,ACL_PROC_BILL_CHECK);
	    							
									if( count($c_accept) > 0)
	    							{
		    							$arr_v=array();
		    							$arr_v[]=$data_save['content']['gfc_org'];
		    							$arr_v[]=$c_accept;
		    							$c_accept=$this->m_base->get_field_where('sys_contact','c_id'
		    							,"AND c_org = ? AND c_id IN ? ",$arr_v,1);
	    							}
	    							
	    							$data_save['wl']['c_accept']=$c_accept;
	    							
								}
								
								break;
							case BILL_PPO_SH:
								
								if($btn == 'next')
								{
									$data_save['content']['ppo'] = BILL_PPO_BILL;
									
									$data_save['wl']['wl_event']='审核单据';
									
									//添加流程接收人
	    							$c_accept=$this->m_acl->get_acl_person($this->proc_id,ACL_PROC_BILL_BILL);
	    							
									if( count($c_accept) > 0)
	    							{
		    							$arr_v=array();
		    							$arr_v[]=$data_save['content']['gfc_org'];
		    							$arr_v[]=$c_accept;
		    							$c_accept=$this->m_base->get_field_where('sys_contact','c_id'
		    							,"AND c_org = ? AND c_id IN ? ",$arr_v,1);
	    							}
	    							
	    							$data_save['wl']['c_accept']=$c_accept;
								}
								elseif($btn == 'pnext')
								{
									$data_save['content']['ppo'] = BILL_PPO_START;
									
									$data_save['wl']['wl_event']='修改单据';
									$data_save['wl']['c_accept'][] = $data_db['content']['db_person_create'];
									$data_save['wl']['c_accept'][] = $data_save['content']['bill_contact_manager'];
								}
								
								break;
							case BILL_PPO_BILL:
								
								if($btn == 'next')
								{
									$data_save['content']['ppo'] = BILL_PPO_END;
									
									if(isset($bsi_sum_all))
									$data_save['content']['bill_sum_return'] = $bsi_sum_all;
								}
								elseif($btn == 'pnext')
								{
									$data_save['content']['ppo'] = BILL_PPO_START;
									
									$data_save['wl']['wl_event']='修改单据';
									$data_save['wl']['c_accept'][] = $data_db['content']['db_person_create'];
									$data_save['wl']['c_accept'][] = $data_save['content']['bill_contact_manager'];
								}
								
								break;
						}
						
						$rtn=$this->update($data_save['content']);
						
						//预收账款
						if( is_array(element('bsi',$data_save['content'])) 
						 && count($data_save['content']['bsi']) > 0)
						{
							$cond_link=array();
							$cond_link['op_id']=element($this->pk_id,$data_get);
	        				$cond_link['op_table']='fm_bill';
							$cond_link['op_field']='bill_id';
							$cond_link['content']='bsi_sum_link';
			        		$this->m_link->del_where($cond_link);
			        		
			        		$this->load->model('proc_bs/m_bs');
			        		$this->m_table_op->load('fm_bs_item');
			        		
							foreach ( $data_save['content']['bsi'] as $v) {
								
								if(strlen($v['bsi_id']) != 32 ) $v['bsi_id'] = fun_urldecode($v['bsi_id']);
								
								if( element('bsi_sum_link', $v) 
								 && $data_save['content']['ppo'] == BILL_PPO_END
								 && $btn == 'next' )
								{
									$bsi_sum = $this->m_base->get_field_where('fm_bs_item','bsi_sum',"AND bsi_id = '{$v['bsi_id']}'");
									
									if( bccomp($bsi_sum,$v['bsi_sum_link']) == 0 )
									{
										$data_save['bsi']=array();
										$data_save['bsi']['bsi_id']=$v['bsi_id'];
										$data_save['bsi']['bsi_type']=BSI_TYPE_BILL;
										$data_save['bsi']['bsi_link_id']=$data_get['bill_id'];
										$this->m_table_op->update($data_save['bsi']);
									}
									else 
									{
										$data_save['bsi']=array();
										if(strlen($v['bsi_id']) != 32 ) $v['bsi_id'] = fun_urldecode($v['bsi_id']);
										$data_save['bsi']['bsi_id']=$v['bsi_id'];
										$data_save['bsi']['bsi_sum'] = $bsi_sum - $v['bsi_sum_link'];
										$this->m_table_op->update($data_save['bsi']);
										
										$data_save['bsi']=$this->m_table_op->get($v['bsi_id']);
										$data_save['bsi']['bsi_id']=NULL;
										$data_save['bsi']['bsi_type']=BSI_TYPE_BILL;
										$data_save['bsi']['bsi_link_id']=$data_get['bill_id'];
										$data_save['bsi']['bsi_sum'] = $v['bsi_sum_link'];
										$this->m_table_op->add($data_save['bsi']);
									}
									
									continue;
								}
								
								if( ! element('bsi_sum_link', $v) ) continue;
								
								$data_save['link']=array();
								$data_save['link']['op_id']=element($this->pk_id,$data_get);
								$data_save['link']['op_table']='fm_bill';
								$data_save['link']['op_field']='bill_id';
								$data_save['link']['content']='bsi_sum_link';
								$data_save['link']['note']=$v['bsi_sum_link'];
								$data_save['link']['link_id']=$v['bsi_id'];
								$data_save['link']['link_table']='fm_bs_item';
								$data_save['link']['link_field']='bsi_id';
								
								$this->m_link->add($data_save['link']);
							}
							
							$data_save['content']['bsi']=json_encode($data_save['content']['bsi']);
						}
						
						//开票申请明细条目表
						if( ! empty(element('bei',$data_save['content']) ) )
						{
							$arr_save=array(
								'bill_id' => element('bill_id',$data_get)
							);

							$this->m_base->save_datatable('fm_bill_eqi',
								$data_save['content']['bei'],
								$data_db['content']['bei'],
								$arr_save);
						}
						
						//开票批准发票条目表
						if( ! empty(element('bdi',$data_save['content']) ) )
						{
							$arr_save=array(
								'bill_id' => element('bill_id',$data_get)
							);

							$this->m_base->save_datatable('fm_bill_detail_item',
								$data_save['content']['bdi'],
								$data_db['content']['bdi'],
								$arr_save);
						}
						
						//工单日志
						if( $btn == 'yj' )
						{
							$data_save['content_log']['log_note']=
						'【'.$this->sess->userdata('c_name').'['.$this->sess->userdata('a_login_id').']】'
						.'于节点【'.$GLOBALS['m_bill']['text']['ppo'][$data_db['content']['ppo']].'】'
						.',将【'.$this->title.'】移交于【'.$data_post['content']['person_yj_s'].'】';
						
							$data_save['wl']['wl_type']=WL_TYPE_YJ;
							$data_save['wl']['wl_event']=element('wl_list_to_do', $data_out);
							$data_save['wl']['c_accept'][]=$data_post['content']['person_yj'];
							
						}
						elseif( $btn == 'next' || $btn == 'pnext' )
						{
							$data_save['content_log']['log_note']=
						'于节点【'.$GLOBALS['m_bill']['text']['ppo'][$data_db['content']['ppo']].'】'.$ppo_btn_text
						.',流转至节点【'.$GLOBALS['m_bill']['text']['ppo'][$data_save['content']['ppo']].'】';
						
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
								
								if($data_save['content']['ppo'] == BILL_PPO_END)
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
								
								if($data_save['content']['ppo'] != BILL_PPO_END)
								$this->m_work_list->add($data_save['wl']);
								
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
								
								if($data_save['content']['ppo'] == BILL_PPO_END)
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
	    $data_out['code']=element('bill_code', $data_db['content']);
	    
	    $data_out['ppo']=element('ppo', $data_db['content']);
	    $data_out['ppo_name']=$GLOBALS['m_bill']['text']['ppo'][element('ppo', $data_db['content'])];
	    
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
}