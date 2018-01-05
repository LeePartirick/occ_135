<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['sys_org_detail'] = array( 
  'table_name_show'=>'机构明细表', 
  'table_note'=>'',  
  'fields'=>array( 
    'o_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'',), 
    'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
    'o_legal_person'=> array('type'=>'VARCHAR','constraint'=>'80','comment'=>'机构法人','null'=>TRUE,), 
    'o_code_taxpayer'=> array('type'=>'VARCHAR','constraint'=>'80','comment'=>'纳税人识别号','null'=>TRUE,), 
	'o_sum_register'=> array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'注册资金','default'=>'0','null'=>TRUE,), 
	'o_licence'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'营业执照类型','UNSIGNED'=>TRUE,'null'=>TRUE,), 
	'o_date_run'=> array('type'=>'DATE','constraint'=>'','comment'=>'营业期限至','null'=>TRUE,), 
	'o_range'=> array('type'=>'TEXT','constraint'=>'','comment'=>'经营范围','null'=>TRUE,),
	'o_addr_register'=> array('type'=>'TEXT','constraint'=>'','comment'=>'注册地址','null'=>TRUE,),
    'o_tel'=> array('type'=>'VARCHAR','constraint'=>'20','comment'=>'联系电话','null'=>TRUE,), 
    'o_fax'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'传真','null'=>TRUE,), 
    'o_post_code'=> array('type'=>'VARCHAR','constraint'=>'20','comment'=>'邮编','null'=>TRUE,), 
    'o_addr'=> array('type'=>'TEXT','constraint'=>'','comment'=>'经营地址','null'=>TRUE,), 
    'o_web'=> array('type'=>'TEXT','constraint'=>'','comment'=>'公司主页','null'=>TRUE,), 
    'o_email'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'Email','null'=>TRUE,), 
    'o_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'备注','null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'o_id', 
  ),  
  'fields_index'=>array(),
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
