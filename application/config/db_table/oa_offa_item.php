<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['oa_offa_item'] = array( 
  'table_name_show'=>'信息系统申请明细', 
  'table_note'=>'', 
  'fields'=>array( 
    'offai_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'',), 
	'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
    'offai_offi_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'信息系统','null'=>TRUE,), 
	'offai_model'=> array('type'=>'VARCHAR','constraint'=>'250','comment'=>'模块','null'=>TRUE,), 
    'offai_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'备注','null'=>TRUE,), 
    'offai_flag_alert'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'提醒','UNSIGNED'=>TRUE,'null'=>TRUE,),
	'offai_c_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'所有人','null'=>TRUE,),
	'offai_person_start'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'开通人','null'=>TRUE,),
	'offai_time_start'=> array('type'=>'DATE','constraint'=>'','comment'=>'开通时间','null'=>TRUE,),
	'offai_person_end'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'注销人','null'=>TRUE,),
	'offai_time_end'=> array('type'=>'DATE','constraint'=>'','comment'=>'注销时间','null'=>TRUE,),
	'offa_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'关联单据','null'=>TRUE,),
	'offl_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'关联单据','null'=>TRUE,),
  ),  
  'primary_key'=>array( 
    'offai_id', 
  ),  
  'fields_index'=>array(
  ), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
