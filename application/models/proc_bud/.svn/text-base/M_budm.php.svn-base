<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 *  
    预算表模板
 */
class M_budm extends CI_Model {
	
	//@todo 主表配置
	private $table_name='fm_bud_main';
	private $pk_id='budm_id';
	private $table_form;
	private $arr_table_form=array();
	private $title='预算表模型';
	private $model_name = 'm_budm';
	private $url_conf = 'proc_bud/budm/edit';
	private $proc_id = 'proc_bud';
	
 	public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->m_define();
        
         //读取表结构
        $this->config->load('db_table/'.$this->table_name, FALSE,TRUE);
        $this->table_form=$this->config->item($this->table_name);
        
        $this->load->model('proc_bud/m_budi');
    }
    
	/**
     * 
     * 定义
     */
	public function m_define()
    {
    	//@todo 定义
    	if( defined('LOAD_M_BUDM') ) return;
    	define('LOAD_M_BUDM', 1);
    	
    	//define
    	
    	//总分包
		define('BUDM_TYPE_SUBC_NO', 0);//无
		define('BUDM_TYPE_SUBC_YES', 1);//收取管理费
		define('BUDM_TYPE_SUBC_SUB', 2);//发送管理费
		
		$GLOBALS['m_budm']['text']['budm_type_subc'] = array(
			BUDM_TYPE_SUBC_NO=>'无',
			BUDM_TYPE_SUBC_YES=>'收取管理费',
			BUDM_TYPE_SUBC_SUB=>'支付管理费',
		);
		
		$GLOBALS['m_budm']['text']['gfc_category_subc'] = array(
			BUDM_TYPE_SUBC_NO=>'无',
			BUDM_TYPE_SUBC_YES=>'我方总包',
			BUDM_TYPE_SUBC_SUB=>'我方分包',
		);
		
		//预算表类型
		define('BUDM_TYPE_PM', 1);//
		define('BUDM_TYPE_OU', 2);//
		
		$GLOBALS['m_budm']['text']['budm_type'] = array(
			BUDM_TYPE_PM=>'项目预算表',
			BUDM_TYPE_OU=>'部门预算表',
		);
    	
    	//默认预算科目
		$GLOBALS['m_budm']['text']['data_budi']=array();
		
		//总分包
		$GLOBALS['m_budm']['text']['data_budi'][]=array(
			'budi_id'=>get_guid(),
			'budi_ou_show'=>'销售部门',
			'budi_sn'=>'1.0',
			'budi_name'=>'无',
			'budi_rate'=>100,
			'budi_css'=>'background-color:#FFFFE7',
			'budi_sum_notax_empty'=>'1'
		);
		
		//项目收入
		$GLOBALS['m_budm']['text']['data_budi'][]=array(
			'budi_id'=>get_guid(),
			'budi_ou_show'=>'销售部门',
			'budi_sn'=>'2.0',
			'budi_name'=>'项目收入(即"合同总额")小计',
			'budi_rate'=>100,
			'budi_css'=>'font-weight:bold;background-color:#FFFFE7',
			'budi_sum_notax_empty'=>'0',
		);
		
		$GLOBALS['m_budm']['text']['data_budi'][]=array(
			'budi_id'=>get_guid(),
			'budi_ou_show'=>'预算财务部',
			'budi_sn'=>'3.0',
			'budi_name'=>'请选择流转税',
			'budi_sum_edit'=>0,
			'budi_rate'=>100,
			'budi_css'=>'background-color:#E8EEF7',
			'budi_sum_notax_empty'=>'1'
		);
		
		$GLOBALS['m_budm']['text']['json_budi'] = json_encode($GLOBALS['m_budm']['text']['data_budi']);
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
    	$acl_list= $this->m_proc_bud->get_acl();

    	$msg='';
    	/************权限验证*****************/

    	//如果有超级权限，TRUE
    	if( ($acl_list & pow(2,ACL_PROC_BUD_SUPER)) != 0 )
    	{
    		return TRUE;
    	}

    	$check_acl=FALSE;

    	if( ! $check_acl
    	 && ($acl_list & pow(2,ACL_PROC_BUD_USER)) != 0
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
    	 
    	$pre='BUDM'.date("Ym");
    	$where .= " AND BUDM_code LIKE  '{$pre}%'";
    	
    	$max_code=$this->m_db->get_m_value('fm_bud_main','budm_code',$where);
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
        
        if($rtn['rtn'])
        $rtn=$this->m_db->delete('fm_bud_item',$where);
		
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
			'fm_bud_main[budm_name]',
			'fm_bud_main[budm_note]',
    	);
    	
    	$conf['field_required']=array(
			'fm_bud_main[budm_name]',
    	);
    	
    	$conf['field_define']=array(
    	);
    	
    	$conf['table_form']=array(
			'fm_bud_main'=>$this->table_form,
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
			'content[budm_name]',
			'content[budm_type]',
			'content[budm_tax_type]',
			'content[budi]',
		);
		
		//编辑数组
		$data_out['field_edit']=array(
			'content[db_time_update]',
			'content[budm_name]',
			'content[budm_type]',
			'content[budm_note]',
			'content[budm_count]',
			'content[budm_css]',
			'content[budm_tax_type]',
			'content[budi]',
		);
		
		//只读数组
		$data_out['field_view']=array();
		
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
		$data_out['json_field_define']['budm_type_subc'] = get_html_json_for_arr($GLOBALS['m_budm']['text']['budm_type_subc'] );
		$data_out['json_field_define']['budm_type'] = get_html_json_for_arr($GLOBALS['m_budm']['text']['budm_type'] );
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
										case 'budm_tax_type':
									
											$data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('tax_id',$v,element($k,$data_db['content']));
											$data_db['content'][$k] =$v ;
											break;
											
										case 'budi':
									
											$data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('budi_id',$v,element($k,$data_db['content']));
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
						
						$arr_search['field']='*';
						$arr_search['from']='fm_bud_item budi';
						$arr_search['where']=' AND budm_id = ? ';
						$arr_search['value'][]=element('budm_id',$data_get);
						$arr_search['sort']= 'budi_sn';
						$arr_search['order']= 'asc';
						
						$rs=$this->m_db->query($arr_search);
						
						$data_db['content']['budi']=json_encode($rs['content']);
						
						$arr_search = array();
						$arr_search['field']='tax_id,tax_sn,tax_no_new,t.t_id,t_name tax_name,tax_rate';
						$arr_search['from']='fm_bud_tax tax
											 LEFT JOIN fm_tax_type t ON
											 (t.t_id = tax.t_id)';
						$arr_search['where']=' AND budm_id = ? ';
						$arr_search['value'][]=element('budm_id',$data_get);
						$arr_search['sort']= 'tax_sn';
						$arr_search['order']= 'asc';
						
						$rs=$this->m_db->query($arr_search);
						
						$data_db['content']['budm_tax_type'] = array();
						
						//流转税
						if(count($rs['content'])>0)
						{
							foreach ($rs['content'] as $v) {
								$v['flag_no_del'] = $this->m_base->get_field_where('pm_given_financial_code','gfc_tax' ,"AND gfc_tax = '{$v['t_id']}'");
								$data_db['content']['budm_tax_type'][] = $v;
							}
						}
						
						$data_db['content']['budm_tax_type'] = json_encode($data_db['content']['budm_tax_type']);
					}
					
				} catch (Exception $e) {
				}
			break;
		}
		/************工单信息*****************/

		/************权限验证*****************/
		//@todo 权限验证
		$acl_list= $this->m_proc_bud->get_acl();

		$this->check_acl($data_db,$acl_list);
		
		/************显示配置*****************/
		//@todo 显示配置
		$title_field='-'.element('budm_name',$data_db['content']);;
		
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
				$data_db['content']['budi']=$GLOBALS['m_budm']['text']['json_budi'];
				$data_db['content']['budm_type']=BUDM_TYPE_PM;
				
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
		if(element('flag_edit_more', $data_get))
		{
			$data_out['field_required']=array();
			
			$data_out['op_disable'][] = 'content[budm_name]';
			$data_out['op_disable'][] = 'title_tax_type';
			$data_out['op_disable'][] = 'title_budi';
			
			$data_out['op_disable'][]='btn_log';
			$data_out['op_disable'][]='btn_del';
			
			$data_out['title'] = '批量编辑'.$this->title.'-请勾选要保存的字段';
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
				
				$rtn=array();//结果
				$check_data=TRUE;
				
				/************数据验证*****************/
				//@todo 数据验证
				if($btn == 'save')
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
				
				if( ! empty(element('budm_tax_type',$data_save['content'])) )
				{
					if( ! is_array(element('budm_tax_type',$data_save['content'])) )
					$arr_tmp = json_decode($data_save['content']['budm_tax_type'],TRUE);
					
					if(count($arr_tmp) > 0)
					{
						$i = 0;
						foreach ($arr_tmp as $k=>$v) {
							$arr_tmp[$k]['tax_sn'] = $i ;
							$i ++ ;
						}
						
						$data_save['content']['budm_tax_type']=json_encode($arr_tmp);
					}
				}
				
				/************事件处理*****************/
				switch ($data_get['act']) {
					case STAT_ACT_CREATE:
						$data_save['content']['budm_code']=$this->get_code($data_save['content']);
						$rtn=$this->add($data_save['content']);
						
						//预算表流转税
						if( ! empty(element('budm_tax_type',$data_save['content']) ) )
						{
							$arr_save=array(
								'budm_id' => $rtn['id'],
							);
							
							$this->m_base->save_datatable('fm_bud_tax',
							$data_save['content']['budm_tax_type'],
							array(),
							$arr_save);
						}
						
						//预算表模型明细
						if( ! empty(element('budi',$data_save['content']) ) )
						{
							$arr_save=array(
								'budm_id' => $rtn['id'],
							);
							
							$this->m_base->save_datatable('fm_bud_item',
							$data_save['content']['budi'],
							$data_db['content']['budi'],
							$arr_save,
							'm_budm',
							'save_budi');
						}
						
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
						
						$rtn=$this->update($data_save['content']);
						
						//预算表流转税
						if( ! empty(element('budm_tax_type',$data_save['content']) ) )
						{
							$arr_save=array(
								'budm_id' => element('budm_id',$data_get),
							);
							
							$this->m_base->save_datatable('fm_bud_tax',
							$data_save['content']['budm_tax_type'],
							$data_db['content']['budm_tax_type'],
							$arr_save);
						}
						
						//预算表模型明细
						if( ! empty(element('budi',$data_save['content']) ) )
						{
							$arr_save=array(
								'budm_id' => element('budm_id',$data_get),
							);
							
							$this->m_base->save_datatable('fm_bud_item',
							$data_save['content']['budi'],
							$data_db['content']['budi'],
							$arr_save,
							'm_budm',
							'save_budi');
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
	    $data_out['code']=element('budm_code', $data_db['content']);
	    
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
	
	/**
	 * 
	 * 预算表明细保存方法
	 * @param unknown_type $data_save
	 */
	function save_budi($arr_save)
	{
		switch($arr_save['budi_sn'])
		{
			case '1.0':
				$arr_save['budi_name'] = '无';
				break;
			case '3.0':
				$arr_save['budi_name'] = '';
				break;
		}
		
		return $arr_save;
	}
}