<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['fm_bal_item'] = array(
    'table_name_show'=>'费用报销明细',
    'table_note'=>'',
    'fields'=>array(
        'bali_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'主键',),
        'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,),
        'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,),
        'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,),

		'ppo'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'节点','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,),

		'blp_ppo'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'节点','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,),
		'blp_ppo_num'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'经费申请阶段','UNSIGNED'=>TRUE,'null'=>TRUE,),
		'blp_ppo_person'=>array('type'=>'TEXT','constraint'=>'','comment'=>'审核人','null'=>TRUE,),
		
		'bali_sum'=>array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'不含税金额','default'=>'0.00','null'=>TRUE,),
		'bali_sum_zzs'=>array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'增值税','default'=>'0.00','null'=>TRUE,),
		'bali_sum_total'=>array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'金额','default'=>'0.00','null'=>TRUE,),

		'bali_sub'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'预算科目','null'=>TRUE,),
		'bali_ou_tj'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'统计部门','null'=>TRUE,),
		'bali_abstract'=>array('type'=>'TEXT','constraint'=>'','comment'=>'摘要','null'=>TRUE,),
		'bali_note'=>array('type'=>'TEXT','constraint'=>'','comment'=>'备注','null'=>TRUE,),
		'bali_category_statistics'=>array('type'=>'TINYINT','constraint'=>'3','comment'=>'统计属性','UNSIGNED'=>TRUE,'null'=>TRUE,),
		'bali_pay_type'=>array('type'=>'TINYINT','constraint'=>'3','comment'=>'支付方式','UNSIGNED'=>TRUE,'null'=>TRUE,),

		'bal_id'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'费用报销','null'=>TRUE,),
		'bali_gfc_id'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'财务编号','null'=>TRUE,),
    ),
    'primary_key'=>array(
        'bali_id',
    ),
    'fields_index'=>array(),
    'fields_add'=>array(),
    'fields_modify'=>array(),
    'fields_drop'=>array(),
);