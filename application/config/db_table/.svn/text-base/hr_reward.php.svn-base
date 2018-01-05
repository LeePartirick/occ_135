<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['hr_reward'] = array( 
  'table_name_show'=>'奖惩记录', 
  'table_note'=>'', 
  'fields'=>array( 
    'hr_rp_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'主键',), 
    'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
    'hr_rp_date'=> array('type'=>'DATE','constraint'=>'','comment'=>'开始时间','null'=>TRUE,), 
    'hr_rp_type'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'类别','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'hr_rp_content'=> array('type'=>'TEXT','constraint'=>'','comment'=>'内容','null'=>TRUE,), 
    'hr_rp_ou_approve'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'批准部门','null'=>TRUE,), 
    'hr_rp_person_approve'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'批准人','null'=>TRUE,), 
    'hr_rp_doc_code'=> array('type'=>'VARCHAR','constraint'=>'100','comment'=>'文件号','null'=>TRUE,), 
    'c_id'=> array('type'=>'VARCHAR','constraint'=>'40','null'=>TRUE,), 
    'hr_rp_cause'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'原因','null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'hr_rp_id', 
  ),  
  'fields_index'=>array(), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
