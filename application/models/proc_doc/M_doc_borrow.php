<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 *
模板
 */
class M_doc_borrow extends CI_Model {

    //@todo 主表配置
    private $table_name='oa_doc_borrow';//数据表
    private $pk_id='docb_id';//数据表主键
    private $table_form;
    private $arr_table_form=array();
    private $title='借阅及归还档案';//标题
    private $model_name = 'm_doc_borrow';//模型名称
    private $url_conf = 'proc_doc/doc_borrow/edit';//编辑页面
    private $proc_id = 'proc_doc';//节点

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
    }

    /**
     *
     * 定义
     */
    public function m_define()
    {
        //@todo 定义
        if( defined('LOAD_M_DOC_BORROW') ) return;
        define('LOAD_M_DOC_BORROW', 1);

        //define
        //借阅或领取
        define('DOCB_TYPE_BORROW', 1); // 借阅
        define('DOCB_TYPE_RECEIVE', 2); // 领取

        $GLOBALS['m_doc_borrow']['text']['docb_type']=array(
            DOCB_TYPE_BORROW=>'借阅',
            DOCB_TYPE_RECEIVE=>'领取',
        );

		// 节点
        define('DOC_BORROW_PPO_END', 0); // 流程结束
        define('DOC_BORROW_PPO_START', 1); // 起始
        define('DOC_BORROW_PPO_FH', 2); // 复核
        define('DOC_BORROW_PPO_SH', 3); // 审核
        define('DOC_BORROW_PPO_SP', 4); // 借阅
        define('DOC_BORROW_PPO_BACK', 5); // 归还
        define('DOC_BORROW_PPO_BOOK', 6); // 预约成功
        define('DOC_BORROW_PPO_BACKSP', 7); // 归还确认
        define('DOC_BORROW_PPO_LOST', 8); // 填写遗失情况
        define('DOC_BORROW_PPO_LOSTSH', 9); // 遗失审核
        define('DOC_BORROW_PPO_LOSTSP', 10); // 遗失审批

        $GLOBALS['m_doc_borrow']['text']['ppo']=array(
            DOC_BORROW_PPO_START=>'起始',
            DOC_BORROW_PPO_FH=>'复核',
            DOC_BORROW_PPO_SH=>'审核',
            DOC_BORROW_PPO_SP=>'借阅',
            DOC_BORROW_PPO_BACK=>'档案待归还',
            DOC_BORROW_PPO_BOOK=>'预约成功',
            DOC_BORROW_PPO_BACKSP=>'档案归还确认',
            DOC_BORROW_PPO_LOST=>'遗失情况说明',
            DOC_BORROW_PPO_LOSTSH=>'遗失审核',
            DOC_BORROW_PPO_LOSTSP=>'遗失审批',
            DOC_BORROW_PPO_END=>'流程结束',
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
    	$acl_list= $this->m_proc_doc->get_acl();

    	$msg='';
    	/************权限验证*****************/

    	//如果有超级权限，TRUE
    	if( ($acl_list & pow(2,ACL_PROC_DOC_SUPER)) != 0 )
    	{
    		return TRUE;
    	}

    	$check_acl=FALSE;

    	if( ! $check_acl
    	 && ($acl_list & pow(2,ACL_PROC_DOC_USER)) != 0
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
     * 单据编号
     * @param $content
     */
    public function get_code($data_save=array())
    {
        $where='';

        $pre='';
        
        $pre = $this->m_base->get_field_where('sys_ou','ou_org_pre'," AND ou_id ='{$data_save['content']['docb_org']}'");

//        switch (element('docb_org', $data_save['content']))
//        {
//            //成都
//            case '22B090894556F980B81361AA996ACF3B':
//                $pre='CD-';
//                break;
//            //北京
//            case '52D7478777D4BA42B3ECD05DCA53B7C9':
//            case '92F7520839C9108378883C6A90BEBFBE':
//                $pre='BJ-';
//                break;
//            //广州
//            case '95844F63647F4D89B7773198DDCE04C0':
//                $pre='GZ-';
//                break;
//            //杭州
//            case '9F8453E40A17EDDAA9EE72BB49C52E83':
//                $pre='HZ-';
//                break;
//            //上海
//            case 'B12F0862F53C9772369A4A990D7EA510':
//                $pre='SH-';
//                break;
//            default:
//
//        }

        $pre.='-JY'.date("Ym");
        $where .= " AND docb_code LIKE '{$pre}%'";

        $max_code=$this->m_db->get_m_value('oa_doc_borrow','docb_code',$where);
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
                    $rtn['msg_err']=$rtn['err']['msg'] = '于【'.$arr_tmp[0].'】存在关联数据,不可删除!';
                    return $rtn;
                }
            }
        }

        $data_db['content']=$this->get($id);

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
            
            //取消工单信息
	        $this->m_work_list->cancel_wl($id,$this->model_name);
	        
	        //删除关联文件
	        $this->m_file->del_link_file($id,$this->table_name,$this->pk_id);
	        
	        //删除所有关联数据
			$this->m_link->del_all($id);
			
			//更新档案明细表
			$this->clear_docb_id($id);
        }

        /************返回数据*****************/
        return $rtn;
    }

 	/**
	 * 
	 * 更新关联单据
	 * @param $content
	 */
	public function clear_docb_id($id)
    {
    	/************模型载入*****************/

        /************变量初始化****************/
        $data_save=array();//
        $rtn=array();//结果
        $rtn['rtn']=TRUE;
        $where='';
        /************变量赋值*****************/
        $data_save['content']=array();
		$data_save['content']['docb_id'] = '';
        $data_save['content']['db_time_update']=date("Y-m-d H:i:s");
        $where=" 1=1 AND {$this->pk_id} = '{$id}'";

        /************数据处理*****************/
        $this->db->trans_begin();

        if($rtn['rtn'])
            $rtn=$this->m_db->update('oa_doc_item',$data_save['content'],$where);

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
        	'oa_doc_borrow[docb_type]',
        	'oa_doc_borrow[docb_c_id]',
        	'sys_contact[c_login_id]',
        	'oa_doc_borrow[docb_c_ou]',
        	'oa_doc_borrow[docb_time_start]',
        	'oa_doc_borrow[docb_time_end]',
        	'oa_doc_borrow[docb_explain]'
        );

        $conf['field_required']=array(
        	'oa_doc_borrow[docb_type]',
        	'oa_doc_borrow[docb_c_id]',
        	'sys_contact[c_login_id]',
        	'oa_doc_borrow[docb_c_ou]',
        	'oa_doc_borrow[docb_time_start]',
        	'oa_doc_borrow[docb_explain]'
        );

        $conf['field_define']=array(
       		'oa_doc_borrow[docb_type]'=>$GLOBALS['m_doc_borrow']['text']['docb_type'],
        );
        
		$this->arr_table_form['sys_contact']['fields']['c_login_id']['comment']='统计人账号';
        $conf['table_form']=array(
        	'oa_doc_borrow'=>$this->table_form,
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
            'content[docb_type]',
            'content[docb_c_id]',
            'content[docb_c_id_s]',
            'content[docb_c_ou]',
            'content[docb_c_ou_s]',
            'content[docb_time_start]',
            'content[docb_explain]',
        );

        //编辑数组
        $data_out['field_edit']=array(
            'content[docb_type]',
            'content[docb_c_id]',
            'content[docb_c_id_s]',
            'content[docb_c_ou]',
            'content[docb_c_ou_s]',
            'content[docb_time_start]',
            'content[docb_time_end]',
            'content[docb_explain]',
            'content[docb_borrow]',
        	'content[docb_r_explain]'
        );

        //只读数组
        $data_out['field_view']=array(
        	'content[docb_book]'
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
        $data_out['json_field_define']['docb_type']=get_html_json_for_arr($GLOBALS['m_doc_borrow']['text']['docb_type']);

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
										case 'docb_borrow':
                                            $data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('doci_id',json_encode($v),element($k,$data_db['content']));
                                            $data_db['content'][$k] =json_encode($v) ;
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

                        //工单信息读取
                        $data_db['wl_list']=$this->m_work_list->get_wl_to_do(element($this->pk_id,$data_get),$this->model_name);
                        
                        if( ! empty(element('content',$data_db)))
                        {
                        	foreach($data_db['content'] as $k=>$v)
                        	{
                        		switch($k)
                        		{
                        			case 'docb_c_id':
                        				$data_db['content'][$k.'_s']=$this->m_base->get_c_show_by_cid($v);
                        				break;
                        			case 'docb_c_ou':
                        				$data_db['content'][$k.'_s']=$this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id='{$v}'");
                        				break;
                        			case 'docb_book':
                        				if($v == '0')
                        				{
                        					$data_db['content'][$k]="借阅";
                        				}else{
                        					$data_db['content'][$k]="预约";
                        				}
                        				break;
                        		}
                        	}
                        }
                        
                        //获取借取档案信息
						$arr_search_link=array();
						$arr_search_link['field']='doci_name,doci_id,doci_page_have,note,doci_org,doc_id';
						$arr_search_link['from']='oa_doc_item doci 
												LEFT JOIN sys_link l 
												ON( doci.doci_id = l.link_id )';
						$arr_search_link['where']=" AND op_id = ? AND op_table = ? AND op_field = ? AND content = ?";
						$arr_search_link['value'][]=element('docb_id',$data_db['content']);
						$arr_search_link['value'][]='oa_doc_borrow';
						$arr_search_link['value'][]='docb_id';
						$arr_search_link['value'][]='docb_borrow';
						$rs_link=$this->m_db->query($arr_search_link);
						
						if( count($rs_link['content']) > 0 )
						{
							$book_info='';
							foreach($rs_link['content'] as $k=>$v){
								$rs_link['content'][$k]['doci_id_s']=$v['doci_name'];
								$rs_link['content'][$k]['doci_org_s']=$this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id='{$v['doci_org']}'");
								$rs_link['content'][$k]['doci_page_now']=$rs_link['content'][$k]['note'];
								
								$book_info.=$v['doci_id'].',';
							}
						}
						
						$data_db['content']['docb_borrow']=json_encode($rs_link['content'],TRUE);
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
            case DOC_BORROW_PPO_START:
            case DOC_BORROW_PPO_LOST:
            case DOC_BORROW_PPO_BACK:
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

        $acl_list= $this->m_proc_doc->get_acl();

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
                $data_db['content']['ppo'] = DOC_BORROW_PPO_START;
                $data_db['content']['docb_type']=DOCB_TYPE_BORROW;
                $data_db['content']['docb_time_start']=date('Y-m-d');
                $data_db['content']['docb_c_id']=$this->sess->userdata('c_id');
                $data_db['content']['docb_c_id_s']=$this->sess->userdata('c_show');
                $data_db['content']['docb_c_ou']=$this->sess->userdata('c_ou_bud');
                $data_db['content']['docb_c_ou_s']=$this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id='{$this->sess->userdata('c_ou_bud')}'");
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

                $data_out['field_view'][]='content[docb_type]';

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

    	if( element('ppo',$data_db['content']) <= 7
		 && element('ppo',$data_db['content']) != DOC_BORROW_PPO_END)
		{
			$data_out['op_disable'][]='title_lost';
		}
		
		if( element('ppo',$data_db['content']) != DOC_BORROW_PPO_SP 
		&& element('ppo',$data_db['content']) != DOC_BORROW_PPO_END)
		{
			$data_out['op_disable'][]='title_book';
		}
		
		if( $data_get['act'] == STAT_ACT_EDIT
		&& element( 'ppo',$data_db['content']) == 0
		&& ($acl_list & pow(2,ACL_PROC_DOC_SUPER) ) == 0 )
		{
			$data_out['op_disable'][]='btn_save';
			$data_out['op_disable'][]='btn_del';

			$data_out['op_disable'][]='btn_next';
			$data_out['op_disable'][]='btn_pnext';

			$data_out['op_disable'][]='btn_reload';
		}
		
    	if( $data_db['content']['ppo'] == DOC_BORROW_PPO_LOST)
        {
            $data_out['field_required'][] = 'content[docb_r_explain]';
            
//            $data_out['op_disable'][] = 'btn_pnext';
//            $data_out['op_disable'][] = 'btn_save';
        }
        
    	if( $data_db['content']['ppo'] > 1 
    	&& $data_db['content']['ppo']!=DOC_BORROW_PPO_BACK 
    	&& $data_db['content']['ppo']!=DOC_BORROW_PPO_LOST)
        {
            $data_out['field_view'] = $data_out['field_edit'];
        }
        
        //只显示遗失文件
        if( $data_db['content']['ppo'] >7 )
        {
        	$data_db['content']['docb_borrow'] = json_decode($data_db['content']['docb_borrow'],TRUE);
        	
        	if( count($data_db['content']['docb_borrow']) > 0 )
        	{
        		foreach( $data_db['content']['docb_borrow'] as $k=>$v ){
        			$doci_page=$this->m_base->get_field_where('oa_doc_item','doci_page_now'," AND doci_id='{$v['doci_id']}'");
        			
        			if( $doci_page-$v['doci_page_now'] == 0)
        			{
        				$data_db['content']['docb_borrow'][$k]['hide'] = 1;
        			}
        		}
        		$data_db['content']['docb_borrow'] = json_encode($data_db['content']['docb_borrow']);
        	}
        }
        
        if(element('flag_edit_more', $data_get))
        {
            $data_out['field_required']=array();

            $data_out['op_disable'][]='btn_log';

            $data_out['title'] = '批量编辑'.$this->title.'-请勾选要保存的字段';
        }
        elseif( element( 'ppo',$data_db['content']) == DOC_BORROW_PPO_END )
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
                $rtn['err'] = array();

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
                	//借阅归还日期必填
                    if( ! empty(element('docb_type',$data_post['content'] ) )
                        && element('docb_type',$data_post['content'])==DOCB_TYPE_BORROW )
                    {
                        $data_out['field_required'][]='content[docb_time_end]';
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
                    
                	//借阅档案不为空
                	$docb_borrow=json_decode(element('docb_borrow',$data_post['content']),TRUE);
                	 
                    if( count($docb_borrow) == '0')
                    {
                    	$rtn['err']['content[docb_borrow]']='请填写借阅档案！';
                        $check_data=FALSE;
                        
                    }else{
	                    $doci_out='';
	                    $doci_type='';
	                    $doci_org=array();
	                    $docb_id=array();
	                    $doci_id=array();
	                    
	                    foreach($docb_borrow as $k=>$v){
	                    	
	               	    	$arr_search_doci=array();
		                    $arr_search_doci['field'] = 'doci_org,docb_id,doci_name,doci_type';
		                    $arr_search_doci['from'] = 'oa_doc_item';
		                    $arr_search_doci['where'] = ' AND doci_id = ?';
		                    $arr_search_doci['value'][] = $v['doci_id'];
		                    $rtn_doci=$this->m_db->query($arr_search_doci);
		                    $rtn_doci=current($rtn_doci['content']);
		                    
		                    $doci_org[]=$rtn_doci['doci_org'];
		                    
	                    	if( element( 'docb_id',$data_get ) )//非创建时
	               	    	{
	               	    		$arr_search=array();
	               	    		$arr_search['field']='GROUP_CONCAT(op_id) op_id';
	               	    		$arr_search['from']='sys_link l 
	               	    							LEFT JOIN oa_doc_borrow docb 
	               	    							ON (l.op_id=docb.docb_id)';
	               	    		$arr_search['where']=" AND link_id=? AND ppo!=?";
	               	    		$arr_search['value'][]=$v['doci_id'];
	               	    		$arr_search['value'][]='0';
	               	    		$rtn_docb=$this->m_db->query($arr_search);
	               	    		$rtn_docb=explode(',',$rtn_docb['content'][0]['op_id']);
	               	    		$docb_book=array_unique($rtn_docb);
	               	    		
	               	    		if( $rtn_doci['docb_id'] != element('docb_id',$data_get) 
	               	    		&& !in_array(element('docb_id',$data_get),$docb_book))
	               	    		{
	               	    			$doci_out.= $rtn_doci['doci_name'].',';
	               	    		}
	               	    		
	               	    	}else{
	               	    		
	               	    		$arr_search=array();
                    			$arr_search['field']='docb_id';
                    			$arr_search['from']='sys_link l 
                    								LEFT JOIN oa_doc_borrow docb 
                    								ON (l.op_id=docb.docb_id)';
                    			$arr_search['where']=" AND link_id=? AND ppo!=0";
                    			$arr_search['value']=$v['doci_id'];
                    			$rtn=$this->m_db->query($arr_search);
                    			
                    			//存在借出时
	               	    		if( ! empty(element('docb_id',$rtn_doci) ))
	               	    		{
	               	    			$doci_out.= $rtn_doci['doci_name'].',';
	               	    			$doci_id[]=$v['doci_id'];
	               	    		}else{
	               	    			//没有借出，但存在有预约的
	               	    			if(count($rtn['content'])>0)
	               	    			{
	               	    				$doci_out.= $rtn_doci['doci_name'].',';
	               	    				$doci_id[]=$v['doci_id'];
	               	    			}
	               	    		}
	               	    	}
	               	    	
	               	    	//档案不可借
	               	    	if( $rtn_doci['doci_type'] != '0' )
	               	    	{
	               	    		$rtn['err']['content[docb_borrow]'][] = array(
													'id' => $v['id'],
													'field' => 'doci_id',
													'act' => STAT_ACT_EDIT,
													'err_msg'=>'该档案不可借！'
													);
								$check_data=FALSE;
								
	               	    	}
	               	    	
	               	    	$docb_id[]=$this->m_base->get_field_where('oa_doc_item','docb_id'," AND doci_id='{$v['doci_id']}'");
	                    }
	                    
                    	//公司不同
	                	$doci_org = array_unique($doci_org);
	                	if( count($doci_org) > 1 && $doci_org)
                    	{
                    		$rtn['err']['content[docb_borrow]']='借阅档案归属公司不同，请分开借阅！';
                        	$check_data=FALSE;
                    	}
                    	
                    	//档案状态不同
                    	$docb_id=array_unique($docb_id);
                    	if(count($docb_id)>1)
                    	{
                    		$rtn['err']['docb_diff']='档案状态不同，请分开借取！';
	                        $check_data=FALSE;
                    	}
                    	
                    	//是否预约
	                	if($doci_out && empty(element('doci_out',$data_post['content'])))
	                    {	
	                    	$doci_name=trim($doci_out,',');
	                    	$rtn['err']['doci_out']=$doci_out.'已借出,是否预约！';
	                        $check_data=FALSE;
	                        
	                    }else if($doci_out && !empty(element('doci_out',$data_post['content']))){
	                    	
	                    	if( count($doci_id) > 0 )
	                    	{
	                    		foreach($doci_id as $v){
	                    			$arr_search=array();
	                    			$arr_search['field']='docb_id';
	                    			$arr_search['from']='sys_link l 
	                    								LEFT JOIN oa_doc_borrow docb 
	                    								ON (l.op_id=docb.docb_id)';
	                    			$arr_search['where']=" AND link_id=? AND ppo!=0";
	                    			$arr_search['value']=$v;
	                    			$rtn=$this->m_db->query($arr_search);
	                    		}
	                    		
	                    		if( count($rtn['content']) > 0)
	                    		{
	                    			$arr_docb_id='';
	                    			foreach($rtn['content'] as $v){
	                    				$arr_docb_id.="'".$v['docb_id']."',";
	                    			}
	                    			$arr_docb_id=trim($arr_docb_id,',');
	                    		}
	                    		
	                    		$time=$this->m_check->time_unique('oa_doc_borrow',
	                    										'docb_time_start',
	                    										'docb_time_end',
	                    										$data_post['content']['docb_time_start'],
	                    										$data_post['content']['docb_time_end'],
	                    										" AND docb_id IN ({$arr_docb_id})");
								
	                    		if($time == FALSE)
	                    		{
	                    			$rtn['err']['doci_time']='预约时间有误，请重新选择预约时间！';
	                        		$check_data=FALSE;
	                    		}
	                    	}
	                    	
	                    }
	                    
	                    if( $data_db['content']['ppo'] == DOC_BORROW_PPO_BOOK 
	                    	&& $docb_id[0] !=element('docb_id',$data_get) 
	                    	&& !empty($docb_id[0]))
	                    {
	                    	$rtn['err']['doci_notback']='档案尚未归还！';
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

                        if( element('flag_edit_more', $data_post)
                            && element($k.'_check', $data_post['content']) != 1 )
                            continue;

                        if( ! in_array('content['.$k.']',$data_out['field_view'])
                            && ! in_array('content['.$k.']',$data_out['op_disable'])
                            && in_array('content['.$k.']',$data_out['field_edit']) )
                            $data_save['content'][$k]=$v;
                    }
                }
				$data_save['content']['docb_borrow']=json_decode($data_save['content']['docb_borrow'],TRUE);
				
				if(element('doci_out',$data_post['content'])) $data_save['content']['docb_book']='1';

                /************事件处理*****************/
                switch ($data_get['act']) {
                    case STAT_ACT_CREATE:
                    	$data_save['content']['docb_org']=$this->m_base->get_field_where('sys_contact','c_org'," AND c_id='{$data_save['content']['docb_c_id']}'");
                        $data_save['content']['docb_code']=$this->get_code($data_save);

                        $rtn=$this->add($data_save['content']);

                        //保存借阅档案
                		if( is_array(element('docb_borrow',$data_save['content'])) 
						 && count($data_save['content']['docb_borrow']) > 0)
						{
							foreach ( $data_save['content']['docb_borrow'] as $k=>$v) {
								
								$data_save['link']=array();
								$data_save['link']['op_id']=$rtn['id'];
								$data_save['link']['op_table']='oa_doc_borrow';
								$data_save['link']['op_field']='docb_id';
								$data_save['link']['content']='docb_borrow';
								$data_save['link']['note']=$v['doci_page_now'];
								$data_save['link']['link_id']=$v['doci_id'];
								$data_save['link']['link_table']='oa_doc_item';
								$data_save['link']['link_field']='doci_id';
								
								$this->m_link->add($data_save['link']);
								
								if( empty(element('doci_out',$data_post['content'])))
								{
									//更新档案明细表
									$this->m_table_op->load('oa_doc_item');
									$doci_page=array();

									$doci_page['doci_id']=$v['doci_id'];
								
									$doci_page['docb_id']=$rtn['id'];
									
									$this->m_table_op->update($doci_page);
								}
							}
						}
						
                        //创建我的工单
                        $data_save['wl']['wl_id'] = $rtn['id'];
                        $data_save['wl']['wl_type'] = WL_TYPE_I;
                        $data_save['wl']['wl_code']=$data_save['content']['docb_code'];
                        $data_save['wl']['wl_op_table']='oa_doc_borrow';
                        $data_save['wl']['wl_op_field']='docb_id';
                        $data_save['wl']['op_id']=$rtn['id'];
                        $data_save['wl']['p_id']=$this->proc_id;
                        $data_save['wl']['pp_id']=$this->model_name;
                        $data_save['wl']['wl_proc']=$data_save['content']['ppo'];
                        $data_save['wl']['wl_url']=$this->url_conf.'/act/2';
                        $data_save['wl']['wl_note']='【'.$this->title.'】'
                            .','.$data_save['content']['docb_c_id_s']
                        ;
                        $data_save['wl']['c_accept'][] = $this->sess->userdata('c_id');
                        $data_save['wl']['c_accept'][] = $data_save['content']['docb_c_id'];

                        $this->m_work_list->add($data_save['wl']);

                        $data_save['wl']['wl_id']=get_guid();
                        $data_save['wl']['wl_type'] = 0 ;
                        $data_save['wl']['wl_event']='补全、提交单据';
                        $data_save['wl']['wl_proc'] = 1;
                        $this->m_work_list->add($data_save['wl']);

                        $rtn['wl_i'][] = $this->sess->userdata('c_id');
                        $rtn['wl_accept'][] = $data_save['wl']['c_accept'];
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
                        $data_save['wl']['wl_code']=$data_db['content']['docb_code'];
                        $data_save['wl']['wl_op_table']='oa_doc_borrow';
                        $data_save['wl']['wl_op_field']='docb_id';
                        $data_save['wl']['op_id']=$data_save['content'][$this->pk_id];
                        $data_save['wl']['p_id']=$this->proc_id;
                        $data_save['wl']['pp_id']=$this->model_name;
                        $data_save['wl']['wl_url']=$this->url_conf.'/act/2';
                        $data_save['wl']['wl_proc']=$data_save['content']['ppo'];
                        $data_save['wl']['wl_time_end']=date('Y-m-d H:i:s',strtotime('+30 day'));
                        $data_save['wl']['c_accept'] = array();
                        $data_save['wl']['wl_note']='【'.$this->title.'】'
                            .','.$data_save['content']['docb_c_id_s'];

                        //工单流转
                        switch (element('ppo',$data_db['content']))
                        {
                            case DOC_BORROW_PPO_START:

                                if($btn == 'next')
                                {
                                    $data_save['content']['ppo'] = DOC_BORROW_PPO_FH;

                                    $data_save['wl']['wl_event']='复核单据';

                                    //添加流程接收人
                                    $c_accept=$this->m_acl->get_acl_person($this->proc_id,ACL_PROC_DOC_BORROW_FCHECK);
					
                                    //筛选复核人（部门领导）
                                	if( count($c_accept) > 0)
		    						{
			    						$arr_v=array();
			    						$arr_v[]=$data_save['content']['docb_c_ou'];
			    						$arr_v[]=$c_accept;
			    						$c_accept=$this->m_base->get_field_where('sys_contact','c_id'
			    							,"AND c_ou_bud = ? AND c_id IN ? ",$arr_v,1);
		    						}
                                    
                                    $data_save['wl']['c_accept']=$c_accept;
                                }
                                break;
                            case DOC_BORROW_PPO_FH:

                            	if($btn == 'next')
                           		{
                                	//验证档案的归属公司和借阅人的归属公司是否一致
                                	if(count($data_save['content']['docb_borrow']))
                                	{
                                		$c_org=$this->m_base->get_field_where('sys_contact','c_org'," AND c_id='{$data_save['content']['docb_c_id']}'");
                                		
                                		if($data_save['content']['docb_borrow'][0]['doci_org'] != $c_org)
                                		{
                                			$data_save['content']['ppo'] = DOC_BORROW_PPO_SH;
                                			$data_save['wl']['wl_event']='审核单据';
                                			
                                			//添加流程接收人
                               	 			$c_accept=$this->m_acl->get_acl_person($this->proc_id,ACL_PROC_DOC_BORROW_AUDIT);
                               	 			
                                			//筛选审核人（协办人）
		                                	if( count($c_accept) > 0)
				    						{
					    						$arr_v=array();
					    						$arr_v[]=$data_save['content']['docb_borrow'][0]['doci_org'];
					    						$arr_v[]=$c_accept;
					    						$c_accept=$this->m_base->get_field_where('sys_contact','c_id'
					    							,"AND c_org = ? AND c_id IN ? ",$arr_v,1);
				    						}
				    						
                                		}else{
                                			$data_save['content']['ppo'] = DOC_BORROW_PPO_SP;
                                			$data_save['wl']['wl_event']='借阅';
                                			
                                			//添加流程接收人
		                                    $c_accept=$this->m_acl->get_acl_person($this->proc_id,ACL_PROC_DOC_BORROW_APPROVAL);
		                                    
                                			//筛选审核人（档案保管员）
		                                	if( count($c_accept) > 0)
				    						{
					    						$arr_v=array();
					    						$arr_v[]=$data_save['content']['docb_borrow'][0]['doci_org'];
					    						$arr_v[]=$c_accept;
					    						$c_accept=$this->m_base->get_field_where('sys_contact','c_id'
					    							,"AND c_org = ? AND c_id IN ? ",$arr_v,1);
				    						}
                                		}
                                		$data_save['wl']['c_accept']=$c_accept;
                                	}
                            	}
                            	elseif($btn == 'pnext')
                            	{
                                	$data_save['content']['ppo'] = DOC_BORROW_PPO_START;

                                	$data_save['wl']['wl_event']='修改单据';
                                	$data_save['wl']['c_accept'][] = $data_db['content']['db_person_create'];
                                	$data_save['wl']['c_accept'][] = $data_save['content']['docb_c_id'];
                            	}
                            	break;
                            case DOC_BORROW_PPO_SH:

                                if($btn == 'next')
                                {
                                    $data_save['content']['ppo'] = DOC_BORROW_PPO_SP;
									
                                    $data_save['wl']['wl_event']='借阅';

                                    //添加流程接收人
                                    $c_accept=$this->m_acl->get_acl_person($this->proc_id,ACL_PROC_DOC_BORROW_APPROVAL);

                                    //筛选（档案保管员）
                                	if( count($c_accept) > 0)
		    						{
			    						$arr_v=array();
			    						$arr_v[]=$data_save['content']['docb_borrow'][0]['doci_org'];
			    						$arr_v[]=$c_accept;
			    						$c_accept=$this->m_base->get_field_where('sys_contact','c_id'
			    							,"AND c_org = ? AND c_id IN ? ",$arr_v,1);
		    						}
                                    
                                    $data_save['wl']['c_accept']=$c_accept;

                                }
                                elseif($btn == 'pnext')
                                {
                                    $data_save['content']['ppo'] = DOC_BORROW_PPO_START;

                                    $data_save['wl']['wl_event']='修改单据';
                                    $data_save['wl']['c_accept'][] = $data_db['content']['db_person_create'];
                                    $data_save['wl']['c_accept'][] = $data_save['content']['docb_c_id'];
                                }

                                break;
                            case DOC_BORROW_PPO_SP:
								
                                if($btn == 'next')
                                {
                                	if($data_save['content']['docb_type'] == 2 )
                                	{
                                		$data_save['content']['ppo'] = DOC_BORROW_PPO_END;
                                	}else{
                                		$book_yn=$this->m_base->get_field_where('oa_doc_borrow','docb_book'," AND docb_id='{$data_get['docb_id']}'");
                                		if($book_yn == '0')
                                		{
                                			$data_save['content']['ppo'] = DOC_BORROW_PPO_BACK;
									
		                                    $data_save['wl']['wl_event']='档案待归还';
		
		                                    //添加流程接收人
		                                    $data_save['wl']['c_accept'][]=$data_db['content']['docb_c_id'];
                                		}else{
                                			if($docb_id[0] == $data_get['docb_id'] || $docb_id =='')
                                			{
                                				$data_save['content']['ppo'] = DOC_BORROW_PPO_BACK;
									
		                                    	$data_save['wl']['wl_event']='档案待归还';
		
		                                    	//添加流程接收人
		                                    	$data_save['wl']['c_accept'][]=$data_db['content']['docb_c_id'];
                                			}else{
                                				$data_save['content']['ppo'] = DOC_BORROW_PPO_BOOK;
									
		                                    	$data_save['wl']['wl_event']='预约成功，档案待借';
		
		                                    	//添加流程接收人
		                                    	$c_accept=$this->m_acl->get_acl_person($this->proc_id,ACL_PROC_DOC_BORROW_APPROVAL);

                                    			//筛选（档案保管员）
                                				if( count($c_accept) > 0)
		    									{
			    									$arr_v=array();
			    									$arr_v[]=$data_save['content']['docb_borrow'][0]['doci_org'];
			    									$arr_v[]=$c_accept;
			    									$c_accept=$this->m_base->get_field_where('sys_contact','c_id'
			    										,"AND c_org = ? AND c_id IN ? ",$arr_v,1);
		    									}
                                    
                                    			$data_save['wl']['c_accept']=$c_accept;
                                			}
                                			
                                		}
                                		
                                	}
                                }
                                elseif($btn == 'pnext')
                                {
                                    $data_save['content']['ppo'] = DOC_BORROW_PPO_START;

                                    $data_save['wl']['wl_event']='修改单据';
                                    $data_save['wl']['c_accept'][] = $data_db['content']['db_person_create'];
                                    $data_save['wl']['c_accept'][] = $data_save['content']['docb_c_id'];
                                }

                                break;
                           case DOC_BORROW_PPO_BOOK:
								
                                if($btn == 'next')
                                {
                                	$data_save['content']['ppo'] = DOC_BORROW_PPO_BACK;
									
                                    $data_save['wl']['wl_event']='档案待归还';
		
                                    //添加流程接收人
                                    $data_save['wl']['c_accept'][]=$data_db['content']['docb_c_id'];
                                	
                                }
                                elseif($btn == 'pnext')
                                {
                                    $data_save['content']['ppo'] = DOC_BORROW_PPO_START;

                                    $data_save['wl']['wl_event']='修改单据';
                                    $data_save['wl']['c_accept'][] = $data_db['content']['db_person_create'];
                                    $data_save['wl']['c_accept'][] = $data_save['content']['docb_c_id'];
                                }

                                break;
                            case DOC_BORROW_PPO_BACK:

                            	$docb_save=$data_save['content']['docb_borrow'];
                            	$lost='';
								foreach($docb_save as $v){
									if($v['note'] != $v['doci_page_now'])
									{
										$lost='1';
									}
								}
                                if($btn == 'next')
                                {
	                                if( $lost )
									{
	                                	$data_save['content']['ppo'] = DOC_BORROW_PPO_LOST;
										
	                                    $data_save['wl']['wl_event']='档案遗失，填写遗失情况说明';
	
	                                    $data_save['wl']['c_accept'][]=$data_db['content']['docb_c_id'];
									}else{
										
	                                    //添加流程接收人
	                                    $c_accept=$this->m_acl->get_acl_person($this->proc_id,ACL_PROC_DOC_BORROW_APPROVAL);
	
										$c_id=$this->sess->userdata('c_id');
										
										//登陆人为档案保管员，流程结束
										if( in_array($c_id, $c_accept))
										{
											$data_save['content']['ppo'] = DOC_BORROW_PPO_END;
											
										}else{
											$data_save['content']['ppo'] = DOC_BORROW_PPO_BACKSP;
										
		                                    $data_save['wl']['wl_event']='档案归还';
		
		                                    //添加流程接收人
		                                    $c_accept=$this->m_acl->get_acl_person($this->proc_id,ACL_PROC_DOC_BORROW_APPROVAL);
		
		                                    //筛选（档案保管员）
											if( count($c_accept) > 0)
				    						{
					    						$arr_v=array();
					    						$arr_v[]=$data_save['content']['docb_borrow'][0]['doci_org'];
					    						$arr_v[]=$c_accept;
					    						$c_accept=$this->m_base->get_field_where('sys_contact','c_id'
					    							,"AND c_org = ? AND c_id IN ? ",$arr_v,1);
				    						}
										}
			    						
	                                    $data_save['wl']['c_accept']=$c_accept;
									}
                                }
                                elseif($btn == 'pnext')
                                {
                                    $data_save['content']['ppo'] = DOC_BORROW_PPO_START;

                                    $data_save['wl']['wl_event']='修改单据';
                                    $data_save['wl']['c_accept'][] = $data_db['content']['db_person_create'];
                                    $data_save['wl']['c_accept'][] = $data_save['content']['docb_c_id'];
                                }
                                break;
                           case DOC_BORROW_PPO_BACKSP:

                                if($btn == 'next')
                                {
                                	$data_save['content']['ppo'] = DOC_BORROW_PPO_END;
                                }
                                break;
                           case DOC_BORROW_PPO_LOST:

                                if($btn == 'next')
                                {
                                	$data_save['content']['ppo'] = DOC_BORROW_PPO_LOSTSH;
									
                                    $data_save['wl']['wl_event']='档案遗失，审核单据';

                                    //添加流程接收人
                                    $c_accept=$this->m_acl->get_acl_person($this->proc_id,ACL_PROC_DOC_AUDIT);

                                    //筛选（部门领导）
                                	if( count($c_accept) > 0)
		    						{
			    						$arr_v=array();
			    						$arr_v[]=$data_save['content']['docb_c_ou'];
			    						$arr_v[]=$c_accept;
			    						$c_accept=$this->m_base->get_field_where('sys_contact','c_id'
			    							,"AND c_ou_bud = ? AND c_id IN ? ",$arr_v,1);
		    						}
                                    
                                    $data_save['wl']['c_accept']=$c_accept;
                                }
                                break;
                            case DOC_BORROW_PPO_LOSTSH:

                                if($btn == 'next')
                                {
                                	$data_save['content']['ppo'] = DOC_BORROW_PPO_LOSTSP;
									
                                    $data_save['wl']['wl_event']='档案遗失，审批单据';

                                    //添加流程接收人
                                    $c_accept=$this->m_acl->get_acl_person($this->proc_id,ACL_PROC_DOC_LOST_APPROVAL);

                                    //筛选（保管员的领导）
                                	if( count($c_accept) > 0)
		    						{
			    						$arr_v=array();
			    						$arr_v[]=$data_save['content']['docb_borrow'][0]['doci_org'];
			    						$arr_v[]=$c_accept;
			    						$c_accept=$this->m_base->get_field_where('sys_contact','c_id'
			    							,"AND c_org = ? AND c_id IN ? ",$arr_v,1);
		    						}
                                    
                                    $data_save['wl']['c_accept']=$c_accept;
                                }
                                elseif($btn == 'pnext')
                                {
                                    $data_save['content']['ppo'] = DOC_BORROW_PPO_BACK;

                                    $data_save['wl']['wl_event']='修改单据';
                                    $data_save['wl']['c_accept'][] = $data_db['content']['db_person_create'];
                                    $data_save['wl']['c_accept'][] = $data_save['content']['docb_c_id'];
                                }
                                break;
                            case DOC_BORROW_PPO_LOSTSP:

                                if($btn == 'next')
                                {
                                    $data_save['content']['ppo'] = DOC_BORROW_PPO_END;
                                }
                                elseif($btn == 'pnext')
                                {
                                    $data_save['content']['ppo'] = DOC_BORROW_PPO_BACK;

                                    $data_save['wl']['wl_event']='修改单据';
                                    $data_save['wl']['c_accept'][] = $data_db['content']['db_person_create'];
                                    $data_save['wl']['c_accept'][] = $data_save['content']['docb_c_id'];
                                }
                                break;
                        }
                        
                        $rtn=$this->update($data_save['content']);
                        
                        //档案借阅
						$cond_link=array();
						$cond_link['op_id']=element($this->pk_id,$data_get);
	        			$cond_link['op_table']='oa_doc_borrow';
						$cond_link['op_field']='docb_id';
						$cond_link['content']='docb_borrow';

						//改变借阅状态
						$this->m_table_op->load('oa_doc_item');
						
						$this->clear_docb_id($data_db['content']['docb_id']);
						
			        	if( $data_save['content']['ppo'] != DOC_BORROW_PPO_END)
			        	{
				        	$this->m_link->del_where($cond_link);
				        		
							foreach ($data_save['content']['docb_borrow'] as $k=>$v) {
								
								$data_save['link']=array();
								$data_save['link']['op_id']=element('docb_id',$data_db['content']);
								$data_save['link']['op_table']='oa_doc_borrow';
								$data_save['link']['op_field']='docb_id';
								$data_save['link']['content']='docb_borrow';
								$data_save['link']['note']=$v['doci_page_now'];
								$data_save['link']['link_id']=$v['doci_id'];
								$data_save['link']['link_table']='oa_doc_item';
								$data_save['link']['link_field']='doci_id';
								$this->m_link->add($data_save['link']);
								
								//更新档案明细表
								$doci_docb=array();
								$doci_docb['doci_id']=$v['doci_id'];
								$db_docb_id=$this->m_base->get_field_where('oa_doc_item','docb_id',' AND doci_id=?',$v['doci_id']);
								
								if($db_docb_id=='')
								{
									$doci_docb['docb_id']=$data_get['docb_id'];
								}
								
								$this->m_table_op->update($doci_docb);
							}
			        	}else if($data_save['content']['ppo'] == DOC_BORROW_PPO_END && $data_save['content']['docb_type'] == 2)
			        	{
				        	foreach ($data_save['content']['docb_borrow'] as $k=>$v) {
								//更新档案明细表
								$doci_page=array();
								$doci_page['doci_id']=$v['doci_id'];
								$doci_page['doci_type'] = '1';
								$this->m_table_op->update($doci_page);
							}
			        	}else if($data_db['content']['ppo'] == DOC_BORROW_PPO_LOSTSP)
			        	{
			        		foreach ($data_save['content']['docb_borrow'] as $k=>$v) {
								$doci_page_now = $this->m_base->get_field_where('oa_doc_item','doci_page_now'," AND doci_id='{$v['doci_id']}'");
								
								if($doci_page_now != $v['doci_page_now'])
								{
									$data_save['link']=array();
									$data_save['link']['op_id']=element('docb_id',$data_db['content']);
									$data_save['link']['op_table']='oa_doc_borrow';
									$data_save['link']['op_field']='docb_id';
									$data_save['link']['content']='借阅页数'.$doci_page_now.'页,实际归还'.$v['doci_page_now'].'页';
									$data_save['link']['link_id']=$v['doci_id'];
									$data_save['link']['link_table']='oa_doc_item';
									$data_save['link']['link_field']='doci_id';
									$this->m_link->add($data_save['link']);
									
									//更新档案明细表
									$doci_page_now=array();
									$doci_page_now['doci_id']=$v['doci_id'];
									$doci_page_now['doci_page_now']=$v['doci_page_now'];
									
									if($v['doci_page_now'] == '0')
									{
										$doci_page_now['doci_type']='1';
									}
									
									$this->m_table_op->update($doci_page_now);
								}
							}
			        	}
							
                        //工单日志
                        if( $btn == 'yj' )
                        {
                            $data_save['content_log']['log_note']=
                                '【'.$this->sess->userdata('c_name').'['.$this->sess->userdata('a_login_id').']】'
                                .'于节点【'.$GLOBALS['m_doc_borrow']['text']['ppo'][$data_db['content']['ppo']].'】'
                                .',将【'.$this->title.'】移交于【'.$data_post['content']['person_yj_s'].'】';

                            $data_save['wl']['wl_type']=WL_TYPE_YJ;
                            $data_save['wl']['wl_event']=element('wl_list_to_do', $data_out);
                            $data_save['wl']['c_accept'][]=$data_post['content']['person_yj'];

                        }
                        elseif( $btn == 'next' || $btn == 'pnext' )
                        {
                            $data_save['content_log']['log_note']=
                                '于节点【'.$GLOBALS['m_doc_borrow']['text']['ppo'][$data_db['content']['ppo']].'】'.$ppo_btn_text
                                .',流转至节点【'.$GLOBALS['m_doc_borrow']['text']['ppo'][$data_save['content']['ppo']].'】';
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

								if($data_save['content']['ppo'] == DOC_BORROW_PPO_END)
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

                                if($data_save['content']['ppo'] != DOC_BORROW_PPO_END)
                                $this->m_work_list->add($data_save['wl']);

                                //获取工单关注人与所有人
                                $arr_wl_person = $this->m_work_list->get_wl_care_accept(element($this->pk_id,$data_get),$this->model_name);

                                $rtn['wl_end'] = array();
                                $rtn['wl_accept'] = $data_save['wl']['c_accept'];
                                $rtn['wl_accept'][] = $this->sess->userdata('c_id');
                                $rtn['wl_accept'][] = $data_db['content']['docb_c_id'];

                                if( count( element('arr_wl_accept', $data_out)) > 0 )
                                $rtn['wl_accept'] = array_values(array_merge($rtn['wl_accept'],$data_out['arr_wl_accept']));

                                $rtn['wl_accept'] =array_unique($rtn['wl_accept']);

                                $rtn['wl_care'] = $arr_wl_person['care'];
                                $rtn['wl_i'] = $arr_wl_person['accept'];
                                $rtn['wl_op_id'] = element($this->pk_id,$data_get);
                                $rtn['wl_pp_id'] = $this->model_name;

                                if($data_save['content']['ppo'] == DOC_BORROW_PPO_END)
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
				$rtn['wl_accept'][] = $data_db['content']['docb_c_id'];
				
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

        $data_out['proc_id']=$this->proc_id;
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
        $data_out['code']=element('docb_code',$data_db['content']);

        $data_out['ppo']=element('ppo', $data_db['content']);
        $data_out['ppo_name']=$GLOBALS['m_doc_borrow']['text']['ppo'][element('ppo', $data_db['content'])];

        $data_out['fun_no_db']=element('fun_no_db', $data_get);
        $data_out['data_db_post'] = $this->input->post('data_db');

        $data_out['flag_edit_more']=element('flag_edit_more', $data_get);

        $data_out[$this->pk_id]=element($this->pk_id,$data_get);
        if(element('docb_id',$data_get))
        $data_out['docb_id']=$data_get['docb_id'];

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
}