<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['fm_bill_eqi'] = array( 
  'table_name_show'=>'开票申请明细条目表', 
  'table_note'=>'', 
  'fields'=>array( 
    'bei_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'',), 
	'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 

	'bei_name'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'货物名称','null'=>TRUE,), 
	'bei_model'=> array('type'=>'TEXT','constraint'=>'','comment'=>'货物规格','null'=>TRUE,), 

	'bei_number'=> array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'货物数量','default'=>'0.00','null'=>TRUE,), 
	'bei_unit_price'=> array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'货物单价','default'=>'0.00','null'=>TRUE,), 
	'bei_sum'=> array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'价税合计','default'=>'0.00','null'=>TRUE,), 

    'bill_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'开票','null'=>TRUE,), 

  ),  
  'primary_key'=>array( 
    'bei_id', 
  ),  
  'fields_index'=>array(
  ), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
