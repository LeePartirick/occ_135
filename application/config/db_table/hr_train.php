<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['hr_train'] = array( 
  'table_name_show'=>'培训记录', 
  'table_note'=>'', 
  'fields'=>array( 
    'hr_t_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'主键',), 
    'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
    'hr_t_time_start'=> array('type'=>'DATE','constraint'=>'','comment'=>'起始时间','null'=>TRUE,), 
    'hr_t_time_end'=> array('type'=>'DATE','constraint'=>'','comment'=>'截止时间','null'=>TRUE,), 
    'hr_t_name'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'培训名称','null'=>TRUE,), 
    'hr_t_ca_name'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'证书名称','null'=>TRUE,), 
    'hr_t_org'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'培训单位','null'=>TRUE,), 
    'hr_t_time_ca_end'=> array('type'=>'DATE','constraint'=>'','comment'=>'证书截止时间','null'=>TRUE,), 
    'hr_t_type_last'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'是否续证','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'hr_t_person'=> array('type'=>'VARCHAR','constraint'=>'100','comment'=>'证明人','null'=>TRUE,), 
    'hr_t_person_tel'=> array('type'=>'VARCHAR','constraint'=>'100','comment'=>'联系方式','null'=>TRUE,), 
    'hr_t_expense'=> array('type'=>'DECIMAL','constraint'=>'11,2','comment'=>'培训费用','default'=>'0','null'=>TRUE,), 
    'hr_t_date_work'=> array('type'=>'DATE','constraint'=>'','comment'=>'服务期期限','null'=>TRUE,), 
    'hr_t_type'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'培训类型','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'c_id'=> array('type'=>'VARCHAR','constraint'=>'40','null'=>TRUE,), 
	'hr_t_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'备注','null'=>TRUE,), 
    'hr_t_act'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'动作类型','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'hr_t_flag_check'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'审批标记','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'hr_t_id', 
  ),  
  'fields_index'=>array(), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
