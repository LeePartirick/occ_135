<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['fm_bud_main'] = array( 
  'table_name_show'=>'预算表模型', 
  'table_note'=>'', 
  'fields'=>array( 
    'budm_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'',), 
	'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 

    'budm_name'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'名称','null'=>TRUE,), 
    'budm_code'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'编号','null'=>TRUE,), 
	'budm_type'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'类型','UNSIGNED'=>TRUE,'null'=>TRUE,),
    'budm_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'备注','null'=>TRUE,), 
	'budm_css'=> array('type'=>'text','comment'=>'CSS','null'=>TRUE,), 
	'budm_count'=> array('type'=>'text','comment'=>'计算公式','null'=>TRUE,), 
//	'budm_tax_type'=> array('type'=>'text','comment'=>'税种','null'=>TRUE,),
  ),  
  'primary_key'=>array( 
    'budm_id', 
  ),  
  'fields_index'=>array(
  ), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
