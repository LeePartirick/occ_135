<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['fm_gfc_bud'] = array( 
  'table_name_show'=>'项目预算表', 
  'table_note'=>'', 
  'fields'=>array( 
    'gbud_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'',), 
    'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
	'gfc_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'所属项目','null'=>TRUE,),
	'gbud_budi_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'预算表模型明细ID','null'=>TRUE,), 
	'gbud_sub'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'预算科目','null'=>TRUE,),
//	'gbud_name'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'核算内容','null'=>TRUE,),
	'gbud_sum_tender'=> array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'标前预算','default'=>'0.00','null'=>TRUE,), 
	'gbud_sum_start'=> array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'初始预算额','default'=>'0.00','null'=>TRUE,), 
	'gbud_sum'=> array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'预算额','default'=>'0.00','null'=>TRUE,), 
	'gbud_sum_final'=> array('type'=>'DECIMAL','constraint'=>'15,2','default'=>'0.00','comment'=>'预算执行','null'=>TRUE,), 
	'gbud_count_update'=> array('type'=>'TINYINT','constraint'=>'3','default'=>'1','comment'=>'公式更新','UNSIGNED'=>TRUE,'null'=>TRUE,),
  ),  
  'primary_key'=>array( 
    'gbud_id', 
  ),  
  'fields_index'=>array(
  ), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
