<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 *  
    人事信息
 */
class M_hr_info extends CI_Model {
	
	//@todo 主表配置
	private $table_name='hr_info';
	private $pk_id='c_id';
	private $table_form;
	private $arr_table_form=array();
	private $title='员工信息';
	private $model_name = 'm_hr_info';
	private $url_conf = 'proc_hr/hr_info/edit';
	private $proc_id = 'proc_hr';
	
 	public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->m_define();
        
         //读取表结构
        $this->config->load('db_table/'.$this->table_name, FALSE,TRUE);
        $this->table_form=$this->config->item($this->table_name);
        
         //读取表结构
        $this->config->load('db_table/sys_contact', FALSE,TRUE);
        $this->arr_table_form['sys_contact']=$this->config->item('sys_contact');

        $this->config->load('db_table/sys_contact_add', FALSE,TRUE);
        $this->arr_table_form['sys_contact_add']=$this->config->item('sys_contact_add');
        
        $this->load->model('proc_back/m_account');
        $this->load->model('proc_contact/m_contact');
		$this->load->model('base/m_web_info');
        $this->load->model('proc_hr/m_hr');
        $this->load->model('proc_hr/m_hr_train');
		$this->load->model('proc_hr/m_hr_work');
		$this->load->model('proc_hr/m_hr_reward');
		$this->load->model('proc_hr/m_hr_idcard');
		$this->load->model('proc_hr/m_hr_card');
		$this->load->model('proc_hr/m_hr_edu');
		$this->load->model('proc_hr/m_hr_family');
		$this->load->model('proc_hr/m_hr_family_crime');
		$this->load->model('proc_hr/m_hr_family_card');
        $this->load->model('proc_hr/m_hr_contract');
    }

	/**
     *
     * 定义
     */
	public function m_define()
    {
    	//@todo 定义
    	if( defined('LOAD_M_HR_INFO') ) return;
    	define('LOAD_M_HR_INFO', 1);

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
    	
    	if( ! $act) $act = STAT_ACT_CREATE;

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
    	 && $act == STAT_ACT_CREATE
    	 && ($acl_list & pow(2,ACL_PROC_HR_INFO_CHECK )) != 0 )
    	{
    		return TRUE;
    	}
    	
    	if(  ! $check_acl 
    	 && element('flag_edit_more', $data_get) == 1
    	 && ($acl_list & pow(2,ACL_PROC_HR_INFO_CHECK )) != 0  )
    	{
    	 	return TRUE;
    	}
    	
    	if( ! $check_acl 
    	 && element('c_id', $data_db['content']) == $this->sess->userdata('c_id') )
        {
        	$check_acl=TRUE;
        }

        if( ! $check_acl
    	 && ($acl_list & pow(2,ACL_PROC_HR_VIEW_ALL )) == 0
    	 && element('c_org', $data_db['content']) != $this->sess->userdata('c_org')
    	 && element('c_hr_org', $data_db['content']) != $this->sess->userdata('c_org')
    	)
	    {
        	$msg = '您不属于【'.element('c_org_s', $data_db['content']).'】,不可查看相关信息！' ;
			redirect('base/main/show_err/msg/'.fun_urlencode($msg));
        }

    	if( ! $check_acl
    	 && $act == STAT_ACT_EDIT
    	 && ($acl_list & pow(2,ACL_PROC_HR_USER)) == 0
    	)
	    {
	     	$url=current_url();
			$url=str_replace('/act/2','/act/3',$url);
			redirect($url);
	    }

    	if( ! $check_acl
    	 && $act == STAT_ACT_VIEW
    	 && ($acl_list & pow(2,ACL_PROC_HR_INFO_CHECK )) == 0
    	 && ($acl_list & pow(2,ACL_PROC_HR_USER )) == 0
    	 && ($acl_list & pow(2,ACL_PROC_HR_INFO )) == 0
    	 && ($acl_list & pow(2,ACL_PROC_HR_VIEW )) == 0
    	)
	    {
	     	$msg = '您没有【'.$this->title.'】的【员工信息-查看】权限不可进行操作！' ;
			redirect('base/main/show_err/msg/'.fun_urlencode($msg));
	    }

	    if( ! $check_acl
    	 && ($acl_list & pow(2,ACL_PROC_HR_USER )) != 0
    	)
	    {
	    	$check_acl = TRUE;
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

    	$pre=$this->m_base->get_field_where('sys_ou','ou_org_pre'," AND ou_id ='{$data_save['content']['c_hr_org']}'");

    	$pre_ou = $this->m_base->get_field_where('sys_ou','ou_org_pre'," AND ou_id ='{$data_save['content']['c_ou_2']}'");
    	
    	if($pre_ou) $pre = $pre_ou;
    	
    	switch (element('hr_type_work', $data_save['content']))
    	{
    		case HR_TYPE_WORK_SY:
    		case HR_TYPE_WORK_ZS:
    		case HR_TYPE_WORK_SX:
    			$pre.='-';
    			break;
    		case HR_TYPE_WORK_JX:
			case HR_TYPE_WORK_QT:
			case HR_TYPE_WORK_WB:
			case HR_TYPE_WORK_LW:
				$pre.='QT-';
    			break;
    		default:
    			$pre.='-';
    	}

//    	switch (element('c_hr_org', $data_save['content']))
//    	{
//    		//成都
//    		case '22B090894556F980B81361AA996ACF3B':
//    			$pre='CD'.$pre_hr_type_work;
//    			break;
//    		//北京
//    		case '52D7478777D4BA42B3ECD05DCA53B7C9':
//    		case '92F7520839C9108378883C6A90BEBFBE':
//    			$pre='BJ'.$pre_hr_type_work;
//    			break;
//    		//广州
//    		case '95844F63647F4D89B7773198DDCE04C0':
//    			$pre='GZ'.$pre_hr_type_work;
//    			break;
//    		//杭州
//    		case '9F8453E40A17EDDAA9EE72BB49C52E83':
//    			$pre='HZ';
//    			break;
//    		//上海
//    		case 'B12F0862F53C9772369A4A990D7EA510':
//    			$pre='SH'.$pre_hr_type_work;
//    			break;
//    		default:
//    	}
//
//    	switch (element('c_ou_2', $data_save['content']))
//    	{
//    		case 'D8CE0D3C523D8F3DDF541A3F2829480F':
//    			$pre='WH'.$pre_hr_type_work;
//    			break;
//    		case 'F5F754E88D72AC08CD8E6672A797946A':
//    			$pre='NJ'.$pre_hr_type_work;
//    			break;
//    	}

    	switch (element('c_hr_org', $data_save['content']))
    	{
    		//成都
    		case '22B090894556F980B81361AA996ACF3B':
    		//北京
    		case '52D7478777D4BA42B3ECD05DCA53B7C9':
    		case '92F7520839C9108378883C6A90BEBFBE':
    		//广州
    		case '95844F63647F4D89B7773198DDCE04C0':
    		//上海
    		case 'B12F0862F53C9772369A4A990D7EA510':

    			$pre.='30';
		    	$where .= " AND hr_code_pre LIKE  '{$pre}%'";

		    	$max_code=$this->m_db->get_m_value('hr_info','hr_code',$where);
		    	$code=str_pad((intval($max_code)+1), 4, '0', STR_PAD_LEFT);

    			break;
    		//杭州
    		case '9F8453E40A17EDDAA9EE72BB49C52E83':

    			$pre.='30';
		    	$where .= " AND hr_code_pre LIKE  '{$pre}%'";

		    	$max_code=$this->m_db->get_m_value('hr_info','hr_code',$where);
		    	$code=intval($max_code)+1;

    			break;
    	}

    	$data_save['content']['hr_code'] = $code;
    	$data_save['content']['hr_code_pre'] = $pre;

    	return $data_save;
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

    	$this->m_table_op->load('sys_contact_add');
		$data_db['content_c_add']=$this->m_table_op->get( $data_save['content']['c_id']);

		if( empty($data_db['content_c_add']) )
		{
			$rtn=$this->m_db->insert($data_save['content'],'sys_contact_add');
		}

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
        $rtn=$this->m_db->update('sys_contact',$data_save['content'],$where);

        if($rtn['rtn'])
        $rtn=$this->m_db->update('sys_contact_add',$data_save['content'],$where);

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
    		'sys_contact.c_id'
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
        $rtn=$this->m_db->delete('sys_contact_add',$where);

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
            'hr_info[hr_code]',
            'sys_contact[c_name]',
    		'sys_contact[c_login_id]',
            'sys_contact[c_sex]',
            'sys_contact[c_birthday]',
            'sys_contact_add[c_mz]',
            'sys_contact_add[c_hy]',
            'sys_contact[c_zzmm]',
            'sys_contact[c_code_person]',
            'sys_contact[c_tel]',
            'sys_contact[c_phone]',
            'sys_contact[c_email]',
            'sys_contact_add[c_hj]',
            'sys_contact_add[c_addr_live]',
            'sys_contact_add[c_addr]',
            'sys_contact_add[c_time_graduate]',
            'sys_contact_add[c_school]',
            'sys_contact_add[c_zy]',
    		'sys_contact[c_xw]',
    		'sys_contact[c_bank_type]',
            'sys_contact[c_bank]',
    		'sys_contact_add[c_time_work]',
    		'sys_contact[c_org]',
    		'sys_contact[c_hr_org]',
            'sys_contact[c_ou_2]',
            'sys_contact[c_ou_3]',
            'sys_contact[c_ou_4]',
    		'sys_contact[c_job]',
    		'hr_info[hr_zw_1]',
            'hr_info[hr_zw_2]',
            'hr_info[hr_zw_3]',
    		'hr_info[hr_zcdj]',
            'hr_info[hr_zclb]',
            'hr_info[hr_time_ht]',
            'hr_info[hr_time_htdq]',
            'hr_info[hr_type_work]',
            'hr_info[hr_type]',
            'hr_info[hr_time_rz]',
            'hr_info[hr_wage_set]',
            'hr_info[hr_time_lz]',
            'hr_info[hr_time_zz]',
    		'hr_info[hr_shbx]',
    		'sys_contact[c_card_gjj]',
    		'sys_contact[c_card_sb]',
    		'hr_info[hr_vacation]',
    	);

    	$conf['field_required']=array(
            'hr_info[hr_code]',
            'sys_contact[c_name]',
    		'sys_contact[c_login_id]',
            'sys_contact[c_sex]',
            'sys_contact[c_birthday]',
//            'sys_contact_add[c_mz]',
//            'sys_contact_add[c_jg]',
//            'sys_contact_add[c_hy]',
//            'sys_contact[c_zzmm]',
            'sys_contact[c_code_person]',
            'sys_contact[c_tel]',
//            'sys_contact[c_phone]',
            'sys_contact[c_email]',
//            'sys_contact_add[c_hj]',
//            'sys_contact_add[c_addr_live]',
//            'sys_contact_add[c_addr]',
//            'sys_contact_add[c_time_graduate]',
//            'sys_contact_add[c_school]',
//            'sys_contact_add[c_zy]',
//    		'sys_contact[c_xw]',
    		'sys_contact[c_bank_type]',
            'sys_contact[c_bank]',
    		'sys_contact[c_org]',
    		'sys_contact[c_hr_org]',
            'sys_contact[c_ou_2]',
            'sys_contact[c_ou_3]',
            'sys_contact[c_ou_4]',
    		'sys_contact[c_job]',
    		'hr_info[hr_zw_1]',
            'hr_info[hr_zw_2]',
            'hr_info[hr_zw_3]',
//    		'hr_info[hr_zcdj]',
//            'hr_info[hr_zclb]',
//            'hr_info[hr_time_ht]',
//            'hr_info[hr_time_htdq]',
            'hr_info[hr_type_work]',
            'hr_info[hr_type]',
            'hr_info[hr_time_rz]',
//            'hr_info[hr_wage_set]',
//            'hr_info[hr_time_lz]',
//            'hr_info[hr_time_zz]',
    		'hr_info[hr_shbx]',
//    		'sys_contact[c_card_gjj]',
//    		'sys_contact[c_card_sb]',
//    		'hr_info[hr_vacation]',
    	);

    	$arr_c_bank_type = $GLOBALS['m_hr']['text']['c_bank_type'];
    	unset($arr_c_bank_type[4]);
    	unset($arr_c_bank_type[5]);
    	
    	$conf['field_define']=array(
            'sys_contact[c_sex]'=>$GLOBALS['m_contact']['text']['c_sex'],
            'sys_contact_add[c_hy]'=>$GLOBALS['m_hr']['text']['c_hy'],
            'sys_contact[c_zzmm]'=>$GLOBALS['m_hr']['text']['c_zzmm'],
            'sys_contact[c_bank_type]'=>$arr_c_bank_type,
            'hr_info[hr_type_work]'=>$GLOBALS['m_hr']['text']['hr_type_work'],
            'hr_info[hr_type]'=>$GLOBALS['m_hr']['text']['hr_type'],
    		'hr_info[hr_zw_1]'=>$GLOBALS['m_hr']['text']['hr_zw_1'],
    		'hr_info[hr_zw_2]'=>$GLOBALS['m_hr']['text']['hr_zw_2'],
    		'hr_info[hr_zw_3]'=>$GLOBALS['m_hr']['text']['hr_zw_3'],
            'sys_contact[c_xw]'=>$GLOBALS['m_hr']['text']['c_xw'],
            'hr_info[hr_zcdj]'=>$GLOBALS['m_hr']['text']['hr_zcdj'],
            'hr_info[hr_zclb]'=>$GLOBALS['m_hr']['text']['hr_zclb'],
    		'hr_info[hr_shbx]'=>$GLOBALS['m_hr']['text']['hr_shbx'],
    	);

    	$this->arr_table_form['sys_contact']['fields']['c_card_gjj']['comment'] = '公积金';
    	$this->arr_table_form['sys_contact']['fields']['c_card_sb']['comment'] = '社保账号';
    	
    	$conf['table_form']=array(
            'hr_info'=>$this->table_form,
            'sys_contact'=>$this->arr_table_form['sys_contact'],
            'sys_contact_add'=>$this->arr_table_form['sys_contact_add'],
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
			'content[c_name]',
			'content[c_sex]',
			'content[hr_code_pre]',
			'content[hr_code]',
		);

		//编辑数组
		$data_out['field_edit']=array(
			'content[db_time_update]',
			'content[c_id]',
			'content[c_org]',
			'content[c_org_s]',
			'content[c_name]',
			'content[c_name_old]',
			'content[c_img]',
			'content[c_img_show]',
			'content[c_sex]',
			'content[c_hy]',
			'content[c_code_person]',
			'content[c_zzmm]',
			'content[c_birthday]',
			'content[c_time_work]',
			'content[c_xl]',
			'content[c_xl_day]',
			'content[c_xw]',
			'content[c_mz]',
			'content[c_jg]',
			'content[c_jg_show]',
			'content[c_tel]',
			'content[c_tel_info]',
			'content[c_tel_2]',
			'content[c_tel_2_info]',
			'content[c_email]',
			'content[c_interest]',
			'content[c_mac_line]',
			'content[c_mac_noline]',

			'content[hr_code_pre]',
			'content[hr_code]',
			'content[c_login_id]',
			'content[c_email_sys]',
			'content[c_tel_code]',
			'content[c_hr_org]',
			'content[c_hr_org_s]',
			'content[hr_offer]',
			'content[hr_work_place]',
			'content[hr_gqjl]',
			'content[hr_shbx]',
			'content[hr_vacation]',
			'content[c_ou_2_s]',
			'content[c_ou_3_s]',
			'content[c_ou_4_s]',
			'content[c_ou_2]',
			'content[c_ou_3]',
			'content[c_ou_4]',
			'content[c_job_s]',
			'content[c_job]',
			'content[hr_zclb]',
			'content[hr_zcdj]',
			'content[hr_zw_1]',
			'content[hr_zw_2]',
			'content[hr_zw_3]',
			'content[hr_tec]',
			'content[hr_tec_data]',
			'content[hr_type_work]',
			'content[hr_type]',
			'content[hr_wage]',
			'content[hr_time_rz]',
			'content[hr_time_zz]',
			'content[hr_wage_org]',
			'content[hr_wage_set]',
			'content[hr_time_ht]',
			'content[hr_time_htdq]',
			'content[hr_time_lz]',
			'content[hr_ht_year]',
			'content[hr_num_xq]',
            'content[hr_contract]',
			'content[hr_train_org]',
			'content[hr_reward]',

			'content[c_bank_type]',
			'content[c_bank]',

			'content[hr_train]',

			'content[hr_family]',
			'content[hr_family_crime]',
			'content[c_family_crime]',
			'content[hr_family_card_gat]',
			'content[hr_family_card]',
			'content[c_family_gat]',
			'content[c_family_foreign]',

			'content[hr_edu]',

			'content[hr_work]',

			'content[hr_idcard]',

			'content[hr_card]',

			'content[c_doc_org]',
			'content[c_doc_addr]',
			'content[c_doc_addr_postcode]',
			'content[c_doc_code]',
			'content[c_doc_person]',
			'content[c_doc_person_tele]',

			'content[c_addr_live]',
			'content[c_post_code_live]',
			'content[c_phone_addrl]',
			'content[c_addr]',
			'content[c_post_code]',
			'content[c_phone]',
			'content[c_jzjd]',
			'content[c_jzdfw]',
			'content[c_hj]',
			'content[c_hjjzz]',
			'content[c_jzlxr]',
			'content[c_jzlxr_gx]',
			'content[c_jzlxr_tele]',
			'content[c_jzlxr_dz]',

			'content[c_school]',
			'content[c_time_graduate]',
			'content[c_zy]',
		);

		//只读数组
		$data_out['field_view']=array(
			'content[c_id]',
			'content[hr_wage_org_s]',
			'content[hr_code_s]',
			'content[c_age]',
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

		$flag_more = element('flag_more', $data_post);
		$flag_print = element('flag_print', $data_get);
		/************字段定义*****************/
		//@todo 字段定义
		$arr_field=array_unique(array_merge($data_out['field_edit'], $data_out['field_view']));

		$data_out['json_field_define']=array();
		$data_out['json_field_define']['c_sex']=get_html_json_for_arr($GLOBALS['m_contact']['text']['c_sex']);
		$data_out['json_field_define']['c_hy']=get_html_json_for_arr($GLOBALS['m_hr']['text']['c_hy']);
		$data_out['json_field_define']['base_yn']=get_html_json_for_arr($GLOBALS['m_base']['text']['base_yn']);
		$data_out['json_field_define']['c_xl']=get_html_json_for_arr($GLOBALS['m_hr']['text']['c_xl']);
		$data_out['json_field_define']['c_xw']=get_html_json_for_arr($GLOBALS['m_hr']['text']['c_xw']);
		$data_out['json_field_define']['c_zzmm']=get_html_json_for_arr($GLOBALS['m_hr']['text']['c_zzmm']);
		$data_out['json_field_define']['hr_shbx']=get_html_json_for_arr($GLOBALS['m_hr']['text']['hr_shbx']);
		$data_out['json_field_define']['hr_zcdj']=get_html_json_for_arr($GLOBALS['m_hr']['text']['hr_zcdj']);
		$data_out['json_field_define']['hr_zclb']=get_html_json_for_arr($GLOBALS['m_hr']['text']['hr_zclb']);
		$data_out['json_field_define']['hr_zw_1']=get_html_json_for_arr($GLOBALS['m_hr']['text']['hr_zw_1']);
		$data_out['json_field_define']['hr_zw_2']=get_html_json_for_arr($GLOBALS['m_hr']['text']['hr_zw_2']);
		$data_out['json_field_define']['hr_zw_3']=get_html_json_for_arr($GLOBALS['m_hr']['text']['hr_zw_3']);
		$data_out['json_field_define']['hr_type_work']=get_html_json_for_arr($GLOBALS['m_hr']['text']['hr_type_work']);
		$data_out['json_field_define']['hr_type']=get_html_json_for_arr($GLOBALS['m_hr']['text']['hr_type']);
		$data_out['json_field_define']['c_bank_type']=get_html_json_for_arr($GLOBALS['m_hr']['text']['c_bank_type']);
		$data_out['json_field_define']['c_jzdfw']=get_html_json_for_arr($GLOBALS['m_hr']['text']['c_jzdfw']);
		$data_out['json_field_define']['c_hj']=get_html_json_for_arr($GLOBALS['m_hr']['text']['c_hj']);
		$data_out['json_field_define']['c_hjjzz']=get_html_json_for_arr($GLOBALS['m_hr']['text']['c_hjjzz']);
		$data_out['json_field_define']['f_have']=get_html_json_for_arr($GLOBALS['m_hr']['text']['f_have']);
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
										case 'hr_train_org':

											$data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('hr_t_id',$v,element($k,$data_db['content']),'m_hr_train','show_change_hr_info');
											$data_db['content'][$k] =$v ;
											break;
										case 'hr_train':

											$data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('hr_t_id',$v,element($k,$data_db['content']),'m_hr_train','show_change_hr_info');
											$data_db['content'][$k] =$v ;
											break;

										case 'hr_edu':

											$data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('hr_edu_id',$v,element($k,$data_db['content']),'m_hr_edu','show_change_hr_info');
											$data_db['content'][$k] =$v ;
											break;

										case 'hr_reward':

											$data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('hr_rp_id',$v,element($k,$data_db['content']),'m_hr_reward','show_change_hr_info');
											$data_db['content'][$k] =$v ;
											break;

                                        case 'hr_contract':

                                            $data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('cont_id',$v,element($k,$data_db['content']),'m_hr_contract','show_change_hr_info');
                                            $data_db['content'][$k] =$v ;

                                            break;

										case 'hr_idcard':

											$data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('hr_idc_id',$v,element($k,$data_db['content']),'m_hr_idcard','show_change_hr_info');
											$data_db['content'][$k] =$v ;
											break;

										case 'hr_card':

											$data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('hr_card_id',$v,element($k,$data_db['content']),'m_hr_card','show_change_hr_info');
											$data_db['content'][$k] =$v ;
											break;

										case 'hr_work':

											$data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('hr_w_id',$v,element($k,$data_db['content']),'m_hr_work','show_change_hr_info');
											$data_db['content'][$k] =$v ;
											break;

										case 'hr_family':

											$data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('hr_f_id',$v,element($k,$data_db['content']),'m_hr_family','show_change_hr_info');
											$data_db['content'][$k] =$v ;
											break;

										case 'hr_family_crime':

											$data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('hr_fc_id',$v,element($k,$data_db['content']),'m_hr_family_crime','show_change_hr_info');
											$data_db['content'][$k] =$v ;
											break;

										case 'hr_family_card_gat':

											$data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('hr_fcard_id',$v,element($k,$data_db['content']),'m_hr_family_card','show_change_hr_info');
											$data_db['content'][$k] =$v ;
											break;

										case 'hr_family_card':

											$data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('hr_fcard_id',$v,element($k,$data_db['content']),'m_hr_family_card','show_change_hr_info');
											$data_db['content'][$k] =$v ;
											break;

										case 'hr_tec':

											$diff='';

											$arr_f=array();
											if( $data_db['content']['hr_tec_data'] )
												$arr_f = json_decode($data_db['content']['hr_tec_data'] ,TRUE);

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
									         && isset($GLOBALS['m_hr']['text'][$k][$v]) )
											$data_db['content'][$k]=$GLOBALS['m_hr']['text'][$k][element($k,$data_db['content'])];

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

						$this->m_table_op->load('sys_contact');
						$data_db['content_c'] =  $this->m_table_op->get(element($this->pk_id,$data_get));

						if( empty($data_db['content'][$this->pk_id])
						 && ! empty($data_db['content_c'][$this->pk_id]) )
						{
							$url = str_replace('proc_hr/hr_info', 'proc_contact/contact', current_url());
							redirect($url);
						}

						$this->m_table_op->load('sys_contact_add');
						$data_db['content_c_add'] =  $this->m_table_op->get(element($this->pk_id,$data_get));

						$data_db['content']= array_merge($data_db['content_c_add'],$data_db['content_c'],$data_db['content']);

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

						if( ! empty($data_db['content']['hr_time_rz']) )
						{

							$data_db['content']['hr_wage_org'] = time_diff(date("Y-m-d"), $data_db['content']['hr_time_rz'],array('Y'=>''));
							$data_db['content']['hr_wage_org_s'] = $data_db['content']['hr_wage_org']+$data_db['content']['hr_wage_set'];
						}

						//工单信息读取
						$data_db['wl_list']=$this->m_work_list->get_wl_to_do(element($this->pk_id,$data_get),$this->model_name);

						$data_db['content']['hr_code_s']=$data_db['content']['hr_code_pre'].$data_db['content']['hr_code'];

						if( ! empty($data_db['content']['c_birthday']) )
						{
							$data_db['content']['c_age']=date("Y")-date('Y', strtotime($data_db['content']['c_birthday']));
							$data_db['content']['c_age'].='岁';
						}

						if($data_db['content']['c_org'])
						$data_db['content']['c_org_s']=$this->m_base->get_field_where('sys_org','o_name',"AND o_id = '{$data_db['content']['c_org']}'");

						if( ! empty($data_db['content']['c_job']) )
						$data_db['content']['c_job_s']=$this->m_base->get_field_where('hr_job','job_name'," AND job_id = '{$data_db['content']['c_job']}'");

						if( ! empty($data_db['content']['c_ou_2']) )
						$data_db['content']['c_ou_2_s']=$this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id = '{$data_db['content']['c_ou_2']}'");

						if( ! empty($data_db['content']['c_ou_3']) )
						$data_db['content']['c_ou_3_s']=$this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id = '{$data_db['content']['c_ou_3']}'");

						if( ! empty($data_db['content']['c_ou_4']) )
						$data_db['content']['c_ou_4_s']=$this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id = '{$data_db['content']['c_ou_4']}'");


						//获取培训记录
						$arr_search=array();
						$arr_search['field']='*';
						$arr_search['from']="hr_train";
						$arr_search['where']=' AND c_id = ? ';
						$arr_search['value'][]=element('c_id',$data_get);
						$arr_search['sort']=array("hr_t_time_start");
						$arr_search['order']=array('desc');

						$rs=$this->m_db->query($arr_search);

						$data_db['content']['hr_train_org'] = array();
						$data_db['content']['hr_train'] = array();

						if(count($rs['content'])>0)
						{
							foreach ($rs['content'] as $v) {

								if($v['hr_t_type'] == HR_T_TYPE_ORG)
								$data_db['content']['hr_train_org'][]=$v;
								else
								$data_db['content']['hr_train'][]=$v;
							}
						}

						$data_db['content']['hr_train_org'] = json_encode($data_db['content']['hr_train_org']);
						$data_db['content']['hr_train'] = json_encode($data_db['content']['hr_train']);

						//获取证件记录
						$arr_search=array();
						$arr_search['field']='*';
						$arr_search['from']="hr_family_card";
						$arr_search['where']=' AND c_id = ? ';
						$arr_search['value'][]=element('c_id',$data_get);
						$arr_search['sort']=array("hr_fcard_id");
						$arr_search['order']=array('desc');

						$rs=$this->m_db->query($arr_search);

						$data_db['content']['hr_family_card_gat'] = array();
						$data_db['content']['hr_family_card'] = array();

						if(count($rs['content'])>0)
						{
							foreach ($rs['content'] as $v) {

								if($v['hr_fcard_type'] == HR_FCARD_TYPE_JJZ)
									$data_db['content']['hr_family_card_gat'][]=$v;
								else if($v['hr_fcard_type'] == HR_FCARD_TYPE_LK)
									$data_db['content']['hr_family_card'][]=$v;
							}
						}

						$data_db['content']['hr_family_card_gat'] = json_encode($data_db['content']['hr_family_card_gat']);
						$data_db['content']['hr_family_card'] = json_encode($data_db['content']['hr_family_card']);

						//获取工作经历
						$arr_search=array();
						$arr_search['field']='*';
						$arr_search['from']="hr_work";
						$arr_search['where']=' AND c_id = ? ';
						$arr_search['value'][]=element('c_id',$data_get);
						$arr_search['sort']=array("hr_w_time_start");
						$arr_search['order']=array('desc');

						$rs=$this->m_db->query($arr_search);

						$data_db['content']['hr_work'] = array();

						if(count($rs['content'])>0)
						{
							foreach ($rs['content'] as $v) {
								$data_db['content']['hr_work'][]=$v;
							}
						}

						$data_db['content']['hr_work'] = json_encode($data_db['content']['hr_work']);

						//获取家庭信息
						$arr_search=array();
						$arr_search['field']='*';
						$arr_search['from']="hr_family";
						$arr_search['where']=' AND c_id = ? ';
						$arr_search['value'][]=element('c_id',$data_get);
						$arr_search['sort']=array("hr_f_relation");
						$arr_search['order']=array('desc');

						$rs=$this->m_db->query($arr_search);

						$data_db['content']['hr_family'] = array();

						if(count($rs['content'])>0)
						{
							foreach ($rs['content'] as $v) {
								$data_db['content']['hr_family'][]=$v;
							}
						}

						$data_db['content']['hr_family'] = json_encode($data_db['content']['hr_family']);

						//获取犯罪记录
						$arr_search=array();
						$arr_search['field']='*';
						$arr_search['from']="hr_family_crime";
						$arr_search['where']=' AND c_id = ? ';
						$arr_search['value'][]=element('c_id',$data_get);
						$arr_search['sort']=array("hr_fc_description");
						$arr_search['order']=array('desc');

						$rs=$this->m_db->query($arr_search);

						$data_db['content']['hr_family_crime'] = array();

						if(count($rs['content'])>0)
						{
							foreach ($rs['content'] as $v) {
								$data_db['content']['hr_family_crime'][]=$v;
							}
						}

						$data_db['content']['hr_family_crime'] = json_encode($data_db['content']['hr_family_crime']);

						//获取奖惩记录
						$arr_search=array();
						$arr_search['field']='*';
						$arr_search['from']="hr_reward";
						$arr_search['where']=' AND c_id = ? ';
						$arr_search['value'][]=element('c_id',$data_get);
						$arr_search['sort']=array("hr_rp_date");
						$arr_search['order']=array('desc');

						$rs=$this->m_db->query($arr_search);

						$data_db['content']['hr_reward'] = array();

						if(count($rs['content'])>0)
						{
							foreach ($rs['content'] as $v) {


								if($v['hr_rp_person_approve'])
								$v['hr_rp_person_approve_s'] = $this->m_base->get_c_show_by_cid($v['hr_rp_person_approve']);

								$v['hr_rp_ou_approve_s'] = $this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id = '{$v['hr_rp_ou_approve']}'");
								$data_db['content']['hr_reward'][]=$v;
							}
						}

						$data_db['content']['hr_reward'] = json_encode($data_db['content']['hr_reward']);

                        //获取合同信息
                        $arr_search=array();
                        $arr_search['field']='*';
                        $arr_search['from']="hr_contract";
                        $arr_search['where']=' AND c_id = ? ';
                        $arr_search['value'][]=element('c_id',$data_get);

                        $rs=$this->m_db->query($arr_search);

                        $data_db['content']['hr_contract'] = array();

                        if(count($rs['content'])>0)
                        {
                            foreach ($rs['content'] as $v) {

                                foreach($v as $k1=>$v1){
                                    switch($k1){

                                        case 'cont_hr_type':
                                            $v[$k1.'_s']=$GLOBALS['m_hr']['text']['hr_type'][$v1];
                                            break;
                                        case 'cont_hr_type_work':
                                            $v[$k1.'_s']=$GLOBALS['m_hr']['text']['hr_type_work'][$v1];
                                            break;
                                        case 'cont_type':
                                             $v[$k1.'_s']=$GLOBALS['m_hr']['text']['cont_type'][$v1];
                                            break;

                                    }
                                }
                                $v['c_name_s'] = $data_db['content']['c_name'].'['. $data_db['content']['c_login_id'].']';
                                $v['hr_code_s']=$data_db['content']['hr_code_pre'].$data_db['content']['hr_code'];
                                
                                $data_db['content']['hr_contract'][]=$v;
                            }
                        }

                        $data_db['content']['hr_contract'] = json_encode($data_db['content']['hr_contract']);

						//获取身份证件
						$arr_search=array();
						$arr_search['field']='*';
						$arr_search['from']="hr_idcard";
						$arr_search['where']=' AND c_id = ? ';
						$arr_search['value'][]=element('c_id',$data_get);
						$arr_search['sort']=array("hr_idc_type");
						$arr_search['order']=array('desc');

						$rs=$this->m_db->query($arr_search);

						$data_db['content']['hr_idcard'] = array();

						if(count($rs['content'])>0)
						{
							foreach ($rs['content'] as $v) {
								$data_db['content']['hr_idcard'][]=$v;
							}
						}

						$data_db['content']['hr_idcard'] = json_encode($data_db['content']['hr_idcard']);

						//获取教育
						$arr_search=array();
						$arr_search['field']='*';
						$arr_search['from']="hr_edu";
						$arr_search['where']=' AND c_id = ? ';
						$arr_search['value'][]=element('c_id',$data_get);
						$arr_search['sort']=array("hr_edu_id");
						$arr_search['order']=array('desc');

						$rs=$this->m_db->query($arr_search);

						$data_db['content']['hr_edu'] = array();

						if(count($rs['content'])>0)
						{
							foreach ($rs['content'] as $v) {
									$data_db['content']['hr_edu'][]=$v;
							}
						}

						$data_db['content']['hr_edu'] = json_encode($data_db['content']['hr_edu']);

						//获取卡帐信息
						$arr_search=array();
						$arr_search['field']='*';
						$arr_search['from']="hr_card";
						$arr_search['where']=' AND c_id = ? ';
						$arr_search['value'][]=element('c_id',$data_get);
						$arr_search['sort']=array("hr_card_type");
						$arr_search['order']=array('desc');

						$rs=$this->m_db->query($arr_search);

						$data_db['content']['hr_card'] = array();

						if(count($rs['content'])>0)
						{
							foreach ($rs['content'] as $v) {
								$v['hr_card_type_s'] = $GLOBALS['m_hr']['text']['c_bank_type'][$v['hr_card_type']];
								$data_db['content']['hr_card'][]=$v;
							}
						}

						$data_db['content']['hr_card'] = json_encode($data_db['content']['hr_card']);

						if($data_db['content']['c_family_crime'] == NULL){
							$data_db['content']['c_family_crime'] =F_HAVE_N;
						}
						if($data_db['content']['c_family_gat'] == NULL){
							$data_db['content']['c_family_gat'] =F_HAVE_N;
						}
						if($data_db['content']['c_family_foreign'] == NULL){
							$data_db['content']['c_family_foreign'] =F_HAVE_N;
						}

						//获取技术方向
						$arr_search_link=array();
						$arr_search_link['rows']=0;
						$arr_search_link['field']='link_id';
						$arr_search_link['from']='sys_link';
						$arr_search_link['where']=" AND op_id = ? AND op_table = ? AND op_field = ? AND content = ?";
						$arr_search_link['value'][]=element('c_id',$data_db['content']);
						$arr_search_link['value'][]='hr_info';
						$arr_search_link['value'][]='c_id';
						$arr_search_link['value'][]='hr_tec';
						$rs_link=$this->m_db->query($arr_search_link);
						$data_db['content']['hr_tec']=array();
						$data_db['content']['hr_tec_data']=array();

						if(count($rs_link['content'])>0)
						{
							foreach ( $rs_link['content'] as $v ) {
								$data_db['content']['hr_tec'][]=$v['link_id'];

								$data_db['content']['hr_tec_data'][]=array(
									'id'=>$v['link_id'],
									'text'=>$this->m_base->get_field_where('hr_tec','tec_name'," AND tec_id = '{$v['link_id']}'")
								);
							}
						}

						$data_db['content']['hr_tec_data']=json_encode($data_db['content']['hr_tec_data']);
					}

					$path_img=$this->config->item('base_photo_path').element('c_img',$data_db['content']).'.jpg';
					if(file_exists($path_img))
	        		$data_db['content']['c_img_show']='data:image/jpeg;base64,'.getImgBaseStr($path_img);

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

		$acl_list= $this->m_proc_hr->get_acl();

		if( ! empty (element('acl_wl_yj', $data_out)) )
		$acl_list= $acl_list | $data_out['acl_wl_yj'];

		$this->check_acl($data_db,$acl_list);

		/************显示配置*****************/
		//@todo 显示配置
		$title_field='-'.element('hr_code_s',$data_db['content'])
					.'-'.element('c_name',$data_db['content']);

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
				$data_db['content']['c_family_crime'] = F_HAVE_N;
				$data_db['content']['c_family_gat'] = F_HAVE_N;
				$data_db['content']['c_family_foreign'] = F_HAVE_N;
				
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

		//编辑标记，去除审核权限
		if( element('flag_edit', $data_get)
		 && ($acl_list & pow(2,ACL_PROC_HR_INFO_CHECK)) != 0)
		{
			$acl_list -= pow(2,ACL_PROC_HR_INFO_CHECK);
		}

		$data_out['op_disable'][]='btn_del';
		$data_out['op_disable'][]='btn_pnext';

		$data_out['ppo_name'] = '信息修改';

		$data_out['flag_check'] = '';

		//存在身份证，生日只读
		if( element('c_code_person', $data_db['content']) )
		{
			$data_out['field_view'][]='content[c_birthday]';
		}

		//信息未补全
		if( element('hr_info_finish', $data_db['content']) == 0 )
		{
			$data_out['ppo_name'] = '信息补全';

			if( element('c_id', $data_db['content']) != $this->sess->userdata('c_id'))
			{
				$data_out['op_disable'][]='btn_next';
			}

			$data_out['ppo_btn_next']='提交';

		}
		//信息已补全,且没有人事信息审核权限
		elseif( ($acl_list & pow(2,ACL_PROC_HR_INFO_CHECK)) == 0 )
		{
			$data_out['ppo_btn_next']='修改';
			$data_out['op_disable'][]='btn_save';
		}

		//没有审核权限，工作信息只读
		if( ($acl_list & pow(2,ACL_PROC_HR_INFO_CHECK)) == 0 )
		{
			$data_out['field_view'] = array_unique(array_merge($data_out['field_view'],array(
				'content[hr_code_pre]',
				'content[hr_code]',
				'content[c_org]',
				'content[c_org_s]',
				'content[c_login_id]',
				'content[c_email_sys]',
				'content[c_tel_code]',
				'content[c_hr_org]',
				'content[c_hr_org_s]',
				'content[hr_offer]',
				'content[hr_work_place]',
				'content[hr_gqjl]',
				'content[hr_shbx]',
				'content[hr_vacation]',
				'content[c_ou_2_s]',
				'content[c_ou_3_s]',
				'content[c_ou_4_s]',
				'content[c_ou_2]',
				'content[c_ou_3]',
				'content[c_ou_4]',
				'content[c_job_s]',
				'content[c_job]',
				'content[hr_zclb]',
				'content[hr_zcdj]',
				'content[hr_zw_1]',
				'content[hr_zw_2]',
				'content[hr_zw_3]',
				'content[hr_tec]',
				'content[hr_tec_data]',
				'content[hr_type_work]',
				'content[hr_type]',
				'content[hr_wage]',
				'content[hr_time_rz]',
				'content[hr_time_zz]',
				'content[hr_wage_org]',
				'content[hr_wage_set]',
				'content[hr_time_ht]',
				'content[hr_time_htdq]',
				'content[hr_time_lz]',
				'content[hr_ht_year]',
				'content[hr_num_xq]',
				'content[hr_train_org]',
				'content[hr_reward]',
                'content[hr_contract]',
			)));

			$data_out['field_required'] = array_values(array_unique(array_merge($data_out['field_required'],array(
				'content[c_name]',
				'content[c_sex]',
				'content[c_hy]',
				'content[c_code_person]',
				'content[c_zzmm]',
				'content[c_birthday]',
				'content[c_time_work]',
				'content[c_xl]',
				'content[c_xl_day]',
				'content[c_mz]',
				'content[c_jg]',
				'content[c_jg_show]',
				'content[c_tel_2]',
				'content[c_email]',

				'content[c_bank]',
				'content[c_bank_type]',

//				'content[c_doc_org]',
//				'content[c_doc_addr]',
//				'content[c_doc_addr_postcode]',

				'content[c_addr_live]',
				'content[c_post_code_live]',
				'content[c_phone_addrl]',
				'content[c_addr]',
				'content[c_post_code]',
				'content[c_phone]',
				'content[c_jzjd]',
				'content[c_jzdfw]',
				'content[c_hj]',
				'content[c_jzlxr]',
				'content[c_jzlxr_gx]',
				'content[c_jzlxr_tele]',
				'content[c_jzlxr_dz]',

				'content[c_family_crime]',
				'content[c_family_gat]',
				'content[c_family_foreign]',

				'content[c_school]',
				'content[c_time_graduate]',
				'content[c_zy]',

			))));

		}

		//没有员工信息-全部权限
		if( element('c_id', $data_db['content']) != $this->sess->userdata('c_id')
		 && ($acl_list & pow(2,ACL_PROC_HR_INFO)) == 0 )
		{
			$data_out['op_disable'][]='tab_card';
			$data_out['op_disable'][]='tab_idcard';
			$data_out['op_disable'][]='tab_doc';
			$data_out['op_disable'][]='tab_family';
		}

		if( $data_get['act'] == STAT_ACT_EDIT 
		 && ($acl_list & pow(2,ACL_PROC_HR_INFO_CHECK)) != 0 )
		{
			$data_out['field_required'] = array_values(array_unique(array_merge($data_out['field_required'],array(
				'content[hr_code_pre]',
				'content[hr_code]',
				'content[c_org]',
				'content[c_hr_org]',
				'content[hr_offer]',
				'content[hr_work_place]',
				'content[hr_gqjl]',
				'content[hr_shbx]',
				'content[hr_vacation]',
				'content[c_ou_2_s]',
				'content[c_ou_3_s]',
				'content[c_ou_4_s]',
				'content[c_ou_2]',
				'content[c_ou_3]',
				'content[c_ou_4]',
				'content[c_job_s]',
				'content[c_job]',
				'content[hr_zclb]',
				'content[hr_zcdj]',
				'content[hr_zw_1]',
				'content[hr_zw_2]',
				'content[hr_zw_3]',
				'content[hr_type_work]',
				'content[hr_type]',
				'content[hr_wage]',
				'content[hr_time_rz]',
			))));
		}
		
		//信息未审核
		if( element('hr_check', $data_db['content']) == 0
		 && element('hr_info_finish', $data_db['content']) == 1 
		 && ($acl_list & pow(2,ACL_PROC_HR_INFO_CHECK)) != 0 )
		{
			$data_out['ppo_name'] = '信息审核';

			if(  empty($flag_log))
			{
				$data_out['flag_check'] = TRUE;

				//显示修改信息
				$data_db['content_old']=json_decode($data_db['content']['hr_data_start'],TRUE);
				$data_change['content']=$data_db['content'];

				if( count(element('content',$data_change))>0 )
				{
					foreach (element('content',$data_change) as $k=>$v)
					{

						if( $v != element($k,$data_db['content_old']))
						{
							switch ($k)
							{
								case 'hr_train':

									$data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('hr_t_id',$v,element($k,$data_db['content_old']),'m_hr_train','show_change_hr_info');

									break;
								case 'hr_work':

									$data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('hr_w_id',$v,element($k,$data_db['content_old']),'m_hr_work','show_change_hr_info');

									break;
								case 'hr_family':

									$data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('hr_f_id',$v,element($k,$data_db['content_old']),'m_hr_family','show_change_hr_info');

									break;
								case 'hr_family_crime':

									$data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('hr_fc_id',$v,element($k,$data_db['content_old']),'m_hr_family_crime','show_change_hr_info');

									break;
								case 'hr_family_card_gat':

									$data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('hr_fcard_id',$v,element($k,$data_db['content_old']),'m_hr_family_card','show_change_hr_info');

									break;
								case 'hr_family_card':

									$data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('hr_fcard_id',$v,element($k,$data_db['content_old']),'m_hr_family_card','show_change_hr_info');

									break;
								case 'hr_reward':

									$data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('hr_rp_id',$v,element($k,$data_db['content_old']),'m_hr_reward','show_change_hr_info');

									break;
                                case 'hr_contract':

                                    $data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('cont_id',$v,element($k,$data_db['content_old']),'m_hr_contract','show_change_hr_info');

                                    break;
								case 'hr_idcard':

									$data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('hr_idc_id',$v,element($k,$data_db['content_old']),'m_hr_idcard','show_change_hr_info');

									break;
								case 'hr_card':

									$data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('hr_card_id',$v,element($k,$data_db['content_old']),'m_hr_card','show_change_hr_info');

									break;
								case 'hr_edu':

									$data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('hr_edu_id',$v,element($k,$data_db['content_old']),'m_hr_edu','show_change_hr_info');

									break;

								case 'c_family_crime':
								case 'c_family_foreign':
								case 'c_family_gat':
									$data_out['log']['content['.$k.']']='变更前:'.$GLOBALS['m_hr']['text']['f_have'][element($k,$data_db['content_old'])];

									break;


								default:
									if( (element($k,$data_db['content_old']) || element($k,$data_db['content_old']) == '0' )
							         && isset($GLOBALS['m_hr']['text'][$k][$v]) )
									$data_db['content_old'][$k]=$GLOBALS['m_hr']['text'][$k][element($k,$data_db['content_old'])];

									$data_out['log']['content['.$k.']']='变更前:'.element($k,$data_db['content_old']);
							}
						}
					}
				}
			}
		}
		elseif(($acl_list & pow(2,ACL_PROC_HR_INFO_CHECK)) != 0 )
		{
			$data_out['op_disable'][]='btn_next';
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
			
			$data_out['op_disable']=array_values(array_unique(array_merge($data_out['op_disable'],array(
				'content[c_org_s]',
				'content[c_name]',
				'content[c_name_old]',
				'content[c_img]',
				'content[c_img_show]',
				'content[c_sex]',
				'content[c_hy]',
				'content[c_code_person]',
				'content[c_zzmm]',
				'content[c_birthday]',
				'content[c_time_work]',
				'content[c_xl]',
				'content[c_xl_day]',
				'content[c_xw]',
				'content[c_mz]',
				'content[c_jg]',
				'content[c_jg_show]',
				'content[c_tel]',
				'content[c_tel_info]',
				'content[c_tel_2]',
				'content[c_tel_2_info]',
				'content[c_email]',
				'content[c_interest]',
				'content[c_mac_line]',
				'content[c_mac_noline]',
	
				'content[hr_code]',
				'content[c_login_id]',
				'content[c_email_sys]',
				'content[c_tel_code]',
				'content[c_pwd_web]',
//				'content[c_hr_org]',
//				'content[c_hr_org_s]',
//				'content[hr_offer]',
//				'content[hr_work_place]',
//				'content[hr_gqjl]',
//				'content[hr_shbx]',
//				'content[hr_vacation]',
//				'content[c_ou_2_s]',
//				'content[c_ou_3_s]',
//				'content[c_ou_4_s]',
//				'content[c_ou_2]',
//				'content[c_ou_3]',
//				'content[c_ou_4]',
//				'content[c_job_s]',
//				'content[c_job]',
//				'content[hr_zclb]',
//				'content[hr_zcdj]',
//				'content[hr_zw_1]',
//				'content[hr_zw_2]',
//				'content[hr_zw_3]',
				'content[hr_tec]',
//				'content[hr_type_work]',
//				'content[hr_type]',
//				'content[hr_wage]',
//				'content[hr_time_rz]',
//				'content[hr_time_zz]',
//				'content[hr_wage_org]',
//				'content[hr_wage_set]',
//				'content[hr_time_ht]',
//				'content[hr_time_htdq]',
//				'content[hr_time_lz]',
//				'content[hr_ht_year]',
//				'content[hr_num_xq]',
//	            'content[hr_contract]',
//				'content[hr_train_org]',
//				'content[hr_reward]',

				'title_hr_contract',
				'title_hr_train_org',
				'title_hr_reward',
				'title_office',
			
				'tab_card',
				'tab_idcard',
				'tab_doc',
				'tab_addr',
				'tab_family',
				'tab_edu',
				'tab_work',
				'tab_train',
			))));
			
			$data_out['title'] = '批量编辑'.$this->title.'-请勾选要保存的字段';
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
					//导入验证
					if( $data_get['act'] == STAT_ACT_CREATE )
					{
						$data_out['field_required'] = array(
							'content[hr_code]',
				            'content[c_name]',
				    		'content[c_login_id]',
				            'content[c_sex]',
				            'content[c_birthday]',
				            'content[c_code_person]',
				            'content[c_tel]',
				            'content[c_email]',
				    		'content[c_bank_type]',
				            'content[c_bank]',
				    		'content[c_org]',
				    		'content[c_hr_org]',
				            'content[c_ou_2]',
				            'content[c_ou_3]',
				            'content[c_ou_4]',
				    		'content[c_job]',
				    		'content[hr_zw_1]',
				            'content[hr_zw_2]',
				            'content[hr_zw_3]',
				            'content[hr_type_work]',
				            'content[hr_type]',
				            'content[hr_time_rz]',
				    		'content[hr_shbx]',
						);
						
						$data_out['field_edit'][] = 'content[c_card_gjj]';
						$data_out['field_edit'][] = 'content[c_card_sb]';
					}
				
					if( $btn == 'next' )
					{
						$data_out['field_required'][] = 'content[c_img_show]';
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

					if( element('content[c_img_show]', $rtn['err']))
					{
						$rtn['err']['content[c_img]'] = $rtn['err']['content[c_img_show]'];
					}
				}
				
				//验证工号
				if( ! empty( element('hr_code_pre',$data_post['content']) ) 
				 && ! empty( element('hr_code',$data_post['content']) ) 
				)
				{
					$where_check=' AND c_id != \''.element('c_id',$data_db['content']).'\'';
					
					$check = $this->m_check->unique('hr_info','CONCAT(hr_code_pre,hr_code)',$data_post['content']['hr_code_pre'].$data_post['content']['hr_code'],$where_check);
					
					if( ! $check )
					{
						$rtn['err']['content[c_code_person]']='工号【'.$data_post['content']['hr_code_pre'].$data_post['content']['hr_code'].'】已存在,不可重复创建！';
						$check_data=FALSE;
					}
				}
				
				//验证账户
				if( ! empty( element('c_login_id',$data_post['content']) ) )
				{
					$where_check=' AND c_id != \''.element('c_id',$data_db['content']).'\'';

					$check=$this->m_check->unique('sys_contact','c_login_id',element('c_login_id',$data_post['content']),$where_check);
					if( ! $check )
					{
						$rtn['err']['content[c_name]']='关联账户【 '.element('c_login_id',$data_post['content']).'】已存在，不可重复创建！';
						$check_data=FALSE;
					}
					
					$check=$this->m_base->get_field_where('sys_account','a_id'," AND a_login_id = '{$data_post['content']['c_login_id']}'");
					if( ! $check )
					{
						$rtn['err']['content[c_name]']='关联账户【 '.element('c_login_id',$data_post['content']).'】未创建，不可创建！';
						$check_data=FALSE;
					}
				}
				
				//验证身份证
				$info_c_code_person = array();
				
				if( ! empty( element('c_code_person',$data_post['content']) ) )
				{
					$info_c_code_person = getIDCardInfo($data_post['content']['c_code_person']);

					if( $info_c_code_person['error'] != 2 )
					{
						$rtn['err']['content[c_code_person]']='身份证 【'.element('c_code_person',$data_post['content']).'】不合法！';
						$check_data=FALSE;
					}
					else
					{
						$where_check=' AND c_id != \''.element('c_id',$data_db['content']).'\'';

						$check=$this->m_check->unique('sys_contact','c_code_person',element('c_code_person',$data_post['content']),$where_check);
						if( ! $check )
						{
							$rtn['err']['content[c_code_person]']='身份证【 '.element('c_code_person',$data_post['content']).'】已存在，不可重复创建！';
							$check_data=FALSE;
						}
					}
				}

				//验证手机
				if( ! empty( element('c_tel',$data_post['content']) ) )
				{
					$where_check=' AND c_id != \''.element('c_id',$data_db['content']).'\'';

					$check=$this->m_check->unique('sys_contact','c_tel',element('c_tel',$data_post['content']),$where_check);
					if($check) $check=$this->m_check->unique('sys_contact','c_tel_2',element('c_tel',$data_post['content']),$where_check);

					if( ! $check )
					{
						$rtn['err']['content[c_tel]']='手机 【'.element('c_tel',$data_post['content']).'】已存在，不可重复创建！';
						$check_data=FALSE;
					}

					if( empty( element('c_tel_info',$data_post['content']) ) )
					{
						$check=$this->m_check->tele(element('c_tel',$data_post['content']),'');

						if( ! $check )
						{
							$rtn['err']['content[c_tel]']='手机【'.element('c_tel',$data_post['content']).'】不合法！';
							$check_data=FALSE;
						}
						else
							$data_post['content']['c_tel_info'] = $check;
					}
				}

				//验证手机
				if( ! empty( element('c_tel_2',$data_post['content']) ) )
				{
					$where_check=' AND c_id != \''.element('c_id',$data_db['content']).'\'';

					$check=$this->m_check->unique('sys_contact','c_tel_2',element('c_tel_2',$data_post['content']),$where_check);
					if($check) $check=$this->m_check->unique('sys_contact','c_tel',element('c_tel_2',$data_post['content']),$where_check);

					if( ! $check )
					{
						$rtn['err']['content[c_tel_2]']='手机 【'.element('c_tel_2',$data_post['content']).'】已存在，不可重复创建！';
						$check_data=FALSE;
					}

					if( empty( element('c_tel_2_info',$data_post['content']) ) )
					{
						$check=$this->m_check->tele(element('c_tel_2',$data_post['content']),'');

						if( ! $check )
						{
							$rtn['err']['content[c_tel_2]']='手机【'.element('c_tel_2',$data_post['content']).'】不合法！';
							$check_data=FALSE;
						}
						else
							$data_post['content']['c_tel_2_info'] = $check;
					}
				}

				if( element('c_family_crime',$data_post['content']) == 2
				 && count(json_decode(element('hr_family_crime',$data_post['content']))) == 0)
				{
					$rtn['err']['content[hr_family_crime]']='请补全信息';
					$check_data=FALSE;
				}

				if( element('c_family_gat',$data_post['content']) == 2
				 && count(json_decode(element('hr_family_card_gat',$data_post['content']))) == 0)
				{
					$rtn['err']['content[hr_family_card_gat]']='请补全信息';
					$check_data=FALSE;
				}

				if( element('c_family_foreign',$data_post['content']) == 2
				 && count(json_decode(element('hr_family_card',$data_post['content']))) == 0)
				{
					$rtn['err']['content[hr_family_card]']='请补全信息';
					$check_data=FALSE;
				}

				//没有审核权限
				if( ($acl_list & pow(2,ACL_PROC_HR_INFO_CHECK)) == 0 )
				{

					if(count(json_decode(element('hr_edu',$data_post['content']))) == 0)
					{
						$rtn['err']['content[hr_edu]']='请填写教育信息！';
						$check_data=FALSE;
					}

					if(count(json_decode(element('hr_family',$data_post['content']))) == 0)
					{
						$rtn['err']['content[hr_family]']='请填写家庭信息！';
						$check_data=FALSE;
					}

					if( empty(element('c_hjjzz',$data_post['content']))
					 && element('c_hj',$data_post['content']) == C_HJ_NSH )
	        		{
	        			$rtn['err']['content[c_hjjzz]']='请填写户籍居住证!';
						$check_data=FALSE;
	        		}

					if( $btn == 'next')
					{
						if( empty(element('c_img_show',$data_post['content'])) )
		        		{
		        			$rtn['err']['content[c_img]']='请上传照片！';
							$check_data=FALSE;
		        		}

						if( empty(element('c_mac_line',$data_post['content'])) )
		        		{
		        			$rtn['err']['content[c_mac_line]']='请填写有线MAC地址!';
							$check_data=FALSE;
		        		}

						if( empty(element('c_mac_noline',$data_post['content'])) )
		        		{
		        			$rtn['err']['content[c_mac_noline]']='请填写无线MAC地址!';
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

				if( ! empty(element('hr_tec',$data_save['content'])) )
				{
					if( ! is_array(element('hr_tec',$data_save['content'])) )
					{
						$data_save['content']['hr_tec'] = explode(',', $data_save['content']['hr_tec']);
					}
				}

				//存在身份证，通过身份证获取生日
				if( ! empty( element('c_code_person', $data_save['content']) ) 
				 && element('birthday', $info_c_code_person) )
				$data_save['content']['c_birthday'] = $info_c_code_person['birthday'];

				//照片
				if( ! empty($data_save['content']['c_img_show']) )
        		{
        			if(strstr($data_save['content']['c_img_show'] ,','))
        			$data_img=substr(strstr($data_save['content']['c_img_show'] ,','),1);
        			else
        			$data_img=$data_save['content']['c_img_show'];

        			if( empty(element('c_img',$data_db['content'])) )
        			{
        				$data_save['content']['c_img'] =$data_db['content']['c_img'] =get_guid();
        			}

        			$path_img=$this->config->item('base_photo_path').$data_db['content']['c_img'].'.jpg';

        			$data_img= base64_decode($data_img);

        			write_file($path_img, $data_img, 'w');

        			$data_save['content']['c_img_show']='';
        		}

        		$data_db['content']['c_img_show']='';

        		if(count(json_decode(element('hr_family_crime',$data_save['content']))) > 0)
        		{
        			$data_save['content']['c_family_crime'] = 2 ;
        		}

				if(count(json_decode(element('hr_family_card_gat',$data_save['content']))) > 0)
        		{
        			$data_save['content']['c_family_gat'] = 2 ;
        		}

				if(count(json_decode(element('hr_family_card',$data_save['content']))) > 0)
        		{
        			$data_save['content']['c_family_foreign'] = 2 ;
        		}
				/************事件处理*****************/
				switch ($data_get['act']) {
					case STAT_ACT_CREATE:
						
						$data_save['content']['a_id']=$this->m_base->get_field_where('sys_account','a_id'," AND a_login_id = '{$data_save['content']['c_login_id']}'");
						if( ! element('c_id', $data_save['content']) )
						{
							$rtn = $this->m_contact->add($data_save['content']);
							$data_save['content']['c_id'] = $rtn['id'];
						}

						$rtn=$this->add($data_save['content']);
						
						$this->m_contact->update($data_save['content']);
						
						if( element('c_card_gjj', $data_save['content']))
						{
							$data_save['hr_card'] = array();
							$data_save['hr_card']['hr_card_type'] = C_BANK_TYPE_GJJ;
							$data_save['hr_card']['hr_card_code'] = $data_save['content']['c_card_gjj'];
							$data_save['hr_card']['c_id'] = $data_save['content']['c_id'];
							
							$this->m_hr_card->add($data_save['hr_card']);
						}
						
						if( element('c_card_sb', $data_save['content']))
						{
							$data_save['hr_card'] = array();
							$data_save['hr_card']['hr_card_type'] = C_BANK_TYPE_SHEBAO;
							$data_save['hr_card']['hr_card_code'] = $data_save['content']['c_card_sb'];
							$data_save['hr_card']['c_id'] = $data_save['content']['c_id'];
							
							$this->m_hr_card->add($data_save['hr_card']);
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

						//流程工单
						$ppo_btn_text = $data_out['ppo_btn_next'];
						if($btn == 'pnext')
						$ppo_btn_text = $data_out['ppo_btn_pnext'];

						//工单基本信息
						$data_save['wl']['wl_code']=$data_db['content']['hr_code_s'];
		    			$data_save['wl']['wl_op_table']='hr_info';
		    			$data_save['wl']['wl_op_field']='c_id';
		    			$data_save['wl']['op_id']=$data_save['content'][$this->pk_id];
	    				$data_save['wl']['p_id']=$this->proc_id;
	    				$data_save['wl']['pp_id']=$this->model_name;
		    			$data_save['wl']['wl_url']=$this->url_conf.'/act/2';
		    			$data_save['wl']['wl_proc']=element('ppo', $data_db['content']);
		    			$data_save['wl']['wl_time_end']=date('Y-m-d H:i:s',strtotime('+30 day'));
		    			$data_save['wl']['c_accept'] = array();
		    			$data_save['wl']['wl_note']='【'.$this->title.'】'
		    				.',员工:【'.$data_save['content']['hr_code_s'].'】'.$data_save['content']['c_name'].'['.$data_save['content']['c_login_id'].']'
		    				.',手机:'.$data_save['content']['c_tel']
		    				.',短号:'.$data_save['content']['c_tel_code']
		    				;

		    			//信息未补全，提交
		    			if( $data_db['content']['hr_info_finish'] == 0
		    			 && $btn == 'next' )
		    			{
		    				$data_save['content']['hr_info_finish'] = 1;

		    				$data_save['wl']['wl_event']='员工信息补全，审核';

		    				$data_save['content_log']['log_note'] = '员工信息补全';

							//添加流程接收人
    						$c_accept=$this->m_acl->get_acl_person($this->proc_id,ACL_PROC_HR_INFO_CHECK);

    						$data_save['wl']['c_accept']=$c_accept;

    						// 初始数据为空，则记录初始数据
    						if( ! $data_db['content']['hr_data_start'])
    						$data_save['content']['hr_data_start'] = json_encode($data_db['content']);

		    			}

		    			//信息未审核，有审核权限，通过
						if( $data_db['content']['hr_check'] == 0
						 && ($acl_list & pow(2,ACL_PROC_HR_INFO_CHECK)) != 0
		    			 && $btn == 'next' )
		    			{
		    				$data_save['content']['hr_check'] = 1;
		    				$data_save['content']['hr_data_start'] = '';

		    				$data_save['content_log']['log_note'] = '员工信息修改审核通过';
		    			}
		    			//没有审核权限,修改
		    			elseif($btn == 'next')
		    			{
		    				$data_save['content']['hr_check'] = 0;

		    				$data_save['content_log']['log_note'] = '员工信息修改';

		    				//添加流程接收人
    						$c_accept=$this->m_acl->get_acl_person($this->proc_id,ACL_PROC_HR_INFO_CHECK);
    						$data_save['wl']['c_accept']=$c_accept;

    						//更新审核工单失效
							$data_save['wl_have_do']=array();
							$data_save['wl_have_do']['wl_log_note']=$data_save['content_log']['log_note'];
							$data_save['wl_have_do']['wl_status']=WL_STATUS_FAIL;
							$this->m_work_list->update_wl_have_do(element($this->pk_id,$data_get),$this->model_name,$data_save['wl_have_do']);


    						// 初始数据为空，则记录初始数据
    						if( ! $data_db['content']['hr_data_start'])
    						$data_save['content']['hr_data_start'] = json_encode($data_db['content']);
		    			}

                        //合同信息
                        if(!empty(element('hr_contract',$data_save['content']))){
                            $cont=json_decode($data_save['content']['hr_contract'],true);
                            if(count($cont)>0){
                                $data_save['content']['hr_ht_year']=$cont[count($cont)-1]['cont_year'];
                                $data_save['content']['hr_time_ht']=$cont[count($cont)-1]['cont_time_start'];
                                $data_save['content']['hr_time_htdq']=$cont[count($cont)-1]['cont_time_end'];
                                $data_save['content']['hr_num_xq']=count($cont)-1;
                            }
                        }

						$rtn=$this->update($data_save['content']);

						if( is_array(element('hr_tec',$data_save['content']))
						 && count( element('hr_tec',$data_save['content']) ) > 0 )
						{
							$cond_link=array();
							$cond_link['op_id']=element($this->pk_id,$data_get);
							$cond_link['op_table']='hr_info';
							$cond_link['op_field']='c_id';
							$cond_link['content']='hr_tec';
							$this->m_link->del_where($cond_link);

							$data_save['content']['hr_tec_data']=array();

							foreach ($data_save['content']['hr_tec'] as $v) {

								$data_save['link']=array();
								$data_save['link']['op_id']=$data_save['content'][$this->pk_id];
								$data_save['link']['op_table']='hr_info';
								$data_save['link']['op_field']='c_id';
								$data_save['link']['content']='hr_tec';
								$data_save['link']['link_id']=$v;

								$this->m_link->add($data_save['link']);

								$data_save['content']['hr_tec_data'][]=array(
									'id'=>$v,
									'text'=>$this->m_base->get_field_where('hr_tec','tec_name'," AND tec_id = '{$v}'")
								);
							}

							$data_save['content']['hr_tec_data']=json_encode($data_save['content']['hr_tec_data']);
						}

						//公司培训记录
						if( ! empty(element('hr_train_org',$data_save['content']) ) )
						{
							$arr_save=array(
								'c_id' => element('c_id',$data_get),
								'hr_t_type' => HR_T_TYPE_ORG
							);

							$this->m_base->save_datatable('hr_train',
							$data_save['content']['hr_train_org'],
							$data_db['content']['hr_train_org'],
							$arr_save);
						}

						//培训记录
						if( ! empty(element('hr_train',$data_save['content']) ) )
						{
							$arr_save=array(
								'c_id' => element('c_id',$data_get)
							);

							$this->m_base->save_datatable('hr_train',
							$data_save['content']['hr_train'],
							$data_db['content']['hr_train'],
							$arr_save);
						}

						//身份证件
						if( ! empty(element('hr_idcard',$data_save['content']) ) )
						{
							$arr_save=array(
								'c_id' => element('c_id',$data_get)
							);

							$this->m_base->save_datatable('hr_idcard',
								$data_save['content']['hr_idcard'],
								$data_db['content']['hr_idcard'],
								$arr_save);
						}

						//卡帐信息
						if( ! empty(element('hr_card',$data_save['content']) ) )
						{
							$arr_save=array(
								'c_id' => element('c_id',$data_get)
							);

							$this->m_base->save_datatable('hr_card',
								$data_save['content']['hr_card'],
								$data_db['content']['hr_card'],
								$arr_save);
						}

						//教育信息
						if( ! empty(element('hr_edu',$data_save['content']) ) )
						{
							$arr_save=array(
								'c_id' => element('c_id',$data_get)
							);

							$this->m_base->save_datatable('hr_edu',
								$data_save['content']['hr_edu'],
								$data_db['content']['hr_edu'],
								$arr_save);
						}
						
						//工作经历
						if( ! empty(element('hr_work',$data_save['content']) ) )
						{
							$arr_save=array(
								'c_id' => element('c_id',$data_get)
							);

							$this->m_base->save_datatable('hr_work',
								$data_save['content']['hr_work'],
								$data_db['content']['hr_work'],
								$arr_save);
						}
						
						//家庭信息
						if( ! empty(element('hr_family',$data_save['content']) ) )
						{
							$arr_save=array(
								'c_id' => element('c_id',$data_get)
							);

							$this->m_base->save_datatable('hr_family',
								$data_save['content']['hr_family'],
								$data_db['content']['hr_family'],
								$arr_save);
						}
						
						//犯罪记录
						if( ! empty(element('hr_family_crime',$data_save['content']) ) )
						{
							$arr_save=array(
								'c_id' => element('c_id',$data_get)
							);

							$this->m_base->save_datatable('hr_family_crime',
								$data_save['content']['hr_family_crime'],
								$data_db['content']['hr_family_crime'],
								$arr_save);
						}
						
						//港澳台
						if( ! empty(element('hr_family_card_gat',$data_save['content']) ) )
						{
							$arr_save=array(
								'c_id' => element('c_id',$data_get),
								'hr_fcard_type' => HR_FCARD_TYPE_JJZ
							);

							$this->m_base->save_datatable('hr_family_card',
								$data_save['content']['hr_family_card_gat'],
								$data_db['content']['hr_family_card_gat'],
								$arr_save);
						}
						
						//绿卡
						if( ! empty(element('hr_family_card',$data_save['content']) ) )
						{
							$arr_save=array(
								'c_id' => element('c_id',$data_get),
								'hr_fcard_type' => HR_FCARD_TYPE_LK
							);

							$this->m_base->save_datatable('hr_family_card',
								$data_save['content']['hr_family_card'],
								$data_db['content']['hr_family_card'],
								$arr_save);
						}
						
						//奖惩记录
						if( ! empty(element('hr_reward',$data_save['content']) ) )
						{
							$arr_save=array(
								'c_id' => element('c_id',$data_get)
							);

							$this->m_base->save_datatable('hr_reward',
								$data_save['content']['hr_reward'],
								$data_db['content']['hr_reward'],
								$arr_save);
						}

                        if( ! empty(element('hr_contract',$data_save['content']) ) )
                        {
                            $arr_save=array(
                                'c_id' => element('c_id',$data_get)
                            );

                            $this->m_base->save_datatable('hr_contract',
                                $data_save['content']['hr_contract'],
                                $data_db['content']['hr_contract'],
                                $arr_save);
                        }


						//工单日志
						if( $btn == 'yj' )
						{
							$data_save['content_log']['log_note']=
						'【'.$this->sess->userdata('c_name').'['.$this->sess->userdata('a_login_id').']】'
						.'于节点【'.$data_out['ppo_name'].'】'
						.',将【'.$this->title.'】移交于【'.$data_post['content']['person_yj_s'].'】';

							$data_save['wl']['wl_type']=WL_TYPE_YJ;
							$data_save['wl']['wl_event']=element('wl_list_to_do', $data_out);
							$data_save['wl']['c_accept'][]=$data_post['content']['person_yj'];

						}
						elseif( $btn == 'next' || $btn == 'pnext' )
						{

							$data_save['content_log']['log_note']=
						'于节点【'.$data_out['ppo_name'].'】'.$ppo_btn_text;

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

								if( count(element('arr_wl_i_to_do', $data_out)) > 0 )
								$data_save['wl_have_do']['wl_id_i_do'] = $data_out['arr_wl_i_to_do'];

								$this->m_work_list->update_wl_have_do(element($this->pk_id,$data_get),$this->model_name,$data_save['wl_have_do']);

//								//更新我的工单
//								$data_save['wl_i']['wl_log_note']=$data_save['content_log']['log_note'];
//
//								if( $data_db['content']['hr_check'] == 0
//								 && $data_save['content']['hr_check'] == 1)
//								{
//									$data_save['wl_i']['wl_status']=WL_STATUS_FINISH;
//									$data_save['wl_i']['wl_result']=WL_RESULT_SUCCESS;
//									$data_save['wl_i']['wl_person_do'] = $this->sess->userdata('c_id');
//    								$data_save['wl_i']['wl_time_do'] = date('Y-m-d H:i:s');
//								}
//								elseif($data_save['content']['hr_check'] != 1)
//								{
//									$data_save['wl_i']['db_time_create']= date('Y-m-d H:i:s');
//									$data_save['wl_i']['wl_status']=0;
//									$data_save['wl_i']['wl_result']='';
//									$data_save['wl_i']['wl_person_do'] = '';
//    								$data_save['wl_i']['wl_time_do'] = '';
//								}
//
//								$this->m_work_list->update_wl_i(element($this->pk_id,$data_get),$this->model_name,$data_save['wl_i']);
//
								$data_save['wl']['wl_comment_new'] =
								'<p>'.date("Y-m-d H:i:s").' '.$this->sess->userdata('c_name').'['.$this->sess->userdata('a_login_id').']</p>'
								.'<p>'.$data_save['content_log']['log_note'].'</p>';

								if( ! empty($wl_comment) )
								$data_save['wl']['wl_comment_new'] = '<p>'.$wl_comment.'</p>';

								if(count($data_save['wl']['c_accept']) > 0 )
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

								$rtn['wl_end'] = $arr_wl_person['accept'];

								break;
						}

						$arr_log_content=array();
						$data_save['content']['hr_data_start']='';
						$data_db['content']['hr_data_start']='';
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
	    $data_out['code']=element('hr_code_pre', $data_db['content']).element('hr_code', $data_db['content']);

	    $data_out['fun_no_db']=element('fun_no_db', $data_get);
	    $data_out['data_db_post'] = $this->input->post('data_db');
	    
	    $data_out['flag_edit_more']=element('flag_edit_more', $data_get);
	    
	    $data_out[$this->pk_id]=element($this->pk_id,$data_get);
    	$data_out['ppo']=element('ppo', $data_db['content']);

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
		
		if( $flag_print )
		$this->url_conf = str_replace('edit', 'print', $this->url_conf);
		
		/************载入视图 *****************/
		$arr_view[]=$this->url_conf;
		$arr_view[]=$this->url_conf.'_js';
		$arr_view[]='proc_contact/fun_js';
		$this->m_view->load_view($arr_view,$data_out);
	}

	/**
	 *
	 * 根据录用通知创建员工信息
	 * @param $arr hr_offer数据数组
	 */
	public function create_hrinfo_by_hroffer($arr)
	{
		/************模型载入*****************/

		/************变量初始化****************/
		$data_save=array();//
		$rtn=array();//结果
		$rtn['rtn']=TRUE;
		$where='';
		/************数据处理*****************/

		if( ! element('c_id', $arr) ) {
			$rtn['rtn']=FALSE;

			return $rtn['rtn'];
		}

		$data_save['content']['c_id'] = $arr['c_id'];
		$data_save['content']['c_name'] = $arr['c_name'];
		$data_save['content']['c_login_id'] = $arr['c_login_id'];
		$data_save['content']['hr_type_work'] = $arr['offer_type_work'];
		$data_save['content']['c_org'] = $arr['c_org'];
		$data_save['content']['c_hr_org'] = $arr['c_hr_org'];
		$data_save['content']['c_ou_2'] = $arr['c_ou_2'];
		$data_save['content']['c_ou_3'] = $arr['c_ou_3'];
		$data_save['content']['c_ou_4'] = $arr['c_ou_4'];
		$data_save['content']['c_ou_bud'] = $arr['c_ou_bud'];
		$data_save['content']['hr_time_rz'] = date("Y-m-d");

		//根据用工形式判断人员类别
		switch ($data_save['content']['hr_type_work'])
		{
    		case HR_TYPE_WORK_ZS:
    			$data_save['content']['hr_type'] = HR_TYPE_ZZ;
    			break;
			case HR_TYPE_WORK_QT:
				$data_save['content']['hr_type'] = HR_TYPE_QT;
				break;
			case HR_TYPE_WORK_WB:
				$data_save['content']['hr_type'] = HR_TYPE_WB;
    			break;
		}

		$data_save=$this->get_code($data_save);

		$data_db['content_hr']=$this->get($data_save['content']['c_id']);
		if( element('c_id', $data_db['content_hr']) )
		{
			$data_save['content']['hr_dim_porc'] = 0;
			$this->update($data_save['content']);
			$rtn['id'] = $data_save['content']['c_id'];

			$data_save['content_log']['log_note']='【'.$this->sess->userdata('c_name').'['.$this->sess->userdata('a_login_id').']】于【人事管理-录用通知】，创建【员工信息】';

			//创建我的工单
	    	$data_save['wl']['wl_id'] = $rtn['id'];
	    	$data_save['wl']['wl_type'] = WL_TYPE_I;
	    	$data_save['wl']['wl_code']=$data_save['content']['hr_code_pre'].$data_save['content']['hr_code'];
	    	$data_save['wl']['wl_op_table']='hr_info';
	    	$data_save['wl']['wl_op_field']='c_id';
	    	$data_save['wl']['op_id']=$rtn['id'];
	    	$data_save['wl']['p_id']=$this->proc_id;
	    	$data_save['wl']['pp_id']=$this->model_name;
	    	$data_save['wl']['wl_proc']=element('ppo', $data_save['content']);
	    	$data_save['wl']['wl_url']=$this->url_conf.'/act/2';
	    	$data_save['wl']['wl_note']='【'.$this->title.'】'
	    		.',员工:'.$data_save['content']['c_name'].'['.$data_save['content']['c_login_id'].']'
	    		;

	    	//更新我的工单
			$data_save['wl']['wl_log_note']=$data_save['content_log']['log_note'];
	    	$data_save['wl']['c_accept'][] = $this->sess->userdata('c_id');
	    	$data_save['wl']['c_accept'][] = $data_save['content']['c_id'];

	    	$this->m_work_list->update($data_save['wl']);
		}
		else
		{
			$rtn=$this->add($data_save['content']);

			$data_save['content_log']['log_note']='【'.$this->sess->userdata('c_name').'['.$this->sess->userdata('a_login_id').']】于【人事管理-录用通知】，创建【员工信息】';

			//创建我的工单
	    	$data_save['wl']['wl_id'] = $rtn['id'];
	    	$data_save['wl']['wl_type'] = WL_TYPE_I;
	    	$data_save['wl']['wl_code']=$data_save['content']['hr_code_pre'].$data_save['content']['hr_code'];
	    	$data_save['wl']['wl_op_table']='hr_info';
	    	$data_save['wl']['wl_op_field']='c_id';
	    	$data_save['wl']['op_id']=$rtn['id'];
	    	$data_save['wl']['p_id']=$this->proc_id;
	    	$data_save['wl']['pp_id']=$this->model_name;
	    	$data_save['wl']['wl_proc']=element('ppo', $data_save['content']);
	    	$data_save['wl']['wl_url']=$this->url_conf.'/act/2';
	    	$data_save['wl']['wl_note']='【'.$this->title.'】'
	    		.',员工:'.$data_save['content']['c_name'].'['.$data_save['content']['c_login_id'].']'
	    		;
	    		
	    	//更新我的工单
			$data_save['wl']['wl_log_note']=$data_save['content_log']['log_note'];
	    	$data_save['wl']['c_accept'][] = $this->sess->userdata('c_id');
	    	$data_save['wl']['c_accept'][] = $data_save['content']['c_id'];
	    	
	    	$this->m_work_list->add($data_save['wl']);
		}
		
    	$data_save['wl']['wl_id']=get_guid();
    	$data_save['wl']['wl_type'] = 0 ;
    	$data_save['wl']['wl_event']='员工信息创建';
    	$data_save['wl']['ppo'] = 1;
    	$data_save['wl']['wl_status']=WL_STATUS_FINISH;
		$data_save['wl']['wl_result']=WL_RESULT_SUCCESS;
		$data_save['wl']['wl_person_do'] = $this->sess->userdata('c_id');
    	$data_save['wl']['wl_time_do'] = date('Y-m-d H:i:s');
    	
    	$this->m_work_list->add($data_save['wl']);
    	
    	//工单基本信息
    	$data_save['wl']=array();
		$data_save['wl']['wl_code']=$data_save['content']['hr_code_pre'].$data_save['content']['hr_code'];
    	$data_save['wl']['wl_op_table']='hr_info';
    	$data_save['wl']['wl_op_field']='c_id';
    	$data_save['wl']['op_id']=$rtn['id'];
    	$data_save['wl']['p_id']=$this->proc_id;
    	$data_save['wl']['pp_id']=$this->model_name;
    	$data_save['wl']['wl_proc']=element('ppo', $data_save['content']);
    	$data_save['wl']['wl_url']=$this->url_conf.'/act/2';
    	$data_save['wl']['wl_time_end']=date('Y-m-d H:i:s',strtotime('+30 day'));
    	$data_save['wl']['c_accept'] = array($data_save['content']['c_id']);
    	$data_save['wl']['wl_note']='【'.$this->title.'】'
    		.',员工:'.$data_save['content']['c_name'].'['.$data_save['content']['c_login_id'].']'
    		;
    		
    	$data_save['wl']['wl_event']='个人信息补全';

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
	 * 获取日志条件
	 * @param  $arr_save
	 */
	function get_where_log($arr_search,$data_get)
	{
    	$arr_op_id = array();
    	
		$arr_search_link=array();
		$arr_search_link['field']='offer_id';
		$arr_search_link['from']='hr_offer';
		$arr_search_link['where']=' AND c_id = ?';
		$arr_search_link['value'][]=$data_get['op_id'];
		$rs=$this->m_db->query($arr_search_link);
		
		if(count($rs['content'])>0)
		{
			foreach ($rs['content'] as $v) {
				$arr_op_id[] = $v['offer_id'];
			}
		}
		
		$arr_search_link=array();
		$arr_search_link['field']='dim_id';
		$arr_search_link['from']='hr_dim';
		$arr_search_link['where']=' AND c_id = ?';
		$arr_search_link['value'][]=$data_get['op_id'];
		$rs=$this->m_db->query($arr_search_link);
		
		if(count($rs['content'])>0)
		{
			foreach ($rs['content'] as $v) {
				$arr_op_id[] = $v['dim_id'];
			}
		}
		
		$arr_op_id[] = $data_get['op_id'];
		
		$arr_search['where'].=' AND op_id IN ? ';
		$arr_search['value'][]=$arr_op_id;
		
		$arr_search['where'].=' AND log_p_id = ? ';
		$arr_search['value'][]='proc_hr';
		
    	return $arr_search;
	}
}