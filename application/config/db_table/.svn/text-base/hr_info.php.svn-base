<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['hr_info'] = array( 
  'table_name_show'=>'员工信息', 
  'table_note'=>'', 
  'fields'=>array( 
    'c_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'主键',), 
    'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
	'hr_code_pre'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'前缀','null'=>TRUE,), 
    'hr_code'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'工号','null'=>TRUE,), 

	'hr_time_rz'=> array('type'=>'DATE','constraint'=>'','comment'=>'入职时间','null'=>TRUE,), 
    'hr_offer'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'是否推荐','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'hr_work_place'=> array('type'=>'VARCHAR','constraint'=>'100','comment'=>'工作地点','null'=>TRUE,), 
    'hr_gqjl'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'股权激励','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'hr_shbx'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'社会保险','UNSIGNED'=>TRUE,'null'=>TRUE,),
	'hr_vacation'=> array('type'=>'INT','constraint'=>'3','comment'=>'带薪年假','UNSIGNED'=>TRUE,'null'=>TRUE,'default'=>'0',), 
    'hr_zcdj'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'职称等级','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'hr_zclb'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'职称类别','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'hr_zw_1'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'职务大类','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'hr_zw_2'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'职务中类','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'hr_zw_3'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'职务小类','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'hr_zwcw'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'职务称谓','null'=>TRUE,), 

	'hr_type_work'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'用工形式','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'hr_type'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'人员类别','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'hr_wage'=> array('type'=>'INT','constraint'=>'11','comment'=>'累积工龄','null'=>TRUE,'default'=>'0',), 
    'hr_wage_set'=> array('type'=>'INT','constraint'=>'11','comment'=>'本单位工龄调整值','null'=>TRUE,'default'=>'0',), 
    
    'hr_time_zz'=> array('type'=>'DATE','constraint'=>'','comment'=>'转正时间','null'=>TRUE,), 
    'hr_time_lz'=> array('type'=>'DATE','constraint'=>'','comment'=>'离职时间','null'=>TRUE,), 
    'hr_time_ht'=> array('type'=>'DATE','constraint'=>'','comment'=>'合同签订','null'=>TRUE,), 
    'hr_time_htdq'=> array('type'=>'DATE','constraint'=>'','comment'=>'合同到期','null'=>TRUE,), 
    'hr_ht_year'=> array('type'=>'DECIMAL','constraint'=>'11,2','comment'=>'合同年限','null'=>TRUE,), 
    'hr_num_xq'=> array('type'=>'INT','constraint'=>'11','comment'=>'续签次数','null'=>TRUE,), 

    'hr_info_finish'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'人事信息补全','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'hr_check'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'人事信息审批','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'hr_data_start'=> array('type'=>'LONGTEXT','constraint'=>'','comment'=>'变更前数据','null'=>TRUE,), 
    'hr_dim_porc'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'离职流程启用标记','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,),

  ),  
  'primary_key'=>array( 
    'c_id', 
  ),  
  'fields_index'=>array(),
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
