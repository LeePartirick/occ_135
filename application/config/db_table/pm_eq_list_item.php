<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['pm_eq_list_item'] = array( 
  'table_name_show'=>'项目设备清单明细', 
  'table_note'=>'', 
  'fields'=>array( 
    'eli_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'',), 
	'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 

	'eli_eq_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'设备id','null'=>TRUE,), 
	'eli_name'=> array('type'=>'VARCHAR','constraint'=>'250','comment'=>'设备名称','null'=>TRUE,), 
    'eli_brand'=> array('type'=>'VARCHAR','constraint'=>'250','comment'=>'设备品牌','null'=>TRUE,), 
    'eli_model'=> array('type'=>'VARCHAR','constraint'=>'250','comment'=>'设备型号','null'=>TRUE,), 
	'eli_unit'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'单位','null'=>TRUE,), 
	'eli_description'=> array('type'=>'TEXT','constraint'=>'','comment'=>'详细描述','null'=>TRUE,), 
    'eli_parameter'=> array('type'=>'TEXT','constraint'=>'','comment'=>'设备参数','null'=>TRUE,), 
	'eli_maintenance'=> array('type'=>'INT','constraint'=>'11','comment'=>'保修期-月/服务期-月','null'=>TRUE,), 
	'eli_maintenance_start'=> array('type'=>'DATE','constraint'=>'','comment'=>'服务起始时间','null'=>TRUE,), 
	'eli_supply_org' => array('type'=>'VARCHAR','constraint'=>'40','comment'=>'供应商/分包商','null'=>TRUE,), 
	'eli_supply_org_s' => array('type'=>'VARCHAR','constraint'=>'40','comment'=>'供应商/分包商','null'=>TRUE,), 

	'eli_sum'=> array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'采购单价','null'=>TRUE,), 
	'eli_sum_total'=> array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'单位成本','null'=>TRUE,),
	'eli_sum_total_have'=> array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'已采购单位成本','null'=>TRUE,),
	'eli_count'=> array('type'=>'INT','constraint'=>'14','comment'=>'数量','null'=>TRUE,),
    'eli_count_have'=> array('type'=>'INT','constraint'=>'11','comment'=>'已采购数量','null'=>TRUE,),

	'eli_type_bill'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'票种','UNSIGNED'=>TRUE,'null'=>TRUE,),
	'eli_type_lxcg'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'零星采购属性','UNSIGNED'=>TRUE,'null'=>TRUE,),
	'eli_type'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'清单属性','UNSIGNED'=>TRUE,'null'=>TRUE,),

	'eli_sub'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'预算科目','null'=>TRUE,),
	'eli_c_pr'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'采购人','null'=>TRUE,), 
    'eli_gfc_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'财务编号','null'=>TRUE,), 

    'eli_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'备注','null'=>TRUE,), 

  ),  
  'primary_key'=>array( 
    'eli_id', 
  ),  
  'fields_index'=>array(
  ), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
