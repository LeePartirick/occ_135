<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['oa_doc'] = array(
    'table_name_show'=>'档案',
    'table_note'=>'',
    'fields'=>array(
        'doc_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'主键',),
        'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,),
        'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,),
        'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,),
        'ppo'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'节点','default'=>'0','UNSIGNED'=>TRUE,'null'=>TRUE,),
        
        'doc_org'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'归属公司','null'=>TRUE,),
        'doc_gfc_id'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'关联财务编号','null'=>TRUE,),
        'doc_name'=>array('type'=>'VARCHAR','constraint'=>'200','comment'=>'档案全称','null'=>TRUE,),
        'doc_sign_org'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'签发单位','null'=>TRUE,),
        'doc_efftime_start'=>array('type'=>'DATE','constraint'=>'','comment'=>'有效起始日期','null'=>TRUE,),
        'doc_efftime_end'=>array('type'=>'DATE','constraint'=>'','comment'=>'有效截止日期','null'=>TRUE,),
        'doc_addtime'=>array('type'=>'DATE','constraint'=>'','comment'=>'录入时间','null'=>TRUE,),//取当前时间
        'doc_letter_have'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'应有件-页','null'=>TRUE,),
		'doc_letter_now'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'实际件-页','null'=>TRUE,),
		'doc_page_have'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'应有页','null'=>TRUE,),
		'doc_page_now'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'实际页','null'=>TRUE,),
        'doc_alert_time'=>array('type'=>'DATE','constraint'=>'','comment'=>'提醒日期','null'=>TRUE,),
		'doc_alert_yn'=>array('type'=>'TINYINT','constraint'=>'3','comment'=>'是否提醒','null'=>TRUE,),
        'doc_sub_person'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'递交人','null'=>TRUE,),
        'doc_keep_person'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'保管人','null'=>TRUE,),
        'doc_protect_person'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'维护人','null'=>TRUE,),
        'doc_original_code'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'档案原始号','null'=>TRUE,),

        'doc_secret'=>array('type'=>'TINYINT','constraint'=>'3','comment'=>'档案密级','null'=>TRUE,),
        'doc_limit_level'=>array('type'=>'TINYINT','constraint'=>'3','comment'=>'限制级别','null'=>TRUE,),
        'doc_project_type'=>array('type'=>'TINYINT','constraint'=>'3','comment'=>'项目状态','null'=>TRUE,),
        'doc_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'备注','null'=>TRUE,),

        //审批信息
        'doc_company_code' => array('type'=>'VARCHAR','constraint'=>'40','comment'=>'公司码','null'=>TRUE,),
        'doc_big_code' => array('type'=>'VARCHAR','constraint'=>'40','comment'=>'大类码','null'=>TRUE,),
        'doc_middle_code' => array('type'=>'VARCHAR','constraint'=>'40','comment'=>'中类码','null'=>TRUE,),
        'doc_small_code' => array('type'=>'VARCHAR','constraint'=>'40','comment'=>'小类码','null'=>TRUE,),
        'doc_code' => array('type'=>'VARCHAR','constraint'=>'40','comment'=>'档案码','null'=>TRUE,),
        'doc_location' => array('type'=>'VARCHAR','constraint'=>'80','comment'=>'存放位置','null'=>TRUE,),
        'doc_nominate' => array('type'=>'VARCHAR','constraint'=>'80','comment'=>'案卷题名','null'=>TRUE,),
        'doc_return_time'=>array('type'=>'DATE','constraint'=>'','comment'=>'归档日期','null'=>TRUE,),

    ),
    'primary_key'=>array(
        'doc_id',
    ),
    'fields_index'=>array(),
    'fields_add'=>array(),
    'fields_modify'=>array(),
    'fields_drop'=>array(),
);


