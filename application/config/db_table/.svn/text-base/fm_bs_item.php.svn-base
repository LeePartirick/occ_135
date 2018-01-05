<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['fm_bs_item'] = array( 
  'table_name_show'=>'回款明细', 
  'table_note'=>'', 
  'fields'=>array( 
    'bsi_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'',), 
	'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
	'ppo'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'节点','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,),
 
	'bsi_sum'=> array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'回款金额','default'=>'0.00','null'=>TRUE,), 
	'bsi_type'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'关联类型','UNSIGNED'=>TRUE,'null'=>TRUE,),
	'bsi_link_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'关联单据','null'=>TRUE,), 
	'bsi_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'备注','null'=>TRUE,), 

	'bs_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'回款','null'=>TRUE,), 
	'bsi_gfc_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'财务编号','null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'bsi_id', 
  ),  
  'fields_index'=>array(
  ), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
