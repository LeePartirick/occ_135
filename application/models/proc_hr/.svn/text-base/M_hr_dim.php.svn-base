<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 *
员工离职
 */
class M_hr_dim extends CI_Model {

	//@todo 主表配置
	private $table_name='hr_dim';
	private $pk_id='dim_id';
	private $table_form;
	private $title='员工离职';
	private $model_name = 'm_hr_dim';
	private $url_conf = 'proc_hr/hr_dim/edit';
	private $proc_id = 'proc_hr';

	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
		$this->m_define();

		//读取表结构
		$this->config->load('db_table/'.$this->table_name, FALSE,TRUE);
		$this->table_form=$this->config->item($this->table_name);

        $this->load->model('proc_hr/m_hr');
	}

	/**
	 *
	 * 定义
	 */
	public function m_define()
	{
		//@todo 定义
		if( defined('LOAD_M_HR_DIM') ) return;
		define('LOAD_M_HR_DIM', 1);

		//define

		// 节点
		define('HR_DIM_PPO_END', 0); // 流程结束
		define('HR_DIM_PPO_START', 1); // 起始
		define('HR_DIM_PPO_FH', 2); // 复核
		define('HR_DIM_PPO_SH', 3); // 审核

		$GLOBALS['m_hr_dim']['text']['ppo']=array(
			HR_DIM_PPO_START=>'起始',
			HR_DIM_PPO_FH=>'复核',
			HR_DIM_PPO_SH=>'审核',
			HR_DIM_PPO_END=>'流程结束',
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
			$acl_list= $this->m_proc_hr->get_acl();

		$msg='';
		/************权限验证*****************/

		//如果有超级权限，TRUE
		if( ($acl_list & pow(2,ACL_PROC_HR_SUPER)) != 0 )
		{
			return TRUE;
		}

		$check_acl=FALSE;

		//复核节点
		if( ! $check_acl
			&& element('ppo',$data_db['content']) == HR_DIM_PPO_FH
			&& $act == STAT_ACT_EDIT
		)
		{
			if( ($acl_list & pow(2,ACL_PROC_HR_DIM_FCHECK)) == 0 )
			{
				$url=current_url();
				$url=str_replace('/act/2','/act/3',$url);
				redirect($url);
			}

			if( element('c_org', $data_db['content']) == $this->sess->userdata('c_org')
				|| element('c_hr_org', $data_db['content']) == $this->sess->userdata('c_org') )
				$check_acl=TRUE;
		}

		//审核节点
		if( ! $check_acl
			&& element('ppo',$data_db['content']) == HR_DIM_PPO_SH
			&& $act == STAT_ACT_EDIT
		)
		{
			if( ($acl_list & pow(2,ACL_PROC_HR_DIM_CHECK)) == 0 )
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
			&& ($acl_list & pow(2,ACL_PROC_HR_USER)) != 0
		)
		{
			$check_acl=TRUE;

			if( element('c_org',$data_db['content'])
				&& ( element('c_org',$data_db['content']) != $this->sess->userdata('c_org') )
				&& ( element('c_hr_org',$data_db['content']) != $this->sess->userdata('c_org') )
			)
			{
				$msg = '您不是该单据的相关人,不可进行操作！' ;
				$check_acl = FALSE;
			}
		}

		if( ! $check_acl )
		{
			if( ! $msg )
				$msg = '您没有【人事管理】的【操作】权限不可进行操作！' ;

			redirect('base/main/show_err/msg/'.fun_urlencode($msg));
		}
	}

	/**
	 *获取单据编号
	 */
	public function get_code($data_save=array())
	{
		$where='';

		$pre = $this->m_base->get_field_where('sys_ou','ou_org_pre'," AND ou_id ='{$data_save['content']['c_hr_org']}'");

		$pre_ou = $this->m_base->get_field_where('sys_ou','ou_org_pre'," AND ou_id ='{$data_save['content']['c_ou_2']}'");
    	if($pre_ou) $pre = $pre_ou;
    	
		$pre.='-DIM'.date("Ym");
		$where .= " AND dim_code LIKE  '{$pre}%'";

		$max_code=$this->m_db->get_m_value('hr_dim','dim_code',$where);
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
		$arr_link=array();

		if(count($arr_link) > 0)
		{
			foreach ($arr_link as $v ) {
				$arr_tmp = explode('.', $v);
				$field=$this->m_base->get_field_where($arr_tmp[0],$arr_tmp[1]," AND {$arr_tmp[1]} = '{$id}' ");
				if($field)
				{
					$rtn['rtn'] = FALSE;
					$rtn['err']['msg'] = '于【'.$arr_tmp[0].'】存在关联数据,不可删除!';
					return $rtn;
				}
			}
		}
		
		$data_db['content'] = $this->get($id);

		$this->db->trans_begin();

		if($rtn['rtn'])
			$rtn=$this->m_db->delete($this->table_name,$where);
			
		if( $data_db['content']['ppo'] != 0 && $data_db['content']['ppo'] > 1 )
		{
			$data_save['content_hr'] = array();
			$data_save['content_hr']['c_id'] = $data_db['content']['c_id'];
			$data_save['content_hr']['hr_dim_porc'] = 0;
			
			$this->m_table_op->load('hr_info');
            $this->m_table_op->update($data_save['content_hr']);
		}

		if( ! $rtn['rtn'] )
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
			
			//取消工单信息
			$this->m_work_list->cancel_wl($id,$this->model_name);
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
			'hr_dim[dim_date]',
			'hr_dim[dim_cause]',
			'hr_dim[dim_note]',
		);

		$conf['field_required']=array(
			'hr_dim[dim_date]'
		);

		$conf['field_define']=array(
		);

		$conf['table_form']=array(
			'hr_dim'=>$this->table_form
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
			'content[dim_date]',
            'content[c_id]',
            'content[c_id_s]',
		);

		//编辑数组
		$data_out['field_edit']=array(
			'content[db_time_update]',
            'content[c_id]',
            'content[c_id_s]',
			'content[dim_date]',
			'content[dim_hr_type]',
            'content[dim_cause]',
            'content[dim_note]',
		);

		//只读数组
		$data_out['field_view']=array(
			'content[c_hr_org_s]',
            'content[c_org_s]',
            'content[c_ou_2_s]',
            'content[c_ou_3_s]',
            'content[c_ou_4_s]',
            'content[c_job_s]',
            'content[c_tel]',
            'content[c_tel_code]',
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
		$data_out['json_field_define']['hr_type']=get_html_json_for_arr($GLOBALS['m_hr']['text']['hr_type']);
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
						
						$this->m_table_op->load('sys_contact');
                        $data_db['content_c'] =  $this->m_table_op->get($data_db['content']['c_id']);

					    $data_db['content']= array_merge($data_db['content_c'],$data_db['content']);
						 
						$data_db['wl_list']=$this->m_work_list->get_wl_to_do(element($this->pk_id,$data_get),$this->model_name);

                        $data_db['content']['c_id_s']=$data_db['content']['c_name'].'['.$data_db['content']['c_login_id'].']';
                        
                        if( ! empty($data_db['content']['c_org']) )
                            $data_db['content']['c_org_s']=$this->m_base->get_field_where('sys_org','o_name'," AND o_id = '{$data_db['content']['c_org']}'");

                        if( ! empty($data_db['content']['c_hr_org']) )
                            $data_db['content']['c_hr_org_s']=$this->m_base->get_field_where('sys_org','o_name'," AND o_id = '{$data_db['content']['c_hr_org']}'");

                        if( ! empty($data_db['content']['c_ou_2']) )
                            $data_db['content']['c_ou_2_s']=$this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id = '{$data_db['content']['c_ou_2']}'");

                        if( ! empty($data_db['content']['c_ou_3']) )
                            $data_db['content']['c_ou_3_s']=$this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id = '{$data_db['content']['c_ou_3']}'");

                        if( ! empty($data_db['content']['c_ou_4']) )
                            $data_db['content']['c_ou_4_s']=$this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id = '{$data_db['content']['c_ou_4']}'");

                        if( ! empty($data_db['content']['c_job']) )
                            $data_db['content']['c_job_s']=$this->m_base->get_field_where('hr_job','job_name'," AND job_id = '{$data_db['content']['c_job']}'");
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
			case HR_DIM_PPO_START:
				$data_out['ppo_btn_next']='提交';
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
		$acl_list= $this->m_proc_hr->get_acl();

		if( ! empty (element('acl_wl_yj', $data_out)) )
			$acl_list= $acl_list | $data_out['acl_wl_yj'];

		$this->check_acl($data_db,$acl_list);

		/************显示配置*****************/
		//@todo 显示配置
		$title_field='-'.element('c_id_s',$data_db['content']);

		switch ($data_get['act']) {
			case STAT_ACT_CREATE:
				$data_out['title']='创建'.$this->title;

				$data_out['op_disable'][]='btn_del';
				$data_out['op_disable'][]='btn_log';

				$data_out['op_disable'][]='btn_next';
				$data_out['op_disable'][]='btn_pnext';

				$data_out['op_disable'][]='btn_wl';
				$data_out['op_disable'][]='btn_im';
				
				$data_out['op_disable'][]='title_info';

				//创建默认值
//				$data_db['content']['c_hr_org'] = $data_db['content']['c_org']=$this->sess->userdata('c_org') ;
				$data_db['content']['ppo']=HR_DIM_PPO_START;
                $data_db['content']['dim_date']=date('Y-m-d');
				$data_db['content']['dim_hr_type'] = HR_TYPE_LZ;
				
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
				
				 $data_out['field_view'][]='content[c_id_s]';

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
		if( element( 'ppo',$data_db['content']) == 1 )
		{
			$data_out['op_disable'][]='btn_pnext';
		}

		if( element( 'ppo',$data_db['content']) != 1 )
		{
			$data_out['op_disable'][]='btn_del';
		}
		
		if( element( 'ppo',$data_db['content']) != 0 
		 && element( 'ppo',$data_db['content']) < HR_DIM_PPO_SH )
		{
			$data_out['op_disable'][]='content[dim_hr_type]';
		}
			
		if( $data_get['act'] == STAT_ACT_EDIT
		&& element( 'ppo',$data_db['content']) == 0
		&& ($acl_list & pow(2,ACL_PROC_HR_SUPER) ) == 0 )
		{
			$data_out['op_disable'][]='btn_save';
			$data_out['op_disable'][]='btn_del';

			$data_out['op_disable'][]='btn_next';
			$data_out['op_disable'][]='btn_pnext';

			$data_out['field_view']=array_unique(array_merge($data_out['field_view'],$data_out['field_edit']));
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

                    //判断注销流程是否走完 测试暂时注销
                    if( $btn == 'next'
                     && element('ppo', $data_db['content']) == HR_DIM_PPO_SH)
                    {
                        $check_logout = $this->m_base->get_field_where('oa_office_logout','ppo'," AND offl_link_id = '{$data_db['content']['dim_id']}' ");
                        if($check_logout != 0)
                        {
                            $rtn['err']['content[c_id_s]']='【信息系统-注销】流程未结束，不可【通过】！';
                            $check_data=FALSE;
                        }
                    }
                    
					 //判断离职人员是否已发起离职申请
	                if( ! empty(element('c_id',$data_post['content']))){
	                	
	                	$arr_search=array();
	                	$arr_search['field']='*';
	                	$arr_search['from']='hr_dim';
	                	$arr_search['where']=" AND c_id= ? AND ppo != '0' AND dim_id != ? ";
	                	$arr_search['value'][]=element('c_id',$data_post['content']);
	                	$arr_search['value'][]=element('dim_id', $data_get,'');
	                	$rs=$this->m_db->query($arr_search);
	                	
	                	if( $rs['total'] != 0 ){
	                	    $check_data = FALSE;
	                	    $rtn['err']['content[c_id_s]']='已存在离职流程，不能重复创建！';
	                	}
	                	
	                	$c_type = $this->m_base->get_field_where('hr_info','hr_type'," AND c_id = '{$data_post['content']['c_id']}'");
	                	
	                	switch ($c_type)
	                	{
	                		case HR_TYPE_LZ:
	                		case HR_TYPE_TX:
	                			
	                			$check_data = FALSE;
	                	    	$rtn['err']['content[c_id_s]']='人员已离职！不可创建离职流程！';
	                	    
	                			break;
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

						$data_save['content']['c_hr_org'] = $this->m_base->get_field_where('sys_contact','c_org'," AND c_id = '{$data_save['content']['c_id']}'");
						$data_save['content']['c_ou_2'] = $this->m_base->get_field_where('sys_contact','c_ou_2'," AND c_id = '{$data_save['content']['c_id']}'");
						$data_save['content']['dim_code']=$this->get_code($data_save);
						$data_save['content']['ppo']=HR_DIM_PPO_START;

						$rtn=$this->add($data_save['content']);

						//创建我的工单
						$data_save['wl']['wl_id'] = $rtn['id'];
						$data_save['wl']['wl_type'] = WL_TYPE_I;
						$data_save['wl']['wl_code']=$data_save['content']['dim_code'];
						$data_save['wl']['wl_op_table']='hr_dim';
						$data_save['wl']['wl_op_field']='dim_id';
						$data_save['wl']['op_id']=$rtn['id'];
						$data_save['wl']['p_id']=$this->proc_id;
						$data_save['wl']['pp_id']=$this->model_name;
						$data_save['wl']['wl_proc']=$data_save['content']['ppo'];
						$data_save['wl']['wl_url']=$this->url_conf.'/act/2';
						$data_save['wl']['wl_note']='【'.$this->title.'】'
							.','.$data_save['content']['c_id_s']
							.','.$data_save['content']['dim_date']
							.','.$data_save['content']['dim_cause']
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
						$data_save['wl']['wl_code']=$data_db['content']['dim_code'];
						$data_save['wl']['wl_op_table']='hr_dim';
						$data_save['wl']['wl_op_field']='dim_id';
						$data_save['wl']['op_id']=$data_save['content'][$this->pk_id];
						$data_save['wl']['p_id']=$this->proc_id;
						$data_save['wl']['pp_id']=$this->model_name;
						$data_save['wl']['wl_url']=$this->url_conf.'/act/2';
						$data_save['wl']['wl_proc']=$data_save['content']['ppo'];
						$data_save['wl']['wl_time_end']=date('Y-m-d H:i:s',strtotime('+30 day'));
						$data_save['wl']['c_accept'] = array();
						$data_save['wl']['wl_note']='【'.$this->title.'】'
							.','.$data_save['content']['c_id_s']
							.','.$data_save['content']['dim_date']
							.','.$data_save['content']['dim_cause']
						;

						//工单流转
						switch (element('ppo',$data_db['content']))
						{
							case HR_DIM_PPO_START:

								if($btn == 'next')
								{
									$data_save['content']['ppo'] = HR_DIM_PPO_FH;

									$data_save['wl']['wl_event']='复核单据';
									
									$data_save['content_hr'] = array();
									$data_save['content_hr']['c_id'] = $data_save['content']['c_id'];
									$data_save['content_hr']['hr_dim_porc'] = 1;
									
									$this->m_table_op->load('hr_info');
                                    $this->m_table_op->update($data_save['content_hr']);

									//添加流程接收人
									$c_accept=$this->m_acl->get_acl_person($this->proc_id,ACL_PROC_HR_DIM_FCHECK);
									
									if( count($c_accept) > 0)
	    							{
		    							$arr_v=array();
		    							$arr_v[]=$data_db['content']['c_org'];
		    							$arr_v[]=$c_accept;
		    							$c_accept=$this->m_base->get_field_where('sys_contact','c_id'
		    							,"AND c_org = ? AND c_id IN ? ",$arr_v,1);
	    							}

									$data_save['wl']['c_accept']=$c_accept;

								}

								break;
							case HR_DIM_PPO_FH:

								if($btn == 'next')
								{
									$data_save['content']['ppo'] = HR_DIM_PPO_SH;

									$data_save['wl']['wl_event']='审核单据';

									//添加流程接收人
									$c_accept=$this->m_acl->get_acl_person($this->proc_id,ACL_PROC_HR_DIM_CHECK);
									$data_save['wl']['c_accept']=$c_accept;
									
                                    //创建信息系统申请
                                    $this->load->model('proc_office/m_office_logout');
                                    $rtn_office_logout=$this->m_office_logout->create_default_by_hr($data_save['content']);
								}
								elseif($btn == 'pnext')
								{
									$data_save['content']['ppo'] = HR_DIM_PPO_START;

									$data_save['wl']['wl_event']='修改单据';
									$data_save['wl']['c_accept'][] = $data_db['content']['db_person_create'];
								}

								break;
							case HR_DIM_PPO_SH:

								if($btn == 'next')
								{
									$data_save['content']['ppo'] = HR_DIM_PPO_END;
									
									$data_save['content_hr'] = array();
									$data_save['content_hr']['c_id'] = $data_save['content']['c_id'];
									$data_save['content_hr']['hr_time_lz'] = $data_save['content']['dim_date'];
									$data_save['content_hr']['hr_type'] = $data_save['content']['dim_hr_type'];
									$data_save['content_hr']['hr_dim_porc'] = 0;
									
									$this->m_table_op->load('hr_info');
                                    $this->m_table_op->update($data_save['content_hr']);

								}
								elseif($btn == 'pnext')
								{
									$data_save['content']['ppo'] = HR_DIM_PPO_START;

									//取消信息系统注销申请
									$offl_id = $this->m_base->get_field_where('oa_office_logout','offl_id'," AND offl_link_id = '{$data_get['dim_id']}'");
									
									$arr_v=array();
	    							$arr_v[]=$offl_id;
									$data_save['wl']['c_accept'] = $this->m_base->get_field_where('sys_wl_person','wlp_person'
		    							,"AND wl_op_id = ? ",$arr_v,1);
		    							
                                    $this->load->model('proc_office/m_office_logout');
                                    $data_save['content']['offl_id'] = $offl_id;
                                    $this->m_office_logout->end_offl($data_save['content']);
                                    
									$data_save['wl']['wl_event']='修改单据';
									$data_save['wl']['c_accept'][] = $data_db['content']['db_person_create'];
								}

								break;

						}
						
						$rtn=$this->update($data_save['content']);
						
						if($btn == 'pnext')
						{
							$data_save['content_hr'] = array();
							$data_save['content_hr']['c_id'] = $data_save['content']['c_id'];
							$data_save['content_hr']['hr_dim_porc'] = 0;
							
							$this->m_table_op->load('hr_info');
                            $this->m_table_op->update($data_save['content_hr']);
						}

						//工单日志
						if( $btn == 'yj' )
						{
							$data_save['content_log']['log_note']=
								'【'.$this->sess->userdata('c_name').'['.$this->sess->userdata('a_login_id').']】'
								.'于节点【'.$GLOBALS['m_hr_dim']['text']['ppo'][$data_db['content']['ppo']].'】'
								.',将【'.$this->title.'】移交于【'.$data_post['content']['person_yj_s'].'】';

							$data_save['wl']['wl_type']=WL_TYPE_YJ;
							$data_save['wl']['wl_event']=element('wl_list_to_do', $data_out);
							$data_save['wl']['c_accept'][]=$data_post['content']['person_yj'];

						}
						elseif( $btn == 'next' || $btn == 'pnext' )
						{
							$data_save['content_log']['log_note']=
								'于节点【'.$GLOBALS['m_hr_dim']['text']['ppo'][$data_db['content']['ppo']].'】'.$ppo_btn_text
								.',流转至节点【'.$GLOBALS['m_hr_dim']['text']['ppo'][$data_save['content']['ppo']].'】';

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

								if($data_save['content']['ppo'] == HR_DIM_PPO_END)
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

								if($data_save['content']['ppo'] != HR_DIM_PPO_END)
									$this->m_work_list->add($data_save['wl']);

								//获取工单关注人与所有人
								$arr_wl_person = $this->m_work_list->get_wl_care_accept(element($this->pk_id,$data_get),$this->model_name);

								$rtn['wl_end'] = array();
								$rtn['wl_accept'] = $data_save['wl']['c_accept'];
								$rtn['wl_accept'][] = $this->sess->userdata('c_id');

                                if(isset($rtn_office_logout))
                                    $rtn['wl_accept']=array_values(array_merge($rtn['wl_accept'],$rtn_office_logout['c_accept']));

								if( count( element('arr_wl_accept', $data_out)) > 0 )
									$rtn['wl_accept'] = array_values(array_merge($rtn['wl_accept'],$data_out['arr_wl_accept']));

								$rtn['wl_accept'] =array_unique($rtn['wl_accept']);

								$rtn['wl_care'] = $arr_wl_person['care'];
								$rtn['wl_i'] = $arr_wl_person['accept'];
								$rtn['wl_op_id'] = element($this->pk_id,$data_get);
								$rtn['wl_pp_id'] = $this->model_name;

								if($data_save['content']['ppo'] == HR_DIM_PPO_END)
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
		$data_out['code']=element('dim_code', $data_db['content']);

		$data_out['ppo']=element('ppo', $data_db['content']);
		$data_out['ppo_name']=$GLOBALS['m_hr_dim']['text']['ppo'][element('ppo', $data_db['content'])];

		$data_out[$this->pk_id]=element($this->pk_id,$data_get);

		$data_out['data']=array();

        if( count($data_out['field_out'])>0)
        {
            foreach ($data_out['field_out'] as $k=>$v) {
                $arr_f = split_table_field($v);
                $data_out['data'][$v] = element($arr_f['field'], $data_db['content']);
            }
        }

		$data_out['data']=json_encode($data_out['data']);
		/************载入视图 *****************/
		$arr_view[]=$this->url_conf;
		$arr_view[]=$this->url_conf.'_js';

		$this->m_view->load_view($arr_view,$data_out);
	}
}