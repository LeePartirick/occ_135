<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['fm_back_section'] = array( 
  'table_name_show'=>'回款', 
  'table_note'=>'', 
  'fields'=>array( 
    'bs_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'',), 
	'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
	'ppo'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'节点','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,), 

	'bs_code'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'单据编号','null'=>TRUE,), 
	'bs_sum'=> array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'回款金额','default'=>'0.00','null'=>TRUE,), 

	'bs_company_out'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'回款单位','null'=>TRUE,), 
	'bs_contact_manager'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'回款统计人','null'=>TRUE,), 
	'bs_org_owner'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'所属机构','null'=>TRUE,), 

	'bs_time'=> array('type'=>'DATE','constraint'=>'','comment'=>'回款时间','null'=>TRUE,),
	'bs_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'备注','null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'bs_id', 
  ),  
  'fields_index'=>array(
  ), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
