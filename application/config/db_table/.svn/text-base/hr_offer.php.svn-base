<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['hr_offer'] = array( 
  'table_name_show'=>'员工录用', 
  'table_note'=>'', 
  'fields'=>array( 
    'offer_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'主键',), 
    'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
    'offer_code'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'单据编号','null'=>TRUE,), 
    'offer_time_report'=> array('type'=>'DATE','constraint'=>'','comment'=>'报到时间','null'=>TRUE,), 
	'c_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'关联联系人','null'=>TRUE,), 
    'offer_type_work'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'用工形式','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'offer_office'=> array('type'=>'TINYINT','constraint'=>'11','comment'=>'信息系统','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'offer_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'备注','null'=>TRUE,), 
	'ppo'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'节点','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'offer_id', 
  ),  
  'fields_index'=>array(),
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
