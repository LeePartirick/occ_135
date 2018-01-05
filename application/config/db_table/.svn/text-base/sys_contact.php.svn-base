<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['sys_contact'] = array( 
  'table_name_show'=>'联系人表', 
  'table_note'=>'', 
  'fields'=>array( 
    'c_id'=> array('type'=>'VARCHAR','constraint'=>'40',), 
	'db_time_update'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据更新时间','null'=>TRUE,), 
	'db_time_create'=> array('type'=>'DATETIME','constraint'=>'','comment'=>'数据创建时间','null'=>TRUE,), 
	'db_person_create'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'创建人','null'=>TRUE,),  

	//系统信息
	'c_login_id'=> array('type'=>'VARCHAR','constraint'=>'80','comment'=>'关联账户','null'=>TRUE,), 
	'c_email_sys'=> array('type'=>'VARCHAR','constraint'=>'80','comment'=>'系统邮箱','null'=>TRUE,), 
	'c_org'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'所属机构','null'=>TRUE,), 
	'c_hr_org'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'法人','null'=>TRUE,), 
	'c_ou_bud'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'预算部门','null'=>TRUE,),
	'c_ou_2'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'二级部门','null'=>TRUE,), 
	'c_ou_3'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'三级部门','null'=>TRUE,), 
	'c_ou_4'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'四级部门','null'=>TRUE,), 
	'c_job'=>array('type'=>'VARCHAR','constraint'=>'40','comment'=>'职位','null'=>TRUE,), 
	
	'c_pwd_start'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'初始密码','null'=>TRUE,), 
    'c_pwd_web'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'上网密码','null'=>TRUE,), 
    'c_login_id_m'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'手机上网账号','null'=>TRUE,), 
    'c_email_gz'=> array('type'=>'VARCHAR','constraint'=>'100','comment'=>'工资邮箱','null'=>TRUE,), 

	//基本信息
    'c_name'=> array('type'=>'VARCHAR','constraint'=>'80','comment'=>'姓名','null'=>TRUE,), 
	'a_id'=> array('type'=>'VARCHAR','constraint'=>'40','null'=>TRUE,), 
	'c_sex'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'性别','UNSIGNED'=>TRUE,'null'=>TRUE,), 
	'c_type'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'人员类型','null'=>TRUE,), 
	'c_img'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'照片','null'=>TRUE,), 
	'c_birthday'=> array('type'=>'DATE','constraint'=>'','comment'=>'生日','null'=>TRUE,), 
	'c_code_person'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'身份证','null'=>TRUE,),

	//联系信息
	'c_email'=> array('type'=>'VARCHAR','constraint'=>'200','comment'=>'EMAIL','null'=>TRUE,), 
	'c_tel_code'=> array('type'=>'VARCHAR','constraint'=>'20','comment'=>'短号','null'=>TRUE,), 
	'c_tel'=> array('type'=>'VARCHAR','constraint'=>'20','comment'=>'手机','null'=>TRUE,), 
	'c_tel_info'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'手机信息','null'=>TRUE,), 
	'c_tel_2'=> array('type'=>'VARCHAR','constraint'=>'20','comment'=>'备用手机','null'=>TRUE,), 
	'c_tel_2_info'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'备用手机信息','null'=>TRUE,),
	'c_phone'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'固定电话','null'=>TRUE,),

	'c_xl'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'学历','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'c_xw'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'学位','UNSIGNED'=>TRUE,'null'=>TRUE,), 
    'c_zzmm'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'政治面貌','UNSIGNED'=>TRUE,'null'=>TRUE,), 

	'c_bank'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'银行卡号','null'=>TRUE,), 
	'c_bank_type'=> array('type'=>'TINYINT','constraint'=>'3','comment'=>'银行卡类别','UNSIGNED'=>TRUE,'null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'c_id', 
  ),  
  'fields_index'=>array(),
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
