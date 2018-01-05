<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 *  
    财务编号开票回款计划
 */
class M_gfc_bp extends CI_Model {
	
	//@todo 主表配置
	private $table_name='pm_given_financial_code';
	private $pk_id='gfc_id';
	private $table_form;
	private $arr_table_form=array();
	private $title='开票回款计划';
	private $model_name = 'm_gfc_bp';
	private $url_conf = 'proc_gfc/gfc_bp/edit';
	private $proc_id = 'proc_gfc';
	
 	public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->m_define();
        
         //读取表结构
        $this->config->load('db_table/'.$this->table_name, FALSE,TRUE);
        $this->table_form=$this->config->item($this->table_name);
        
        $this->load->model('proc_bud/m_budm');
        $this->load->model('proc_gfc/m_gfc');
        $this->load->model('proc_gfc/m_bp');
        
    }
    
	/**
     * 
     * 定义
     */
	public function m_define()
    {
    	//@todo 定义
    	if( defined('LOAD_M_GFC_BP') ) return;
    	define('LOAD_M_GFC_BP', 1);
    	
    	//define
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
    	$acl_list= $this->m_proc_gfc->get_acl();

    	$msg='';
    	/************权限验证*****************/

    	//如果有超级权限，TRUE
    	if( ($acl_list & pow(2,ACL_PROC_GFC_SUPER)) != 0 )
    	{
    		return TRUE;
    	}

    	$check_acl=FALSE;

    	if( ! $check_acl
    	 && ($acl_list & pow(2,ACL_PROC_GFC_USER)) != 0
    	)
	    {
	     	$check_acl=TRUE;
	    }

	    if( ! $check_acl )
	    {
			if( ! $msg )
			$msg = '您没有【'.$this->title.'】的【操作】权限不可进行操作！' ;

			redirect('base/main/show_err/msg/'.fun_urlencode($msg));
	    }
    }
    
	/**
     * 
     */
	public function get_code($data_save=array())
    {
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
     * 生成导入xlsx
     */
	public function create_import_xlsx()
    {
    	$this->load->model('base/m_excel');
    	
    	$conf=array();
    	
    	//@todo 导入xlsx配置
    	$conf['field_edit']=array(
			'pm_given_financial_code[gfc_name]',
			'pm_given_financial_code[gfc_note]',
    	);
    	
    	$conf['field_required']=array(
			'pm_given_financial_code[gfc_name]',
    	);
    	
    	$conf['field_define']=array(
    	);
    	
    	$conf['table_form']=array(
			'pm_given_financial_code'=>$this->table_form,
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
		);
		
		//编辑数组
		$data_out['field_edit']=array(
			'content[db_time_update]',
		
			'content[gfc_category_bill]',
			'content[gfc_bp]',
			'content[gfc_bp_sum_remain]',
		);
		
		//只读数组
		$data_out['field_view']=array(
			
			'content[gfc_finance_code]',
			'content[gfc_time_node_sign]',
			'content[gfc_ou_tj]',
			'content[gfc_ou_tj_data]',
		
			'content[gfc_org]',
			'content[gfc_name]',
			'content[gfc_org_jia_s]',
			'content[gfc_org_jia]',
			'content[gfc_c_s]',
			'content[gfc_c]',
			'content[gfc_ou_s]',
			'content[gfc_ou]',
			'content[gfc_category_contract]',
			'content[gfc_sum]',
			'content[gfc_pt_plan_sign]',
			'content[gfc_category_main]',
			'content[gfc_category_secret]',
			'content[gfc_category_tiaoxian_main]',
			'content[gfc_category_tiaoxian]',
			'content[gfc_category_extra]',
			'content[gfc_category_statistic]',
			'content[gfc_category_subc]',
			'content[gfc_category_cooperation]',
			'content[gfc_area]',
			'content[gfc_area_1]',
			'content[gfc_area_2]',
			'content[gfc_area_show]',
			'content[gfc_note]',
		
			'content[gfc_c_tj_s]',
			'content[gfc_c_tj]',
		
			'content[gfc_bp_prog]',
			'content[gfc_bp_prog_text]',
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
		$data_out['json_field_define']['gfc_category_main']=get_html_json_for_arr($GLOBALS['m_gfc']['text']['gfc_category_main'] );
		$data_out['json_field_define']['gfc_category_secret']=get_html_json_for_arr($GLOBALS['m_gfc']['text']['gfc_category_secret'] );
		$data_out['json_field_define']['gfc_category_tiaoxian_main']=get_html_json_for_arr($GLOBALS['m_gfc']['text']['gfc_category_tiaoxian_main'] );
		$data_out['json_field_define']['gfc_category_tiaoxian']=get_html_json_for_arr($GLOBALS['m_gfc']['text']['gfc_category_tiaoxian'] );
		$data_out['json_field_define']['gfc_category_extra']=get_html_json_for_arr($GLOBALS['m_gfc']['text']['gfc_category_extra'] );
		$data_out['json_field_define']['gfc_category_statistic']=get_html_json_for_arr($GLOBALS['m_gfc']['text']['gfc_category_statistic'] );
		$data_out['json_field_define']['gfc_category_subc']=get_html_json_for_arr($GLOBALS['m_budm']['text']['gfc_category_subc'] );
		$data_out['json_field_define']['gfc_category_cooperation']=get_html_json_for_arr($GLOBALS['m_base']['text']['base_yn'] );
		$data_out['json_field_define']['gfc_category_contract']=get_html_json_for_arr($GLOBALS['m_base']['text']['base_yn'] );
		$data_out['json_field_define']['bp_type']=get_html_json_for_arr($GLOBALS['m_bp']['text']['bp_type'] );
		$data_out['json_field_define']['gfc_category_bill']=get_html_json_for_arr($GLOBALS['m_base']['text']['base_yn'] );
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
								if( is_array($v) ) {
									$v = implode(',', $v);

									if(element($k,$data_db['content']))
										$data_db['content'][$k] = implode(',', $data_db['content'][$k]);
								}

								if( $v != element($k,$data_db['content']) )
								{
									switch ($k)
									{
										case 'gfc_ou_tj':
											
											$diff='';
											
											$arr_f=array();
											if( $data_db['content']['gfc_ou_tj_data'] )
											$arr_f = json_decode($data_db['content']['gfc_ou_tj_data'] ,TRUE);
											
											if(count($arr_f)>0)
											{
												foreach ($arr_f as $v1) {
													$diff.='<br>'.$v1['text'];
												}

											}
											
											$data_out['log']['content['.$k.']']='变更前:'.$diff;
											
											$data_db['content'][$k] = explode(',', $v) ;
											$data_db['content'][$k.'_data'] = element('gfc_ou_tj_data', $data_change['content']);
											break;
											
										case 'gfc_org':
											
											if(element('gfc_org', $data_db['content']))
											$data_db['content']['gfc_org_s'] = $this->m_base->get_field_where('sys_org','o_name', " AND o_id ='{$data_db['content']['gfc_org']}'");
											
											$data_out['log']['content['.$k.']']='变更前:'. element('gfc_org_s', $data_db['content']);
											$data_db['content'][$k] =$v ;
		
											break;
										case 'gfc_c_s':
											$data_out['log']['content['.$k.']']='变更前:'. $this->m_base->get_c_show_by_cid($data_db['content']['gfc_c']);
											$data_db['content'][$k] =$v ;
		
											break;
										case 'gfc_ou_s':
											$data_out['log']['content['.$k.']']='变更前:'. $this->m_base->get_field_where('sys_ou','ou_name', " AND ou_id ='{$data_db['content']['gfc_ou']}'");
											$data_db['content'][$k] =$v ;
											break;
										case 'gfc_c_tj_s':
											$data_out['log']['content['.$k.']']='变更前:'. $this->m_base->get_c_show_by_cid($data_db['content']['gfc_c_tj']);
											$data_db['content'][$k] =$v ;
											break;
										case 'gfc_org_jia_s':
											
											if(element('gfc_org_jia', $data_db['content']))
											$data_db['content']['gfc_org_jia_s'] = $this->m_base->get_field_where('sys_org','o_name', " AND o_id ='{$data_db['content']['gfc_org_jia']}'");
											
											$data_out['log']['content['.$k.']']='变更前:'. element('gfc_org_jia_s', $data_db['content']);
											$data_db['content'][$k] =$v ;
											
											break;
										case 'gfc_category_cooperation':
										case 'gfc_category_contract':
											
											if( (element($k,$data_db['content']) || element($k,$data_db['content']) == '0' )
									         && isset($GLOBALS['m_base']['text'][$k][$v]) )
											$data_db['content'][$k]=$GLOBALS['m_base']['text']['base_yn'][element($k,$data_db['content'])];
									
											$data_out['log']['content['.$k.']']='变更前:'.element($k,$data_db['content']);
											$data_db['content'][$k] =$v ;
											
											break;
											
										case 'gfc_area_1':
										case 'gfc_area_2':
											break;
										case 'gfc_area':
											
											$arr_tmp = array();
											
											if(element($k,$data_db['content']))
											{
												$arr_tmp = explode(',', $data_db['content'][$k]);
												$data_db['content']['gfc_area'] = element(0, $arr_tmp);
												$data_db['content']['gfc_area_1'] = element(1, $arr_tmp);
												$data_db['content']['gfc_area_2'] = element(2, $arr_tmp);
											}
											
											$arr_tmp_2 = explode(',',$v);
											if($arr_tmp_2[0] != element(0, $arr_tmp))
											{
												$data_out['log']['content[gfc_area]']='变更前:'.$this->m_base->get_area_show(element(0, $arr_tmp));
											}
											
											if($arr_tmp_2[1] != element(1, $arr_tmp))
											{
												$data_out['log']['content[gfc_area_1]']='变更前:'.$this->m_base->get_area_show(element(1, $arr_tmp),element(0, $arr_tmp));
											}
											
											if($arr_tmp_2[2] != element(2, $arr_tmp))
											{
												$data_out['log']['content[gfc_area_2]']='变更前:'.$this->m_base->get_area_show(element(2, $arr_tmp),element(1, $arr_tmp));
											}
											
											$data_db['content'][$k] =$v ;
											break;
											
										case 'gfc_bp':
									
											$data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('bp_id',$v,element($k,$data_db['content']),'m_gfc','show_change_gfc_bp');
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
						//批量编辑
						if(  element('flag_edit_more', $data_get) )
						{
							$data_db['content'] = array();
							break;
						}
						
						//非数据库页面调用
						if(  element('fun_no_db', $data_get) )
						{
							$data_db['content'] = json_decode(fun_urldecode($this->input->post('data_db')),TRUE);
							break;
						}
						
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
						$data_db['content']['gfc_ou_tj']=array();
						$data_db['content']['gfc_ou_tj_data']=array();
						
						if(count($rs_link['content'])>0)
						{
							foreach ( $rs_link['content'] as $v ) {
								$data_db['content']['gfc_ou_tj'][]=$v['link_id'];
								
								$data_db['content']['gfc_ou_tj_data'][]=array(
									'id'=>$v['link_id'],
									'text'=>$this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id = '{$v['link_id']}'")
								);
							}
						}
						
						//获取开票回款计划
						$arr_search=array();
						$arr_search['field']='*';
						$arr_search['from']="pm_bill_plan";
						$arr_search['where']=' AND gfc_id = ? ';
						$arr_search['value'][]=element('gfc_id',$data_get);
						$arr_search['sort']=array("bp_time");
						$arr_search['order']=array('asc');
						
						$rs=$this->m_db->query($arr_search);

						$data_db['content']['gfc_bp'] = array();
						
						$bp_sum_all = 0;
						
						if(count($rs['content'])>0)
						{
							foreach ($rs['content'] as $v) {
								$bp_sum_all+=$v['bp_sum'];
								$v['bp_type_s'] = element($v['bp_type'], $GLOBALS['m_bp']['text']['bp_type']);
								$v['bill_id'] = $this->m_base->get_field_where('fm_bill','bill_id'," AND bp_id = '{$v['bp_id']}'");
								$data_db['content']['gfc_bp'][]=$v;
							}
						}
						$data_db['content']['gfc_bp'] = json_encode($data_db['content']['gfc_bp']);
						$data_db['content']['gfc_bp_sum'] = $data_db['content']['gfc_sum'];
						$data_db['content']['gfc_bp_sum_remain'] = $data_db['content']['gfc_sum'] - $bp_sum_all;
						$data_db['content']['gfc_bp_prog'] = 0;
						if($data_db['content']['gfc_sum'] != 0 )
						$data_db['content']['gfc_bp_prog'] = $bp_sum_all/$data_db['content']['gfc_sum']*100 ;
						$data_db['content']['gfc_bp_prog_text'] = '已分解金额:'.$bp_sum_all;
						
						$data_db['content']['gfc_ou_tj_data']=json_encode($data_db['content']['gfc_ou_tj_data']);
						
						$data_db['content']['gfc_c_s'] = $this->m_base->get_c_show_by_cid($data_db['content']['gfc_c']);
						$data_db['content']['gfc_ou_s'] = $this->m_base->get_field_where('sys_ou','ou_name', " AND ou_id ='{$data_db['content']['gfc_ou']}'");
						$data_db['content']['gfc_c_tj_s'] = $this->m_base->get_c_show_by_cid($data_db['content']['gfc_c_tj']);
						$data_db['content']['gfc_org_jia_s'] = $this->m_base->get_field_where('sys_org','o_name', " AND o_id ='{$data_db['content']['gfc_org_jia']}'");
						
						$this->m_table_op->load('sys_contact');
						$data_db['content_c_jia'] = $this->m_table_op->get(element('gfc_c_jia',$data_db['content']));
						$data_db['content']['gfc_c_jia_s'] = element('c_name', $data_db['content_c_jia']);
						
						if(element('c_tel', $data_db['content_c_jia']))
						$data_db['content']['gfc_c_jia_tel'] = element('c_tel', $data_db['content_c_jia']);
						else
						$data_db['content']['gfc_c_jia_tel'] = element('c_phone', $data_db['content_c_jia']);
					}
					
					if(element('gfc_area', $data_db['content']))
					{
						$arr_tmp = explode(',', $data_db['content']['gfc_area']);
						$data_db['content']['gfc_area'] = element(0, $arr_tmp);
						$data_db['content']['gfc_area_1'] = element(1, $arr_tmp);
						$data_db['content']['gfc_area_2'] = element(2, $arr_tmp);
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
			case 1:
				$data_out['ppo_btn_next']='提交';
				break;
		}
				
		if( $data_get['act'] == STAT_ACT_EDIT 
		 && element('ppo', $data_db['content']) != GFC_PPO_END )
		{
			$data_out['flag_wl'] = TRUE;
		}
		
		$data_out=$this->m_work_list->get_wl_info($data_out,$data_db);

		/************权限验证*****************/
		//@todo 权限验证
		$acl_list= $this->m_proc_gfc->get_acl();
		
		if( ! empty (element('acl_wl_yj', $data_out)) ) 
		$acl_list= $acl_list | $data_out['acl_wl_yj'];

		$this->check_acl($data_db,$acl_list);
		
		/************显示配置*****************/
		//@todo 显示配置
		$title_field='-'.element('gfc_name',$data_db['content']);
		
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
				$data_db['content']['gfc_org'] = $this->sess->userdata('c_org');
				$data_db['content']['gfc_c'] = $this->sess->userdata('c_id');
				$data_db['content']['gfc_c_s'] = $this->m_base->get_c_show_by_cid($this->sess->userdata('c_id'));
				$data_db['content']['gfc_ou'] = $this->sess->userdata('c_ou_bud');
				$data_db['content']['gfc_ou_s'] = $this->m_base->get_field_where('sys_ou','ou_name', " AND ou_id ='{$data_db['content']['gfc_ou']}'");
				$data_db['content']['gfc_category_subc'] = BUDM_TYPE_SUBC_NO;
				$data_db['content']['gfc_category_secret'] = GFC_CATEGORY_SECRET_FM;
				$data_db['content']['gfc_category_cooperation'] = BASE_N;
				$data_db['content']['gfc_category_contract'] = BASE_Y;
				
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
				
				$data_out['op_disable'][]='btn_del';
				$data_out['op_disable'][]='btn_person';
				$data_out['op_disable'][]='btn_import';
				
				$data_out['op_disable'][]='btn_next';
				$data_out['op_disable'][]='btn_pnext';
				
				
			break;
			case STAT_ACT_VIEW:
				$data_out['title']='查看'.$this->title.$title_field;
				
				$data_out['op_disable'][]='btn_save';
				$data_out['op_disable'][]='btn_del';
				$data_out['op_disable'][]='btn_person';
				$data_out['op_disable'][]='btn_import';
				
				$data_out['op_disable'][]='btn_next';
				$data_out['op_disable'][]='btn_pnext';
				
				$data_out['field_view']=array_unique(array_merge($data_out['field_view'],$data_out['field_edit']));
				
			break;
		}
		
		//@todo 节点权限显示隐藏
		
		if( $data_get['act'] == STAT_ACT_EDIT
		&& element( 'ppo',$data_db['content']) == 0 
		&& ($acl_list & pow(2,ACL_PROC_GFC_SUPER) ) == 0 )
		{
			$data_out['op_disable'][]='btn_save';
			$data_out['op_disable'][]='btn_del';
			
			$data_out['op_disable'][]='btn_next';
			$data_out['op_disable'][]='btn_pnext';
			
		}
		
		if(element('flag_edit_more', $data_get))
		{
			$data_out['field_required']=array();
			
			$data_out['op_disable'][] = 'content[gfc_name]';
			
			$data_out['op_disable'][]='btn_log';
			$data_out['op_disable'][]='btn_del';
			
			$data_out['title'] = '批量编辑'.$this->title.'-请勾选要保存的字段';
		}
		
		if( element('flag_gfc', $data_get) )
		{
			$data_out['op_disable'][] = 'div_title';
			$data_out['op_disable'][] = 'wl_comment';
		}

		/************事件处理*****************/

		if(in_array('btn_'.$btn,$data_out['op_disable']))
		{
			$rtn['result'] = FALSE;
			
			if($btn == 'del')
			$rtn['msg_err'] = '禁止删除！';
			
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
							 || (
							 		empty(element($arr_tmp['field'],$data_post['content']))
							 	 && element($arr_tmp['field'],$data_post['content']) != '0'
							 	)
							 )
							$data_post['content'][$arr_tmp['field']] = element($arr_tmp['field'],$data_db['content']);
							
							if( empty(element($arr_tmp['field'],$data_post['content'])) 
							 && element($arr_tmp['field'],$data_post['content']) != '0'
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
					
					if( element('gfc_bp_sum_remain', $data_post['content']) != 0 )
					{
						$rtn['err']['content[gfc_bp]']='开票回款计划未分解完毕！';
						$check_data=FALSE;
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
				
				if(element('fun_no_db', $data_get))
				{
					$rtn['rtn']=TRUE;
					echo json_encode($rtn);
					exit; 
				}
				
				/************数据处理*****************/
				$data_save['content']=$data_db['content'];
				
				if(count(element('content',$data_post))>0)
				{
					foreach ($data_post['content'] as $k=>$v) {
						
						if( element('flag_edit_more', $data_post) 
						 && element($k.'_check', $data_post['content']) != 1 )
						 continue;
						 
						if( ! in_array('content['.$k.']',$data_out['field_view'])
						 && ! in_array('content['.$k.']',$data_out['op_disable'])
						 && in_array('content['.$k.']',$data_out['field_edit']) )
						$data_save['content'][$k]=$v;
					}
				}
				/************事件处理*****************/
				switch ($data_get['act']) {
					case STAT_ACT_CREATE:
						
						$data_save['content']['ppo']=GFC_PPO_START;
						
						$rtn=$this->add($data_save['content']);
						
						//创建我的工单
	    				$data_save['wl']['wl_id'] = $rtn['id'];
	    				$data_save['wl']['wl_type'] = WL_TYPE_I;
	    				$data_save['wl']['wl_code']=$data_save['content']['gfc_name'];
		    			$data_save['wl']['wl_op_table']='pm_given_financial_code';
		    			$data_save['wl']['wl_op_field']='gfc_id';
		    			$data_save['wl']['op_id']=$rtn['id'];
	    				$data_save['wl']['p_id']=$this->proc_id;
	    				$data_save['wl']['pp_id']=$this->model_name;
	    				$data_save['wl']['wl_proc']=$data_save['content']['ppo'];
		    			$data_save['wl']['wl_url']=$this->url_conf.'/act/2';
		    			$data_save['wl']['wl_note']='【'.$this->title.'】'
		    				.','.$data_save['content']['gfc_name']
		    				.','.$data_save['content']['gfc_sum']
		    				.','.$this->m_base->get_c_show_by_c_id($data_save['content']['gfc_c'])
		    				.','.$this->m_base->get_field_where('sys_org','o_name'," AND o_id = '{$data_save['content']['gfc_org_jia']}'")
		    				.','.$this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id = '{$data_save['content']['gfc_ou']}'")
		    				.','.$this->m_base->get_field_where('sys_org','o_name'," AND o_id = '{$data_save['content']['gfc_org']}'")
		    				;
	    				$data_save['wl']['c_accept'][] = $this->sess->userdata('c_id');
	    				
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
						
						$rtn=$this->update($data_save['content']);
						
						//开票回款计划
						if( ! empty(element('gfc_bp',$data_save['content']) ) )
						{
							$arr_save=array(
								'gfc_id' => element('gfc_id',$data_get)
							);

							$this->m_base->save_datatable('pm_bill_plan',
								$data_save['content']['gfc_bp'],
								$data_db['content']['gfc_bp'],
								$arr_save);
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
	    $data_out['code']=element('gfc_finance_code', $data_db['content']);
	    
	    $data_out['ppo']=element('ppo', $data_db['content']);
	    $data_out['ppo_name']=$GLOBALS['m_gfc']['text']['ppo'][element('ppo', $data_db['content'])];
	
	    $data_out['fun_no_db']=element('fun_no_db', $data_get);
	    $data_out['data_db_post'] = $this->input->post('data_db');
	    
	    $data_out['flag_edit_more']=element('flag_edit_more', $data_get);
	    
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