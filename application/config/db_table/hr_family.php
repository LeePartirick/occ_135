<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['hr_family'] = array( 
  'table_name_show'=>'员工家庭信息', 
  'table_note'=>'', 
  'fields'=>array( 
    'hr_f_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'主键',), 
    'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
    'hr_f_person'=> array('type'=>'VARCHAR','constraint'=>'80','comment'=>'姓名','null'=>TRUE,), 
    'hr_f_relation'=> array('type'=>'VARCHAR','constraint'=>'80','comment'=>'关系','null'=>TRUE,), 
    'hr_f_birthday'=> array('type'=>'DATE','constraint'=>'','comment'=>'生日','null'=>TRUE,), 
    'hr_f_city'=> array('type'=>'VARCHAR','constraint'=>'80','comment'=>'居住城市','null'=>TRUE,), 
    'hr_f_nationality'=> array('type'=>'VARCHAR','constraint'=>'100','comment'=>'国籍','null'=>TRUE,), 
    'hr_f_org'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'工作单位','null'=>TRUE,), 
    'hr_f_job'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'职位','null'=>TRUE,), 
    'hr_f_tel'=> array('type'=>'VARCHAR','constraint'=>'100','comment'=>'联系方式','null'=>TRUE,), 
    'c_id'=> array('type'=>'VARCHAR','constraint'=>'40','null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'hr_f_id', 
  ),  
  'fields_index'=>array(), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
