<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['fm_loan'] = array(
    'table_name_show'=>'非开票往来',
    'table_note'=>'',
    'fields'=>array(
        'loan_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'主键',),
        'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,),
        'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,),
        'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,),
		'ppo'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'节点','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,),

        'loan_code' => array('type'=>'VARCHAR','constraint'=>'40','comment'=>'单据编号','null'=>TRUE,),
		'loan_code_type'=>array('type'=>'TINYINT','constraint'=>'3','comment'=>'自动生成','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,),

		'loan_time_node'=>array('type'=>'DATE','constraint'=>'','comment'=>'日期','null'=>TRUE,),//员工选择
        'loan_sub'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'预算科目','null'=>TRUE,),
        'loan_org'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'所属公司','null'=>TRUE,),
        'loan_pay_type'=>array('type'=>'TINYINT','constraint'=>'3','comment'=>'支付方式','null'=>TRUE,),
        'loan_sum'=>array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'金额','default'=>'0.00','null'=>TRUE,),
        'loan_ending_sum'=>array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'未冲账金额','default'=>'0.00','null'=>TRUE,),
		'loan_sum_return'=>array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'冲账金额','default'=>'0.00','null'=>TRUE,),
        'loan_return_month'=>array('type'=>'DATE','constraint'=>'','comment'=>'预计归还月','null'=>TRUE,),//员工选择
        'loan_ou'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'部门','null'=>TRUE,),
        'loan_ou_tj'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'统计部门','null'=>TRUE,),
        'loan_c_id'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'申请人','null'=>TRUE,),
        'loan_gfc_id'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'财务编号','null'=>TRUE,),
        'loan_category_finance'=>array('type'=>'TINYINT','constraint'=>'3','comment'=>'财务属性','null'=>TRUE,),//有过账权限的人填写
        'loan_o_id'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'付款单位','null'=>TRUE,),
        'loan_oacc_bank'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'付款单位-开户行','null'=>TRUE,),
        'loan_note'=>array('type'=>'TEXT','constraint'=>'','comment'=>'用途','null'=>TRUE,),
		
		'blp_ppo_num'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'经费申请阶段','UNSIGNED'=>TRUE,'null'=>TRUE,),
    ),
    'primary_key'=>array(
        'loan_id',
    ),
    'fields_index'=>array(),
    'fields_add'=>array(),
    'fields_modify'=>array(),
    'fields_drop'=>array(),
);