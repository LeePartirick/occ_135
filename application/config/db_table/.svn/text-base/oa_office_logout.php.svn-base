<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['oa_office_logout'] = array(
  'table_name_show'=>'信息系统注销',
  'table_note'=>'', 
  'fields'=>array( 
    'offl_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'',),
	'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
    'offl_code'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'单据编号','null'=>TRUE,),
	'offl_c_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'系统所有人','null'=>TRUE,),
    'offl_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'备注','null'=>TRUE,),
	'offl_link_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'关联ID','null'=>TRUE,),
	'ppo'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'流程节点','UNSIGNED'=>TRUE,'null'=>TRUE,),
  ),  
  'primary_key'=>array( 
    'offl_id',
  ),  
  'fields_index'=>array(
  ), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
