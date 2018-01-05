<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['sys_file_type'] = array( 
  'table_name_show'=>'文件属性', 
  'table_note'=>'', 
  'table_code'=>'', 
  'fields'=>array( 
    'f_t_id'=> array('type'=>'VARCHAR','constraint'=>'40',), 
	'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
	'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,), 
	'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,),  
    'f_t_name'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'属性名称','null'=>TRUE,), 
    'f_t_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'属性备注','null'=>TRUE,), 
	'f_t_unique'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'关联文件唯一','default'=>'0','null'=>TRUE,), 
	'f_t_check'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'相关验证','null'=>TRUE,), 
    'f_t_parent'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'上级属性','null'=>TRUE,), 
    'f_t_parent_path'=> array('type'=>'TEXT','constraint'=>'','comment'=>'上级属性路径','null'=>TRUE,), 
	'f_t_sn'=> array('type'=>'INT','constraint'=>'11','comment'=>'排序','default'=>'0','null'=>TRUE,),
  ),  
  'primary_key'=>array( 
    'f_t_id', 
  ),  
  'fields_index'=>array(), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
