<?php
/**
 * 
 * 过滤数组前后空格
 * @param $arr
 */
function trim_array($arr)
{
	if( ! is_array($arr) )
	return $arr;
	
	if(count($arr)>0)
	{
		foreach ($arr as $k=>$v) {
			
			$k=trim($k);
			
			if( is_array($v) )
			$arr[$k]=trim_array($v);
			else
			$arr[$k]=trim($v);
		}
	}
	
	return $arr;
}

/**
 * 
 * 运行cmd
 * @param $command
 */
function run_cmd($command)
{
	//创建shell对象  
	$WshShell   = new COM("WScript.Shell");  
	//执行cmd命令  
	$oExec      = $WshShell->Run("cmd /C ". $command, 0, true); 
}

/**
 * 
 * curl模拟POST请求
 * @param $url
 * @param $data
 */
function curlPost($url,$data="")
{   
    $ch = curl_init();
    
	$opt = array(
			CURLOPT_URL     => $url,            
            CURLOPT_HEADER  => 0,
			CURLOPT_POST    => 1,
            CURLOPT_POSTFIELDS      => $data,
            CURLOPT_RETURNTRANSFER  => 1,
            CURLOPT_TIMEOUT         => 5

    );
    
    $ssl = substr($url,0,8) == "https://" ? TRUE : FALSE;
    
    if ($ssl){
        $opt[CURLOPT_SSL_VERIFYHOST] = 2;
        $opt[CURLOPT_SSL_VERIFYPEER] = FALSE;
    }
    
    curl_setopt_array($ch,$opt);
    $data = curl_exec($ch);
    curl_close($ch);
    
    return $data;
}

/**
  * 
  * 获取当前登录ip
  */
function get_ip()
{
    $ip = '';    
    if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
    {        
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];    
    }
    elseif(isset($_SERVER['HTTP_CLIENT_IP']))
    {        
        $ip = $_SERVER['HTTP_CLIENT_IP'];    
    }
    else
    {        
        $ip = $_SERVER['REMOTE_ADDR'];    
    }
    
    $ip_arr = explode(',', $ip);
    
	return $ip_arr[0];
}

/**
  * 
  * 密码加密
  * @param $pwd 密码
  */
function encry_pwd($pwd)
{
    $pwd = md5(strrev(md5($pwd)));
    return $pwd;
}
    
/**
  * 
  * 获取内部id
  */
function get_guid()
{
    $str=time().get_ip().random_string('md5');
    
    return strtoupper(md5($str));
}

/**
  * 
  * 数组转为json(用于下拉框)
  * @param $arr 数组
  */
function get_json_for_arr($arr)
{
    $rtn='';
    
	if( ! is_array($arr))
		return $rtn;
	
    if(count($arr)>0)
    {
    	foreach ($arr as $k=>$v)
    	{
    		$rtn.='{"id":"'.$k.'","text":"'.$v.'","iconCls":"icon-type"},';
    	}
    	$rtn=trim($rtn,',');
    }
    return $rtn;
}
    
/**
  * 
  * 数组转为json(用于下拉框,HMTL直接输出)
  * @param $arr 数组
  */
function get_html_json_for_arr($arr)
{
    $rtn='';
    
	if( ! is_array($arr))
		return $rtn;
	
    if(count($arr)>0)
    {
    	foreach ($arr as $k=>$v)
    	{
    		$rtn.='{id:\''.$k.'\',text:\''.$v.'\',iconCls:\'icon-type\'},';
    	}
    	$rtn=trim($rtn,',');
    }
    return $rtn;
}

/**
 * 
 * url 加密
 * @param $str 字符串
 */
function fun_urlencode($str)
{
	$str=base64_encode($str);
	$str=str_replace('/', '0x000', $str);
	$str=str_replace('=', '0eq00', $str);
	$str=str_replace('+', '0add0', $str);
	return $str;
}

/**
 * 
 * url 解密
 * @param $str 字符串
 */
function fun_urldecode($str)
{
	$str=str_replace('0x000', '/', $str);
	$str=str_replace('0eq00', '=', $str);
	$str=str_replace('0add0', '+', $str);
	$str=base64_decode($str);
	
	return $str;
}

/**
 * 
 * 验证主键id
 * @param $id 
 */
function fun_check_pk($id)
{
	$regex='/^[_0-9a-zA-Z]$/';
	
	if( ! preg_match($regex, $id))
	$id='';
	
	return $id;
}

/**
 * 
 * 分离table[field]
 * @param $str 
 */
function split_table_field($str)
{
	$rtn=array();
	if( is_array($str) )
	$str=current($str);
	
	$arr=explode('[', $str);
	
	$rtn['table']=$arr[0];
	
	$rtn['field']=trim(element(1, $arr),']');
	
	return $rtn;
}

/**
 * 
 * 分离区间[x,y]
 * @param $str 
 */
function split_qujian($str)
{
	$rtn=array();
	
	$str=trim($str,'(');
	$str=trim($str,')');
	$str=trim($str,'[');
	$str=trim($str,']');
	
	$arr=explode(',', $str);
	
	$rtn['min']=$arr[0];
	$rtn['max']=element('1',$arr);
	
	return $rtn;
}

/**
     * 数字转字母 （类似于Excel列标）
     * @param Int $index 索引值
     * @param Int $start 字母起始值
     * @return String 返回字母
     * @author Anyon Zou <Anyon@139.com>
     * @date 2013-08-15 20:18
     */
function IntToChr($index, $start = 65) {
    $str = '';
    if (floor($index / 26) > 0) {
        $str .= IntToChr(floor($index / 26)-1);
    }
    return $str . chr($index % 26 + $start);
}

 /**
  * 
  * 将图片转为base输出
  * @param $img_path
  */
function getImgBaseStr($path_img){
	
	$data_photo='';
	if( ! empty($path_img) && file_exists($path_img) )
	{
		$data_photo=file_get_contents($path_img);
//	else
//		$data_photo=file_get_contents($this->config->item('base_img_path').'img_err.png');
		
   		$data_photo=chunk_split(base64_encode($data_photo));//base64编码  
	}
	
    return $data_photo;
}

/**
 * 
 * 对通过PHPEXECLREAD 读取的日期进行转换格式
 * @param $time
 */
function get_exl_input_time($time)
{ 
	if($time!=null)
	{
		$time=($time-25569)*24*60*60;
		$time=date("Y-m-d",$time);
	}

	return $time;
} 

/**
 * 通过app访问url
 */
function redirect_app()
{ 
	$url=fun_urlencode(uri_string());
	redirect('app/index/uri/'.$url);
}

/**
 * 
 * 计算时间差
 * @param $time_end
 * @param $time_start
 */
function time_diff($time_end_1,$time_start_1,$format = array() )
{
	$rtn='';
	
	$time_end = new DateTime($time_end_1);
	$time_start = new DateTime($time_start_1);
	$time_diff = $time_end->diff($time_start);
	
	$Y=$time_diff->format('%Y');
	$m=$time_diff->format('%m');
	$d=$time_diff->format('%d');
	$H=$time_diff->format('%H');
	$i=$time_diff->format('%i');
	$s=$time_diff->format('%s');
	
	
	if( ! isset($format['Y']) )
	$m += $Y*12;
	
	if( ! isset($format['m']))
	$d = floor((strtotime($time_end_1)-strtotime($time_start_1))/86400);
	
	if( count($format) > 0 )
	{
		if( ! isset($format['d']))
		$H += $d*24;
		
		if( ! isset($format['H']))
		$i += $H*60;
		
		if( ! isset($format['i']))
		$s += $i*60;
	
		foreach ($format as $k => $v) {
			
			switch ($k)
			{
				case 'Y':
					if($Y)
					$rtn.=$Y.$v;
					break;
				case 'm':
					if($m)
					$rtn.=$m.$v;
					break;
				case 'd':
					if($d)
					$rtn.=$d.$v;
					break;
				case 'H':
					if($H)
					$rtn.=$H.$v;
					break;
				case 'i':
					if($i)
					$rtn.=$i.$v;
					break;
				case 's':
					if($s)
					$rtn.=$s.$v;
					break;
			}
		}
		
		return $rtn;
	}
	
	if($d)
	{
		$rtn = $d.'天';
		if($H) $rtn.=$H.'小时';
	}
	elseif($H != 0 )
	{
		$rtn = $H.'小时';
		if($i) $rtn.=$i.'分';
	}
	elseif($i != 0 )
	{
		$rtn=$i.'分';
		if($s) $rtn.=$s.'秒';
	}
	else 
	{
		$rtn=$s.'秒';
	}
	
	return $rtn;
}

/**
 * 
 * 从身份证中提取生日,包括15位和18位身份证 
 * @param $IDCard
 */
function getIDCardInfo($IDCard){ 
        $result['error']=0;//0：未知错误，1：身份证格式错误，2：无错误 
        $result['flag']='';//0标示成年，1标示未成年 
        $result['tdate']='';//生日，格式如：2012-11-15 
        
        $regex1 = "/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/";
        
        if( ! preg_match($regex1, $IDCard)){ 
            $result['error']=1; 
            return $result; 
        }else{ 
            if(strlen($IDCard)==18){ 
                $tyear=intval(substr($IDCard,6,4)); 
                $tmonth=intval(substr($IDCard,10,2)); 
                $tday=intval(substr($IDCard,12,2)); 
                if($tyear>date("Y")||$tyear<(date("Y")-100)){ 
                    $flag=0; 
                }elseif($tmonth<0||$tmonth>12){ 
                    $flag=0; 
                }elseif($tday<0||$tday>31){ 
                    $flag=0; 
                }else{ 
                	if($tmonth<10) $tmonth='0'.$tmonth;
                	if($tday<10) $tday='0'.$tday;
                    $tdate=$tyear."-".$tmonth."-".$tday.""; 
                } 
            }elseif(strlen($IDCard)==15){ 
                $tyear=intval("19".substr($IDCard,6,2)); 
                $tmonth=intval(substr($IDCard,8,2)); 
                $tday=intval(substr($IDCard,10,2)); 
                if($tyear>date("Y")||$tyear<(date("Y")-100)){ 
                    $flag=0; 
                }elseif($tmonth<0||$tmonth>12){ 
                    $flag=0; 
                }elseif($tday<0||$tday>31){ 
                    $flag=0; 
                }else{ 
                	if($tmonth<10) $tmonth='0'.$tmonth;
                	if($tday<10) $tday='0'.$tday;
                    $tdate=$tyear."-".$tmonth."-".$tday.""; 
                } 
            } 
        } 
        $result['error']=2;//0：未知错误，1：身份证格式错误，2：无错误 
        $result['birthday']=$tdate;//生日日期 
        return $result; 
} 

/**
  * 
  * 获取去除文件扩展名后的文件名
  */
function get_arr_by_filename($filename)
{
	$rtn = array();
	
    $arr_tmp = explode('.', $filename);
    
    $rtn['ext'] = '';
    if(count($arr_tmp) > 1)
    {
    	$rtn['ext'] = $arr_tmp[count($arr_tmp)-1];
    	unset($arr_tmp[count($arr_tmp)-1]);
    }
    
    $rtn['filename'] = implode('.', $arr_tmp);
    
    return $rtn;
}

/**
  * 
  * 科学记数法还原
  */
function sctonum($num, $double = 5){  
    if(FALSE !== stripos($num, "e")){  
        $a = explode("e",strtolower($num));  
        return bcmul($a[0], bcpow(10, $a[1], $double), $double);  
    }  
    else 
    return $num;
}  

/**
  * 
  * 对象转数组
  */
function object2array(&$object) {
    $object =  json_decode( json_encode( $object),true);
    return  $object;
}