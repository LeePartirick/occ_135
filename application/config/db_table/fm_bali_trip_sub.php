<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['fm_bali_trip_sub'] = array(
    'table_name_show'=>'差旅费费用报销',
    'table_note'=>'',
    'fields'=>array(
        'bali_trs_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'主键',),
        'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,),
        'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,),
        'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,),
		'ppo'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'节点','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,),

		'baltrs_c_id'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'费用报销','null'=>TRUE,),
		'baltrs_day_count'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'天数','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,),
		'baltrs_room_normal'=>array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'住宿标准','default'=>'0.00','null'=>TRUE,),
		'baltrs_food_normal'=>array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'伙食标准','default'=>'0.00','null'=>TRUE,),
		'baltrs_room_difference'=>array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'住宿差额','default'=>'0.00','null'=>TRUE,),
		'baltr_other'=>array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'其他','default'=>'0.00','null'=>TRUE,),
		'baltr_food_difference'=>array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'伙食差额','default'=>'0.00','null'=>TRUE,),
		'baltr_sum_total'=>array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'合计','default'=>'0.00','null'=>TRUE,),

		'bal_id'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'费用报销','null'=>TRUE,),
    ),
    'primary_key'=>array(
        'bali_trs_id',
    ),
    'fields_index'=>array(),
    'fields_add'=>array(),
    'fields_modify'=>array(),
    'fields_drop'=>array(),
);