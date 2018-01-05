<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['fm_bali_trip_c'] = array(
    'table_name_show'=>'差旅费费用报销',
    'table_note'=>'',
    'fields'=>array(
        'bali_trc_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'主键',),
        'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,),
        'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,),
        'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,),
		'ppo'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'节点','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,),

		'baltr_c_id'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'姓名','null'=>TRUE,),
		'baltr_c_type'=>array('type'=>'TINYINT','constraint'=>'3','comment'=>'人员类型','UNSIGNED'=>TRUE,'null'=>TRUE,),
		'baltr_single'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'单住天数','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,),
		'baltr_together'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'合住天数','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,),
		'baltr_tra_count'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'单据张数','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,),
		'baltr_pay_type'=>array('type'=>'TINYINT','constraint'=>'3','comment'=>'支付方式','UNSIGNED'=>TRUE,'null'=>TRUE,),
		'baltr_c_sum'=>array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'金额','default'=>'0.00','null'=>TRUE,),

		'bal_id'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'费用报销','null'=>TRUE,),
    ),
    'primary_key'=>array(
        'bali_trc_id',
    ),
    'fields_index'=>array(),
    'fields_add'=>array(),
    'fields_modify'=>array(),
    'fields_drop'=>array(),
);