<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
$config['sys_ra_link'] = array( 
  'table_name_show'=>'RA关联', 
  'table_note'=>'', 
  'table_code'=>'null', 
  'fields'=>array( 
    'a_id'=> array('type'=>'VARCHAR','constraint'=>'40','display'=>'账户','null'=>TRUE,), 
    'ra_note'=> array('type'=>'TEXT','constraint'=>'','comment'=>'备注','null'=>TRUE,), 
    'ra_id'=> array('type'=>'VARCHAR','constraint'=>'40',), 
    'role_id'=> array('type'=>'VARCHAR','constraint'=>'40','comment'=>'角色','null'=>TRUE,), 
  ),  
  'primary_key'=>array( 
    'ra_id', 
  ),  
  'fields_index'=>array(),
  'fields_add'=>array(), 
  'fields_modify'=>array(), 
  'fields_drop'=>array(), 
);  
