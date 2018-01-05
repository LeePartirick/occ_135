<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['hr_family_card'] = array( 
  'table_name_show'=>'家庭成员证件信息', 
  'table_note'=>'', 
  'fields'=>array( 
    'hr_fcard_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'主键',), 
    'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
    'hr_fcard_type'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'证件类型','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'hr_fcard_name'=> array('type'=>'VARCHAR','constraint'=>'80','comment'=>'证件名称','null'=>TRUE,), 
    'hr_fcard_code'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'证件号码','null'=>TRUE,), 
    'c_id'=> array('type'=>'VARCHAR','constraint'=>'40','null'=>TRUE,), 
    'hr_fcard_person'=> array('type'=>'VARCHAR','constraint'=>'80','comment'=>'所有人','null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'hr_fcard_id', 
  ),  
  'fields_index'=>array(),
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
