<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['fm_invoice_type'] = array( 
  'table_name_show'=>'发票类型', 
  'table_note'=>'', 
  'fields'=>array( 
    'it_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'',), 
	'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
    'it_name'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'发票类型','null'=>TRUE,), 
    'it_taking_count'=> array('type'=>'TEXT','constraint'=>'','comment'=>'营业收入计算公式','null'=>TRUE,), 
	'it_tax_count'=> array('type'=>'TEXT','constraint'=>'','comment'=>'流转税计算公式','null'=>TRUE,), 
	'it_no_new'=> array('type'=>'TINYINT','constraint'=>'3','default'=>'0','comment'=>'不可新建','UNSIGNED'=>TRUE,'null'=>TRUE,),
	'it_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'备注','null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'it_id', 
  ),  
  'fields_index'=>array(
  ), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
