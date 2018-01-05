<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['sys_file_verson'] = array( 
  'table_name_show'=>'文件版本表', 
  'table_note'=>'', 
  'fields'=>array( 
	'f_v_id'=> array('type'=>'VARCHAR','constraint'=>'40',), 
	'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
	'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,), 
	'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
    'f_id'=> array('type'=>'VARCHAR','constraint'=>'80','comment'=>'关联文件','null'=>TRUE,), 
    'f_v_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'日志','comment'=>'','null'=>TRUE,), 
    'f_v_size'=> array('type'=>'DECIMAL','constraint'=>'11,2','comment'=>'大小','comment'=>'','default'=>'0','null'=>TRUE,), 
    'f_v_sn'=> array('type'=>'INT','constraint'=>'11','comment'=>'版本','comment'=>'','default'=>'1','null'=>TRUE,), 
    'f_v_path'=> array('type'=>'VARCHAR','constraint'=>'20','comment'=>'路径','comment'=>'','null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'f_v_id', 
  ),  
  'fields_index'=>array(),
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
