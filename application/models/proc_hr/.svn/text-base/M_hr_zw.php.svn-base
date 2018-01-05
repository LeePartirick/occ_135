<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 *
职位
 */
class M_hr_zw extends CI_Model {

	//@todo 主表配置
	private $table_name='hr_zw';
	private $pk_id='zw_id';
	private $table_form;
	private $title='职务管理';
	private $model_name = 'm_hr_zw';
	private $url_conf = 'proc_hr/hr_zw/edit';
	private $proc_id = 'proc_hr';

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
		//@todo 定义
		if( defined('LOAD_M_HR_ZW') ) return;
		define('LOAD_M_HR_ZW', 1);

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
    	$acl_list= $this->m_proc_hr->get_acl();
    	
    	$msg='';
    	/************权限验证*****************/
    	
    	//如果有超级权限，TRUE
    	if( ($acl_list & pow(2,ACL_PROC_HR_SUPER)) != 0 )
    	{
    		return TRUE;
    	}
    	
    	$check_acl=FALSE;
    	
    	if( ! $check_acl 
    	 && ($acl_list & pow(2,ACL_PROC_HR_USER)) != 0 
    	)
	    {
	     	$check_acl=TRUE;
	    }
	    
	    if( ! $check_acl )
	    {
			if( ! $msg )
			$msg = '您没有【人事管理】的【操作】权限不可进行操作！' ;
			
			redirect('base/main/show_err/msg/'.fun_urlencode($msg));
	    }
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
			'hr_zw[zw_name]',
			'hr_zw[zw_note]',
		);

		$conf['field_required']=array(
			'hr_zw[zw_name]',
		);

		$conf['field_define']=array(
		);

		$conf['table_form']=array(
			'hr_zw'=>$this->table_form
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
			'content[zw_name]',
		);

		//编辑数组
		$data_out['field_edit']=array(
			'content[db_time_update]',
			'content[zw_name]',
			'content[zw_note]',
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

		$flag_more=element('flag_more', $data_post);

		/************字段定义*****************/
		//@todo 字段定义
		$arr_field=array_unique(array_merge($data_out['field_edit'], $data_out['field_view']));

		$data_out['json_field_define']=array();

		/************数据读取*****************/
		$data_db['content']=array();

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


					}
				} catch (Exception $e) {
				}
				break;
		}
		/************权限验证*****************/
		//@todo 权限验证
		$acl_list= $this->m_proc_hr->get_acl();
		
		$this->check_acl($data_db,$acl_list);

		/************显示配置*****************/
		//@todo 显示配置
		$title_field='';

		switch ($data_get['act']) {
			case STAT_ACT_CREATE:
				$data_out['title']='创建'.$this->title;

				$data_out['op_disable'][]='btn_del';
				$data_out['op_disable'][]='btn_log';

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

				$data_out['field_view']=array_unique(array_merge($data_out['field_view'],$data_out['field_edit']));

				break;
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

					//验证唯一
					if( ! empty(element('zw_name',$data_post['content'])) )
					{
						$where_check=' AND zw_id != \''.element('zw_id',$data_db['content']).'\'';

						$check=$this->m_check->unique('hr_zw','zw_name',element('zw_name',$data_post['content']),$where_check);
						if( ! $check )
						{
							$rtn['err']['content[zw_name]']='职务【'.element('zw_name',$data_post['content']).'】已存在，不可重复创建！';
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

						$rtn=$this->add($data_save['content']);

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
		$data_out['fun_open']=element('fun_open', $data_get);
		$data_out['fun_open_id']=element('fun_open_id', $data_get);

		$data_out['log']=json_encode(element('log', $data_out));

		$data_out['log_time']=$this->input->post('log_time');
		$data_out['log_a_login_id']=$this->input->post('log_a_login_id');
		$data_out['log_c_name']=$this->input->post('log_c_name');
		$data_out['log_act']=$this->input->post('log_act');
		$data_out['log_note']=$this->input->post('log_note');

		$data_out['db_time_create']=element('db_time_create', $data_db['content']);
		$data_out['code']='';

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