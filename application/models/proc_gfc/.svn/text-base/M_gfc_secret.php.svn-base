<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 *  
  项目标密申请单
 */
class M_gfc_secret extends CI_Model {
	
	//@todo 主表配置
	private $table_name='pm_gfc_secret';
	private $pk_id='gfcs_id';
	private $table_form;
	private $arr_table_form=array();
	private $title='标密申请单';
	private $model_name = 'M_gfc_secret';
	private $url_conf = 'proc_gfc/gfc_secret/edit';
	private $proc_id = 'proc_gfc';
	
 	public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->m_define();
        
         //读取表结构
        $this->config->load('db_table/'.$this->table_name, FALSE,TRUE);
        $this->table_form=$this->config->item($this->table_name);
        
        $this->load->model('proc_gfc/m_proc_gfc');
        $this->load->model('proc_gfc/m_gfc');
        
    }
    
	/**
     * 
     * 定义
     */
	public function m_define()
    {
    	//@todo 定义
    	if( defined('LOAD_M_GFC_SECRET') ) return;
    	define('LOAD_M_GFC_SECRET', 1);
    	
    	//define
    	// 节点
    	define('GFCS_PPO_END', 0); // 流程结束
		define('GFCS_PPO_START', 1); // 起始
		define('GFCS_PPO_CHECK', 2); // 审核
    	
    	$GLOBALS['m_gfc_secret']['text']['ppo']=array(
    		GFCS_PPO_START=>'起始',
    		GFCS_PPO_CHECK=>'审核',
    		GFCS_PPO_END=>'流程结束',
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
    	$where='';
    	$pre = $this->m_base->get_field_where('sys_ou','ou_org_pre'," AND ou_id ='{$data_save['content']['gfc_org']}'");
    	
    	$pre.='-BM'.date("Ym");
    	$where .= " AND gfcs_code LIKE  '{$pre}%'"; 
    	
    	$max_code=$this->m_db->get_m_value('pm_gfc_secret','gfcs_code',$where);
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
	 * @param $id
	 */
	public function get_of_gfc($id)
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$data_db=array();//数据库数组
		$arr_search=array();
		$rtn=array();//结果
		
		/************变量赋值*****************/
		$arr_search['field']='*';
    	$arr_search['from']=$this->table_name;
		$arr_search['where']='AND gfc_id = ? ';
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
    	);
    	
    	$conf['field_required']=array(
    	);
    	
    	$conf['field_define']=array(
    	);
    	
    	$conf['table_form']=array(
			'pm_gfc_secret'=>$this->table_form,
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
			'content[gfcs_category_secret]',
			'content[gfcs_c_check]',
		);
		
		//编辑数组
		$data_out['field_edit']=array(
			'content[db_time_update]',
			'content[gfcs_category_secret]',
			'content[gfcs_name_tm]',
			'content[gfcs_c_check]',
			'content[gfcs_c_s]',
			'content[gfcs_c]',
			'content[gfcs_note]',
		);
		
		//只读数组
		$data_out['field_view']=array(
			'content[gfc_name]',
			'content[gfc_c_s]',
			'content[gfc_ou_s]',
			'content[gfc_org_s]',
			'content[gfcs_code]',
			'content[gfc_org_jia_s]',
			'content[gfc_c_jia]',
			'content[gfc_c_jia_tel]',
			'content[gfc_category_contract]',
			'content[gfc_sum]',
			'content[gfc_pt_plan_sign]',
			'content[gfc_category_main]',
			'content[gfc_category_tiaoxian_main]',
			'content[gfc_category_tiaoxian]',
			'content[gfc_category_extra]',
			'content[gfc_category_statistic]',
			'content[gfc_category_subc]',
			'content[gfc_category_cooperation]',
			'content[gfc_area_show]',
			'content[gfc_note]',
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
		$data_out['json_field_define']['gfc_category_secret']=get_html_json_for_arr($GLOBALS['m_gfc']['text']['gfc_category_secret'] );
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
						
						$data_db['content_gfc'] = $this->m_gfc->get(element('gfc_id',$data_db['content']));
						
						$data_db['content'] = array_merge($data_db['content_gfc'],$data_db['content']);
						
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
						
					}
					
					if( $data_db['content']['gfcs_category_secret'] == GFC_CATEGORY_SECRET_FM )
					$data_db['content']['gfcs_name_tm'] = $data_db['content']['gfc_name'] ;
					
					$data_db['content']['gfc_c_s'] = $this->m_base->get_c_show_by_cid($data_db['content']['gfc_c']);
					$data_db['content']['gfc_ou_s'] = $this->m_base->get_field_where('sys_ou','ou_name', " AND ou_id ='{$data_db['content']['gfc_ou']}'");
					$data_db['content']['gfc_org_jia_s'] = $this->m_base->get_field_where('sys_org','o_name', " AND o_id ='{$data_db['content']['gfc_org_jia']}'");
					$data_db['content']['gfc_org_s'] = $this->m_base->get_field_where('sys_org','o_name', " AND o_id ='{$data_db['content']['gfc_org']}'");
					$data_db['content']['gfc_c_jia_tel'] =  $this->m_base->get_field_where('sys_contact','c_tel'," AND c_id = '{$data_db['content']['gfc_c_jia']}'");
					$data_db['content']['gfc_c_jia'] = $this->m_base->get_c_show_by_cid($data_db['content']['gfc_c_jia']);
					
					$data_db['content']['gfc_category_main'] = element($data_db['content']['gfc_category_main'],$GLOBALS['m_gfc']['text']['gfc_category_main']);
					$data_db['content']['gfc_category_tiaoxian_main'] =  element($data_db['content']['gfc_category_tiaoxian_main'],$GLOBALS['m_gfc']['text']['gfc_category_tiaoxian_main']);
					$data_db['content']['gfc_category_tiaoxian'] =  element($data_db['content']['gfc_category_tiaoxian'],$GLOBALS['m_gfc']['text']['gfc_category_tiaoxian']);
					$data_db['content']['gfc_category_extra'] =  element($data_db['content']['gfc_category_extra'],$GLOBALS['m_gfc']['text']['gfc_category_extra']);
					$data_db['content']['gfc_category_statistic'] =  element($data_db['content']['gfc_category_statistic'],$GLOBALS['m_gfc']['text']['gfc_category_statistic']);
					$data_db['content']['gfc_category_subc'] =  element($data_db['content']['gfc_category_subc'],$GLOBALS['m_budm']['text']['gfc_category_subc']);
					$data_db['content']['gfc_category_cooperation'] =  element($data_db['content']['gfc_category_cooperation'],$GLOBALS['m_base']['text']['base_yn']);
					$data_db['content']['gfc_category_contract'] =  element($data_db['content']['gfc_category_contract'],$GLOBALS['m_base']['text']['base_yn']);
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
			case GFCS_PPO_START:
				$data_out['ppo_btn_next']='提交';
				break;
			case GFCS_PPO_CHECK:
				$data_out['ppo_btn_next']='审核通过';
				break;
		}
				
		if( $data_get['act'] == STAT_ACT_EDIT 
		 && element('ppo', $data_db['content']) != GFCS_PPO_END )
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
		$title_field='-'.element('gfcs_name_tm',$data_db['content']);;
		
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
		if( element( 'ppo',$data_db['content']) == GFCS_PPO_START )
		{
			$data_out['op_disable'][]='btn_pnext';
		}
		
		if( element( 'ppo',$data_db['content']) != 1 )
		{
			$data_out['op_disable'][]='btn_del';
		}
		
		if( element( 'ppo',$data_db['content']) == GFCS_PPO_CHECK )
		{
			$data_out['field_view'][]='content[gfcs_c_check]';
		}
		
		if(element('flag_edit_more', $data_get))
		{
			$data_out['field_required']=array();
			
			$data_out['op_disable'][] = 'content[gfc_name]';
			
			$data_out['op_disable'][]='btn_log';
			$data_out['op_disable'][]='btn_del';
			
			$data_out['title'] = '批量编辑'.$this->title.'-请勾选要保存的字段';
		}
		elseif( element( 'ppo',$data_db['content']) == 0 )
		{
			$data_out['op_disable'][]='btn_next';
            $data_out['op_disable'][]='btn_pnext';
            
			$data_out['field_view'] = array_unique(array_merge($data_out['field_view'],$data_out['field_edit']));
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
					if( element('gfcs_category_secret', $data_post['content']) != GFC_CATEGORY_SECRET_FM )
					{
						$data_out['field_required'][] = 'content[gfcs_name_tm]';
					}
					
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
					
					if( element('gfcs_category_secret', $data_post['content']) != GFC_CATEGORY_SECRET_FM 
					 && element('gfcs_name_tm', $data_post['content']) == element('gfc_name', $data_db['content']) )
					{
						$rtn['err']['content[gfcs_name_tm]']='脱密名称不可与项目名称相同！';
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
				
				$wl_comment='';
				
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
				
				if( element('gfcs_category_secret', $data_save['content']) == GFC_CATEGORY_SECRET_FM )
				{
					$data_save['content']['gfcs_name_tm'] = '';
				}
				/************事件处理*****************/
				switch ($data_get['act']) {
					case STAT_ACT_CREATE:
						$rtn=$this->add($data_save['content']);
						
						//创建我的工单
	    				$data_save['wl']['wl_id'] = $rtn['id'];
	    				$data_save['wl']['wl_type'] = WL_TYPE_I;
	    				$data_save['wl']['wl_code']=$data_save['content']['gfcs_code'];
		    			$data_save['wl']['wl_op_table']='pm_gfc_secret';
		    			$data_save['wl']['wl_op_field']='gfcs_id';
		    			$data_save['wl']['op_id']=$rtn['id'];
	    				$data_save['wl']['p_id']=$this->proc_id;
	    				$data_save['wl']['pp_id']=$this->model_name;
	    				$data_save['wl']['wl_proc']=$data_save['content']['ppo'];
		    			$data_save['wl']['wl_url']=$this->url_conf.'/act/2';
		    			$data_save['wl']['wl_note']='【'.$this->title.'】'
		    				.',项目负责人:'.$data_save['content']['gfc_c_s']
    						.',项目脱密名称:'.$data_save['content']['gfcs_name_tm']
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
						
						//工单基本信息
						$data_save['wl']['wl_code']=$data_db['content']['gfcs_code'];
		    			$data_save['wl']['wl_op_table']='pm_gfc_secret';
		    			$data_save['wl']['wl_op_field']='gfcs_id';
		    			$data_save['wl']['op_id']=$data_save['content'][$this->pk_id];
	    				$data_save['wl']['p_id']=$this->proc_id;
	    				$data_save['wl']['pp_id']=$this->model_name;
		    			$data_save['wl']['wl_url']=$this->url_conf.'/act/2';
		    			$data_save['wl']['wl_proc']=$data_save['content']['ppo'];
		    			$data_save['wl']['wl_time_end']=date('Y-m-d H:i:s',strtotime('+30 day'));
		    			$data_save['wl']['c_accept'] = array();
		    			$data_save['wl']['wl_note']='【'.$this->title.'】'
		    				.',项目负责人:'.$data_save['content']['gfc_c_s']
    						.',项目脱密名称:'.$data_save['content']['gfcs_name_tm']
		    				;
						
		    			//工单流转
						$flag_wl_combine_finish=TRUE;//联合工单通过标记
						$c_accept=array();
						
						switch (element('ppo',$data_db['content']))
						{
							case GFCS_PPO_START:
								
								if($btn == 'next')
								{
									$data_save['content']['ppo'] = GFCS_PPO_CHECK;
									
									$data_save['wl']['wl_event']='审核';
									
									//添加流程接收人
	    							$c_accept[] = $data_save['content']['gfcs_c_check'];
								}
								
								$data_save['wl']['c_accept']=$c_accept;
								
								break;
								
							case GFCS_PPO_CHECK:
								
								if($btn == 'next')
								{
									$data_save['content']['ppo'] = GFCS_PPO_END;
									
									if( $data_save['content']['gfcs_category_secret'] != GFC_CATEGORY_SECRET_FM )
									{
										$data_save['content_gfc']['gfc_name'] = $data_save['content']['gfcs_name_tm'];
										//删除所有关联文件
										$this->m_file->del_link_file($data_save['content']['gfc_id'],'pm_given_financial_code','gfc_id');
									}
								}
								elseif($btn == 'pnext')
								{
									$data_save['content']['ppo'] = GFCS_PPO_START;
									
									$data_save['wl']['wl_event']='修改单据';
												
									$c_accept = array();
									
									$c_accept[] = $data_db['content']['gfc_c'];
									$c_accept[] = $data_db['content']['db_person_create'];
									
								}
								
								$data_save['wl']['c_accept']=$c_accept;
								
								break;
								
						}
						
						$data_save['content_gfc']['gfc_name_tm'] = $data_save['content']['gfcs_name_tm'];
						$data_save['content_gfc']['gfc_category_secret'] = $data_save['content']['gfcs_category_secret'];
						
						$rtn=$this->update($data_save['content']);
						
						$data_save['content_gfc']['gfc_id'] = $data_save['content']['gfc_id'];
						$this->m_gfc->update($data_save['content_gfc']);
						
						//工单日志
						if( $btn == 'yj' )
						{
							$data_save['content_log']['log_note']=
						'【'.$this->sess->userdata('c_name').'['.$this->sess->userdata('a_login_id').']】'
						.'于节点【'.$GLOBALS['m_gfc_secret']['text']['ppo'][$data_db['content']['ppo']].'】'
						.',将【'.$this->title.'】移交于【'.$data_post['content']['person_yj_s'].'】';
						
							$data_save['wl']['wl_type']=WL_TYPE_YJ;
							$data_save['wl']['wl_event']=element('wl_list_to_do', $data_out);
							$data_save['wl']['c_accept'][]=$data_post['content']['person_yj'];
							
						}
						if( $btn == 'next' || $btn == 'pnext' )
						{
								$data_save['content_log']['log_note']=
						'于节点【'.$GLOBALS['m_gfc_secret']['text']['ppo'][$data_db['content']['ppo']].'】'.$ppo_btn_text
						.',流转至节点【'.$GLOBALS['m_gfc_secret']['text']['ppo'][$data_save['content']['ppo']].'】';
						}
						
						//工单更新
						switch ($btn)
						{
							case 'next':
								$data_save['wl_have_do']['wl_result']=WL_RESULT_SUCCESS;
							case 'pnext':
								
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
								
								if($data_save['content']['ppo'] == 0)
								{
									$data_save['wl_i']['wl_status']=WL_STATUS_FINISH;
									$data_save['wl_i']['wl_result']=WL_RESULT_SUCCESS;
									$data_save['wl_i']['wl_person_do'] = $this->sess->userdata('c_id');
    								$data_save['wl_i']['wl_time_do'] = date('Y-m-d H:i:s');
								}
								
								$this->m_work_list->update_wl_i(element($this->pk_id,$data_get),$this->model_name,$data_save['wl_i']);
								
								$data_save['wl']['wl_comment_new'] = 
								'<p>'.date("Y-m-d H:i:s").' '.$this->sess->userdata('c_name').'['.$this->sess->userdata('a_login_id').']</p>'
								.'<p>'.$data_save['content_log']['log_note'].'</p>';
								
								if( ! empty($wl_comment) )
								$data_save['wl']['wl_comment_new'] = '<p>'.$wl_comment.'</p>';
								
								if($data_save['content']['ppo'] != GFCS_PPO_END)
								$this->m_work_list->add($data_save['wl']);
								
								//获取工单关注人与所有人
								$arr_wl_person = $this->m_work_list->get_wl_care_accept(element($this->pk_id,$data_get),$this->model_name);
								
								$rtn['wl_end'] = array();
								$rtn['wl_accept'] = $data_save['wl']['c_accept'];
								$rtn['wl_accept'][] = $this->sess->userdata('c_id');
								
								if( count( element('arr_wl_accept', $data_out)) > 0 )
								$rtn['wl_accept'] =array_values(array_merge($rtn['wl_accept'],$data_out['arr_wl_accept']));
								
								$rtn['wl_care'] = $arr_wl_person['care'];
								$rtn['wl_i'] = $arr_wl_person['accept'];
								$rtn['wl_op_id'] = element($this->pk_id,$data_get);
								$rtn['wl_pp_id'] = $this->model_name;
								$rtn['wl_accept'] =array_unique($rtn['wl_accept']);
								
								if($data_save['content']['ppo'] == 0)
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
				
				$data_save['content_gfc']['gfc_category_secret'] = GFC_CATEGORY_SECRET_FM;
				$data_save['content_gfc']['gfc_name_tm'] = '';
				$data_save['content_gfc']['gfc_id'] = $data_save['content']['gfc_id'];
				$this->m_gfc->update($data_save['content_gfc']);
				
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
	    $data_out['code']=element('gfcs_code', $data_db['content']);
	    
	    $data_out['ppo']=element('ppo', $data_db['content']);
	    
	    $data_out['ppo_name'] = '';
	    $data_out['ppo_name']=$GLOBALS['m_gfc_secret']['text']['ppo'][element('ppo', $data_db['content'])];
	    
	    $data_out['fun_no_db']=element('fun_no_db', $data_get);
	    $data_out['data_db_post'] = $this->input->post('data_db');
	    
	    $data_out['flag_edit_more']=element('flag_edit_more', $data_get);
	    
	    $data_out[$this->pk_id]=element($this->pk_id,$data_get);
	    
	    $data_out['data']=array();
	    
		if( count($data_out['field_out'])>0)
		{
			foreach ($data_out['field_out'] as $k=>$v) {
				$arr_f = split_table_field($v);
				
				$data_out['data'][$v] = element($arr_f['field'], $data_db['content'],'');
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
	 * 根据财务编号创建标密申请
	 * @param $arr 包含gfc_id,gfc_name_tm,gfc_category_secret,gfcs_c_check的数组
	 */
	public function create_default_by_gfc($arr)
	{
		/************模型载入*****************/
		/************变量初始化****************/
		$data_save=array();//
		$rtn=array();//结果
		$rtn['rtn']=TRUE;
		$where='';
		/************数据处理*****************/
		
		if( ! element('gfc_id', $arr) ) {
			$rtn['rtn']=FALSE;
			return $rtn['rtn'];
		}
		
		$data_db['content'] = $this->get_of_gfc($arr['gfc_id']);
		
		if( element('gfcs_id', $data_db['content']))
		{
			$rtn['rtn']=FALSE;
			return $rtn['rtn'];
		}
		
		$data_save['content']['gfc_id'] = $arr['gfc_id'];
		$data_save['content']['gfcs_category_secret'] = $arr['gfc_category_secret'];
		$data_save['content']['gfcs_name_tm'] = $arr['gfc_name_tm'];
		if( !  $arr['gfc_name_tm'] )
		$data_save['content']['gfcs_name_tm'] = $arr['gfc_name'];
		
		$data_save['content']['gfcs_c_check'] = $arr['gfcs_c_check'];
		$data_save['content']['gfc_c'] = $arr['gfc_c'];
		$data_save['content']['gfc_c_s'] = $this->m_base->get_c_show_by_cid($arr['gfc_c']);
		$data_save['content']['gfc_org'] = $arr['gfc_org'];
		 
		$data_save['content']['gfcs_code'] = $this->get_code($data_save);
		
		$data_save['content']['ppo']=GFCS_PPO_CHECK;

		$rtn=$this->add($data_save['content']);
		
		$data_save['content_log']['log_note']='【'.$data_save['content']['gfc_c_s'].'】于【财务编号】，创建【标密申请】,流转至【审核】';

		//创建我的工单
    	$data_save['wl']['wl_id'] = $rtn['id'];
    	$data_save['wl']['wl_type'] = WL_TYPE_I;
    	$data_save['wl']['wl_code']=$data_save['content']['gfcs_code'];
    	$data_save['wl']['wl_op_table']='pm_gfc_secret';
    	$data_save['wl']['wl_op_field']='gfcs_id';
    	$data_save['wl']['op_id']=$rtn['id'];
    	$data_save['wl']['p_id']=$this->proc_id;
    	$data_save['wl']['pp_id']=$this->model_name;
    	$data_save['wl']['wl_proc']=$data_save['content']['ppo'];
    	$data_save['wl']['wl_url']=$this->url_conf.'/act/2';
    	$data_save['wl']['wl_note']='【'.$this->title.'】'
    		.',项目负责人:'.$data_save['content']['gfc_c_s']
    		.',项目脱密名称:'.$data_save['content']['gfcs_name_tm']
    		;
    		
    	//更新我的工单
		$data_save['wl']['wl_log_note']=$data_save['content_log']['log_note'];
    	$data_save['wl']['c_accept'][] = $this->sess->userdata('c_id');
		$data_save['wl']['c_accept'][] = $data_save['content']['gfc_c'];
		
    	$this->m_work_list->add($data_save['wl']);
    	
    	$data_save['wl']['wl_id']=get_guid();
    	$data_save['wl']['wl_type'] = 0 ;
    	$data_save['wl']['wl_event']='标密申请';
    	$data_save['wl']['ppo'] = 1;
    	$data_save['wl']['wl_status']=WL_STATUS_FINISH;
		$data_save['wl']['wl_result']=WL_RESULT_SUCCESS;
		$data_save['wl']['wl_person_do'] = $this->sess->userdata('c_id');
    	$data_save['wl']['wl_time_do'] = date('Y-m-d H:i:s');
    	
    	$this->m_work_list->add($data_save['wl']);
    	
    	//工单基本信息
    	$data_save['wl']=array();
		$data_save['wl']['wl_code']=$data_save['content']['gfcs_code'];
    	$data_save['wl']['wl_op_table']='pm_gfc_secret';
    	$data_save['wl']['wl_op_field']='gfcs_id';
    	$data_save['wl']['op_id']=$rtn['id'];
    	$data_save['wl']['p_id']=$this->proc_id;
    	$data_save['wl']['pp_id']=$this->model_name;
    	$data_save['wl']['wl_proc']=$data_save['content']['ppo'];
    	$data_save['wl']['wl_url']=$this->url_conf.'/act/2';
    	$data_save['wl']['wl_proc']=$data_save['content']['ppo'];
    	$data_save['wl']['wl_time_end']=date('Y-m-d H:i:s',strtotime('+30 day'));
    	$data_save['wl']['c_accept'] = array();
    	$data_save['wl']['c_accept'][] =  $data_save['content']['gfcs_c_check'];
    	$data_save['wl']['wl_note']='【'.$this->title.'】'
    		.',项目负责人:'.$data_save['content']['gfc_c_s']
    		.',项目脱密名称:'.$data_save['content']['gfcs_name_tm']
    		;
    		
    	$data_save['wl']['wl_event']='标密申请审核';

    	$rtn['c_accept'] = $data_save['wl']['c_accept'];
        $this->m_work_list->add($data_save['wl']);
    	
		$arr_log_content=array();
		$arr_log_content['new']['content']=$data_save['content'];
		$arr_log_content['old']['content'][$this->pk_id] = $rtn['id'];

		//操作日志
		$data_save['content_log']['op_id']=$rtn['id'];
		$data_save['content_log']['log_act']=STAT_ACT_CREATE;
		$data_save['content_log']['log_url']=$this->url_conf.'/'.$this->pk_id.'/'.$rtn['id'];
		$data_save['content_log']['log_content']=json_encode($arr_log_content);
		$data_save['content_log']['log_module']=$this->title;
		$data_save['content_log']['log_p_id']=$this->proc_id;
		
		$this->m_log_operate->add($data_save['content_log']);
		
		return $rtn;
	}
	
	/**
	 * 
	 * 查询标密申请审批人
	 * @param unknown_type $a
	 */
	function search_gfcs_c_check($arr_search)
	{
		
		$arr_c_id = $this->m_acl->get_acl_person($this->proc_id,ACL_PROC_GFC_SECRET);
		
		if( count($arr_c_id) > 0)
		{
			$arr_search['where'].= ' AND c_id IN ?';
			$arr_search['value'][] = $arr_c_id;
		}
		else 
		{
			$arr_search['where'].= ' AND 1 != 1 ';
		}
		
		return $arr_search;
	}
}