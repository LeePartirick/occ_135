<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['fm_bali_link'] = array(
    'table_name_show'=>'费用报销明细关联',
    'table_note'=>'',
    'fields'=>array(
        'bl_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'主键',),
        'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,),
        'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,),
        'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,),
		'ppo'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'节点','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,),

		'bl_sum'=>array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'金额','default'=>'0.00','null'=>TRUE,),

		'bali_id'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'费用报销明细','null'=>TRUE,),
		'bal_id'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'费用报销','null'=>TRUE,),
		'gfc_id'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'财务编号','null'=>TRUE,),
		'loan_id'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'非开票','null'=>TRUE,),
    ),
    'primary_key'=>array(
        'bl_id',
    ),
    'fields_index'=>array(),
    'fields_add'=>array(),
    'fields_modify'=>array(),
    'fields_drop'=>array(),
);