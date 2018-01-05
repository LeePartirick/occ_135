<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['fm_bill_detail_item'] = array( 
  'table_name_show'=>'开票批准发票条目表', 
  'table_note'=>'', 
  'fields'=>array( 
    'bdi_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'',), 
	'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 

	'bdi_invoice_code'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'发票号码','null'=>TRUE,), 
	'bdi_invoice_sum'=> array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'发票金额','default'=>'0.00','null'=>TRUE,),
 
	'bdi_time_kp'=> array('type'=>'DATE','constraint'=>'','comment'=>'发票开票时间','null'=>TRUE,),

    'bill_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'开票','null'=>TRUE,), 

  ),  
  'primary_key'=>array( 
    'bdi_id', 
  ),  
  'fields_index'=>array(
  ), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
