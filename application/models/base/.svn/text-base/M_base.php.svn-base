<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 基础类
 */
class M_base extends CI_Model {
	
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
    	if( defined('LOAD_M_BASE') ) return;
    	define('LOAD_M_BASE', 1);
    	
    	// [常用操作状态定义]
		define('STAT_ACT_CREATE', 1); // 创建工作状态
		define('STAT_ACT_EDIT', 2); // 编辑工作状态
		define('STAT_ACT_VIEW', 3); // 查看工作状态
		define('STAT_ACT_REMOVE', 4); // 删除工作状态
		define('STAT_ACT_PRINT', 5); //打印数据状态
		
		$GLOBALS['m_base']['text']['act'] = array(
			STAT_ACT_CREATE=>'创建',
			STAT_ACT_EDIT=>'编辑',
			STAT_ACT_VIEW=>'查看',
			STAT_ACT_REMOVE=>'删除',
		);
		
		define('SITE_AUTHOR', $this->config->item('base_author')); //网站作者名称
		
		define('PATH_PERSON_CONF', str_replace('\\', '/', APPPATH).'config/person'); //个性化配置路径
		
		$GLOBALS['m_base']['text']['weekday']=array("日","一","二","三","四","五","六");
		
		// [系统帐户状态定义]
		define('A_STATUS_STOP', 1); // 帐户状态:停用
		define('A_STATUS_NORMAL', 2); // 帐户状态:正常
		$GLOBALS['m_account']['text']['a_status'] = array(
			A_STATUS_STOP=>'停用',
			A_STATUS_NORMAL=>'正常'
		);
		
    	//认证模式
		define('A_LOGIN_TYPE_DB', 1);//数据库认证
		define('A_LOGIN_TYPE_AD', 2);//AD域认证
		$GLOBALS['m_account']['text']['a_login_type'] = array(
			A_LOGIN_TYPE_DB=>'数据库',
			A_LOGIN_TYPE_AD=>'AD域',
		);
		
		define('BASE_Y', 1);//是
		define('BASE_N', 2);//否
		$GLOBALS['m_base']['text']['base_yn'] = array(
			BASE_Y=>'是',
			BASE_N=>'否',
		);
		
		$GLOBALS['m_base']['text']['base_yn_0'] = array(
			0=>'否',
			BASE_Y=>'是',
		);
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
	  * LIKE 转义自定义处理
	  * @param $str
	  */
	public function escape_like_str($str)
	{
		$str=$this->db->escape_like_str($str);
		$str=str_replace('!_', '\_', $str);
		$str=str_replace('!%', '\%', $str);
		return $str;
	}
	
	/**
      * 
      * 过滤消息
      * @param $msg
      */
    public function filter_str($str)
    {
    	$str=str_ireplace("select", "select", $str); 
    	$str=str_ireplace("insert", "insert", $str); 
    	$str=str_ireplace("update", "update", $str); 
    	$str=str_ireplace("delete", "delete", $str); 
    	$str=str_ireplace("drop", "drop", $str); 
    	$str=str_ireplace("alter", "alter", $str); 
    	$str=str_ireplace("<?php", "<?php", $str); 
    	$str=str_ireplace("<?", "<?", $str); 
    	$str=str_ireplace("?>", "?>", $str); 
    	$str=str_ireplace("<script", "<script", $str); 
    	$str=str_ireplace("</script>", "</script>", $str); 
//    	$str=str_ireplace("on", "on", $str); 
//    	$str=str_ireplace("<iframe", "<iframe", $str); 
//    	$str=str_ireplace("<meta", "<meta", $str); 
//    	$str=str_ireplace("<form", "<form", $str); 
//    	$str=str_ireplace("<html>", "<html>", $str); 
//    	$str=str_ireplace("<head>", "<head>", $str); 
//    	$str=str_ireplace("<body", "<body", $str); 
//    	$str=str_ireplace("<title>", "<title>", $str); 
//    	$str=str_ireplace("<span", "<span", $str); 
//    	$str=str_ireplace("<div", "<div", $str); 
//    	$str=str_ireplace("<table", "<table", $str); 
//    	$str=str_ireplace("<td", "<td", $str); 
//    	$str=str_ireplace("<tr", "<tr", $str); 
//    	$str=str_ireplace("<button", "<button", $str); 
//    	$str=str_ireplace("<a", "<a", $str); 
//    	$str=str_ireplace("<input", "<input", $str); 
//    	$str=str_ireplace("<textarea", "<textarea", $str); 
//    	$str=str_ireplace("<a ", "<a target='_blank' ", $str); 
    	
    	return $str;
    }
    
	/**
     * 
     * 过滤图片
     */
	public function filter_img($str)
    {
    	ini_set('pcre.backtrack_limit', -1); 
	 	$preg = '/<img.*?src=[\"|\']?(.*?)[\"|\']?\s.*?>/i';
		preg_match_all($preg, $str, $imgArr);
		
		$date=date("Y-m");
		$img_path=$this->config->item('base_img_path').$date.'/';
		
	    $arr_data=array();
		if(count($imgArr[0])>0)
		{
			if(!file_exists($img_path)){
		    	mkdir($img_path);//创建目录
		    }
	    
			foreach ($imgArr[0] as $k=>$v) {
				
				if( ! file_exists($this->config->item('base_www_path').$imgArr[1][$k]))
				continue;
				
  				$id=get_guid();
  				
  				$img_info=getimagesize($this->config->item('base_www_path').$imgArr[1][$k]);
  				
  				rename($this->config->item('base_www_path').$imgArr[1][$k], $img_path.$id);
  				
  				$img_size='width:200px';
  				
  				if($img_info[0] <  $img_info[1])
  				{
  					$img_size='height:'.$img_info[1].'px';
  					if($img_info[1] > 150)
  					$img_size='height:150px';
  				}
  				else 
  				{
  					$img_size='width:'.$img_info[1].'px';
  					if($img_info[1] > 200)
  					$img_size='width:200px';
  				}
  				
				$str=str_ireplace($v, '<img class="lazy" style="'.$img_size.'" onclick="win_img_open(this)" data-original="base/fun/show_img/date/'.$date.'/id/'.$id.'">', $str); 
			}
		}
		
		return $str;
    }
    
    /**
     * 
     * 获取查询参数
     * @param $data_get GET数组
     */
    public function get_url_param_of_data_get($data_get = array())
    {
    	$url_param = '';
    	if(count($data_get) > 0)
		{
			foreach ($data_get as $k=>$v) {
				switch($k)
				{
					case 'flag_select':
					case 'fun_select':
					case 'fun_open':
					case 'fun_open_id':
						
						break;
					default:
						$url_param .= '/'.$k.'/'.$v;
				}
			}
		}
		return $url_param;
    }
    
    /**
     * 
     * 获取查询条件
     * @param $data_search 条件数组
     * @param $arr_search 查询数组
     */
    public function get_where_of_data_search($data_search,$arr_search)
    {
    	if(is_array($data_search) && count($data_search)>0)
		{
			foreach ($data_search as $k=>$v) {
				
				$v['value']=element('value', $v);
				$v['value']=trim($v['value']);
				
				//是否存在值
				if( empty($v['value']) && $v['value'] != '0') continue;
				
				//存在重复条件
				if(isset($data_search[$k-1])
				&& ! empty($data_search[$k-1]['value'])
				&& $data_search[$k-1]['field']==$v['field'])
				{
					$arr_search['where'].='';
				}
				else 
				{
					$arr_search['where'].=' and (';
				}
				
				if( ! empty(element('m_link_content', $v)) )
				{
					if( element('table', $v))
					$arr_search['where'].=''.$v['table'].'.';
					
					$arr_search['where'].=$v['m_link']." in (select op_id from sys_link where op_field =? AND content = ? AND link_id in ? ) ";
					
					if( ! empty($v['field_r']) )
					$arr_search['value'][]=$v['field_r'];
					else
					$arr_search['value'][]=$v['field'];
					
					$arr_search['value'][]=$v['m_link_content'];
					$arr_search['value'][]=explode(',', $v['value']);
				}
				else if( ! empty(element('m_link', $v)) )
				{
					if( element('table', $v))
					$arr_search['where'].=''.$v['table'].'.';
					
					$arr_search['where'].=$v['m_link']." in (select op_id from sys_link where op_field =? AND link_id in ? ) ";
					
					if( ! empty($v['field_r']) )
					$arr_search['value'][]=$v['field_r'];
					else
					$arr_search['value'][]=$v['field'];
					
					$arr_search['value'][]=explode(',', $v['value']);
				}
				else if( $v['rule'] == 'find_in_set')
				{
					if( ! empty($v['field_r']) )
					$v['field']=$v['field_r'].' ';
					
					if(isset($v['table']) && $v['table'])
					$v['field']=$v['table'].'.'.$v['field'];
					
					$arr_tmp=explode(',', $v['value']);
					if(count($arr_tmp) > 0)
					{
						$arr_search['where'].='(' ; 
						foreach ($arr_tmp as $v1) {
							$arr_search['where'].= ' FIND_IN_SET(?,'.$v['field'].') OR';
							$arr_search['value'][]=$v1;
						}
						$arr_search['where']=trim($arr_search['where'],'OR');
						$arr_search['where'].=')' ;
					}
				}
				else
				{
					if(isset($v['table']) && $v['table'])
					$arr_search['where'].=$v['table'].'.';
					
					if( ! empty($v['field_r']) )
					$arr_search['where'].=$v['field_r'].' ';
					else
					$arr_search['where'].=$v['field'].' ';
					
					if($v['rule']=='like' || $v['rule']=='not like')
					{
						$arr_search['where'].=$v['rule']."'%".$this->m_base->escape_like_str($v['value'])."%'";
					}
					elseif($v['rule']=='in' || $v['rule']=='not in')
					{
						$arr_search['where'].=$v['rule']." ? ";
						$arr_search['value'][]=explode(',', $v['value']);
					}
					elseif( ! empty($v['rule']) )
					{
						$arr_search['where'].=$v['rule']." ? ";
						$arr_search['value'][]=$v['value'];
					}
					
				}
				
				//存在重复条件
				if(isset($data_search[$k+1])
				&& ! empty($data_search[$k+1]['value'])
				&& $data_search[$k+1]['field']==$v['field'])
				{
					$arr_search['where'].=' or ';
				}
				else 
				{
					$arr_search['where'].=' ) ';
				}
			}
		}
		
		return $arr_search;
    }
    /**
     * 
     * 获取索引个性化配置
     * @param $data_out 输出数组
     */
    public function get_person_conf_index($data_out)
    {
    	//索引个性化配置
		$path_conf_person=PATH_PERSON_CONF.'/index/'.$data_out['url'].'/'.$this->sess->userdata('a_login_id');
		
		$conf_person=array();
		if(file_exists($path_conf_person))
		{
			$conf_person=json_decode(file_get_contents($path_conf_person),TRUE);
		}
		
		$data_out['columns']=element('columns', $conf_person);
		$data_out['frozenColumns']=element('frozenColumns', $conf_person);
		$data_out['sort']=element('sort', $conf_person);
		$data_out['order']=element('order', $conf_person);
		$data_out['no_page']=element('no_page', $conf_person);
		
		//查询个性化配置
		$path_conf_person=PATH_PERSON_CONF.'/search/'.$data_out['url'].'/'.$this->sess->userdata('a_login_id');
		
		$conf_person=array();
		if(file_exists($path_conf_person))
		{
			$conf_person=json_decode(file_get_contents($path_conf_person),TRUE);
		}
		$data_out['conf_search']=element('search', $conf_person);
		
		return $data_out;
    }
    
	/**
      * 
      * 根据规则显示数值
      * @param arr
      */
    public function show_by_rule($arr,$v,$arr_v)
    {
    	$m=$arr['m'];
    	$f=$arr['f'];
    	
    	if($m=='m_base')
    	return $this->$f($v,$arr_v);
    	else
    	return $this->$m->$f($v,$arr_v);
    }
    
	/**
	 * 
	 * 根据条件返回数据
	 * @param $table
	 * @param $field
	 * @param $where
	 * @param $value
	 * @param $flag_arr 
	 */
    public function get_field_where($table,$field,$where,$value=array(),$flag_arr=NULL)
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$data_db=array();//数据库数组
		$arr_search=array();
		$rtn='';//结果
		
		if($flag_arr)
		$rtn = array();
		
		/************变量赋值*****************/
		$arr_search['field']=$field;
    	$arr_search['from']=$table;
		$arr_search['where']=$where;
		$arr_search['value']=$value;
		
		$arr_search['rows'] = 2;
		if( ! $flag_arr )
		$arr_search['rows'] = 0;
    	$rs=$this->m_db->query($arr_search);
    	
    	if(count($rs['content'])>0)
    	{
    		if( ! $flag_arr )
    		$rtn=$rs['content'][0][$field];
    		else 
    		{
    			foreach ($rs['content'] as $v) {
    				
    				$rtn[]=$v[$field];
    			}
    		}
    	}
    	/************返回数据*****************/
		return $rtn;
    }
    
	/**
	 * 
	 * 根据c_id 返回c_name[c_login_id]
	 * @param $table
	 * @param $field
	 * @param $where
	 */
    public function get_c_show_by_cid($c_id)
    {
    	/************模型载入*****************/
    	
    	/************变量初始化****************/
		$data_db=array();//数据库数组
		$arr_search=array();
		$rtn='';//结果
		
		/************变量赋值*****************/
		$arr_search['field']='c_name,c_login_id,c_tel';
    	$arr_search['from']='sys_contact';
		$arr_search['where']=" AND c_id = ? ";
		$arr_search['value'][]=$c_id;
		$arr_search['rows'] = 1;
    	$rs=$this->m_db->query($arr_search);
    	
    	if(count($rs['content'])>0)
    	{
    		$rtn=$rs['content'][0]['c_name'];
    		if($rs['content'][0]['c_login_id'])
    		$rtn.='['.$rs['content'][0]['c_login_id'].']';
    		elseif($rs['content'][0]['c_tel'])
    		$rtn.='['.$rs['content'][0]['c_tel'].']';
    	}
    	
    	/************返回数据*****************/
		return $rtn;
    }
    
	/**
     * 
     * 获取树形路径
     * @param $table 表名
     * @param $op_id 表主键ID
     * @param $p_id  parent_id
     * @param $p_id_value parent_id的值
     */
    public function get_parent_path($table,$op_id,$p_id,$p_id_value)
    {
    	$parent=$p_id_value;
    	$path='';
    	while( $parent != 'base' )
    	{
    		$arr_search['field']=$op_id.','.$p_id;
			$arr_search['from']=$table;
			$arr_search['where']='AND '.$op_id.' = ? ';
			$arr_search['value']=array();
			$arr_search['value'][]=$parent;
			$rs=$this->m_db->query($arr_search);
			
			$rs['content']=current($rs['content']);
			
			if( ! is_array($rs['content']) || empty(element($op_id, $rs['content'])) )
			{
				$parent='base';
			}
			else 
			{
				$path=$rs['content'][$op_id].','.$path;
				$parent=$rs['content'][$p_id];
			}
    	}
    	
    	return trim($path,',');
    }
    
    /**
     * 
     * 获取数据表格变更情况
     * @param $pk_field 
     * @param $data_change 
     * @param $data_old 
     */
    public function get_datatable_change($pk_field,$data_change,$data_old,$m=Null,$fun=Null)
    {
    	$rtn=array();
    	
    	$data_change=json_decode($data_change,TRUE);
    	$data_old=json_decode($data_old,TRUE);
    	
    	if(count($data_old) > 0)
    	{
    		foreach ($data_old as $k=>$v) {
    			unset($data_old[$k]);
    			$data_old[$v[$pk_field]] = $v;
    		}
    	}
    	
    	if(count( $data_change ) > 0 )
		{
			foreach ($data_change as $v) {

				if(isset($v[$pk_field]) && isset($data_old[$v[$pk_field]]))
				{
					foreach ($v as $f=>$val) {
						if( element($f, $data_old[$v[$pk_field]]) !=  $val)
						{
							$rtn[]=array(
							'id' => $v[$pk_field],
							'field' => $f,
							'act' => STAT_ACT_EDIT,
							'value_old' => element($f, $data_old[$v[$pk_field]]),
							'err_msg'=>'变更前:'.element($f, $data_old[$v[$pk_field]])
							);
							
							if( $m && $fun)
							{
								array_pop($rtn); 
								$v[$f] = element($f, $data_old[$v[$pk_field]]);
								$arr_tmp = $this->$m->$fun($v[$pk_field],$f,$v);
								if( $arr_tmp ) $rtn[] = $arr_tmp;
							}
						}
					}
					unset($data_old[$v[$pk_field]]);
				}
				else
				{
					$v['act']=STAT_ACT_CREATE;
					$rtn[]=array(
					'id' => $v[$pk_field],
					'act' => STAT_ACT_CREATE,
					'row' => $v
					);
				}
			}
		}
		
		if(count( $data_old ) > 0 )
		{
			foreach ($data_old as $k=>$v) {
				$v['act'] = STAT_ACT_REMOVE;
				$rtn[]=array(
				'id' => $v[$pk_field],
				'act' => STAT_ACT_REMOVE,
				'row' =>$v
				);
			}
		}
		
		return $rtn;
    }
    
    /**
     * 
     * 获取数据表格保存
     * @param $pk_field 
     * @param $data_change 
     * @param $data_old 
     */
    public function save_datatable($table,$json_save,$json_db,$arr_save=array(),$m=Null,$fun=Null,$type=NULL)
    {
    	$list_save = json_decode($json_save,TRUE);
		$list_db = json_decode($json_db,TRUE);

		 //读取表结构
        $this->config->load('db_table/'.$table, FALSE,TRUE);
        $table_form=$this->config->item($table);
        
		$pk_id = current($table_form['primary_key']);
		
		if(count( $list_db ) > 0 )
		{
			foreach ($list_db as $k=>$v) {
				unset($list_db[$k]);
				$list_db[$v[$pk_id]]=$v;
			}
		}

		if(count( $list_save ) > 0 )
		{
			$this->m_table_op->load($table);
			foreach ($list_save as $v) {

				//已删除数据
				if( element('act', $v) == STAT_ACT_REMOVE )
				continue;
				
				$data_save[$table]=$v;
				
				if( ! empty($arr_save) )
				$data_save[$table] = array_merge($v,$arr_save);
				
				if( $m && $fun && ! $type)
				$data_save[$table] = $this->$m->$fun($data_save[$table]);
				
				if(isset($v[$pk_id]) && isset($list_db[$v[$pk_id]]))
				{
					if( $m && $fun && $type == 'act')
					$this->$m->$fun($data_save[$table],STAT_ACT_EDIT);
					else
					$this->m_table_op->update($data_save[$table]);

					unset($list_db[$v[$pk_id]]);
				}
				else
				{
					if( $m && $fun && $type == 'act')
					$this->$m->$fun($data_save[$table],STAT_ACT_CREATE);
					else
					$this->m_table_op->add($data_save[$table]);
				}
			}
		}
		
		if(count( $list_db ) > 0 )
		{
			$this->m_table_op->load($table);
			foreach ($list_db as $k=>$v) {
				if( $m && $fun && $type == 'act')
				$this->$m->$fun(array($pk_id=>$k),STAT_ACT_REMOVE);
				else
				$this->m_table_op->del($k);
			}
		}
    }
    
     /**
     * 
     * 获取区域名称
     * @param $area_id 
     */
    public function get_area_show($area_id,$parent_id = 'main')
    {
    	if( ! $area_id) return ;
    	
    	$path=str_replace('\\', '/', APPPATH).'config/china_area/'.$parent_id;
    	$arr = array();
    	
    	if(file_exists($path))
    	{
	    	$json = file_get_contents($path);
	    	
	    	$arr = json_decode($json,TRUE);
    	}
    	
    	$area_show = '';
    	
    	if(count($arr) && $area_id)
    	{
    		foreach ($arr as $v) {
    			
    			if( $v['area_id'] == $area_id )
    			{
    				$area_show = $v['name'];
    				break;
    			}
    			
    		}
    	}
    	
    	return $area_show;
    }
}