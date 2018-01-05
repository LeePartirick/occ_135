<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['sys_log_operate'] = array( 
  'table_name_show'=>'操作日志', 
  'table_note'=>'', 
  'type'=>'merge',
  'fields'=>array( 
    'log_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'',), 
    'op_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'','null'=>TRUE,), 
    'log_time'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'','null'=>TRUE,), 
    'c_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'','null'=>TRUE,), 
	'c_name'=> array('type'=>'VARCHAR','constraint'=>'80','comment'=>'','null'=>TRUE,), 
    'log_act'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'log_note'=> array('type'=>'TEXT','constraint'=>'','null'=>TRUE,), 
    'log_client_ip'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'','null'=>TRUE,), 
    'log_user_agent'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'','null'=>TRUE,), 
    'a_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'','null'=>TRUE,), 
	'a_login_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'','null'=>TRUE,), 
    'log_url'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'','null'=>TRUE,), 
    'log_module'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'','null'=>TRUE,), 
    'log_content'=> array('type'=>'TEXT','constraint'=>'','comment'=>'','null'=>TRUE,), 
    'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'','null'=>TRUE,), 
    'log_p_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'','null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'log_id', 
  ),  
  'fields_index'=>array(
  	'op_id',
  	'log_time',
  	'c_id',
  	'c_name',
  	'a_id',
  	'a_login_id',
  	'log_act',
  	'log_p_id',
  ),
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
