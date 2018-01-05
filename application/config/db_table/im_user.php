<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['im_user'] = array( 
  'table_name_show'=>'IM组用户表', 
  'table_note'=>'', 
  'table_code'=>'null', 
  'fields'=>array( 
    'imu_id'=> array('type'=>'VARCHAR','constraint'=>'40','display'=>'主键',), 
    'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
    'im_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'对话组','null'=>TRUE,), 
    'c_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'组成员','null'=>TRUE,), 
    'imu_type'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'成员类型','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'im_time_read'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'组对话读取时间','null'=>TRUE,), 
    'im_time_attend'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'加入组时间','null'=>TRUE,), 
    'im_time_read_can'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'可读消息时间','null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'imu_id', 
  ),  
  'fields_index'=>array(
  ), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
