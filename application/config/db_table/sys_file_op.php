<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['sys_file_op'] = array( 
  'table_name_show'=>'文档云-对象', 
  'table_note'=>'', 
  'fields'=>array( 
	'file_op_id'=> array('type'=>'VARCHAR','constraint'=>'40',), 
	'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
	'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,), 
	'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,),  
    'file_op_type'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'类型','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'file_op_name'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'名称','null'=>TRUE,), 
    'file_op_parent'=> array('type'=>'VARCHAR','constraint'=>'80','comment'=>'上级目录','null'=>TRUE,), 
    'file_op_parent_path'=> array('type'=>'TEXT','constraint'=>'','null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'file_op_id', 
  ),  
  'fields_index'=>array(), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
