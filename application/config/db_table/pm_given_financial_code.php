<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['pm_given_financial_code'] = array( 
  'table_name_show'=>'财务编号', 
  'table_note'=>'', 
  'fields'=>array( 
    'gfc_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'',), 
	'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
	'ppo'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'节点','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,), 

    'gfc_name'=> array('type'=>'VARCHAR','constraint'=>'250','comment'=>'项目全称','null'=>TRUE,), 
	'gfc_name_tm'=> array('type'=>'VARCHAR','constraint'=>'250','comment'=>'脱密后项目全称','null'=>TRUE,), 
    'gfc_finance_code'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'财务编号','null'=>TRUE,), 
	'gfc_contract_code'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'合同编号','null'=>TRUE,), 
	'gfc_key_word'=> array('type'=>'TEXT','constraint'=>'','comment'=>'关键词','null'=>TRUE,), 
	'gfc_sum'=> array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'合同总额','null'=>TRUE,), 
	'gfc_sum_kp'=> array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'开票','null'=>TRUE,),
	'gfc_sum_hk'=> array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'回款','null'=>TRUE,),

	'gfc_org'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'所属公司','null'=>TRUE,), 
	'gfc_org_jia'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'甲方单位','null'=>TRUE,), 
	'gfc_c_jia'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'甲方联系人','null'=>TRUE,), 

	'gfc_budm_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'预算表','null'=>TRUE,), 
	'gfc_bud_verson'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'预算表版本','null'=>TRUE,),
	'gfc_date_bud_alter'=> array('type'=>'DATE','constraint'=>'','comment'=>'预算表更新时间','null'=>TRUE,),
	'gfc_tax'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'流转税','null'=>TRUE,), 

	'gfc_el_verson'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'设备清单版本','null'=>TRUE,),
	'gfc_date_el_alter'=> array('type'=>'DATE','constraint'=>'','comment'=>'预算表更新时间','null'=>TRUE,),

	'gfc_cr_verson' => array('type'=>'TINYINT','constraint'=>'3','comment'=>'评审版本','null'=>TRUE,),

	'gfc_c'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'项目负责人','null'=>TRUE,), 
	'gfc_c_tj'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'项目统计人','null'=>TRUE,), 
	'gfc_ou'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'所属部门','null'=>TRUE,), 

	'gfc_category_tdn'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'是否有临时财务编号','null'=>TRUE,),

	'gfc_time_node_sign'=> array('type'=>'DATE','constraint'=>'','comment'=>'统计时间','null'=>TRUE,),
	'gfc_pt_plan_sign'=> array('type'=>'DATE','constraint'=>'','comment'=>'预计签约时间','null'=>TRUE,),
	'gfc_start_time_sign'=> array('type'=>'DATE','constraint'=>'','comment'=>'项目开工时间','null'=>TRUE,),
	'gfc_complet_time_sign'=> array('type'=>'DATE','constraint'=>'','comment'=>'项目完工时间','null'=>TRUE,),

	'gfc_category_main'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'项目属性','UNSIGNED'=>TRUE,'null'=>TRUE,),
	'gfc_category_extra'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'附加属性','UNSIGNED'=>TRUE,'null'=>TRUE,),
	'gfc_category_statistic'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'附加属性II','UNSIGNED'=>TRUE,'null'=>TRUE,),
	'gfc_category_cooperation'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'是否合作项目','null'=>TRUE,),
	'gfc_category_subc'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'总分包类型','UNSIGNED'=>TRUE,'null'=>TRUE,),
	'gfc_category_secret'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'项目密级','UNSIGNED'=>TRUE,'default'=>0,'null'=>TRUE,),
	'gfc_category_exempt'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'是否免','UNSIGNED'=>TRUE,'null'=>TRUE,),
	'gfc_category_put_ou'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'是否报备','UNSIGNED'=>TRUE,'null'=>TRUE,),
	'gfc_category_contract'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'先实施后签约','UNSIGNED'=>TRUE,'null'=>TRUE,),

	'gfc_area'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'区域','null'=>TRUE,), 
	'gfc_area_show'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'区域显示','null'=>TRUE,), 
	'gfc_category_tiaoxian'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'行业','null'=>TRUE,),
	'gfc_category_tiaoxian_main'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'条线','null'=>TRUE,),

	'gfc_category_bill'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'是否开票','null'=>TRUE,),

    'gfc_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'备注','null'=>TRUE,), 

  ),  
  'primary_key'=>array( 
    'gfc_id', 
  ),  
  'fields_index'=>array(
  ), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
