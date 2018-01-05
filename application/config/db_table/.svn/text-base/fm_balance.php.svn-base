<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['fm_balance'] = array(
    'table_name_show'=>'费用报销',
    'table_note'=>'',
    'fields'=>array(
        'bal_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'主键',),
        'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,),
        'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,),
        'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,),
		'ppo'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'节点','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,),

        'bal_code' => array('type'=>'VARCHAR','constraint'=>'40','comment'=>'单据编号','null'=>TRUE,),
		'bal_code_type'=>array('type'=>'TINYINT','constraint'=>'3','comment'=>'自动生成','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,),

        'bal_org_owner'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'所属公司','null'=>TRUE,),
        'bal_total_sum'=>array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'金额','default'=>'0.00','null'=>TRUE,),
		'rei_total_sum'=>array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'冲账金额','default'=>'0.00','null'=>TRUE,),
        'bal_ou'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'部门','null'=>TRUE,),
        'bal_contact_manager'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'申请人','null'=>TRUE,),
        'bal_note'=>array('type'=>'TEXT','constraint'=>'','comment'=>'备注','null'=>TRUE,),

		'bal_time_node'=> array('type'=>'DATE','constraint'=>'','comment'=>'日期','null'=>TRUE,),
		'bal_time_post_node'=> array('type'=>'DATE','constraint'=>'','comment'=>'过账日期','null'=>TRUE,),

		'bal_category_bumen'=>array('type'=>'TINYINT','constraint'=>'3','comment'=>'是否项目','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,),
    ),
    'primary_key'=>array(
        'bal_id',
    ),
    'fields_index'=>array(),
    'fields_add'=>array(),
    'fields_modify'=>array(),
    'fields_drop'=>array(),
);