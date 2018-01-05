<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['sys_file'] = array( 
  'table_name_show'=>'文件表', 
  'table_note'=>'', 
  'fields'=>array( 
  	'f_id'=> array('type'=>'VARCHAR','constraint'=>'40',), 
	'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
	'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,), 
	'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,),      
	'f_name'=> array('type'=>'VARCHAR','constraint'=>'250','comment'=>'文件名称','null'=>TRUE,), 
    'f_v_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'文件版本','null'=>TRUE,), 
    'f_size'=> array('type'=>'INT','constraint'=>'11','comment'=>'文件大小','default'=>'0','null'=>TRUE,), 
    'f_v_sn'=> array('type'=>'INT','constraint'=>'11','comment'=>'文件版本号','default'=>'1','null'=>TRUE,), 
    'f_secrecy'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'密级','UNSIGNED'=>TRUE,'null'=>TRUE,), 
	'f_link_noedit'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'关联文件禁止删除','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'f_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'备注','null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'f_id', 
  ),  
  'fields_index'=>array(), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
