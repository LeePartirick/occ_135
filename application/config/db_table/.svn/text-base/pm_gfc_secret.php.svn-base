<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['pm_gfc_secret'] = array( 
  'table_name_show'=>'项目标密申请单', 
  'table_note'=>'', 
  'fields'=>array( 
    'gfcs_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'',), 
	'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
	'ppo'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'节点','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    
	'gfcs_code'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'单据编号','null'=>TRUE,), 
	'gfcs_category_secret'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'设备清单版本','null'=>TRUE,),
	'gfcs_name_tm'=> array('type'=>'VARCHAR','constraint'=>'250','comment'=>'脱密后项目全称','null'=>TRUE,), 
	'gfcs_c_check'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'审批人','null'=>TRUE,), 
	'gfcs_c'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'申请人','null'=>TRUE,), 
	'gfcs_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'备注','null'=>TRUE,), 
	'gfc_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'','null'=>TRUE,), 

  ),  
  'primary_key'=>array( 
    'gfcs_id', 
  ),  
  'fields_index'=>array(
  ), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);
