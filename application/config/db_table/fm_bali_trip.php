<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['fm_bali_trip'] = array(
    'table_name_show'=>'差旅费费用报销',
    'table_note'=>'',
    'fields'=>array(
        'bali_tr_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'主键',),
        'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,),
        'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,),
        'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,),
		'ppo'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'节点','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,),

		'baltr_time_out'=> array('type'=>'DATE','constraint'=>'','comment'=>'出发时间','null'=>TRUE,),
		'baltr_time_in'=> array('type'=>'DATE','constraint'=>'','comment'=>'到达时间','null'=>TRUE,),
		'baltr_place_out'=>array('type'=>'VARCHAR','constraint'=>'250','comment'=>'出发地点','null'=>TRUE,),
		'baltr_place_in'=>array('type'=>'VARCHAR','constraint'=>'250','comment'=>'到达地点','null'=>TRUE,),
		'baltr_traffic'=>array('type'=>'TINYINT','constraint'=>'3','comment'=>'交通工具','UNSIGNED'=>TRUE,'null'=>TRUE,),
		'baltr_tra_count'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'车船票单据张数','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,),
		'baltr_tra_sum'=>array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'金额车船票','default'=>'0.00','null'=>TRUE,),
		'baltr_other_count'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'其他单据张数','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,),
		'baltr_city_sum'=>array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'室内交通','default'=>'0.00','null'=>TRUE,),
		'baltr_room_sum'=>array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'住宿','default'=>'0.00','null'=>TRUE,),
		'baltr_food_sum'=>array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'伙食','default'=>'0.00','null'=>TRUE,),
		'baltr_other_sum'=>array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'其他','default'=>'0.00','null'=>TRUE,),
		'baltr_tatal_sum'=>array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'合计','default'=>'0.00','null'=>TRUE,),

		'bal_id'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'费用报销','null'=>TRUE,),
    ),
    'primary_key'=>array(
        'bali_tr_id',
    ),
    'fields_index'=>array(),
    'fields_add'=>array(),
    'fields_modify'=>array(),
    'fields_drop'=>array(),
);