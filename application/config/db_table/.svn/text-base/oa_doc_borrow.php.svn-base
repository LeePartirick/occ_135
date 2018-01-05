<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['oa_doc_borrow'] = array(
    'table_name_show'=>'档案借阅领取',
    'table_note'=>'',
    'fields'=>array(
        'docb_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'主键',),
        'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,),
        'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,),
        'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,),
        'docb_code'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'单据编号','null'=>TRUE,),
        'docb_type'=>array('type'=>'TINYINT','constraint'=>'3','comment'=>'借阅领取类型','null'=>TRUE,),//领取后是否需要归还
        'docb_c_id'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'借（领）人','null'=>TRUE,),
        'docb_c_ou'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'部门','null'=>TRUE,),
        'docb_time_start'=>array('type'=>'DATE','constraint'=>'','comment'=>'借阅时间','null'=>TRUE,),//当前日期
        'docb_time_end'=>array('type'=>'DATE','constraint'=>'','comment'=>'归还时间','null'=>TRUE,),
        'docb_explain'=> array('type'=>'TEXT','constraint'=>'','comment'=>'情况说明','null'=>TRUE,),//都是必填
        'docb_book'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'是否预约','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,),//默认为否
        'ppo'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'节点','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,),
        //归还
        'docb_r_explain'=> array('type'=>'TEXT','constraint'=>'','comment'=>'遗失情况说明','null'=>TRUE,),//遗失必填
    ),
    'primary_key'=>array(
        'docb_id',
    ),
    'fields_index'=>array(),
    'fields_add'=>array(),
    'fields_modify'=>array(),
    'fields_drop'=>array(),
);