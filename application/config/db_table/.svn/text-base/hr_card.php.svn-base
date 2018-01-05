<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['hr_card'] = array( 
  'table_name_show'=>'卡帐', 
  'table_note'=>'', 
  'fields'=>array( 
    'hr_card_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'主键',), 
    'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
    'hr_card_type'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'类型','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'hr_card_code'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'卡号','null'=>TRUE,), 
    'hr_card_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'备注','null'=>TRUE,), 
    'c_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'所属人','null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'hr_card_id', 
  ),  
  'fields_index'=>array(),
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
