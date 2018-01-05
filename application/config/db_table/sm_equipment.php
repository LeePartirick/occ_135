<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['sm_equipment'] = array( 
  'table_name_show'=>'设备', 
  'table_note'=>'', 
  'fields'=>array( 
    'eq_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'主键',), 
    'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
    'eq_name'=> array('type'=>'VARCHAR','constraint'=>'250','comment'=>'设备名称','null'=>TRUE,), 
    'eq_brand'=> array('type'=>'VARCHAR','constraint'=>'250','comment'=>'设备品牌','null'=>TRUE,), 
    'eq_model'=> array('type'=>'VARCHAR','constraint'=>'250','comment'=>'设备型号','null'=>TRUE,), 
    'eq_type'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'设备类型','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'eq_sort'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'设备类别','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'eq_unit'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'单位','null'=>TRUE,), 
    'eq_description'=> array('type'=>'TEXT','constraint'=>'','comment'=>'详细描述','null'=>TRUE,), 
    'eq_parameter'=> array('type'=>'TEXT','constraint'=>'','comment'=>'设备参数','null'=>TRUE,), 
    'eq_maintenance'=> array('type'=>'INT','constraint'=>'11','comment'=>'保修期-月','null'=>TRUE,), 
    'eq_price'=> array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'参考单价','default'=>'0','null'=>TRUE,), 
    'eq_org'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'供应商名称','null'=>TRUE,), 
    'eq_partnership'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'合作关系','UNSIGNED'=>TRUE,'null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'eq_id', 
  ),  
  'fields_index'=>array(), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
