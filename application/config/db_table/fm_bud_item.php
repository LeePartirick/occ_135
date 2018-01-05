<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['fm_bud_item'] = array( 
  'table_name_show'=>'预算表模型明细', 
  'table_note'=>'', 
  'fields'=>array( 
    'budi_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'',), 
	'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 

	'budi_ou'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'部门ID','null'=>TRUE,), 
	'budi_ou_show'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'部门','null'=>TRUE,), 
    'budi_sn'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'行次','null'=>TRUE,), 
	'budi_sub'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'预算科目','null'=>TRUE,), 
	'budi_name'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'核算内容','null'=>TRUE,), 
	'budi_rate'=> array('type'=>'DECIMAL','constraint'=>'11,2','comment'=>'税率','null'=>TRUE,), 
    'budi_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'备注','null'=>TRUE,), 
	'budi_css'=> array('type'=>'TEXT','comment'=>'CSS','null'=>TRUE,), 
	'budi_css_notax'=> array('type'=>'TEXT','comment'=>'不含税CSS','null'=>TRUE,), 
	'budi_link'=> array('type'=>'text','comment'=>'链接','null'=>TRUE,), 
	'budi_sum_edit'=> array('type'=>'TINYINT','constraint'=>'3','default'=>'1','comment'=>'金额可编辑','UNSIGNED'=>TRUE,'null'=>TRUE,),
	'budi_sub_check'=> array('type'=>'TINYINT','constraint'=>'3','default'=>'1','comment'=>'科目可选','UNSIGNED'=>TRUE,'null'=>TRUE,),
	'budi_sum_notax_empty'=> array('type'=>'TINYINT','constraint'=>'3','default'=>'1','comment'=>'无不含税金额','UNSIGNED'=>TRUE,'null'=>TRUE,),
	'budm_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'预算表ID',), 
  ),  
  'primary_key'=>array( 
    'budi_id', 
  ),  
  'fields_index'=>array(
  ), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
