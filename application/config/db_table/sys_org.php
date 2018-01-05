<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['sys_org'] = array( 
  'table_name_show'=>'机构表', 
  'table_note'=>'', 
  'fields'=>array( 
    'o_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'主键',), 
    'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
    'o_code'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'机构编号','null'=>TRUE,), 
    'o_name'=> array('type'=>'VARCHAR','constraint'=>'250','comment'=>'机构名称','null'=>TRUE,), 
    'o_type'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'机构类型','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'o_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'备注','null'=>TRUE,), 
    'o_id_standard'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'标准名称','null'=>TRUE,), 
	'o_status'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'状态','UNSIGNED'=>TRUE,'null'=>TRUE,),
	'o_code_register'=> array('type'=>'VARCHAR','constraint'=>'80','comment'=>'组织机构代码/统一社会信用代码','null'=>TRUE,),
	'o_tag'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'机构标签','UNSIGNED'=>TRUE,'null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'o_id', 
  ),  
  'fields_index'=>array(),
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
