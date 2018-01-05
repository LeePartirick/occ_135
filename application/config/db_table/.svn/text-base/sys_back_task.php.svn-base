<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['sys_back_task'] = array( 
  'table_name_show'=>'后台任务表', 
  'table_note'=>'', 
  'fields'=>array( 
    'bt_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'',), 
    'bt_name'=> array('type'=>'VARCHAR','constraint'=>'80','comment'=>'任务名称','null'=>TRUE,), 
    'bt_param'=> array('type'=>'TEXT','constraint'=>'','comment'=>'参数','null'=>TRUE,), 
	'bt_type'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'类型','null'=>TRUE,), 
	'bt_result'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'结果','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,), 
    'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
	'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'bt_id', 
  ),  
  'fields_index'=>array(),
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
