<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['fm_subject'] = array( 
  'table_name_show'=>'预算科目', 
  'table_note'=>'', 
  'fields'=>array( 
    'sub_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'',), 
    'sub_name'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'科目名称','null'=>TRUE,), 
    'sub_code'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'科目编号','null'=>TRUE,), 
    'sub_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'备注','null'=>TRUE,), 
    'sub_class'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'科目分类','UNSIGNED'=>TRUE,'null'=>TRUE,), 
	'sub_type'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'科目属性','UNSIGNED'=>TRUE,'null'=>TRUE,), 
	'sub_parent'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'上级科目','null'=>TRUE,), 
	'sub_parent_path'=> array('type'=>'TEXT','constraint'=>'','comment'=>'上级科目路径','null'=>TRUE,), 
	'sub_tag'=> array('type'=>'TEXT','constraint'=>'','comment'=>'标签','null'=>TRUE,), 
    'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'sub_id', 
  ),  
  'fields_index'=>array(
  ), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
