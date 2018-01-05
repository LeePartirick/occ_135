<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['sys_wl_person'] = array( 
  'table_name_show'=>'工单人员', 
  'table_note'=>'',
  'type'=>'merge',
  'fields'=>array( 
    'wlp_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'主键',), 
    'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
    'wlp_person'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'相关人','null'=>TRUE,), 
    'wlp_type'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'相关类型','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'wl_id'=> array('type'=>'VARCHAR','constraint'=>'40','null'=>TRUE,), 
    'wl_op_id'=> array('type'=>'VARCHAR','constraint'=>'40','null'=>TRUE,), 
	'wl_pp_id'=> array('type'=>'VARCHAR','constraint'=>'40','null'=>TRUE,), 
	'wlp_time_read'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'已读时间','null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'wlp_id', 
  ),  
  'fields_index'=>array(),
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
