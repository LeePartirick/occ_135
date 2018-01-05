<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 网络信息获取类
 */
class M_web_info extends CI_Model {
	
	private $key_code_at='';
	
 	public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        
        $this->m_define();
    }
    
	/**
     * 
     * 定义
     */
	public function m_define()
    {
    	if( defined('LOAD_M_WEB_INFO') ) return;
    	define('LOAD_M_WEB_INFO', 1);
    }
    
	/**
     * 
     * 验证权限
     */
	public function check()
    {
    	
    }
    
	/**
	  * 
	  * 获取手机信息
	  * @param $tele
	  */
	function get_tele_info($tele){
		
		$url='http://tcc.taobao.com/cc/json/mobile_tel_segment.htm?tel='.$tele;
		
	//	$url='http://api.avatardata.cn/MobilePlace/LookUp?key=2b5ab622986642fcb2a24558eb7e0fbf&mobileNumber='.$tele;
		$json=curlPost($url);
		$json=mb_convert_encoding( $json, 'UTF-8', 'GBK,GB2312,BIG5' ); 
	//	$arr=json_decode($json,TRUE);
	
		$arr_tmp=explode("carrier:'",$json);
		$arr_tmp=explode("'",element('1',$arr_tmp));
		
		return $arr_tmp[0];
	}
	
	/**
	  * 
	  * 获取中国地方信息
	  * @param $tele
	  */
	function get_china_area($p_id=NULL){
		
		$path=str_replace('\\', '/', APPPATH).'config/china_area/';
		if( empty($p_id) )
		$path.='main';
		else 
		$path.=$p_id;
		
		$json = '';
		
		if(file_exists($path))
		$json = file_get_contents($path);
		
		if( empty($json) )
		{
			$url='http://api.avatardata.cn/SimpleArea/LookUp?key=53ace235007742b29d42fcbb7d6ed2c8&parentId='.$p_id;
			$json=curlPost($url);
			
			$arr=json_decode($json,TRUE);
			
			$arr=$arr['result'];
			
			$json=json_encode($arr);
			
			write_file($path, $json);
		}
		
		return $json;
	}
	
	/**
	  * 
	  * 获取身份证信息
	  * @param $tele
	  */
	function get_person_code_info($person_code){
		
		$url='http://api.avatardata.cn/IdCard/LookUp?key=9210e26471b84dd8a00af4edefe89ca8&id='.$person_code;
		
		$json=curlPost($url);
		
		return $json;
	}
	
	/**
	  * 
	  * 获取银行卡信息
	  * @param $tele
	  */
	function get_bank_code_info($code){
		
		$url='http://api.avatardata.cn/Bank/Query?key=a2bfb4acc43a4ad1abba70680b1fe79a&cardnum='.$code;
		
		$json=curlPost($url);
		
		return $json;
	}
}