<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['sys_proc'] = array( 
  'table_name_show'=>'流程列表', 
  'table_note'=>'', 
  'fields'=>array( 
    'p_id'=> array('type'=>'VARCHAR','constraint'=>'40',), 
    'p_name'=> array('type'=>'VARCHAR','constraint'=>'80','comment'=>'流程名称','null'=>TRUE,), 
    'p_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'流程描述','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'创建时间','null'=>TRUE,), 
    'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'p_status_run'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'流程启用状态','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'p_class'=> array('type'=>'TEXT','constraint'=>'40','comment'=>'类型','null'=>TRUE,), 
    'p_url'=> array('type'=>'TEXT','constraint'=>'','comment'=>'url','null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'p_id', 
  ),  
  'fields_index'=>array(),
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
