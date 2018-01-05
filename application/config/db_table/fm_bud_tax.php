<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['fm_bud_tax'] = array( 
  'table_name_show'=>'预算表流转税', 
  'table_note'=>'', 
  'fields'=>array( 
    'tax_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'',), 
	'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
	'tax_sn'=> array('type'=>'TINYINT','constraint'=>'3','default'=>'0','comment'=>'排序','UNSIGNED'=>TRUE,'null'=>TRUE,),
	'tax_no_new'=> array('type'=>'TINYINT','constraint'=>'3','default'=>'0','comment'=>'不可新建','UNSIGNED'=>TRUE,'null'=>TRUE,),
	't_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'流转税','null'=>TRUE,), 
	'tax_rate'=> array('type'=>'TINYINT','constraint'=>'3','default'=>'0','comment'=>'税率','UNSIGNED'=>TRUE,'null'=>TRUE,),
	'budm_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'预算主表','null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'tax_id', 
  ),  
  'fields_index'=>array(
  ), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
