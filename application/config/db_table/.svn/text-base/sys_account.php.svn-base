<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['sys_account'] = array( 
  'table_name_show'=>'账户表', 
  'table_note'=>'', 
  'fields'=>array( 
    'a_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'',), 
    'a_login_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'账号','null'=>TRUE,), 
    'a_name'=> array('type'=>'VARCHAR','constraint'=>'80','comment'=>'显示名称','null'=>TRUE,), 
    'a_password'=> array('type'=>'VARCHAR','constraint'=>'80','comment'=>'密码','null'=>TRUE,), 
	'a_pwd_start'=> array('type'=>'VARCHAR','constraint'=>'80','comment'=>'初始密码','null'=>TRUE,), 
    'a_status'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'状态','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'a_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'备注','null'=>TRUE,), 
    'a_login_type'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'登陆验证类型','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'a_id', 
  ),  
  'fields_index'=>array(
  ), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
