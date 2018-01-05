<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['sys_ou'] = array( 
  'table_name_show'=>'部门团队表', 
  'table_note'=>'', 
  'fields'=>array( 
    'ou_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'主键',), 
    'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
    'ou_name'=> array('type'=>'VARCHAR','constraint'=>'80','comment'=>'团队名称','null'=>TRUE,), 
    'ou_level'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'组织架构','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'ou_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'团队备注','null'=>TRUE,), 
    'ou_code'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'团队编号','null'=>TRUE,), 
    'ou_parent'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'上级团队','null'=>TRUE,), 
    'ou_parent_path'=> array('type'=>'TEXT','constraint'=>'','comment'=>'上级团队路径','null'=>TRUE,), 
    'ou_tag'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'标签','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'ou_class'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'团队分类','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'ou_status'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'状态','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'ou_org'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'所属机构','null'=>TRUE,), 
	'ou_tel'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'电话','null'=>TRUE,), 
	'ou_fax'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'传真','null'=>TRUE,), 
	'ou_addr'=> array('type'=>'VARCHAR','constraint'=>'250','comment'=>'坐标','null'=>TRUE,), 
	'ou_org_pre'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'单据前缀','null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'ou_id', 
  ),  
  'fields_index'=>array(),
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
