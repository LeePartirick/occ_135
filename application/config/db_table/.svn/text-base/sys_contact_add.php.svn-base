<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['sys_contact_add'] = array( 
  'table_name_show'=>'联系人附加信息', 
  'table_note'=>'', 
  'fields'=>array( 
    'c_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'',), 
	'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
	'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,), 
	'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,),  

	//个人信息
	'c_mz'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'民族','null'=>TRUE,), 
    'c_jg'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'籍贯','null'=>TRUE,), 
    'c_jg_show'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'籍贯显示','null'=>TRUE,), 
	'c_name_old'=> array('type'=>'VARCHAR','constraint'=>'80','comment'=>'曾用名','null'=>TRUE,), 
    'c_interest'=> array('type'=>'TEXT','constraint'=>'','comment'=>'兴趣爱好特长','null'=>TRUE,), 

	//教育信息
    'c_xl_day'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'全日制','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'c_zy'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'专业','null'=>TRUE,), 
    'c_school'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'毕业学校','null'=>TRUE,), 
    'c_hy'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'婚姻状况','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'c_time_work'=> array('type'=>'DATE','constraint'=>'','comment'=>'参加工作时间','null'=>TRUE,), 
    'c_time_graduate'=> array('type'=>'DATE','constraint'=>'','comment'=>'毕业时间','null'=>TRUE,), 

	//信息系统
	'c_mac_line'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'MAC地址有线','null'=>TRUE,), 
    'c_mac_noline'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'MAC地址无线','null'=>TRUE,), 

	//地址信息
	'c_addr'=> array('type'=>'TEXT','constraint'=>'','comment'=>'通讯地址','null'=>TRUE,), 
	'c_post_code'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'邮编','null'=>TRUE,),
	'c_addr_live'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'户籍地址','null'=>TRUE,), 
    'c_post_code_live'=> array('type'=>'VARCHAR','constraint'=>'20','comment'=>'户籍地址邮编','null'=>TRUE,), 
    'c_phone_addrl'=> array('type'=>'VARCHAR','constraint'=>'20','comment'=>'户籍地址联系电话','null'=>TRUE,), 
    'c_jzjd'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'居住地街道','null'=>TRUE,), 
    'c_jzdfw'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'居住地房屋性质','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'c_hj'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'户籍','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'c_hjjzz'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'户籍居住证','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    
	//紧急联系人
    'c_jzlxr'=> array('type'=>'VARCHAR','constraint'=>'100','comment'=>'紧急联系人','null'=>TRUE,), 
    'c_jzlxr_gx'=> array('type'=>'VARCHAR','constraint'=>'100','comment'=>'紧急联系人关系','null'=>TRUE,), 
    'c_jzlxr_dz'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'紧急联系人地址','null'=>TRUE,), 
    'c_jzlxr_tele'=> array('type'=>'VARCHAR','constraint'=>'20','comment'=>'紧急联系人电话','null'=>TRUE,), 

	//档案信息
	'c_doc_org'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'档案所在机构','null'=>TRUE,), 
    'c_doc_addr'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'档案机构地址','null'=>TRUE,), 
    'c_doc_addr_postcode'=> array('type'=>'VARCHAR','constraint'=>'20','comment'=>'档案机构邮编','null'=>TRUE,), 
    'c_doc_code'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'档案编码','null'=>TRUE,), 
    'c_doc_person'=> array('type'=>'VARCHAR','constraint'=>'80','comment'=>'档案经办人','null'=>TRUE,), 
    'c_doc_person_tele'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'档案经办人联系方式','null'=>TRUE,), 
    
    //家庭成员信息
    'c_family_crime'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'家庭成员犯罪记录','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'c_family_gat'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'家庭成员港澳台居住证','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'c_family_foreign'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'家庭成员国外绿卡','UNSIGNED'=>TRUE,'null'=>TRUE,), 
	
	//备注
	'c_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'备注','null'=>TRUE,),
  ),  
  'primary_key'=>array( 
    'c_id', 
  ),  
  'fields_index'=>array(),
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
