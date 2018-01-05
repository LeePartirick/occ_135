<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['sys_org_addr'] = array( 
  'table_name_show'=>'机构地址表', 
  'table_note'=>'', 
  'fields'=>array( 
    'o_addr_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'主键',), 
    'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
    'o_addr_content'=> array('type'=>'TEXT','constraint'=>'','comment'=>'地理信息','null'=>TRUE,), 
    'o_addr_cross'=> array('type'=>'TEXT','constraint'=>'','comment'=>'交叉路口','null'=>TRUE,), 
    'o_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'关联机构','null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'o_addr_id', 
  ),  
  'fields_index'=>array(),
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
