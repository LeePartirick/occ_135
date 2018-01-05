<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['hr_dim'] = array( 
  'table_show'=>'员工离职', 
  'table_note'=>'', 
  'fields'=>array( 
    'dim_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'主键',), 
    'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
    'ppo'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'节点','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,),
	'dim_code'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'单据编号','null'=>TRUE,),
    'c_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'离职人员','null'=>TRUE,), 
    'dim_date'=> array('type'=>'DATE','constraint'=>'','comment'=>'离职日期','null'=>TRUE,), 
    'dim_cause'=> array('type'=>'TEXT','constraint'=>'','comment'=>'离职原因','null'=>TRUE,), 
    'dim_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'备注','null'=>TRUE,), 
	'dim_hr_type'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'离职后人员类型','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'dim_file'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'离职文件','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'dim_file_sm'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'离职文件-涉密人员','UNSIGNED'=>TRUE,'null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'dim_id', 
  ),  
  'fields_index'=>array(), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
