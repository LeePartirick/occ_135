<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['hr_work'] = array( 
  'table_name_show'=>'工作经历', 
  'table_note'=>'', 
  'fields'=>array( 
    'hr_w_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'主键',), 
    'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
    'hr_w_time_start'=> array('type'=>'DATE','constraint'=>'','comment'=>'起始时间','null'=>TRUE,), 
    'hr_w_time_end'=> array('type'=>'DATE','constraint'=>'','comment'=>'截止时间','null'=>TRUE,), 
    'hr_w_type'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'工作性质','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'hr_w_org'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'工作单位','null'=>TRUE,), 
    'hr_w_job'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'职务','null'=>TRUE,), 
    'hr_w_salary'=> array('type'=>'DECIMAL','constraint'=>'11,2','comment'=>'税前收入','default'=>'0','null'=>TRUE,), 
    'hr_w_lz_cause'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'离职原因','null'=>TRUE,), 
    'hr_w_person'=> array('type'=>'VARCHAR','constraint'=>'100','comment'=>'证明人','null'=>TRUE,), 
    'hr_w_person_tel'=> array('type'=>'VARCHAR','constraint'=>'100','comment'=>'联系方式','null'=>TRUE,), 
    'c_id'=> array('type'=>'VARCHAR','constraint'=>'40','null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'hr_w_id', 
  ),  
  'fields_index'=>array(),
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
