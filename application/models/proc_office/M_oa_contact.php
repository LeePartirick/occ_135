<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 *
员工索引
 */
class M_oa_contact extends CI_Model {

    //@todo 主表配置
    private $table_name='sys_contact';
    private $pk_id='c_id';
    private $table_form;
    private $arr_table_form=array();
    private $title='员工索引';
    private $model_name = 'm_oa_contact';
    private $url_conf = 'proc_office/oa_contact/edit';
    private $proc_id = 'proc_office';

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->m_define();

        //读取表结构
        $this->config->load('db_table/'.$this->table_name, FALSE,TRUE);
        $this->table_form=$this->config->item($this->table_name);

        $this->config->load('db_table/oa_offa_item', FALSE,TRUE);
        $this->arr_table_form['oa_offa_item']=$this->config->item('oa_offa_item');

        $this->config->load('db_table/hr_info', FALSE,TRUE);
        $this->arr_table_form['hr_info']=$this->config->item('hr_info');

    }

    /**
     *
     * 定义
     */
    public function m_define()
    {
        //@todo 定义
        if( defined('LOAD_M_OA_CONTACT') ) return;
        define('LOAD_M_OA_CONTACT', 1);

        //define
        $this->load->model('proc_contact/m_contact');
        $this->load->model('proc_office/m_oa_offai');
        $this->load->model('proc_office/m_office_apply');
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
            $acl_list= $this->m_proc_office->get_acl();

        $msg='';
        /************权限验证*****************/

        //如果有超级权限，TRUE
        if( ($acl_list & pow(2,ACL_PROC_OFFICE_SUPER)) != 0 )
        {
            return TRUE;
        }

        $check_acl=FALSE;

        if( ! $check_acl
            && ($acl_list & pow(2,ACL_PROC_OFFICE_USER)) != 0
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
        	'sys_contact[c_name]',
        	'sys_contact[c_login_id]',
        	'oa_offa_item[offai_offi_id]',
        	'oa_offa_item[offai_model]',
        	'oa_offa_item[offai_note]',
        );

        $conf['field_required']=array(
        	'sys_contact[c_name]',
        	'sys_contact[c_login_id]',
        	'oa_offa_item[offai_offi_id]',
        	'oa_offa_item[offai_model]',
        );

        $conf['field_define']=array(
        );

        $conf['table_form']=array(
        	'sys_contact'=>$this->table_form,
            'hr_info'=>$this->arr_table_form['hr_info'],
            'oa_offa_item'=>$this->arr_table_form['oa_offa_item'],
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
            'content[offa_item]'
        );

        //只读数组
        $data_out['field_view']=array(
            'content[c_name]',
            'content[c_sex]',
            'content[c_tel_code]',
            'content[c_ou_2]',
            'content[c_ou_3]',
            'content[c_ou_4]',
            'content[c_tel]',
            'content[c_tel_2]',
            'content[c_login_id]',
            'content[c_login_id_m]',
            'content[c_email_sys]',
            'content[c_email_gz]',
            'content[c_mac_line]',
            'content[c_mac_noline]',
            'content[c_pwd_web]',
            'content[c_tel_info]',
            'content[c_tel_2_info]',
            'content[c_org_s]',
        	'content[c_org]',
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
        $data_out['json_field_define']['c_sex']=get_html_json_for_arr($GLOBALS['m_contact']['text']['c_sex']);
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
                                    	case 'offa_item':
                                    		
                                    		$data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('offai_id',$v,element($k,$data_db['content']),'m_oa_contact','show_change_office');
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
                        
                        $this->m_table_op->load('sys_contact_add');
                        $data_db['content_c_add'] =  $this->m_table_op->get(element($this->pk_id,$data_get));

                        $data_db['content']= array_merge($data_db['content_c_add'],$data_db['content']);

                        if(element('c_ou_2',$data_db['content']))
                            $data_db['content']['c_ou_2']=$this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id = '{$data_db['content']['c_ou_2']}'");

                        if(element('c_ou_3',$data_db['content']))
                            $data_db['content']['c_ou_3']=$this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id = '{$data_db['content']['c_ou_3']}'");
                            
                        if(element('c_ou_4',$data_db['content']))
                            $data_db['content']['c_ou_4']=$this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id = '{$data_db['content']['c_ou_4']}'");

                        if($data_db['content']['c_org'])
                            $data_db['content']['c_org_s']=$this->m_base->get_field_where('sys_org','o_name',"AND o_id = '{$data_db['content']['c_org']}'");

                        //获取明细
                        $arr_search=array();
                        $arr_search['field']='*';
                        $arr_search['from']="oa_offa_item";
                        $arr_search['where']=' AND offai_c_id = ? ';
                        $arr_search['value'][]=element($this->pk_id,$data_get);
                        $arr_search['sort']=array("offai_time_start");
                        $arr_search['order']=array('desc');

                        $rs=$this->m_db->query($arr_search);
                        
                        $data_db['content']['offa_item'] = array();

                        if(count($rs['content'])>0)
                        {
                            foreach ($rs['content'] as $v) {

                                $v['offai_offi_id_s'] = $this->m_base->get_field_where('oa_office','offi_name'," AND offi_id = '{$v['offai_offi_id']}'");

                                if($v['offai_person_start'])
                                    $v['offai_person_start_s'] = $this->m_base->get_c_show_by_cid($v['offai_person_start']);

                                if($v['offai_person_end'])
                                    $v['offai_person_end_s'] = $this->m_base->get_c_show_by_cid($v['offai_person_end']);

                                $data_db['content']['offa_item'][]=$v;
                            }
                        }

                        $data_db['content']['offa_item'] = json_encode($data_db['content']['offa_item']);

                        //工单信息读取
                        $data_db['wl_list']=$this->m_work_list->get_wl_to_do(element($this->pk_id,$data_get),$this->model_name);

                    }
                } catch (Exception $e) {
                }
                break;
        }
        /************工单信息*****************/

        //工单控件展示标记
        $data_out['flag_wl'] = FALSE;
        $data_out['pp_id']=$this->model_name;
        $data_out['ppo_name']='';

        $data_out['ppo_btn_next']='通过';
        $data_out['ppo_btn_pnext']='退回';

        $data_out=$this->m_work_list->get_wl_info($data_out,$data_db);

        /************权限验证*****************/
        //@todo 权限验证

        $acl_list= $this->m_proc_office->get_acl();

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
        if( element( 'ppo',$data_db['content']) == 1 )
        {
            $data_out['op_disable'][]='btn_pnext';
        }

        if( element( 'ppo',$data_db['content']) != 1 )
        {
            $data_out['op_disable'][]='btn_del';
        }

        $data_out['flag_check'] = '';

        if(element('flag_edit_more', $data_get))
        {
            $data_out['field_required']=array();

            $data_out['op_disable'][]='btn_log';

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
                $rtn['err'] = array();

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
                
                /************事件处理*****************/
                switch ($data_get['act']) {
                    case STAT_ACT_CREATE:
                    	
                        $rtn=$this->add($data_save['content']);

                        $arr_log_content=array();
                        $arr_log_content['new']['content']=$data_save['content'];
                        $arr_log_content['old']['content'][$this->pk_id]=$rtn['id'];
                        if( ! empty(element('offa_item',$data_save['content']) ) )
                        {
                            if($flag_more && $data_save['content']['offa_c_id']){
                                $this->m_table_op->load('oa_offa_item');
                                foreach ($data_save['content']['offa_item'] as $k=>$v) {

                                    $data_save['offa_item']['offai_offi_id']=$v;
                                    $data_save['offa_item']['offa_id']=$rtn['id'];
                                    $data_save['offa_item']['offai_c_id'] = element('offa_c_id',$data_save['content']);

                                    $this->m_table_op->add($data_save['offa_item']);
                                }
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
                        
                		if( ! empty(element('office',$data_save['content']) ) )
						{
							$list_office_save = json_decode($data_save['content']['office'],TRUE);

							if(count( $list_office_save ) > 0 )
							{
								$v = array();
								$data_save['content_c']=array();
								
								foreach ($list_office_save as $k=>$v) {

									switch ( $v['offai_offi_id'] )
									{
										//LDAP账户
										case '26B028F103FD5AE7C1018A214D79E9EC':
											
											$data_save['content']['c_login_id'] = $v['c_login_id'];
											$data_save['content']['a_id'] = $v['a_id'];
											
										break;
			
										//短号
										case 'E733D2DF8A3A4D08E10F0604DD1689B0':
			
											$data_save['content']['c_tel_code'] = $v['c_tel_code'];
											
										break;
			
										//网络证书
										case '17384E798664501D49970BFF1959A175':
											
											$data_save['content']['c_pwd_web'] = $v['c_pwd_web'];
											
										break;
										
										//邮箱
										case 'BC952B1E100717A078BDD79B45CC0736':
											
											$data_save['content']['c_email_sys'] = $v['c_email_sys'];
											
										break;
										
										//工资邮箱
										case '53AB852B7054D11DBC846C5A6DBCE359':
											
											$data_save['content']['c_email_gz'] = $v['c_email_gz'];
										break;
										
										//手机上网id
										case 'FA31B79FEA42C7A246E7A78F5FCEE504':
											
											$data_save['content']['c_login_id_m'] = $v['c_login_id_m'];
											
										break;
									}
								}
							}
						}

                        $rtn=$this->update($data_save['content']);
                        
                        if( ! empty(element('offa_item',$data_save['content']) ) )
                        {
                            $arr_save=array(
                                'offai_c_id' => element('c_id',$data_db['content'])
                            );

                            $this->m_base->save_datatable('oa_offa_item',
                                $data_save['content']['offa_item'],
                                $data_db['content']['offa_item'],
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
        $data_out['flag_wl_win']=element('flag_wl_win', $data_get);

        $data_out['log']=json_encode(element('log', $data_out));

        $data_out['log_time']=$this->input->post('log_time');
        $data_out['log_a_login_id']=$this->input->post('log_a_login_id');
        $data_out['log_c_name']=$this->input->post('log_c_name');
        $data_out['log_act']=$this->input->post('log_act');
        $data_out['log_note']=$this->input->post('log_note');

        $data_out['db_time_create']=element('db_time_create', $data_db['content']);

        $c_id=element('offa_c_id',$data_db['content']);
        $hr_code=$this->m_base->get_field_where('hr_info','hr_code'," AND c_id ='{$c_id}'");
        $hr_code_pre=$this->m_base->get_field_where('hr_info','hr_code_pre'," AND c_id ='{$c_id}'");

        $data_out['code']=$hr_code_pre.$hr_code;
        $data_out['ppo']=element('ppo', $data_db['content']);

        $data_out['fun_no_db']=element('fun_no_db', $data_get);
        $data_out['data_db_post'] = $this->input->post('data_db');

        $data_out['flag_edit_more']=element('flag_edit_more', $data_get);
        $data_out['c_login_id']=element('c_login_id',$data_db['content']);

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
	 * 显信息系统开通变更
	 * @param $arr 
	 */
	public function show_change_office($id,$field,$v)
	{
		$rtn=array();
		$rtn['id'] = $id;
		$rtn['field'] = $field;
		$rtn['act'] = STAT_ACT_EDIT;
		$rtn['err_msg']= $v[$field];
		
		switch ($field)
		{
			case 'offai_offi_id':
				
				$v[$field] = $this->m_base->get_field_where('oa_office','offi_name'," AND offi_id = '{$v['offai_offi_id']}'");
				$rtn['err_msg'] =  $v[$field];
				
				break;
			case 'offai_time_start':
				
				$v['offai_start_info'] = $v['offai_time_end'].'<br>'.$v['offai_time_person'];
				
				$rtn['err_msg'] =  $v['offai_start_info'];
				
				break;
			case 'offai_time_end':
				$v['offai_end_info'] = $v['offai_time_end'].'<br>'.$v['offai_time_person'];
				
				$rtn['err_msg'] =  $v['offai_end_info'];
				
				break;
			case 'offai_person_start':
				$rtn['err_msg'] = $this->m_base->get_c_show_by_cid($v[$field]);
				break;
			case 'offai_person_end':
				$rtn['err_msg'] = $this->m_base->get_c_show_by_cid($v[$field]);
				break;
		}
		
		$rtn['err_msg']='变更前:'.$rtn['err_msg'];
		
		return $rtn;
	}
    
	/**
	 * 
	 * 获取日志条件
	 * @param  $arr_save
	 */
	function get_where_log($arr_search,$data_get)
	{
    	$arr_op_id = array();
    	
		$arr_search_link=array();
		$arr_search_link['field']='offa_id';
		$arr_search_link['from']='oa_office_apply';
		$arr_search_link['where']=' AND offa_c_id = ?';
		$arr_search_link['value'][]=$data_get['op_id'];
		$rs=$this->m_db->query($arr_search_link);
		
		if(count($rs['content'])>0)
		{
			foreach ($rs['content'] as $v) {
				$arr_op_id[] = $v['offa_id'];
			}
		}
		
		$arr_search_link=array();
		$arr_search_link['field']='offl_id';
		$arr_search_link['from']='oa_office_logout';
		$arr_search_link['where']=' AND offl_c_id = ?';
		$arr_search_link['value'][]=$data_get['op_id'];
		$rs=$this->m_db->query($arr_search_link);
		
		if(count($rs['content'])>0)
		{
			foreach ($rs['content'] as $v) {
				$arr_op_id[] = $v['offl_id'];
			}
		}
		
		$arr_op_id[] = $data_get['op_id'];
		
		$arr_search['where'].=' AND op_id IN ? ';
		$arr_search['value'][]=$arr_op_id;
		
		$arr_search['where'].=' AND log_p_id = ? ';
		$arr_search['value'][]='proc_office';
		
    	return $arr_search;
	}
}