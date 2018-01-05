<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 *  
    经费申请
 */
class M_bl_ppo extends CI_Model {
	
	//@todo 主表配置
	private $table_name='fm_bl_ppo';
	private $pk_id='blp_id';
	private $table_form;
	private $arr_table_form=array();
	private $title='经费流程';
	private $model_name = 'm_bl_ppo';
	private $url_conf = 'proc_bud/bl_ppo/edit';
	private $proc_id = 'proc_bud';
	
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
    	if( defined('LOAD_M_BL_PPO') ) return;
    	define('LOAD_M_BL_PPO', 1);
    	
    	//define
    	
    	// 经费流程节点
        define('BLP_PPO_FH', 2); // 流程结束
        define('BLP_PPO_SH', 3); // 起始
        define('BLP_PPO_SP', 5); // 审核

        $GLOBALS['m_bl_ppo']['text']['blp_ppo']=array(
            BLP_PPO_FH=>'复核-部门',
            BLP_PPO_SH=>'审核-管理部门',
            BLP_PPO_SP=>'审批-总经理',
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
			$msg = '您没有【预算表管理】的【操作】权限不可进行操作！' ;
			
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
    		'fm_bl_ppo[blp_ppo]',
			'fm_bl_ppo[blp_sum_start]',
			'fm_bl_ppo[blp_sum_end]',
			'fm_bl_ppo[blp_sub]',
    		'fm_bl_ppo[blp_ou]',
    		'fm_bl_ppo[blp_org]',
    		'fm_bl_ppo[blp_c]',
    		'fm_bl_ppo[blp_note]',
    	);
    	
    	$conf['field_required']=array(
    	);
    	
    	$conf['field_define']=array(
    	);
    	
    	$conf['table_form']=array(
    		'fm_bl_ppo'=>$this->table_form
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
			'content[blp_ppo]',
			'content[blp_ppo_num]',
			'content[blp_sum_start]',
			'content[blp_sub_s]',
			'content[blp_sub]',
			'content[blp_c]',
		);
		
		//编辑数组
		$data_out['field_edit']=array(
            'content[db_time_update]',
		
			'content[blp_ppo]',
			'content[blp_ppo_num]',
			'content[blp_sum_start]',
			'content[blp_sum_end]',
			'content[blp_sub_s]',
			'content[blp_sub]',
			'content[blp_ou_data]',
			'content[blp_ou]',
			'content[blp_c_data]',
			'content[blp_c]',
			'content[blp_note]',
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
		$data_out['json_field_define']['blp_ppo']=get_html_json_for_arr($GLOBALS['m_bl_ppo']['text']['blp_ppo']);
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
                                if( is_array($v) ) {
                                    $v = implode(',', $v);

                                    if(element($k,$data_db['content']))
                                        $data_db['content'][$k] = implode(',', $data_db['content'][$k]);
                                }

								if( $v != element($k,$data_db['content']) )
								{
									switch ($k)
									{
										case 'blp_ou':
										case 'blp_c':
											
											$diff='';
											
											$arr_f=array();
											if( $data_db['content'][$k.'_data'] )
											$arr_f = json_decode($data_db['content'][$k.'_data'] ,TRUE);
											
											if(count($arr_f)>0)
											{
												foreach ($arr_f as $v1) {
													$diff.='<br>'.$v1['text'];
												}

											}
											
											$data_out['log']['content['.$k.']']='变更前:'.$diff;
											
											$data_db['content'][$k] = explode(',', $v) ;
											
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
							$msg= '经费流程【'.element($this->pk_id,$data_get).'】不存在！';
							
							if($flag_more)
							{
								$rtn['result'] = FALSE;
								$rtn['msg_err'] = $msg;
									
								if( $flag_more )
								return $rtn;
							}
							
							redirect('base/main/show_err/msg/'.fun_urlencode($msg));
						}
						
						$data_db['content']['blp_sub_s']=$this->m_base->get_field_where('fm_subject','sub_name'," AND sub_id = '{$data_db['content']['blp_sub']}'");
						
						if( $data_db['content']['blp_sum_end'] == 0)  $data_db['content']['blp_sum_end'] = '';
						
						//获取审核部门
						$arr_search_link=array();
						$arr_search_link['rows']=0;
						$arr_search_link['field']='link_id';
						$arr_search_link['from']='sys_link';
						$arr_search_link['where']=" AND op_id = ? AND op_table = ? AND op_field = ? AND content = ?";
						$arr_search_link['value'][]=element('blp_id',$data_db['content']);
						$arr_search_link['value'][]='fm_bl_ppo';
						$arr_search_link['value'][]='blp_id';
						$arr_search_link['value'][]='blp_ou';
						$rs_link=$this->m_db->query($arr_search_link);
						$data_db['content']['blp_ou']=array();
						$data_db['content']['blp_ou_data']=array();
						
						if(count($rs_link['content'])>0)
						{
							foreach ( $rs_link['content'] as $v ) {
								$data_db['content']['blp_ou'][]=$v['link_id'];
								
								$data_db['content']['blp_ou_data'][]=array(
									'id'=>$v['link_id'],
									'text'=>$this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id ='{$v['link_id']}'")
								);
							}
						}
						$data_db['content']['blp_ou_data']=json_encode($data_db['content']['blp_ou_data']);
						
						//获取审批人
						$arr_search_link=array();
						$arr_search_link['rows']=0;
						$arr_search_link['field']='link_id';
						$arr_search_link['from']='sys_link';
						$arr_search_link['where']=" AND op_id = ? AND op_table = ? AND op_field = ? AND content = ?";
						$arr_search_link['value'][]=element('blp_id',$data_db['content']);
						$arr_search_link['value'][]='fm_bl_ppo';
						$arr_search_link['value'][]='blp_id';
						$arr_search_link['value'][]='blp_c';
						$rs_link=$this->m_db->query($arr_search_link);
						$data_db['content']['blp_c']=array();
						$data_db['content']['blp_c_data']=array();
						
						if(count($rs_link['content'])>0)
						{
							foreach ( $rs_link['content'] as $v ) {
								$data_db['content']['blp_c'][]=$v['link_id'];
								
								$data_db['content']['blp_c_data'][]=array(
									'id'=>$v['link_id'],
									'text'=>$this->m_base->get_c_show_by_cid($v['link_id'])
								);
							}
						}
						
						$data_db['content']['blp_c_data']=json_encode($data_db['content']['blp_c_data']);

					}
				} catch (Exception $e) {
				}
			break;
		}
		/************权限验证*****************/
		//@todo 权限验证
		$acl_list= $this->m_proc_bud->get_acl();

		$this->check_acl($data_db,$acl_list);
		
		/************显示配置*****************/
		//@todo 显示配置
		$title_field=element('blp_sub_s', $data_db['content']);
		
		switch ($data_get['act']) {
			case STAT_ACT_CREATE:
				$data_out['title']='创建'.$this->title;
				
				$data_out['op_disable'][]='btn_del';
				$data_out['op_disable'][]='btn_log';

				//创建默认值
				$data_db['content']['blp_sum_start'] = 0;
				$data_db['content']['blp_ppo_num'] = 1;

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

        //@todo 节点权限显示隐藏
        if(element('flag_edit_more', $data_get))
        {
            $data_out['field_required']=array();

            $data_out['op_disable'][] = 'content[it_name]';

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
					if(element('blp_ppo', $data_post['content']) != BLP_PPO_SP)
					{
						$data_out['field_required'][] = 'content[blp_ou]';
					}
					
					//必填验证
					if(count($data_out['field_required'])>0)
					{
						foreach ($data_out['field_required'] as $v) {

                            $arr_tmp=split_table_field($v);

                            if( ! is_array(element('content', $data_post))
                             || ( empty(element($arr_tmp['field'],$data_post['content']) )
                               && element($arr_tmp['field'],$data_post['content']) != 0
                             )
                            )
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
                
                if( element('blp_ppo',$data_save['content']) == BLP_PPO_SP )
                $data_save['content']['blp_ou'] = array();
                
				if( ! empty(element('blp_ou',$data_save['content'])) )
				{
					if( ! is_array(element('blp_ou',$data_save['content'])) )
					{
						$data_save['content']['blp_ou'] = explode(',', $data_save['content']['blp_ou']);
					}
				}
				
				if( ! empty(element('blp_c',$data_save['content'])) )
				{
					if( ! is_array(element('blp_c',$data_save['content'])) )
					{
						$data_save['content']['blp_c'] = explode(',', $data_save['content']['blp_c']);
					}
				}
				
				if( ! element('blp_ppo_num', $data_save['content'] ) )
				$data_save['content']['blp_ppo_num']=1;
				else 
				{
					$check_blp_ppo_num = $this->m_base->get_field_where('fm_bl_ppo','blp_ppo_num'
					," AND blp_ppo_num = '{$data_save['content']['blp_ppo_num']}' AND blp_sub = '{$data_save['content']['blp_sub']}' AND blp_ppo = '{$data_save['content']['blp_ppo']}'");
					
					if( ! $check_blp_ppo_num)
					{
						$blp_ppo_num = $this->m_db->get_m_value('fm_bl_ppo','blp_ppo_num'
						," AND blp_sub = '{$data_save['content']['blp_sub']}' AND blp_ppo = '{$data_save['content']['blp_ppo']}' AND blp_id != '".element('blp_id', $data_get)."'");
						
						if($data_save['content']['blp_ppo_num'] > $blp_ppo_num +1)
						$data_save['content']['blp_ppo_num'] =  $blp_ppo_num + 1 ;
					}
				}
				/************事件处理*****************/
				switch ($data_get['act']) {
					case STAT_ACT_CREATE:
						$rtn=$this->add($data_save['content']);

						$arr_log_content=array();
						$arr_log_content['new']['content']=$data_save['content'];
						$arr_log_content['old']['content'][$this->pk_id] = $rtn['id'];
						
						if( count( element('blp_ou',$data_save['content']) ) > 0 )
						{
							foreach ($data_save['content']['blp_ou'] as $v) {
								$data_save['link']=array();
								$data_save['link']['op_id']=$rtn['id'];
								$data_save['link']['op_table']='fm_bl_ppo';
								$data_save['link']['op_field']='blp_id';
								$data_save['link']['content']='blp_ou';
								$data_save['link']['link_id']=$v;
								
								$this->m_link->add($data_save['link']);
							}
						}
						
						if( count( element('blp_c',$data_save['content']) ) > 0 )
						{
							foreach ($data_save['content']['blp_c'] as $v) {
								$data_save['link']=array();
								$data_save['link']['op_id']=$rtn['id'];
								$data_save['link']['op_table']='fm_bl_ppo';
								$data_save['link']['op_field']='blp_id';
								$data_save['link']['content']='blp_c';
								$data_save['link']['link_id']=$v;
								
								$this->m_link->add($data_save['link']);
							}
						}

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
						
						if( count( element('blp_ou',$data_save['content']) ) > 0 )
						{
							$cond_link=array();
							$cond_link['op_id']=element($this->pk_id,$data_get);
	        				$cond_link['op_table']='fm_bl_ppo';
							$cond_link['op_field']='blp_id';
							$cond_link['content']='blp_ou';
			        		$this->m_link->del_where($cond_link);
			        		
			        		$data_save['content']['blp_ou_data']=array();
			        		
							foreach ($data_save['content']['blp_ou'] as $v) {
								
								$data_save['link']=array();
								$data_save['link']['op_id']=$data_save['content'][$this->pk_id];
								$data_save['link']['op_table']='fm_bl_ppo';
								$data_save['link']['op_field']='blp_id';
								$data_save['link']['content']='blp_ou';
								$data_save['link']['link_id']=$v;
								
								$this->m_link->add($data_save['link']);
								
								$data_save['content']['blp_ou_data'][]=array(
									'id'=>$v,
									'text'=>$this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id = '{$v}'")
								);
							}
							
							$data_save['content']['blp_ou_data']=json_encode($data_save['content']['blp_ou_data']);
						}
						
						if( element('blp_ppo',$data_save['content']) == BLP_PPO_SP )
						{
							$cond_link=array();
							$cond_link['op_id']=element($this->pk_id,$data_get);
	        				$cond_link['op_table']='fm_bl_ppo';
							$cond_link['op_field']='blp_id';
							$cond_link['content']='blp_ou';
			        		$this->m_link->del_where($cond_link);
			        		
			        		$data_save['content']['blp_ou_data']=array();
			        		$data_save['content']['blp_ou_data']=json_encode($data_save['content']['blp_ou_data']);
						}
						
						if( count( element('blp_c',$data_save['content']) ) > 0 )
						{
							$cond_link=array();
							$cond_link['op_id']=element($this->pk_id,$data_get);
	        				$cond_link['op_table']='fm_bl_ppo';
							$cond_link['op_field']='blp_id';
							$cond_link['content']='blp_c';
			        		$this->m_link->del_where($cond_link);
			        		
			        		$data_save['content']['blp_c_data']=array();
			        		
							foreach ($data_save['content']['blp_c'] as $v) {
								
								$data_save['link']=array();
								$data_save['link']['op_id']=$data_save['content'][$this->pk_id];
								$data_save['link']['op_table']='fm_bl_ppo';
								$data_save['link']['op_field']='blp_id';
								$data_save['link']['content']='blp_c';
								$data_save['link']['link_id']=$v;
								
								$this->m_link->add($data_save['link']);
								
								$data_save['content']['blp_c_data'][]=array(
									'id'=>$v,
									'text'=>$this->m_base->get_c_show_by_cid($v)
								);
							}
							
							$data_save['content']['blp_c_data']=json_encode($data_save['content']['blp_c_data']);
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
				
				$rtn=$this->del(element('blp_id',$data_get));

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
	    $data_out['code']='';

        $data_out['fun_no_db']=element('fun_no_db', $data_get);
        $data_out['data_db_post'] = $this->input->post('data_db');

        $data_out['flag_edit_more']=element('flag_edit_more', $data_get);

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
	
	/**
	 * 
	 * 获取审核人
	 */
	public function get_c_person($sub,$ou_tj,$sum,$ppo,$ppo_num = 1)
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$data_db=array();//数据库数组
		$arr_search=array();
		$rtn=array();//结果
		
		/************变量赋值*****************/
		$arr_search['field']='lc.link_id';
    	$arr_search['from']=$this->table_name.' blp 
    						LEFT JOIN sys_link lc ON
    						(lc.op_id = blp.blp_id AND lc.content = \'blp_c\')';
    	$arr_search['where']='';
    	
    	if($ppo != BLP_PPO_SP)
    	{
	    	$arr_search['from'].='LEFT JOIN sys_link lou ON
	    						 (lou.op_id = blp.blp_id AND lou.content = \'blp_ou\' AND lou.link_id = ?)';
	    	$arr_search['where'].=' AND lou.link_id IS NOT NULL ';
	    	$arr_search['value'][]=$ou_tj;
    	}
    	
		$arr_search['where'].='AND blp.blp_sub = ? 
							  AND blp_ppo = ? AND blp_ppo_num = ? AND blp_sum_start <= ? AND (blp_sum_end >= ? OR blp_sum_end = 0 )
							  GROUP BY lc.link_id';
		$arr_search['value'][]=$sub;
		$arr_search['value'][]=$ppo;
		$arr_search['value'][]=$ppo_num;
		$arr_search['value'][]=$sum;
		$arr_search['value'][]=$sum;
    	$rs=$this->m_db->query($arr_search);
    	if(count($rs['content'])>0)
    	{
    		foreach ($rs['content'] as $k=>$v) {
    			$rtn[] = $v['link_id'];
    		}
    	}
    	
    	/************返回数据*****************/
		return $rtn;
    }
    
	/**
	 * 
	 * 获取审核部门
	 */
	public function get_ou($sub,$sum)
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$data_db=array();//数据库数组
		$arr_search=array();
		$rtn=array();//结果
		
		/************变量赋值*****************/
		$arr_search['field']='lou.link_id';
    	$arr_search['from']=$this->table_name.' blp 
    						LEFT JOIN sys_link lou ON
    						(lou.op_id = blp.blp_id AND lou.content = \'blp_ou\' )';
		$arr_search['where']='AND blp.blp_sub = ? 
							  AND blp_ppo = ?  AND blp_sum_start <= ? AND (blp_sum_end >= ? OR blp_sum_end = 0 )
							  GROUP BY lou.link_id';
		$arr_search['value'][]=$sub;
		$arr_search['value'][]=BLP_PPO_SH;
		$arr_search['value'][]=$sum;
		$arr_search['value'][]=$sum;
    	$rs=$this->m_db->query($arr_search);
    	
    	if(count($rs['content'])>0)
    	{
    		foreach ($rs['content'] as $k=>$v) {
    			$rtn[] = $v['link_id'];
    		}
    	}
    	
    	/************返回数据*****************/
		return $rtn;
    }
}