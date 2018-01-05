<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['hr_family_crime'] = array( 
  'table_name_show'=>'家庭成员犯罪记录', 
  'table_note'=>'', 
  'fields'=>array( 
    'hr_fc_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'主键',), 
    'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
    'hr_fc_description'=> array('type'=>'TEXT','constraint'=>'','comment'=>'描述','null'=>TRUE,), 
    'c_id'=> array('type'=>'VARCHAR','constraint'=>'40','null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'hr_fc_id', 
  ),  
  'fields_index'=>array(), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
