<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['hr_contract'] = array( 
  'table_name_show'=>'合同', 
  'table_note'=>'', 
  'fields'=>array( 
    'cont_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'主键',), 
    'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
    'c_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'关联员工','null'=>TRUE,), 
    'cont_time_start'=> array('type'=>'DATE','constraint'=>'','comment'=>'合同签订时间','null'=>TRUE,), 
    'cont_time_end'=> array('type'=>'DATE','constraint'=>'','comment'=>'合同到期时间','null'=>TRUE,), 
    'cont_year'=> array('type'=>'INT','constraint'=>'11','comment'=>'合同年限','null'=>TRUE,), 
    'cont_hr_type'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'人员类别','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'cont_hr_type_work'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'用工形式','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'cont_type'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'合同性质','UNSIGNED'=>TRUE,'null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'cont_id', 
  ),  
  'fields_index'=>array(), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
