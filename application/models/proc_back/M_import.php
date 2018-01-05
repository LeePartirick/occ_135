<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 导入类
 */
class M_import extends CI_Model {
	
 	public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        
        $this->m_define();
    }
    
	/**
     * 
     * 定义
     */
	public function m_define()
    {
    	if( defined('LOAD_M_IMPORT') ) return;
    	define('LOAD_M_IMPORT', 1);
    }
    
	/**
     * 
     * 验证权限
     */
	public function check()
    {
    	
    }
    
    /**
     * 
     * 导入账户
     */
    public function import_account()
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$data_post=array();//POST数组
		$data_get=array();//GET数组
		$data_db=array();//数据库数组
		$data_save=array();//数据库保存数组
		$arr_search=array();
		$rtn=array();//结果
		$check_data=TRUE;
		
		/************变量赋值*****************/
		
		/************数据验证*****************/
		
		/************数据处理*****************/
		$this->m_db->change_db('occ');
		
		$arr_search=array();
		$arr_search['page'] = $this->input->post('start');
		$arr_search['rows'] = 50;
		$arr_search['field'] = '*';
		$arr_search['from'] = 'scap_accounts';
		$arr_search['where'] = " AND a_c_login_id != 'admin'";
		$arr_search['order'] = 'asc';
		$arr_search['sort'] = 'a_s_create_time';
		$rs=$this->m_db->query($arr_search);
		
		/************事件处理*****************/
		
		$this->m_db->change_db('default');
		
		$this->load->model('proc_back/m_account');
		
		$rtn['rtn']=FALSE;
		$rtn['per'] = $arr_search['page']*$arr_search['rows']/ $rs['total'];
		
		if($rtn['per'] > 1 )
		$rtn['per']  = 100;
		else 
		$rtn['per'] = $rtn['per'] *100;
		
		if(count($rs['content']) > 0)
		{
			foreach ($rs['content'] as $v) {
				
				$data_save['content']['a_id']=$v['a_s_id'];
				$data_save['content']['a_login_id']=$v['a_c_login_id'];
				$data_save['content']['a_name']=$v['a_c_display_name'];
				$data_save['content']['a_status']=$v['a_s_status'];
				$data_save['content']['a_login_type']=2;
				$data_db['content']=$this->m_account->get($v['a_s_id']);
				if( empty($data_db['content']) )
				{
					$data_db['sys_account']=$this->m_account->add($data_save['content']);
				}
			}
		}
		else 
		{
			$rtn['rtn'] = TRUE;
		}
		
		$rtn['start'] = $arr_search['page']+1;
		
		/************返回结果****************/
		echo json_encode($rtn);
		exit; 
    }
    
 	/**
     * 
     * 导入联系人
     */
 	public function import_contact()
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$data_post=array();//POST数组
		$data_get=array();//GET数组
		$data_db=array();//数据库数组
		$data_save=array();//数据库保存数组
		$arr_search=array();
		$rtn=array();//结果
		$check_data=TRUE;
		
		/************变量赋值*****************/
		
		/************数据验证*****************/
		
		/************数据处理*****************/
		$this->m_db->change_db('occ');
		
		$arr_search=array();
		$arr_search['page'] = $this->input->post('start');
		$arr_search['rows'] = 50;
		$arr_search['field'] = '*';
		$arr_search['from'] = 'g_contact c
							   LEFT JOIN g_party_property_contact p ON 
							   ( p.p_id = c.c_id )
							   ';
		$arr_search['where'] = " AND c_name != 'admin'";
		$arr_search['value'] =array();
		
		$arr_search['order'] = 'asc';
		$arr_search['sort'] = 'c_id';
		$rs=$this->m_db->query($arr_search);
		/************事件处理*****************/
		$this->m_db->change_db('default');
		
		$this->load->model('proc_contact/m_contact');
		
		$rtn['rtn']=FALSE;
		$rtn['per'] = $arr_search['page']*$arr_search['rows']/ $rs['total'];
		
		if($rtn['per'] > 1 )
		$rtn['per']  = 100;
		else 
		$rtn['per'] = $rtn['per'] *100;
		
		if(count($rs['content']) > 0)
		{
			foreach ($rs['content'] as $v) {
				
				$data_save['content']=array();
				$data_save['content']['c_id']=$v['c_id'];
				$data_save['content']['c_name']=$v['c_name'];
				$data_save['content']['c_login_id']=$v['c_login_id'];
				
				if( ! empty($v['c_login_id']) )
				{
					$data_save['content']['a_id']=$this->m_base->get_field_where('sys_account','a_id'," AND a_login_id = '{$v['c_login_id']}'");
				}
				
				$data_save['content']['c_org']=$v['o_id'];
				$data_save['content']['c_rs_org']=$v['o_id'];
				$data_save['content']['c_sex']=$v['c_sex_type'];
				$data_save['content']['c_code_person']=$v['c_person_id_number'];
				$data_save['content']['c_birthday']=$v['c_birthday'];
				$data_save['content']['c_tel']=$v['ppc_mobile'];
				$data_save['content']['c_img']=$v['ppc_image_id'];
				$data_save['content']['c_phone']=$v['ppc_telephone'];
				$data_save['content']['c_email']=$v['ppc_email_address'];
				
				$data_db['content']=$this->m_contact->get($v['c_id']);
				if( empty($data_db['content']) )
				{
					$data_db['content']=$this->m_contact->add($data_save['content']);
				}
			}
		}
		else 
		{
			$rtn['rtn'] = TRUE;
		}
		
		$rtn['start'] = $arr_search['page']+1;
		
		/************返回结果****************/
		echo json_encode($rtn);
		exit; 
    }
    
/**
     * 
     * 导入部门
     */
 	public function import_ou()
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$data_post=array();//POST数组
		$data_get=array();//GET数组
		$data_db=array();//数据库数组
		$data_save=array();//数据库保存数组
		$arr_search=array();
		$rtn=array();//结果
		$check_data=TRUE;
		
		/************变量赋值*****************/
		
		/************数据验证*****************/
		
		/************数据处理*****************/
		$this->m_db->change_db('occ');
		
		$arr_search=array();
		$arr_search['page'] = $this->input->post('start');
		$arr_search['rows'] = 50;
		$arr_search['field'] = '*';
		$arr_search['from'] = 'g_org_unit ou 
							   LEFT JOIN g_party_property_org_unit ppou ON 
							   (ou.ou_id = ppou.p_id AND ppou_sn = 1)
							   LEFT JOIN g_org o ON 
							   (ou.o_id=o.o_id)';
		$arr_search['where'] = 'AND ppou_abbr IN ? ';
		$arr_search['value'] =array();
		$arr_search['value'][] = array('OCC','OCCP','OCC_RS');
		
		$arr_search['order'] = 'asc';
		$arr_search['sort'] = 'ou_id';
		$rs=$this->m_db->query($arr_search);
		
		/************事件处理*****************/
		$this->m_db->change_db('default');
		
		$this->load->model('proc_ou/m_ou');
		
		$rtn['rtn']=FALSE;
		$rtn['per'] = $arr_search['page']*$arr_search['rows']/ $rs['total'];
		
		if($rtn['per'] > 1 )
		$rtn['per']  = 100;
		else 
		$rtn['per'] = $rtn['per'] *100;
		
		if(count($rs['content']) > 0)
		{
			foreach ($rs['content'] as $v) {
				
				if($v['ou_name'] == $v['o_name'])
				continue;
				
				
				$data_save['content']['ou_id']=$v['ou_id'];
				$data_save['content']['ou_name']=$v['ou_name'];
				
				$data_save['content']['ou_level']=OU_LEVEL_BM; //部门
				$data_save['content']['ou_status']=OU_STATUS_RUN; //运作
				$data_save['content']['ou_class']=OU_CLASS_OU; //组织架构
				
				if( ! empty($data_save['content']['ou_parent_id']))
				$data_save['content']['ou_parent']=$v['ou_parent_id'];
				else 
				$data_save['content']['ou_parent']=$v['ou_parent_id'];
				
				$data_save['content']['ou_code']=$this->m_ou->get_code(); 
				$data_save['content']['ou_org']=$v['o_id']; 
				
				$v['ou_name']=trim($v['ou_name']);
				$ou_id = $this->m_base->get_field_where('sys_ou','ou_id'," AND ou_org = '{$v['o_id']}' AND ou_name = '{$v['ou_name']}'");
				if($ou_id)
				{
					$data_db['content']=$this->m_ou->get($ou_id);
					$data_save['content'] = array();
					$data_save['content']['ou_id'] = $ou_id;
					
					if($v['ppou_abbr'] == 'OCC_RS')
					{
						if( ! strstr($data_db['content']['ou_tag'],OU_TAG_HR) )
						$data_save['content']['ou_tag']=$data_db['content']['ou_tag'].','.OU_TAG_HR;
					}
					
					$data_db['sys_ou']=$this->m_ou->update($data_save['content']);
					
					continue;
				}
				
				if( $v['ppou_abbr'] == 'OCC' )
				{
					$data_save['content']['ou_tag']=OU_TAG_BUD;
				}
				
				$data_db['content']=$this->m_ou->get($data_save['content']['ou_id']);
				
				if( empty($data_db['content']) )
				{
					$data_db['sys_ou']=$this->m_ou->add($data_save['content']);
				}
			}
		}
		else 
		{
			$rtn['rtn'] = TRUE;
			
			$arr_search_update=array();
			$arr_search_update['field'] = 'ou.*';
			$arr_search_update['from'] = 'sys_ou ou
								   LEFT JOIN sys_ou ou_p ON
								   (ou_p.ou_id = ou.ou_parent)';
			$arr_search_update['where'] = 'AND ou.ou_level = '.OU_LEVEL_BM.' AND ou_p.ou_id IS NULL ';
			$arr_search_update['value'] =array();
			$arr_search_update['order'] = 'asc';
			$arr_search_update['sort'] = 'ou_id';
			$rs=$this->m_db->query($arr_search_update);
			
			foreach ($rs['content'] as $v) {
				
				$data_save['content'] = array();
				$data_save['content']['ou_id']=$v['ou_id'];
				$data_save['content']['ou_parent']=$v['ou_org'];
				
				$this->m_ou->update($data_save['content']);
			}
		}
		
		$rtn['start'] = $arr_search['page']+1;
		
		/************返回结果****************/
		echo json_encode($rtn);
		exit; 
    }
    
	/**
     * 
     * 导入分公司
     */
 	public function import_hr_org()
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$data_post=array();//POST数组
		$data_get=array();//GET数组
		$data_db=array();//数据库数组
		$data_save=array();//数据库保存数组
		$arr_search=array();
		$rtn=array();//结果
		$check_data=TRUE;
		
		/************变量赋值*****************/
		
		/************数据验证*****************/
		
		/************数据处理*****************/
		$this->m_db->change_db('occ');
		
		$arr_search=array();
		$arr_search['page'] = $this->input->post('start');
		$arr_search['rows'] = 50;
		$arr_search['field'] = '*';
		$arr_search['from'] = 'g_org o
							  LEFT JOIN g_party_property_org ppo ON 
							  (o.o_id = ppo.p_id AND ppo_sn = 1)';
		$arr_search['where'] = 'AND o.o_type = 10';
		$arr_search['order'] = 'asc';
		$arr_search['sort'] = 'o_id';
		$rs=$this->m_db->query($arr_search);
		
		/************事件处理*****************/
		
		$this->m_db->change_db('default');
		
		$this->load->model('proc_ou/m_ou');
		$this->load->model('proc_org/m_org');
		
		$rtn['rtn']=FALSE;
		$rtn['per'] = $arr_search['page']*$arr_search['rows']/ $rs['total'];
		
		if($rtn['per'] > 1 )
		$rtn['per']  = 100;
		else 
		$rtn['per'] = $rtn['per'] *100;
		
		if(count($rs['content']) > 0)
		{
			foreach ($rs['content'] as $v) {
				
				$data_save['content']['ou_id']=$v['o_id'];
				$data_save['content']['ou_name']=$v['o_name'];
				$data_save['content']['ou_status']=OU_STATUS_RUN; //运作
				$data_save['content']['ou_class']=OU_CLASS_OU; //组织架构
				$data_save['content']['ou_level']=OU_LEVEL_ORG; //组织架构
				$data_save['content']['ou_parent']='39ECED9EE5831E9E6020C567511FD319'; //三零服务网
				$data_save['content']['ou_code']=$this->m_ou->get_code(); 
				$data_save['content']['o_note']=$v['ppo_comment'];
				
				$data_save['content']['ou_org']=$data_save['content']['ou_id']; 
				
				$data_db['content']=$this->m_ou->get($data_save['content']['ou_id']);
				
				if( empty($data_db['content']) )
				{
					$data_db['sys_ou']=$this->m_ou->add($data_save['content']);
					
					$data_save['content']['o_id']=$v['o_id'];
					$data_save['content']['o_name']=$v['o_name'];
					$data_save['content']['o_type']=O_TYPE_OU; //分公司
					$data_save['content']['o_id_standard']=$v['o_id'];
					$data_save['content']['o_code']=$data_save['content']['ou_code'];
					$data_save['content']['o_status']=O_STATUS_YES;//有效
					$data_save['content']['o_code_taxpayer']=$v['ppo_taxpayer_id'];
					$data_save['content']['o_legal_person']=$v['ppo_legal_principal'];
					
					$data_save['content']['o_tel']=$v['ppo_telephone'];
					$data_save['content']['o_fax']=$v['ppo_fax'];
					$data_save['content']['o_post_code']=$v['ppo_postal_code'];
					$data_save['content']['o_addr']=$v['ppo_postal_address'];
					$data_save['content']['o_web']=$v['ppo_webpage_address'];
					$data_save['content']['o_email']=$v['ppo_email_address'];
					$data_save['content']['o_note']=$v['ppo_comment'];
					
					$data_db['sys_org']=$this->m_org->add($data_save['content']);
					
					$this->m_table_op->load('sys_org_addr');
						 	
					if($v['ppo_location'])
					{
						$data_save['sys_org_addr']['o_addr_content']=$v['ppo_location'];
						$data_save['sys_org_addr']['o_addr_cross']=$v['ppo_location_cross'];
						$data_save['sys_org_addr']['o_id']=$v['o_id'];
						$this->m_table_op->add($data_save['sys_org_addr']);
					}
					
					if($v['ppo_location_2'])
					{
						$data_save['sys_org_addr']['o_addr_content']=$v['ppo_location_2'];
						$data_save['sys_org_addr']['o_addr_cross']=$v['ppo_location_cross_2'];
						$data_save['sys_org_addr']['o_id']=$v['o_id'];
						$this->m_table_op->add($data_save['sys_org_addr']);
					}
					
					if($v['ppo_location_3'])
					{
						$data_save['sys_org_addr']['o_addr_content']=$v['ppo_location_3'];
						$data_save['sys_org_addr']['o_addr_cross']=$v['ppo_location_cross_3'];
						$data_save['sys_org_addr']['o_id']=$v['o_id'];
						$this->m_table_op->add($data_save['sys_org_addr']);
					}
					
					if($v['ppo_location_4'])
					{
						$data_save['sys_org_addr']['o_addr_content']=$v['ppo_location_4'];
						$data_save['sys_org_addr']['o_addr_cross']=$v['ppo_location_cross_4'];
						$data_save['sys_org_addr']['o_id']=$v['o_id'];
						$this->m_table_op->add($data_save['sys_org_addr']);
					}
					
					if($v['ppo_location_5'])
					{
						$data_save['sys_org_addr']['o_addr_content']=$v['ppo_location_5'];
						$data_save['sys_org_addr']['o_addr_cross']=$v['ppo_location_cross_5'];
						$data_save['sys_org_addr']['o_id']=$v['o_id'];
						$this->m_table_op->add($data_save['sys_org_addr']);
					}
					
					$this->m_table_op->load('sys_org_account');
					
					if($v['ppo_bank'])
					{
						$data_save['sys_org_account']['oacc_bank']=$v['ppo_bank'];
						$data_save['sys_org_account']['oacc_account']=$v['ppo_bank_account'];
						$data_save['sys_org_account']['o_id']=$v['o_id'];
						$this->m_table_op->add($data_save['sys_org_account']);
					}
					
					if($v['ppo_bank_2'])
					{
						$data_save['sys_org_account']['oacc_bank']=$v['ppo_bank_2'];
						$data_save['sys_org_account']['oacc_account']=$v['ppo_bank_account_2'];
						$data_save['sys_org_account']['o_id']=$v['o_id'];
						$this->m_table_op->add($data_save['sys_org_account']);
					}
					
					if($v['ppo_bank_3'])
					{
						$data_save['sys_org_account']['oacc_bank']=$v['ppo_bank_3'];
						$data_save['sys_org_account']['oacc_account']=$v['ppo_bank_account_3'];
						$data_save['sys_org_account']['o_id']=$v['o_id'];
						$this->m_table_op->add($data_save['sys_org_account']);
					}
				}
			}
		}
		else 
		{
			$rtn['rtn'] = TRUE;
		}
		
		$rtn['start'] = $arr_search['page']+1;
		
		/************返回结果****************/
		echo json_encode($rtn);
		exit; 
    }
    
/**
     * 
     * 导入机构
     */
 	public function import_org()
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$data_post=array();//POST数组
		$data_get=array();//GET数组
		$data_db=array();//数据库数组
		$data_save=array();//数据库保存数组
		$arr_search=array();
		$rtn=array();//结果
		$check_data=TRUE;
		
		/************变量赋值*****************/
		
		/************数据验证*****************/
		
		/************数据处理*****************/
		$this->m_db->change_db('occ');
		
		$arr_search=array();
		$arr_search['page'] = $this->input->post('start');
		$arr_search['rows'] = 50;
		$arr_search['field'] = '*';
		$arr_search['from'] = 'g_org o
							  LEFT JOIN g_party_property_org ppo ON 
							  (o.o_id = ppo.p_id AND ppo_sn = 1)';
		$arr_search['where'] = 'AND o.o_type = 1 OR o.o_type = 2';
		$arr_search['order'] = 'asc';
		$arr_search['sort'] = 'o_code';
		$rs=$this->m_db->query($arr_search);
		
		/************事件处理*****************/
		
		$this->m_db->change_db('default');
		
		$this->load->model('proc_org/m_org');
		
		$rtn['rtn']=FALSE;
		$rtn['per'] = $arr_search['page']*$arr_search['rows']/ $rs['total'];
		
		if($rtn['per'] > 1 )
		$rtn['per']  = 100;
		else 
		$rtn['per'] = $rtn['per'] *100;
		
		if(count($rs['content']) > 0)
		{
			foreach ($rs['content'] as $v) {
				
				$data_save['content']['o_id']=$v['o_id'];
				
				$data_db['content']=$this->m_org->get($data_save['content']['o_id']);
				
				if( empty($data_db['content']) )
				{
					$data_save['content']['o_id']=$v['o_id'];
					$data_save['content']['o_name']=$v['o_name'];
					$data_save['content']['o_type']=O_TYPE_OTHER; 
					$data_save['content']['o_id_standard']=$v['o_id'];
					$data_save['content']['o_status']=O_STATUS_YES;//有效
					$data_save['content']['o_code']=$this->m_org->get_code();
					
					$data_save['content']['o_code_taxpayer']=$v['ppo_taxpayer_id'];
					$data_save['content']['o_legal_person']=$v['ppo_legal_principal'];
					
					$data_save['content']['o_tel']=$v['ppo_telephone'];
					$data_save['content']['o_fax']=$v['ppo_fax'];
					$data_save['content']['o_post_code']=$v['ppo_postal_code'];
					$data_save['content']['o_addr']=$v['ppo_postal_address'];
					$data_save['content']['o_web']=$v['ppo_webpage_address'];
					$data_save['content']['o_email']=$v['ppo_email_address'];
					$data_save['content']['o_note']=$v['ppo_comment'];
					$data_save['content']['o_tag'] = $v['o_type'];
					
					$data_db['sys_org']=$this->m_org->add($data_save['content']);
					
					$this->m_table_op->load('sys_org_addr');
						 	
					if($v['ppo_location'])
					{
						$data_save['sys_org_addr']['o_addr_content']=$v['ppo_location'];
						$data_save['sys_org_addr']['o_addr_cross']=$v['ppo_location_cross'];
						$data_save['sys_org_addr']['o_id']=$v['o_id'];
						$this->m_table_op->add($data_save['sys_org_addr']);
					}
					
					if($v['ppo_location_2'])
					{
						$data_save['sys_org_addr']['o_addr_content']=$v['ppo_location_2'];
						$data_save['sys_org_addr']['o_addr_cross']=$v['ppo_location_cross_2'];
						$data_save['sys_org_addr']['o_id']=$v['o_id'];
						$this->m_table_op->add($data_save['sys_org_addr']);
					}
					
					if($v['ppo_location_3'])
					{
						$data_save['sys_org_addr']['o_addr_content']=$v['ppo_location_3'];
						$data_save['sys_org_addr']['o_addr_cross']=$v['ppo_location_cross_3'];
						$data_save['sys_org_addr']['o_id']=$v['o_id'];
						$this->m_table_op->add($data_save['sys_org_addr']);
					}
					
					if($v['ppo_location_4'])
					{
						$data_save['sys_org_addr']['o_addr_content']=$v['ppo_location_4'];
						$data_save['sys_org_addr']['o_addr_cross']=$v['ppo_location_cross_4'];
						$data_save['sys_org_addr']['o_id']=$v['o_id'];
						$this->m_table_op->add($data_save['sys_org_addr']);
					}
					
					if($v['ppo_location_5'])
					{
						$data_save['sys_org_addr']['o_addr_content']=$v['ppo_location_5'];
						$data_save['sys_org_addr']['o_addr_cross']=$v['ppo_location_cross_5'];
						$data_save['sys_org_addr']['o_id']=$v['o_id'];
						$this->m_table_op->add($data_save['sys_org_addr']);
					}
					
					$this->m_table_op->load('sys_org_account');
					
					if($v['ppo_bank'])
					{
						$data_save['sys_org_account']['oacc_bank']=$v['ppo_bank'];
						$data_save['sys_org_account']['oacc_account']=$v['ppo_bank_account'];
						$data_save['sys_org_account']['o_id']=$v['o_id'];
						$this->m_table_op->add($data_save['sys_org_account']);
					}
					
					if($v['ppo_bank_2'])
					{
						$data_save['sys_org_account']['oacc_bank']=$v['ppo_bank_2'];
						$data_save['sys_org_account']['oacc_account']=$v['ppo_bank_account_2'];
						$data_save['sys_org_account']['o_id']=$v['o_id'];
						$this->m_table_op->add($data_save['sys_org_account']);
					}
					
					if($v['ppo_bank_3'])
					{
						$data_save['sys_org_account']['oacc_bank']=$v['ppo_bank_3'];
						$data_save['sys_org_account']['oacc_account']=$v['ppo_bank_account_3'];
						$data_save['sys_org_account']['o_id']=$v['o_id'];
						$this->m_table_op->add($data_save['sys_org_account']);
					}
				}
			}
		}
		else 
		{
			$rtn['rtn'] = TRUE;
		}
		
		$rtn['start'] = $arr_search['page']+1;
		
		/************返回结果****************/
		echo json_encode($rtn);
		exit; 
    }
    
	/**
     * 
     * 导入职位
     */
 	public function import_hr_job()
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$data_post=array();//POST数组
		$data_get=array();//GET数组
		$data_db=array();//数据库数组
		$data_save=array();//数据库保存数组
		$arr_search=array();
		$rtn=array();//结果
		$check_data=TRUE;
		
		/************变量赋值*****************/
		
		/************数据验证*****************/
		
		/************数据处理*****************/
		$this->m_db->change_db('occ');
		
		$arr_search=array();
		$arr_search['page'] = $this->input->post('start');
		$arr_search['rows'] = 50;
		$arr_search['field'] = '*';
		$arr_search['from'] = 'itsm_yp_fb_job';
		$arr_search['where'] = ' GROUP BY job_fb_name ';
		$arr_search['value'] =array();
		
		$arr_search['order'] = 'asc';
		$arr_search['sort'] = 'job_fb_id';
		$rs=$this->m_db->query($arr_search);
		/************事件处理*****************/
		$this->m_db->change_db('default');
		
		$this->load->model('proc_hr/m_hr_job');
		
		$rtn['rtn']=FALSE;
		$rtn['per'] = $arr_search['page']*$arr_search['rows']/ $rs['total'];
		
		if($rtn['per'] > 1 )
		$rtn['per']  = 100;
		else 
		$rtn['per'] = $rtn['per'] *100;
		
		if(count($rs['content']) > 0)
		{
			foreach ($rs['content'] as $v) {
				
				$data_save['content']['job_id']=$v['job_fb_id'];
				$data_save['content']['job_name']=$v['job_fb_name'];
				$data_db['content']=$this->m_hr_job->get($v['job_fb_id']);
				$data_save['content']['job_code']=$this->m_hr_job->get_code($data_save['content']);
				if( empty($data_db['content']) )
				{
					$data_db['sys_account']=$this->m_hr_job->add($data_save['content']);
				}
			}
		}
		else 
		{
			$rtn['rtn'] = TRUE;
		}
		
		$rtn['start'] = $arr_search['page']+1;
		
		/************返回结果****************/
		echo json_encode($rtn);
		exit; 
    }
    
    /**
     * 
     * 导入信息系统
     */
 	public function import_oa_office()
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$data_post=array();//POST数组
		$data_get=array();//GET数组
		$data_db=array();//数据库数组
		$data_save=array();//数据库保存数组
		$arr_search=array();
		$rtn=array();//结果
		$check_data=TRUE;
		
		/************变量赋值*****************/
		
		/************数据验证*****************/
		
		/************数据处理*****************/
		$this->m_db->change_db('occ');
		
		$arr_search=array();
		$arr_search['page'] = $this->input->post('start');
		$arr_search['rows'] = 50;
		$arr_search['field'] = '*';
		$arr_search['from'] = 'itsm_rs_office_platform';
		$arr_search['where'] = '';
		$arr_search['value'] =array();
		
		$arr_search['order'] = 'asc';
		$arr_search['sort'] = 'rs_office_platform_id';
		$rs=$this->m_db->query($arr_search);
		/************事件处理*****************/
		$this->m_db->change_db('default');
		
		$this->load->model('proc_office/m_oa_office');
		
		$rtn['rtn']=FALSE;
		$rtn['per'] = $arr_search['page']*$arr_search['rows']/ $rs['total'];
		
		if($rtn['per'] > 1 )
		$rtn['per']  = 100;
		else 
		$rtn['per'] = $rtn['per'] *100;
		
		if(count($rs['content']) > 0)
		{
			foreach ($rs['content'] as $v) {
				
				$data_save['content']=array();
				$data_save['content']['offi_id']=$v['rs_office_platform_id'];
				$data_save['content']['offi_name']=$v['rs_office_platform_name'];
				$data_save['content']['offi_status_run']=1;//启用
				
				$data_db['content']=$this->m_oa_office->get($v['rs_office_platform_id']);
				if( empty($data_db['content']) )
				{
					$data_db['content']=$this->m_oa_office->add($data_save['content']);
				}
			}
		}
		else 
		{
			$rtn['rtn'] = TRUE;
		}
		
		$rtn['start'] = $arr_search['page']+1;
		
		/************返回结果****************/
		echo json_encode($rtn);
		exit; 
    }
    
	/**
     * 
     * 导入技术方向
     */
 	public function import_hr_tec()
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$data_post=array();//POST数组
		$data_get=array();//GET数组
		$data_db=array();//数据库数组
		$data_save=array();//数据库保存数组
		$arr_search=array();
		$rtn=array();//结果
		$check_data=TRUE;
		
		/************变量赋值*****************/
		
		/************数据验证*****************/
		
		/************数据处理*****************/
		$this->m_db->change_db('occ');
		
		$arr_search=array();
		$arr_search['page'] = $this->input->post('start');
		$arr_search['rows'] = 50;
		$arr_search['field'] = '*';
		$arr_search['from'] = 'itsm_rs_technical_direction';
		$arr_search['where'] = 'GROUP BY rs_technical_direction_name';
		$arr_search['value'] =array();
		
		$arr_search['order'] = 'asc';
		$arr_search['sort'] = 'rs_org';
		$rs=$this->m_db->query($arr_search);
		/************事件处理*****************/
		$this->m_db->change_db('default');
		
		$this->load->model('proc_hr/m_hr_tec');
		
		$rtn['rtn']=FALSE;
		$rtn['per'] = $arr_search['page']*$arr_search['rows']/ $rs['total'];
		
		if($rtn['per'] > 1 )
		$rtn['per']  = 100;
		else 
		$rtn['per'] = $rtn['per'] *100;
		
		if(count($rs['content']) > 0)
		{
			foreach ($rs['content'] as $v) {
				
				$data_save['content']=array();
				$data_save['content']['tec_id']=$v['rs_technical_direction_id'];
				$data_save['content']['tec_name']=$v['rs_technical_direction_name'];
				$data_save['content']['tec_note']=$v['rs_technical_direction_content'];
				
				$data_db['content']=$this->m_hr_tec->get($v['rs_technical_direction_id']);
				if( empty($data_db['content']) )
				{
					$data_db['content']=$this->m_hr_tec->add($data_save['content']);
				}
			}
		}
		else 
		{
			$rtn['rtn'] = TRUE;
		}
		
		$rtn['start'] = $arr_search['page']+1;
		
		/************返回结果****************/
		echo json_encode($rtn);
		exit; 
    }
    
	/**
     * 
     * 导入文件属性
     */
 	public function import_file_type()
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$data_post=array();//POST数组
		$data_get=array();//GET数组
		$data_db=array();//数据库数组
		$data_save=array();//数据库保存数组
		$arr_search=array();
		$rtn=array();//结果
		$check_data=TRUE;
		
		/************变量赋值*****************/
		
		/************数据验证*****************/
		
		/************数据处理*****************/
		$this->m_db->change_db('occ');
		
		$arr_search=array();
		$arr_search['page'] = $this->input->post('start');
		$arr_search['rows'] = 50;
		$arr_search['field'] = '*';
		$arr_search['from'] = 'occ_file_type_extend';
		$arr_search['value'] =array();
		
		$arr_search['order'] = 'asc';
		$arr_search['sort'] = 'ofte_create_time';
		$rs=$this->m_db->query($arr_search);
		/************事件处理*****************/
		$this->m_db->change_db('default');
		
		$this->load->model('proc_file/m_file_type');
		
		$rtn['rtn']=FALSE;
		$rtn['per'] = $arr_search['page']*$arr_search['rows']/ $rs['total'];
		
		if($rtn['per'] > 1 )
		$rtn['per']  = 100;
		else 
		$rtn['per'] = $rtn['per'] *100;
		
		if(count($rs['content']) > 0)
		{
			foreach ($rs['content'] as $v) {
				
				$data_save['content']=array();
				$data_save['content']['f_t_id']=$v['ofte_id'];
				$data_save['content']['f_t_name']=$v['ofte_name'];
				$data_save['content']['f_t_parent']=$v['ofte_parent_id'];
				if( ! $data_save['content']['f_t_parent'] )
				$data_save['content']['f_t_parent'] = 'base';
				
				$data_save['content']['f_t_sn']=$v['ofte_sn'];
				
				$data_db['content']=$this->m_file_type->get($v['ofte_id']);
				if( empty($data_db['content']) )
				{
					$data_db['content']=$this->m_file_type->add($data_save['content']);
				}
			}
		}
		else 
		{
			$rtn['rtn'] = TRUE;
		}
		
		$rtn['start'] = $arr_search['page']+1;
		
		/************返回结果****************/
		echo json_encode($rtn);
		exit; 
    }
    
	/**
     * 
     * 导入预算科目
     */
 	public function import_subject()
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$data_post=array();//POST数组
		$data_get=array();//GET数组
		$data_db=array();//数据库数组
		$data_save=array();//数据库保存数组
		$arr_search=array();
		$rtn=array();//结果
		$check_data=TRUE;
		
		/************变量赋值*****************/
		
		/************数据验证*****************/
		
		/************数据处理*****************/
		$this->m_db->change_db('occ');
		
		$arr_search=array();
		$arr_search['page'] = $this->input->post('start');
		$arr_search['rows'] = 50;
		$arr_search['field'] = '*';
		$arr_search['from'] = 'itsm_subject';
		$arr_search['value'] =array();
		
		$arr_search['order'] = 'asc';
		$arr_search['sort'] = 'sub_code';
		$rs=$this->m_db->query($arr_search);
		/************事件处理*****************/
		$this->m_db->change_db('default');
		
		$this->load->model('proc_bud/m_subject');
		
		$rtn['rtn']=FALSE;
		$rtn['per'] = $arr_search['page']*$arr_search['rows']/ $rs['total'];
		
		if($rtn['per'] > 1 )
		$rtn['per']  = 100;
		else 
		$rtn['per'] = $rtn['per'] *100;
		
		if(count($rs['content']) > 0)
		{
			foreach ($rs['content'] as $v) {
				
				$data_save['content']=array();
				$data_save['content']['sub_id']=$v['sub_id'];
				$data_save['content']['sub_name']=$v['sub_name'];
				$data_save['content']['sub_parent']=$v['sub_parent_id'];
				
				if( ! $data_save['content']['sub_parent'] 
				 || $data_save['content']['sub_parent'] == '769BB7FB74CE33B0BC31F31012779D27')
				$data_save['content']['sub_parent']='base';
				
				$data_save['content']['sub_class']=$v['sub_category_main'];
				$data_save['content']['sub_type']=$v['sub_category_budget'];
				
				$data_save['content']['sub_code']=$this->m_subject->get_code();
				$data_db['content']=$this->m_subject->get($v['sub_id']);
				
				if( empty($data_db['content']) )
				{
					$data_db['content']=$this->m_subject->add($data_save['content']);
				}
			}
		}
		else 
		{
			$rtn['rtn'] = TRUE;
		}
		
		$rtn['start'] = $arr_search['page']+1;
		
		/************返回结果****************/
		echo json_encode($rtn);
		exit; 
    }
    
	/**
     * 
     * 导入全国区域
     */
 	public function import_area()
    {
    	/************模型载入*****************/
    	$this->load->model('base/m_web_info');
    	/************变量初始化****************/
		$data_post=array();//POST数组
		$data_get=array();//GET数组
		$data_db=array();//数据库数组
		$data_save=array();//数据库保存数组
		$arr_search=array();
		$rtn=array();//结果
		$check_data=TRUE;
		
		/************变量赋值*****************/
		$area_id = $this->input->post('start');
		$rtn['per'] = 0;
		$rtn['rtn'] = TRUE;
		/************数据验证*****************/
		
		/************数据处理*****************/
   		$arr_main = $this->m_web_info->get_china_area();
		$arr_main = json_decode($arr_main,TRUE);
		
		if (count($arr_main) > 0 )
		{
			$rtn['rtn']=FALSE;
			$i = 0;
			
			foreach ($arr_main as $v) {
				
				$i ++ ;
				
				$path=str_replace('\\', '/', APPPATH).'config/china_area/'.$v['area_id'];
				
				if(file_exists($path))
				continue;
				
				$arr_area_2 =  $this->m_web_info->get_china_area($v['area_id']);
				$arr_area_2 = json_decode($arr_area_2,TRUE);
				
				foreach ($arr_area_2 as $v2) {
					$arr_area_3 =  $this->m_web_info->get_china_area($v2['area_id']);
				}
				
				break;
			}
			$rtn['per'] = $i*100 / count($arr_main);
			
			if($i >= count($arr_main))
			{
				$rtn['rtn']=TRUE;
			}
			
		}
		/************事件处理*****************/
		$rtn['start'] = 1;
		
		/************返回结果****************/
		echo json_encode($rtn);
		exit; 
    }
}