<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['fm_bill'] = array( 
  'table_name_show'=>'开票', 
  'table_note'=>'', 
  'fields'=>array( 
    'bill_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'',), 
	'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
    'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,), 
    'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,), 
	'ppo'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'节点','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,), 

	'bill_code'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'单据编号','null'=>TRUE,), 
	'bill_sum'=> array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'开票金额','default'=>'0.00','null'=>TRUE,), 
	'bill_ending_sum'=> array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'应收账款','default'=>'0.00','null'=>TRUE,), 
	'bill_sum_return'=> array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'已收账款','default'=>'0.00','null'=>TRUE,), 
	'bill_tax_sum'=> array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'税金','default'=>'0.00','null'=>TRUE,), 
	'bill_tax'=> array('type'=>'VARCHAR','constraint'=>'100','comment'=>'流转税','null'=>TRUE,), 
	'bill_takings'=> array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'营业收入','default'=>'0.00','null'=>TRUE,), 

	'bill_org_customer'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'客户名称','null'=>TRUE,), 
	'bill_contact_manager'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'开票统计人','null'=>TRUE,), 
	'bill_send_type'=>array('type'=>'TINYINT','constraint'=>'3','comment'=>'发票送达方式','null'=>TRUE,),

	'bill_category'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'发票类型','null'=>TRUE,), 	

	'bill_time_node_kp'=> array('type'=>'DATE','constraint'=>'','comment'=>'开票时间','null'=>TRUE,),
	'bill_time_return'=> array('type'=>'DATE','constraint'=>'','comment'=>'预计回款时间','null'=>TRUE,),
	'bp_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'备注','null'=>TRUE,), 

	'bill_org_owner'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'所属机构','null'=>TRUE,), 	

    'gfc_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'财务编号','null'=>TRUE,), 
	'bp_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'开票计划','null'=>TRUE,), 

  ),  
  'primary_key'=>array( 
    'bill_id', 
  ),  
  'fields_index'=>array(
  ), 
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
