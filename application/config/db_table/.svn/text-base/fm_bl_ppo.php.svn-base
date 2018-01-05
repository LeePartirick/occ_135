<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['fm_bl_ppo'] = array(
    'table_name_show'=>'费用申请流程',
    'table_note'=>'',
    'fields'=>array(
        'blp_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'主键',),
        'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,),
        'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,),
        'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,),
//		'ppo'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'节点','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,),

		'blp_ppo'=>array('type'=>'TINYINT','constraint'=>'3','comment'=>'审核节点','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,),
		'blp_ppo_num'=>array('type'=>'TINYINT','constraint'=>'3','comment'=>'审核阶段','UNSIGNED'=>TRUE,'null'=>TRUE,),
        'blp_sum_start'=>array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'金额下限','default'=>'0.00','null'=>TRUE,),
		'blp_sum_end'=>array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'金额上限','null'=>TRUE,),
        
		'blp_sub'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'预算科目','null'=>TRUE,),
		'blp_ou'=>array('type'=>'TEXT','comment'=>'审核部门','null'=>TRUE,),
		'blp_c'=>array('type'=>'TEXT','comment'=>'审核人','null'=>TRUE,),
        'blp_note'=>array('type'=>'TEXT','constraint'=>'','comment'=>'备注','null'=>TRUE,),
    ),
    'primary_key'=>array(
        'blp_id',
    ),
    'fields_index'=>array(),
    'fields_add'=>array(),
    'fields_modify'=>array(),
    'fields_drop'=>array(),
);