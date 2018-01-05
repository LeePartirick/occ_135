<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['oa_office'] = array( 
  'table_name_show'=>'信息系统', 
  'table_note'=>'', 
  'fields'=>array( 
    'offi_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'',), 
	'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
    'offi_name'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'系统名称','null'=>TRUE,), 
    'offi_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'备注','null'=>TRUE,), 
    'offi_status_run'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'是否启用','UNSIGNED'=>TRUE,'null'=>TRUE,),
	'offi_org'=> array('type'=>'TEXT','constraint'=>'','comment'=>'使用机构','null'=>TRUE,), 
	'offi_org_default'=> array('type'=>'TEXT','constraint'=>'','comment'=>'默认开启','null'=>TRUE,),
  ),  
  'primary_key'=>array( 
    'offi_id', 
  ),  
  'fields_index'=>array(
  ), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
