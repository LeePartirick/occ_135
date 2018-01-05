<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['hr_tec'] = array( 
  'table_name_show'=>'员工技术方向', 
  'table_note'=>'', 
  'table_code'=>'', 
  'fields'=>array( 
    'tec_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'主键',), 
    'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>'1',), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'创建时间','null'=>'1',), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>'1',), 
    'tec_name'=> array('type'=>'VARCHAR','constraint'=>'80','comment'=>'技术方向','null'=>'1','field_proc'=>'true',), 
    'tec_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'描述','null'=>'1','field_proc'=>'true',), 
  ),  
  'primary_key'=>array( 
    'tec_id', 
  ),  
  'fields_add'=>array(), 
  'fields_index'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
