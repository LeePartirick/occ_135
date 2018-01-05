<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['pm_bud_price_approval'] = array(
    'table_name_show'=>'自研产品',
    'table_note'=>'',
    'fields'=>array(
        'pa_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'主键',),
        'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,),
        'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,),
        'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,),
        'pa_gfc_id'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'关联财务编号','null'=>TRUE,),
        'pa_sn'=>array('type'=>'SMALLINT','constraint'=>'5','comment'=>'设备排序','null'=>TRUE,),
        'pa_eq_id'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'设备名称','null'=>TRUE,),
        'pa_eq_num'=>array('type'=>'DECIMAL','constraint'=>'40','comment'=>'设备数量','null'=>TRUE,),
        'pa_eq_price'=>array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'设备单价','null'=>TRUE,),
        'pa_eq_total'=>array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'设备总价','null'=>TRUE,),
        'pa_num_alt'=>array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'设备数量_变更后','null'=>TRUE,),
        'pa_price_alt'=>array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'设备单价_变更后','null'=>TRUE,),
        'pa_total_alt'=>array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'设备总价_变更后','null'=>TRUE,),
        'pa_num_alt_view'=>array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'设备总价_本次变更数','null'=>TRUE,),
        'pa_price_alt_view'=>array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'设备总价_本次变更数','null'=>TRUE,),
        'pa_total_alt_view'=>array('type'=>'DECIMAL','constraint'=>'15,2','comment'=>'设备总价_本次变更数','null'=>TRUE,),
    ),
    'primary_key'=>array(
        'pa_id',
    ),
    'fields_index'=>array(),
    'fields_add'=>array(),
    'fields_modify'=>array(),
    'fields_drop'=>array(),
);


