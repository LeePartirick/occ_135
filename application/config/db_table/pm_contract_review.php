<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['pm_contract_review'] = array( 
  'table_name_show'=>'合同评审项', 
  'table_note'=>'', 
  'fields'=>array( 
    'cr_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'',), 
	'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
    'cr_name'=> array('type'=>'VARCHAR','constraint'=>'250','comment'=>'评审内容','null'=>TRUE,), 
	'cr_ou_show'=> array('type'=>'VARCHAR','constraint'=>'250','comment'=>'评审部门显示','null'=>TRUE,), 
	'cr_ou'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'评审部门','null'=>TRUE,), 
	'cr_ppo'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'评审阶段','null'=>TRUE,), 
	'cr_sn'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'排序','null'=>TRUE,), 
	'cr_default'=> array('type'=>'VARCHAR','constraint'=>'100','default'=>0,'comment'=>'默认评审项','null'=>TRUE,), 
	'cr_person_empty'=> array('type'=>'TINYINT','constraint'=>'3','default'=>0,'comment'=>'评审可为空','null'=>TRUE,), 
	'cr_pass_alter'=> array('type'=>'TINYINT','constraint'=>'3','default'=>0,'comment'=>'修改后通过','null'=>TRUE,), 
	'cr_link_field'=> array('type'=>'TEXT','constraint'=>'','comment'=>'关联字段','null'=>TRUE,), 
	'cr_link_file'=> array('type'=>'TEXT','constraint'=>'','comment'=>'关联文件','null'=>TRUE,), 
	'cr_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'备注','null'=>TRUE,), 

  ),  
  'primary_key'=>array( 
    'cr_id', 
  ),  
  'fields_index'=>array(
  ), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
