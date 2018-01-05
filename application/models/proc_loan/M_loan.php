<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 *  
    非开票往来
 */
class M_loan extends CI_Model {
	
	//@todo 主表配置
	private $table_name='fm_loan';
	private $pk_id='loan_id';
	private $table_form;
	private $arr_table_form=array();
	private $title='非开票往来';
	private $model_name = 'm_loan';
	private $url_conf = 'proc_loan/loan/edit';
	private $proc_id = 'proc_loan';
	
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
        
        $this->load->model('proc_gfc/m_gfc');
        $this->load->model('proc_bud/m_bl_ppo');
    }
    
	/**
     * 
     * 定义
     */
	public function m_define()
    {
    	//@todo 定义
    	if( defined('LOAD_M_LOAN') ) return;
    	define('LOAD_M_LOAN', 1);
    	
    	//define
        //支付方式
        define('LOAN_PAY_TYPE_CARD', 1); // 卡
        define('LOAN_PAY_TYPE_WIRE', 2); // 电汇
        define('LOAN_PAY_TYPE_BILL', 3); // 汇票
        define('LOAN_PAY_TYPE_ACCEPTANCE_THREE', 4); // 三个月承兑汇票
        define('LOAN_PAY_TYPE_ACCEPTANCE_SIX', 5); // 六个月承兑汇票
        define('LOAN_PAY_TYPE_ACCEPTANCE_BANK', 6); // 银行承兑汇票
        define('LOAN_PAY_TYPE_ACCEPTANCE_BUSINESS', 7); // 商业承兑汇票
        define('LOAN_PAY_TYPE_CHARGEOFFS', 8); // 冲账
        define('LOAN_PAY_TYPE_CASH', 9); // 现金
        define('LOAN_PAY_TYPE_CHEQUE', 10); // 支票
        define('LOAN_PAY_TYPE_SWK', 11); // 商务卡

        $GLOBALS['m_loan']['text']['loan_pay_type']=array(
            LOAN_PAY_TYPE_CARD=>'卡',
            LOAN_PAY_TYPE_SWK=>'商务卡',
            LOAN_PAY_TYPE_WIRE=>'电汇',
            LOAN_PAY_TYPE_BILL=>'汇票',
            LOAN_PAY_TYPE_ACCEPTANCE_THREE=>'三个月承兑汇票',
            LOAN_PAY_TYPE_ACCEPTANCE_SIX=>'六个月承兑汇票',
            LOAN_PAY_TYPE_ACCEPTANCE_BANK=>'银行承兑汇票',
            LOAN_PAY_TYPE_ACCEPTANCE_BUSINESS=>'商业承兑汇票',
            LOAN_PAY_TYPE_CHARGEOFFS=>'冲账',
            LOAN_PAY_TYPE_CASH=>'现金',
            LOAN_PAY_TYPE_CHEQUE=>'支票',
        );
        
        //财务属性
        define('LOAN_CATEGORY_FINANCE_PERSON', 1); // 个人
        define('LOAN_CATEGORY_FINANCE_UNIT', 2); // 单位

        $GLOBALS['m_loan']['text']['loan_category_finance']=array(
            LOAN_CATEGORY_FINANCE_PERSON=>'个人',
            LOAN_CATEGORY_FINANCE_UNIT=>'单位',
        );
        
        // 节点
        define('LOAN_PPO_END', 0); // 流程结束
        define('LOAN_PPO_START', 1); // 起始
        define('LOAN_PPO_FH', 2); // 审核
        define('LOAN_PPO_SH', 3); // 审核
        define('LOAN_PPO_GZ', 4); // 过账
        define('LOAN_PPO_SP', 5); // 总经理审批

        $GLOBALS['m_loan']['text']['ppo']=array(
            LOAN_PPO_START=>'起始',
            LOAN_PPO_FH=>'复核',
            LOAN_PPO_SH=>'审核',
            LOAN_PPO_GZ=>'过账',
            LOAN_PPO_SP=>'审批',
            LOAN_PPO_END=>'流程结束',
        );
    }

	public function check_acl( $data_db=array() ,$acl_list = NULL)
	{
		/************变量初始化****************/

		$data_get=trim_array($this->uri->uri_to_assoc(4));
		$act=element('act', $data_get);

		if( ! $acl_list )
			$acl_list= $this->m_proc_loan->get_acl();

		$msg='';
		/************权限验证*****************/

		//如果有超级权限，TRUE
		if( ($acl_list & pow(2,ACL_PROC_LOAN_SUPER)) != 0 )
		{
			return TRUE;
		}

		$check_acl=FALSE;

        //审核节点
        if( ! $check_acl
            && element('ppo',$data_db['content']) == LOAN_PPO_SH
            && $act == STAT_ACT_EDIT
        )
        {
            if( ($acl_list & pow(2,ACL_PROC_LOAN_CHECK)) == 0 )
            {
                $url=current_url();
                $url=str_replace('/act/2','/act/3',$url);
                redirect($url);
            }
            else
            {
                $check_acl=TRUE;
            }

        }
        //过账节点
        if( ! $check_acl
            && element('ppo',$data_db['content']) == LOAN_PPO_GZ
            && $act == STAT_ACT_EDIT
        )
        {
            if( ($acl_list & pow(2,ACL_PROC_LOAN_POSTED)) == 0 )
            {
                $url=current_url();
                $url=str_replace('/act/2','/act/3',$url);
                redirect($url);
            }
            else
            {
                $check_acl=TRUE;
            }

        }
        //审批节点
        if( ! $check_acl
            && element('ppo',$data_db['content']) == LOAN_PPO_SP
            && $act == STAT_ACT_EDIT
        )
        {
            if( ($acl_list & pow(2,ACL_PROC_LOAN_FINAL)) == 0 )
            {
                $url=current_url();
                $url=str_replace('/act/2','/act/3',$url);
                redirect($url);
            }
            else
            {
                $check_acl=TRUE;
            }

        }

		if( ! $check_acl
			&& ($acl_list & pow(2,ACL_PROC_LOAN_USER)) != 0
		)
		{
			$check_acl=TRUE;
		}

		if( ! $check_acl )
		{
			if( ! $msg )
				$msg = '您没有【非开票往来管理】的【操作】权限不可进行操作！' ;

			redirect('base/main/show_err/msg/'.fun_urlencode($msg));
		}
	}

	//获取单据编号
    public function get_code($data_save=array())
    {
        $where='';

        $pre = $this->m_base->get_field_where('sys_ou','ou_org_pre'," AND ou_id ='{$data_save['content']['loan_org']}'");

        $pre.='-FKY'.date("Ym");
        $where .= " AND loan_code LIKE  '{$pre}%'";

        $max_code=$this->m_db->get_m_value('fm_loan','loan_code',$where);
        $code=$pre.str_pad((intval(substr($max_code, (strlen($pre))))+1), 4, '0', STR_PAD_LEFT);

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
        $this->m_gfc->update_gbud(element('loan_gfc_id', $content),element('loan_sub', $content));
        	
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

    	);
		
		if(count($arr_link) > 0)
		{
			foreach ($arr_link as $v ) {
				$arr_tmp = explode('.', $v);
				$field=$this->m_base->get_field_where($arr_tmp[0],$arr_tmp[1]," AND {$arr_tmp[1]} = '{$id}' ");
				if($field)
				{
					$rtn['rtn'] = FALSE;
					$rtn['msg_err']=$rtn['err']['msg'] = '于【'.$arr_tmp[0].'】存在关联数据,不可删除!';
					return $rtn;
				}
			}
		}
		
		$data_db['content'] = $this->get($id);
		
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
        $this->m_gfc->update_gbud(element('loan_gfc_id', $content),element('loan_sub', $content));
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
    		'fm_loan[loan_org]',
            'fm_loan[loan_c_id]',
    		'sys_contact[c_login_id]',
    		'fm_loan[loan_gfc_id]',
            'fm_loan[loan_ou]',
            'fm_loan[loan_sub]',
            'fm_loan[loan_pay_type]',
            'fm_loan[loan_sum]',
            'fm_loan[loan_return_month]',
            'fm_loan[loan_ou_tj]',
            'fm_loan[loan_o_id]',
            'fm_loan[loan_oacc_bank]',
            'fm_loan[loan_note]',
    	);
    	
    	$conf['field_required']=array(
			'fm_loan[loan_org]',
            'fm_loan[loan_c_id]',
    		'sys_contact[c_login_id]',
            'fm_loan[loan_ou]',
            'fm_loan[loan_sub]',
            'fm_loan[loan_pay_type]',
            'fm_loan[loan_sum]',
            'fm_loan[loan_return_month]',
            'fm_loan[loan_ou_tj]',
    	);
    	
    	$conf['field_define']=array(
			'fm_loan[loan_pay_type]'=>$GLOBALS['m_loan']['text']['loan_pay_type'],
    	);
    	
    	$this->arr_table_form['sys_contact']['fields']['c_login_id']['comment']='申请人账号';
    	$this->table_form['fields']['loan_oacc_bank']['comment']='开户行账户';
    	$this->table_form['fields']['loan_gfc_id']['comment']='关联项目财务编号';
    	$conf['table_form']=array(
			'fm_loan'=>$this->table_form,
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
			'content[loan_org]',
			'content[loan_time_node]',
            'content[loan_c_id_s]',
			'content[loan_c_id]',
            'content[loan_ou_s]',
			'content[loan_ou]',
            'content[loan_sub_s]',
			'content[loan_sub]',
            'content[loan_pay_type]',
            'content[loan_sum]',
            'content[loan_return_month]',
			'content[loan_ou_tj]',
		);
		
		//编辑数组
		$data_out['field_edit']=array(
			'content[db_time_update]',
			
			'content[loan_code]',
			'content[loan_time_node]',
            'content[loan_org]',
            'content[loan_c_id_s]',
            'content[loan_c_id]',
            'content[loan_ou_s]',
            'content[loan_ou]',
            'content[loan_sub_s]',
            'content[loan_sub]',
            'content[loan_pay_type]',
            'content[loan_sum]',
            'content[loan_ending_sum]',
            'content[loan_return_month]',
            'content[loan_category_finance]',
            'content[loan_ou_tj_s]',
			'content[loan_ou_tj]',
            'content[loan_gfc_id_s]',
            'content[loan_gfc_id]',
            'content[loan_o_id_s]',
            'content[loan_o_id]',
            'content[loan_oacc_bank]',
            'content[loan_note]',
		
		);
		
		//只读数组
		$data_out['field_view']=array(
            'content[loan_ending_sum]',
            
            'content[gfc_name]',
            'content[gfc_finance_code]',
            'content[gfc_sum]',
            'content[gfc_ou_tj]',

            'content[total_sum]'
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
        $data_out['json_field_define']['loan_oacc_bank']='';
        $data_out['json_field_define']['loan_sub']='';
        $data_out['json_field_define']['loan_pay_type']=get_html_json_for_arr($GLOBALS['m_loan']['text']['loan_pay_type']);
        $data_out['json_field_define']['loan_category_finance']=get_html_json_for_arr($GLOBALS['m_loan']['text']['loan_category_finance']);
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
						
						if($data_db['content']['ppo'] == 0)
						$data_db['content']['loan_ending_sum'] = $data_db['content']['loan_sum'] - $data_db['content']['loan_sum_return'];
						
						//有财务编号显示项目信息
                        if( ! empty(element('loan_gfc_id',$data_db['content']))){
                        	$data_db['content_gfc'] = $this->m_gfc->get($data_db['content']['loan_gfc_id']);
                        	
                        	$data_db['content']['loan_gfc_id_s'] = $data_db['content_gfc']['gfc_finance_code'];
                        	
                        	$data_db['content']= array_merge($data_db['content_gfc'],$data_db['content']);
                        	
                        	//获取统计部门
							$arr_search_link=array();
							$arr_search_link['rows']=0;
							$arr_search_link['field']='link_id';
							$arr_search_link['from']='sys_link';
							$arr_search_link['where']=" AND op_id = ? AND op_table = ? AND op_field = ? AND content = ?";
							$arr_search_link['value'][]=element('gfc_id',$data_db['content']);
							$arr_search_link['value'][]='pm_given_financial_code';
							$arr_search_link['value'][]='gfc_id';
							$arr_search_link['value'][]='gfc_ou_tj';
							$rs_link=$this->m_db->query($arr_search_link);
							$data_db['content']['gfc_ou_tj']='';
							
							if(count($rs_link['content'])>0)
							{
								foreach ( $rs_link['content'] as $v ) {
									$data_db['content']['gfc_ou_tj'].=$this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id = '{$v['link_id']}'").',';
								}
							}
                        }
                        
                        $data_db['wl_list']=$this->m_work_list->get_wl_to_do(element($this->pk_id,$data_get),$this->model_name);

                        foreach($data_db['content'] as $k=>$v){
                            switch($k){
                                case 'loan_c_id':
                                    $data_db['content'][$k.'_s']=$this->m_base->get_c_show_by_cid($v);
                                    break;
                                case 'loan_ou':
                                case 'loan_ou_tj':
                                    $data_db['content'][$k.'_s']=$this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id='{$v}'");
                                    break;
                                case 'loan_sub':
                                    $data_db['content'][$k.'_s']=$this->m_base->get_field_where('fm_subject','sub_name'," AND sub_id='{$v}'");
                                    break;
                                case 'loan_o_id':
                                    $data_db['content'][$k.'_s']=$this->m_base->get_field_where('sys_org','o_name'," AND o_id='{$v}'");
                                    break;
                            }
                        }
                        
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
            case LOAN_PPO_START:
                $data_out['ppo_btn_next']='提交';
                break;
            case LOAN_PPO_GZ:
                $data_out['ppo_btn_next']='过账';
                break;
        }

        if( $data_get['act'] == STAT_ACT_EDIT
            && element('ppo', $data_db['content']) != 0 )
        {
            $data_out['flag_wl'] = TRUE;
        }

        $data_out=$this->m_work_list->get_wl_info($data_out,$data_db);
		/************权限验证*****************/
		//@todo 权限验证
		$acl_list= $this->m_proc_loan->get_acl();

		if( ! empty (element('acl_wl_yj', $data_out)) )
			$acl_list= $acl_list | $data_out['acl_wl_yj'];

		$this->check_acl($data_db,$acl_list);
		/************显示配置*****************/
		//@todo 显示配置
		$title_field='';
		
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
                $data_db['content']['ppo'] = LOAN_PPO_START;
                $data_db['content']['loan_c_id'] = $this->sess->userdata('c_id');
                $data_db['content']['loan_c_id_s'] = $this->sess->userdata('c_show');
                $data_db['content']['loan_ou'] = $this->sess->userdata('c_ou_bud');
                $data_db['content']['loan_ou_s'] = $this->m_base->get_field_where('sys_ou','ou_name', " AND ou_id ='{$data_db['content']['loan_ou']}'");

                $data_db['content']['loan_org'] = $this->sess->userdata('c_org');
                $data_db['content']['loan_time_node'] = date("Y-m-d");
                
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
				
				$data_out['field_view'][]='content[loan_org]';
				
				
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

        if( element( 'ppo',$data_db['content']) == 1 )
        {
            $data_out['op_disable'][]='btn_pnext';
        }

        if( element( 'ppo',$data_db['content']) != 1 )
        {
            $data_out['op_disable'][]='btn_del';
            
            if( element( 'ppo',$data_db['content']) != LOAN_PPO_FH )
            {
            	$data_out['field_view'] = array_unique(array_merge($data_out['field_view'],array(
					'content[loan_org]',
		            'content[loan_org_s]',
		            'content[loan_c_id_s]',
		            'content[loan_c_id]',
		            'content[loan_ou_s]',
		            'content[loan_ou]',
		            'content[loan_sub_s]',
		            'content[loan_sub]',
		            'content[loan_pay_type]',
		            'content[loan_sum]',
		            'content[loan_ending_sum]',
		            'content[loan_return_month]',
		            'content[loan_ou_tj_s]',
		            'content[loan_ou_tj]',
		            'content[loan_gfc_id_s]',
		            'content[loan_gfc_id]',
		            'content[loan_o_id_s]',
		            'content[loan_o_id]',
		            'content[loan_oacc_bank]',
		            'content[loan_note]',
				)));
            }
        }
        
        if( element( 'ppo',$data_db['content']) != 0 )
        {
        	$data_out['op_disable'][]='content[loan_ending_sum]';
        	$data_out['op_disable'][]='title_loan_cz';
        }
        
		if( element('loan_code_type', $data_db['content']) == 1)
		{
			$data_out['field_view'][]='content[loan_code]';
		}

		//禁用项目信息
        if(empty(element('loan_gfc_id',$data_db['content'])))
        {
            $data_out['op_disable'][]='title_gfc';
        }

        //非过账节点
        if( element( 'ppo',$data_db['content']) != LOAN_PPO_GZ)
        {
            $data_out['field_view'][]='content[loan_category_finance]';
        }
        
		if( $data_get['act'] == STAT_ACT_EDIT
		&& element( 'ppo',$data_db['content']) == 0  )
		{
			
			if( ($acl_list & pow(2,ACL_PROC_LOAN_SUPER) ) == 0)
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
			
			$data_out['op_disable'][]='loan_bud';
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
		elseif( element( 'ppo',$data_db['content']) == 0 )
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
					//除卡和现金外其余的付款单位必填
                    if( element('loan_pay_type',$data_post['content']) != LOAN_PAY_TYPE_CARD
                     && element('loan_pay_type',$data_post['content']) != LOAN_PAY_TYPE_CASH )
                    {
                        $data_out['field_required'][]='content[loan_oacc_bank]';
                    }
                    
                    //如果有付款单位，开户行必填
                    if( ! empty( element('loan_o_id',$data_post['content']) ) )
                    {
                    	$data_out['field_required'][]='content[loan_oacc_bank]';
                    }
                    
                    //过账财务属性必填
                    if( element( 'ppo',$data_db['content']) == LOAN_PPO_GZ )
                    {
                    	$data_out['field_required'][]='content[loan_category_finance]';
                    }
                    
					//必填验证
					if(count($data_out['field_required'])>0)
					{
						foreach ($data_out['field_required'] as $v) {

							$arr_tmp=split_table_field($v);

							if(empty(element($arr_tmp['field'],$data_post['content'])))
							$data_post['content'][$arr_tmp['field']] = element($arr_tmp['field'],$data_db['content']);
							
							if( empty(element($arr_tmp['field'],$data_post['content'])) 
							 && element($arr_tmp['field'],$data_post['content']) !== '0'
							 )
							{
								$field_s='';
								if(isset($this->table_form['fields'][$arr_tmp['field']]))
								$field_s = $this->table_form['fields'][$arr_tmp['field']]['comment'];
								elseif(count($this->arr_table_form)>0)
								{
									foreach ($this->arr_table_form as $k=>$v1) {
										
										if(isset($v1['fields'][$arr_tmp['field']]))
										{
											$field_s = $v1['fields'][$arr_tmp['field']]['comment'];
											break;
										}
									}
								}

								$rtn['err']['content['.$arr_tmp['field'].']']='请输入'.$field_s.'！';
								$check_data=FALSE;
							}
						}
					}
					
					if( ! empty( element('loan_code', $data_post['content'])))
					{
						$where_check=' AND loan_id != \''.element('loan_id',$data_db['content']).'\'';

						$check=$this->m_check->unique('fm_loan','loan_code',element('loan_code',$data_post['content']),$where_check);
						if( ! $check )
						{
							$rtn['err']['content[loan_code]']='单据编号【 '.element('loan_code',$data_post['content']).'】已存在，不可重复创建！';
							$check_data=FALSE;
						}
					}

                    //存在财务编号，验证预算
                    if( ! empty(element('loan_gfc_id',$data_post['content']) ) 
                     && ! empty(element('loan_sum',$data_post['content']) ) 
                     && ! empty(element('loan_sub',$data_post['content']) )
                    )
                    {
                    	$arr_check = $this->m_gfc->check_bud($data_post['content']['loan_gfc_id']
                    	,$data_post['content']['loan_sub']
                    	,element('loan_id', $data_get)
                    	,$data_post['content']['loan_sum']);
						
                       if( ! $arr_check['rtn']){
                           $rtn['err']['content[loan_sum]'] = $arr_check['msg'];
                           $check_data=FALSE;
                       }
                    }
                    
                    //验证统计部门是否合法
                    if(element('ppo', $data_db['content']) != 0)
                    {
                    	if( ! empty( element('loan_ou_tj', $data_post['content'])))
                    	{
	                    	$check = $this->m_bl_ppo->get_ou($data_post['content']['loan_sub'],$data_post['content']['loan_sum']);
		                                 
		                    if(count($check) > 0 && ! in_array($data_post['content']['loan_ou_tj'], $check))
		                    {
		                    	$rtn['err']['content[loan_ou_tj]'] = '该统计部门已取消！请选择其他统计部门！';
	                            $check_data=FALSE;
		                    }       
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
						
						if( empty(element('loan_code', $data_save['content'])) )
						{
                        	$data_save['content']['loan_code']=$this->get_code($data_save);
                        	$data_save['content']['loan_code_type'] = 1;
						}

						$rtn=$this->add($data_save['content']);

                        //创建我的工单
                        $data_save['wl']['wl_id'] = $rtn['id'];
                        $data_save['wl']['wl_type'] = WL_TYPE_I;
                        $data_save['wl']['wl_code']=$data_save['content']['loan_code'];
                        $data_save['wl']['wl_op_table']='fm_loan';
                        $data_save['wl']['wl_op_field']='loan_id';
                        $data_save['wl']['op_id']=$rtn['id'];
                        $data_save['wl']['p_id']=$this->proc_id;
                        $data_save['wl']['pp_id']=$this->model_name;
                        $data_save['wl']['wl_proc']=$data_save['content']['ppo'];
                        $data_save['wl']['wl_url']=$this->url_conf.'/act/2';
                        $data_save['wl']['wl_note']='【'.$this->title.'】'
                        	.','.$data_save['content']['loan_sum']
                        	.','.$data_save['content']['loan_sub_s']
                            .','.$data_save['content']['loan_c_id_s']
                        ;
                        $data_save['wl']['c_accept'][] = $this->sess->userdata('c_id');
                        $data_save['wl']['c_accept'][] = $data_save['content']['loan_c_id'];

                        $this->m_work_list->add($data_save['wl']);

                        $data_save['wl']['wl_id']=get_guid();
                        $data_save['wl']['wl_type'] = 0 ;
                        $data_save['wl']['wl_event']='补全、提交单据';
                        $data_save['wl']['wl_proc'] = 1;
                        $this->m_work_list->add($data_save['wl']);

                        $rtn['wl_i'][] = $this->sess->userdata('c_id');
                        $rtn['wl_accept'][] = $this->sess->userdata('c_id');
                        $rtn['wl_accept'][] = $data_save['content']['loan_c_id'];
                        
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
                        $data_save['wl']['wl_code']=$data_db['content']['loan_code'];
                        $data_save['wl']['wl_op_table']='fm_loan';
                        $data_save['wl']['wl_op_field']='loan_id';
                        $data_save['wl']['op_id']=$data_save['content'][$this->pk_id];
                        $data_save['wl']['p_id']=$this->proc_id;
                        $data_save['wl']['pp_id']=$this->model_name;
                        $data_save['wl']['wl_url']=$this->url_conf.'/act/2';
                        $data_save['wl']['wl_proc']=$data_save['content']['ppo'];
                        $data_save['wl']['wl_time_end']=date('Y-m-d H:i:s',strtotime('+30 day'));
                        $data_save['wl']['c_accept'] = array();
                        $data_save['wl']['wl_note']='【'.$this->title.'】'
                        	.','.$data_save['content']['loan_sum']
                        	.','.$data_save['content']['loan_sub_s']
                            .','.$data_save['content']['loan_c_id_s'];

                        //工单流转
                        switch (element('ppo',$data_db['content']))
                        {
                            case LOAN_PPO_START:

                                if($btn == 'next')
                                {
                                	if( $data_save['content']['loan_ou'] == $data_save['content']['loan_ou_tj'] )
                                	{
                                		$data_save['content']['ppo'] = LOAN_PPO_SH;
                                		$data_save['content']['blp_ppo_num'] = 1;
                                		
                                		$data_save['wl']['wl_event']='审核单据';
                                		
                                		//添加流程接收人
	                                    $c_accept = $this->m_bl_ppo->get_c_person($data_save['content']['loan_sub'],$data_save['content']['loan_ou_tj']
	                                    ,$data_save['content']['loan_sum'],$data_save['content']['ppo']);
	                                    
	                                    if(count($c_accept) == 0)
	                                    {
	                                    	$data_save['content']['ppo'] = LOAN_PPO_FH;
                                			$data_save['content']['blp_ppo_num'] = 1;
                                			
                                			$data_save['wl']['wl_event']='复核单据';
	                                    }
                                	}
                                	else 
                                	{
                                		$data_save['content']['ppo'] = LOAN_PPO_FH;
                                		$data_save['content']['blp_ppo_num'] = 1;
                                		
                                		$data_save['wl']['wl_event']='复核单据';
                                		
                                		//添加流程接收人
                                		$c_accept = $this->m_bl_ppo->get_c_person($data_save['content']['loan_sub'],$data_save['content']['loan_ou']
                                		,$data_save['content']['loan_sum'],$data_save['content']['ppo']);
                                	}
                                	
                                	if( $data_save['content']['ppo'] == LOAN_PPO_FH 
                                	 && count($c_accept) == 0 )
                                	{
                                		$c_accept=$this->m_acl->get_acl_person($this->proc_id,ACL_PROC_LOAN_FCHECK);
                                		if(count($c_accept)>0){
	                                        $arr_v=array();
	                                        $arr_v[]=$c_accept;
	                                        $arr_v[]=$data_save['content']['loan_ou'];
	                                        $arr_v[]=$data_save['content']['loan_ou'];
	                                        $arr_v[]=$data_save['content']['loan_ou'];
	                                        $c_accept=$this->m_base->get_field_where('sys_contact','c_id'
	                                            ," AND c_id IN ? AND ( c_ou_2 = ? OR c_ou_3 = ? OR c_ou_4 = ?) ",$arr_v,1);
	                                    }
                                	}
                                	
                                	if(count($c_accept)>0){
                                        $arr_v=array();
                                        $arr_v[]=$data_save['content']['loan_org'];
                                        $arr_v[]=$c_accept;
                                        $c_accept=$this->m_base->get_field_where('sys_contact','c_id'
                                            ,"AND c_org = ? AND c_id IN ? ",$arr_v,1);
                                    }
                                	
                                    $data_save['wl']['c_accept']=$c_accept;
                                }

                                break;
                            case LOAN_PPO_FH:

                                if($btn == 'next')
                                {
                                	//是否存在复数阶段
                                	$c_accept = $this->m_bl_ppo->get_c_person($data_save['content']['loan_sub'],$data_save['content']['loan_ou']
	                                 ,$data_save['content']['loan_sum'],$data_save['content']['ppo'],$data_save['content']['blp_ppo_num']+1);
	                                 
	                                if( count($c_accept) == 0 )
	                                {
	                                    $data_save['content']['ppo'] = LOAN_PPO_SH;
	                                    $data_save['content']['blp_ppo_num'] = 1;
	                                    $data_save['wl']['wl_event']='审核单据';
	                                    
	                                    $c_accept = $this->m_bl_ppo->get_c_person($data_save['content']['loan_sub'],$data_save['content']['loan_ou_tj']
	                                 	,$data_save['content']['loan_sum'],$data_save['content']['ppo'],$data_save['content']['blp_ppo_num']);
	                                	
	                                 	if(count($c_accept) == 0)
	                                 	{
//	                                 		if( ! element('loan_gfc_id', $data_save['content']) )
//	                                 		{
//		                                 		$data_save['content']['ppo'] = LOAN_PPO_GZ;
//			                                    $data_save['wl']['wl_event']='过账';
//		                                 		$c_accept=$this->m_acl->get_acl_person($this->proc_id,ACL_PROC_LOAN_POSTED);
//	                                 		}
//	                                 		else 
	                                 		{
	                                 			$c_accept=$this->m_acl->get_acl_person($this->proc_id,ACL_PROC_LOAN_CHECK);
	                                 			
		                                 		if(count($c_accept)>0){
			                                        $arr_v=array();
			                                        $arr_v[]=$data_save['content']['loan_ou_tj'];
			                                        $arr_v[]=$c_accept;
			                                        $c_accept=$this->m_base->get_field_where('sys_contact','c_id'
			                                            ,"AND c_ou_bud = ? AND c_id IN ? ",$arr_v,1);
			                                    }
	                                 		}
	                                 	}
	                                }
	                                else 
	                                {
	                                	$data_save['content']['blp_ppo_num']++;
	                                    $data_save['wl']['wl_event']='复核单据'.$data_save['content']['blp_ppo_num'].'阶段';
	                                }

                                 	if(count($c_accept)>0){
                                        $arr_v=array();
                                        $arr_v[]=$data_save['content']['loan_org'];
                                        $arr_v[]=$c_accept;
                                        $c_accept=$this->m_base->get_field_where('sys_contact','c_id'
                                            ,"AND c_org = ? AND c_id IN ? ",$arr_v,1);
                                    }

                                    $data_save['wl']['c_accept']=$c_accept;

                                }
                                elseif($btn == 'pnext')
                                {
                                    $data_save['content']['ppo'] = LOAN_PPO_START;

                                    $data_save['wl']['wl_event']='修改单据';
                                    $data_save['wl']['c_accept'][] = $data_db['content']['db_person_create'];
                                }

                                break;
                            case LOAN_PPO_SH:

                                if($btn == 'next')
                                {
                                	//是否存在复数阶段
                                	$c_accept = $this->m_bl_ppo->get_c_person($data_save['content']['loan_sub'],$data_save['content']['loan_ou_tj']
	                                 ,$data_save['content']['loan_sum'],$data_save['content']['ppo'],$data_save['content']['blp_ppo_num']+1);
	                                 
	                                if( count($c_accept) == 0 )
	                                {
	                                    $data_save['content']['ppo'] = LOAN_PPO_GZ;
	                                    $data_save['content']['blp_ppo_num'] = 1;
	                                    $data_save['wl']['wl_event']='过账';
	                                    
	                                    $c_accept=$this->m_acl->get_acl_person($this->proc_id,ACL_PROC_LOAN_POSTED);
	                                }
	                                else 
	                                {
	                                	$data_save['content']['blp_ppo_num']++;
	                                    $data_save['wl']['wl_event']='审核单据'.$data_save['content']['blp_ppo_num'].'阶段';
	                                }
	                                
                                    //根据所属公司决定过账人
                                    if(count($c_accept)>0){
                                        $arr_v=array();
                                        $arr_v[]=$data_save['content']['loan_org'];
                                        $arr_v[]=$c_accept;
                                        $c_accept=$this->m_base->get_field_where('sys_contact','c_id'
                                            ,"AND c_org = ? AND c_id IN ? ",$arr_v,1);
                                    }

                                    $data_save['wl']['c_accept']=$c_accept;

                                }
                                elseif($btn == 'pnext')
                                {
                                    $data_save['content']['ppo'] = LOAN_PPO_START;

                                    $data_save['wl']['wl_event']='修改单据';
                                    $data_save['wl']['c_accept'][] = $data_db['content']['db_person_create'];
                                    $data_save['wl']['c_accept'][] = $data_save['content']['loan_c_id'];
                                }

                                break;
                            case LOAN_PPO_GZ:

                                if($btn == 'next')
                                {
                                	
	                                $c_accept = $this->m_bl_ppo->get_c_person($data_save['content']['loan_sub'],$data_save['content']['loan_ou_tj']
	                                 ,$data_save['content']['loan_sum'],LOAN_PPO_SP,$data_save['content']['blp_ppo_num']);
	                                
	                                if(count($c_accept) == 0)
	                                {
	                                 	$data_save['content']['ppo'] = LOAN_PPO_END;
	                                }
	                                else 
	                                {
	                                    $data_save['content']['ppo'] = LOAN_PPO_SP;
	                                    $data_save['wl']['wl_event']='审批';
	                                    
	                                    //添加流程接收人
//	                                    $c_accept=$this->m_acl->get_acl_person($this->proc_id,ACL_PROC_LOAN_FINAL);
	                                }

                                    if(count($c_accept)>0){
                                        $arr_v=array();
                                        $arr_v[]=$data_save['content']['loan_org'];
                                        $arr_v[]=$c_accept;
                                        $c_accept=$this->m_base->get_field_where('sys_contact','c_id'
                                            ,"AND c_org = ? AND c_id IN ? ",$arr_v,1);
                                    }
                                    
                                    $data_save['wl']['c_accept']=$c_accept;

                                }
                                elseif($btn == 'pnext')
                                {
                                    $data_save['content']['ppo'] = LOAN_PPO_START;

                                    $data_save['wl']['wl_event']='修改单据';
                                    $data_save['wl']['c_accept'][] = $data_db['content']['db_person_create'];
                                    $data_save['wl']['c_accept'][] = $data_save['content']['loan_c_id'];
                                }

                                break;
                            case LOAN_PPO_SP:

                                if($btn == 'next')
                                {
                                	//是否存在复数阶段
                                	$c_accept = $this->m_bl_ppo->get_c_person($data_save['content']['loan_sub'],$data_save['content']['loan_ou_tj']
	                                 ,$data_save['content']['loan_sum'],$data_save['content']['ppo'],$data_save['content']['blp_ppo_num']+1);
	                                 
	                                if( count($c_accept) == 0 )
	                                {
	                                    $data_save['content']['ppo'] = LOAN_PPO_END;
	                                }
	                                else 
	                                {
	                                	$data_save['content']['blp_ppo_num']++;
	                                    $data_save['wl']['wl_event']='审批单据'.$data_save['content']['blp_ppo_num'].'阶段';
	                                    
	                                    if(count($c_accept)>0){
	                                        $arr_v=array();
	                                        $arr_v[]=$data_save['content']['loan_org'];
	                                        $arr_v[]=$c_accept;
	                                        $c_accept=$this->m_base->get_field_where('sys_contact','c_id'
	                                            ,"AND c_org = ? AND c_id IN ? ",$arr_v,1);
	                                    }
	
	                                    $data_save['wl']['c_accept']=$c_accept;
	                                }

                                }
                                elseif($btn == 'pnext')
                                {
                                    $data_save['content']['ppo'] = LOAN_PPO_START;

                                    $data_save['wl']['wl_event']='修改单据';
                                    $data_save['wl']['c_accept'][] = $data_db['content']['db_person_create'];
                                    $data_save['wl']['c_accept'][] = $data_save['content']['loan_c_id'];
                                }

                                break;

                        }

						$rtn=$this->update($data_save['content']);

                        //工单日志
                        if( $btn == 'yj' )
                        {
                            $data_save['content_log']['log_note']=
                                '【'.$this->sess->userdata('c_name').'['.$this->sess->userdata('a_login_id').']】'
                                .'于节点【'.$GLOBALS['m_loan']['text']['ppo'][$data_db['content']['ppo']].'】'
                                .',将【'.$this->title.'】移交于【'.$data_post['content']['person_yj_s'].'】';

                            $data_save['wl']['wl_type']=WL_TYPE_YJ;
                            $data_save['wl']['wl_event']=element('wl_list_to_do', $data_out);
                            $data_save['wl']['c_accept'][]=$data_post['content']['person_yj'];

                        }
                        elseif( $btn == 'next' || $btn == 'pnext' )
                        {
                            $data_save['content_log']['log_note']=
                                '于节点【'.$GLOBALS['m_loan']['text']['ppo'][$data_db['content']['ppo']].'】'.$ppo_btn_text
                                .',流转至节点【'.$GLOBALS['m_loan']['text']['ppo'][$data_save['content']['ppo']].'】';

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
                                $data_save['wl_i']['wl_log_note']=$data_save['content_log']['log_note'];

                                if($data_save['content']['ppo'] == LOAN_PPO_END)
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

                                if($data_save['content']['ppo'] != LOAN_PPO_END)
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

                                if($data_save['content']['ppo'] == LOAN_PPO_END)
                                    $rtn['wl_end'] = $arr_wl_person['accept'];

                                break;
                        }

						if( $data_db['content']['loan_c_id'] != $data_save['content']['loan_c_id'])
						{
							$this->m_work_list->update_wl_i_person(element($this->pk_id,$data_get),$data_db['content']['loan_c_id'],$data_save['content']['loan_c_id']);
							$this->m_work_list->update_wl_person(element($this->pk_id,$data_get),$data_db['content']['loan_c_id'],$data_save['content']['loan_c_id']);
						
							$rtn['wl_i'][] = $data_db['content']['loan_c_id'];
							$rtn['wl_i'][] = $data_save['content']['loan_c_id'];
							
							$rtn['wl_accept'][] = $data_db['content']['loan_c_id'];
							$rtn['wl_accept'][] = $data_save['content']['loan_c_id'];
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

		$data_out['op_disable'] = array_values(array_unique($data_out['op_disable']));
		$data_out['op_disable']=json_encode($data_out['op_disable']);
		
		/************模板赋值*****************/
		
		$data_out['act']=$data_get['act'];
		$data_out['url']=current_url();
		$data_out['time']=time();
		if( ! empty(element('time', $data_get)) )
		$data_out['time']=element('time', $data_get);
		
		$data_out['fun_open']=element('fun_open', $data_get);
	    $data_out['fun_open_id']=element('fun_open_id', $data_get);
	    
	    $data_out['log']=json_encode(element('log', $data_out));
		
		$data_out['log_time']=$this->input->post('log_time');
		$data_out['log_a_login_id']=$this->input->post('log_a_login_id');
		$data_out['log_c_name']=$this->input->post('log_c_name');
		$data_out['log_act']=$this->input->post('log_act');
		$data_out['log_note']=$this->input->post('log_note');
	    
	    $data_out['db_time_create']=element('db_time_create', $data_db['content']);
	    $data_out['code']=element('loan_code',$data_db['content']);

        $data_out['ppo']=element('ppo', $data_db['content']);
        $data_out['ppo_name']=$GLOBALS['m_loan']['text']['ppo'][element('ppo', $data_db['content'])];
	    
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