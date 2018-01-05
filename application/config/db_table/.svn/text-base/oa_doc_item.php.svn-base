<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['oa_doc_item'] = array(
    'table_name_show'=>'档案信息',
    'table_note'=>'',
    'fields'=>array(
        'doci_id'=> array('type'=>'VARCHAR','constraint'=>'80','comment'=>'主键',),
        'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,),
        'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,),
        'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,),
        'doci_name'=>array('type'=>'VARCHAR','constraint'=>'80','comment'=>'文件名','null'=>TRUE,),
        'doci_page_now'=>array('type'=>'INT','constraint'=>'40','comment'=>'实际页数','null'=>TRUE,),
		'doci_page_have'=>array('type'=>'INT','constraint'=>'40','comment'=>'应有页数','null'=>TRUE,),
		'doci_org'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'所属公司','null'=>TRUE,),
        'doci_type'=>array('type'=>'TINYINT','constraint'=>'3','comment'=>'档案状态','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,),
        'doc_gfc_id'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'关联财务编号','null'=>TRUE,),
		'docb_id'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'关联档案借取','null'=>TRUE,),
		'doci_f_id'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'关联档案id','null'=>TRUE,),
        'doc_id'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'关联档案表','null'=>TRUE,),//主表
		'docb_book'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'预约档案','null'=>TRUE,),
),
    'primary_key'=>array(
        'doci_id',
),
    'fields_index'=>array(),
    'fields_add'=>array(),
    'fields_modify'=>array(),
    'fields_drop'=>array(),
);