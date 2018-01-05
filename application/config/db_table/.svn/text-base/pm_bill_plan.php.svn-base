<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['pm_bill_plan'] = array( 
  'table_name_show'=>'开票回款计划', 
  'table_note'=>'', 
  'fields'=>array( 
    'bp_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'',), 
	'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 

	'bp_time'=> array('type'=>'DATE','constraint'=>'','comment'=>'预计开票时间','null'=>TRUE,),
	'bp_time_back'=> array('type'=>'DATE','constraint'=>'','comment'=>'预计回款时间','null'=>TRUE,),
	'bp_type'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'货款性质','null'=>TRUE,),
	'bp_sum'=> array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'金额','default'=>'0.00','null'=>TRUE,), 
	'bp_sum_kp'=> array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'已开票金额','default'=>'0.00','null'=>TRUE,), 
	'bp_sum_hk'=> array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'已回款金额','default'=>'0.00','null'=>TRUE,), 
    'gfc_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'财务编号','null'=>TRUE,), 

    'bp_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'备注','null'=>TRUE,), 

  ),  
  'primary_key'=>array( 
    'bp_id', 
  ),  
  'fields_index'=>array(
  ), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
