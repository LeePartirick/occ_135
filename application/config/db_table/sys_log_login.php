<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['sys_log_login'] = array( 
  'table_name_show'=>'登陆日志', 
  'table_note'=>'', 
  'type'=>'merge',
  'fields'=>array( 
    'log_id'=> array('type'=>'VARCHAR','constraint'=>'40',), 
    'log_time'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'登陆时间','null'=>TRUE,), 
    'a_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'','null'=>TRUE,), 
    'a_login_id'=> array('type'=>'VARCHAR','constraint'=>'80','comment'=>'登陆账号','null'=>TRUE,), 
    'c_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'登陆人','null'=>TRUE,), 
    'c_name'=> array('type'=>'VARCHAR','constraint'=>'80','comment'=>'姓名','null'=>TRUE,), 
    'log_result'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'结果','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'log_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'备注','null'=>TRUE,), 
    'log_client_ip'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'ip地址','null'=>TRUE,), 
    'log_user_agent'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'客户端','null'=>TRUE,), 
    'log_ua_type'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'客户端类型','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'log_ua_name'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'客户端名称','null'=>TRUE,), 
    'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'更新时间','null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'log_id', 
  ),  
  'fields_index'=>array(),
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
