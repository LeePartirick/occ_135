<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['im_msg'] = array( 
  'table_name_show'=>'im消息', 
  'table_note'=>'', 
  'type'=>'merge',
  'fields'=>array( 
    'msg_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'主键',), 
    'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
    'msg_content'=> array('type'=>'LONGTEXT','constraint'=>'','comment'=>'内容','null'=>TRUE,), 
    'im_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'归属对话','null'=>TRUE,), 
    'msg_type'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'消息类型','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'msg_id', 
  ),  
  'fields_index'=>array(
  ), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
