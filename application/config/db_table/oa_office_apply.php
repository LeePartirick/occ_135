<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['oa_office_apply'] = array( 
  'table_name_show'=>'信息系统申请', 
  'table_note'=>'', 
  'fields'=>array( 
    'offa_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'',), 
	'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
    'offa_code'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'单据编号','null'=>TRUE,), 
	'offa_c_apply'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'申请人','null'=>TRUE,), 
	'offa_c_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'系统所有人','null'=>TRUE,), 
    'offa_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'备注','null'=>TRUE,), 
	'ppo'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'流程节点','UNSIGNED'=>TRUE,'null'=>TRUE,),
	'offa_offer_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'关联录用通知','null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'offa_id', 
  ),  
  'fields_index'=>array(
  ), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
