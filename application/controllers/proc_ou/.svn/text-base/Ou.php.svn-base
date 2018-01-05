<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 团队管理
 * @author 朱明
 *
 */
class Ou extends CI_Controller {

	
	public function __construct()
    {
        parent::__construct();
        $this->load->model('proc_ou/m_ou');
        $this->load->model('proc_ou/m_proc_ou');
    }
    
	public function _remap($method, $params = array())
	{
	    if (method_exists($this, $method))
	    {
	        return call_user_func_array(array($this, $method), $params);
	    }
	    
	    redirect('base/main/show_404');
	}
	
	/**
	 * 索引
	 */
	public function index()
	{
		/************变量初始化****************/
		$data_out=array();//输出数组
		$arr_view=array();//视图数组
		$data_post=array();//输出数组
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		
		/************事件处理*****************/
		
		/************模板赋值***********/
		$data_out['flag_select']=element('flag_select', $data_get);
		$data_out['fun_select']=element('fun_select', $data_get);
		
		$data_out['fun_open']=element('fun_open', $data_get);
		$data_out['fun_open_id']=element('fun_open_id', $data_get);
		
		$data_out['title']='团队索引';
		$data_out['time']=time();
		if( ! empty(element('time', $data_get)) )
		$data_out['time']=element('time', $data_get);
		
		$data_out['url']='proc_ou-ou-index';
		
		$data_out['field_search_start']='ou_org,ou_code,ou_name,ou_status,ou_tag';
		$data_out['field_search_rule_default']='{"field":"ou_name","field_s":"团队名称","table":"sys_ou","value":"","rule":"like","group":"search","editor":"text"}';
		$data_out['field_search_rule']='
		{"id":"ou_code","text":"团队编号","rule":{"field":"ou_code","field_s":"团队编号","table":"sys_ou","value":"'.element('ou_code',$data_get).'","rule":"like","group":"search","editor":"text"}},
		{"id":"ou_name","text":"团队名称","rule":{"field":"ou_name","field_s":"团队名称","table":"sys_ou","value":"'.element('ou_name',$data_get).'","rule":"like","group":"search","editor":"text"}},
		{"id":"ou_parent","text":"上级团队","rule":{"field":"ou_parent","field_s":"上级团队","table":"sys_ou","value":"'.element('ou_parent',$data_get).'","rule":"=","group":"search","editor":{
			"type":"combobox",
			"options":{
				"hasDownArrow":"",
				"panelHeight":"0",
				"start_fun":"load_ou_parent_search'.$data_out['time'].'()"
			}
		}}},
		{"id":"ou_org","text":"所属机构","rule":{"field":"ou_org","field_s":"所属机构","table":"sys_ou","value":"'.element('ou_org',$data_get).'","rule":"in","group":"search",
		 "fun_end":"fun_end_ou_org_search'.$data_out['time'].'()",
		 "editor":{
			"type":"combotree",
			"options":{
				"valueField": "id",
				"textField": "text",
				"multiple":"true",
				"panelWidth":"300",
				"panelHeight":"auto",
				"start_fun":"load_ou_org_search'.$data_out['time'].'()"
			}
		}}},
		{"id":"ou_status","text":"状态","rule":{"field":"ou_status","field_s":"状态","table":"sys_ou","value":"'.element('ou_status',$data_get).'","rule":"in","group":"search","editor":{
        	"type":"combotree",
				"options":{
				"valueField": "id",
				"textField": "text",
				"panelHeight":"auto",
				"multiple":"true",
				"data":['.get_json_for_arr($GLOBALS['m_ou']['text']['ou_status']).'] 
				}
        }}},
        {"id":"ou_tag","text":"标签","rule":{"field":"ou_tag","field_s":"标签","table":"sys_ou","value":"'.element('ou_status',$data_get).'","rule":"find_in_set","group":"search","editor":{
        	"type":"combotree",
				"options":{
				"valueField": "id",
				"textField": "text",
				"panelHeight":"auto",
				"multiple":"true",
				"data":['.get_json_for_arr($GLOBALS['m_ou']['text']['ou_tag']).'] 
				}
        }}},
        {"id":"ou_note","text":"备注","rule":{"field":"ou_note","field_s":"备注","table":"sys_ou","value":"'.element('ou_note',$data_get).'","rule":"like","group":"search","editor":"text"}}';
		
		$data_out['field_search_value_dispaly']= array(
			'ou_status'=>$GLOBALS['m_ou']['text']['ou_status'],
			'ou_tag'=>$GLOBALS['m_ou']['text']['ou_tag'],
		);
		$data_out['field_search_value_dispaly']=json_encode($data_out['field_search_value_dispaly']);
		
		$data_out=$this->m_base->get_person_conf_index($data_out);
		
		/************载入视图 ****************/
		$arr_view[]='proc_ou/ou/index';
		$arr_view[]='proc_ou/ou/index_js';
		$this->m_view->load_view($arr_view,$data_out);
	}
	
	/**
	 * json
	 */
	public function get_json()
	{
		//判断是否ajax请求
		$is_ajax=$this->input->is_ajax_request();
		if( ! $is_ajax) exit;
		
		/************变量初始化****************/
		//开始时间
		$time_start=time();
		
		$arr_search=array();
		$data_search=array();
		
		$rows = '';
		$json = '';
		$msg  = '';
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		
		//控件
		$from=element('from', $data_get);
		$field_id=element('field_id', $data_get);
		$field_text=element('field_text', $data_get);
		
		//查询条件
		$data_search=$this->input->post_get('data_search');
		if( ! empty($data_search))
		{
			$data_search=json_decode($data_search,TRUE);
		}
		
		//查询参数
		$query=trim($this->input->post_get('query'));
		$field_q=trim($this->input->post_get('field_q'));
		$field_s=trim($this->input->post_get('field_s'));
		
		//分页
		$arr_search['page']=$this->input->post_get('page');
		$arr_search['rows']=$this->input->post_get('rows');
		
		if( empty($arr_search['rows']) )
		{
			$arr_search['rows'] = 200;
		}
		
		//排序
		$arr_search['order']=$this->input->post_get('order');
		$arr_search['sort']=$this->input->post_get('sort');
		
		if( empty($arr_search['sort']) )
		{
			$arr_search['sort']='ou_code';
			$arr_search['order']='asc';
		}
		
		switch ($arr_search['sort'])
		{
			case 'ou_org_s':
				$arr_search['sort']='ou_org';
				break;
			case 'ou_parent_s':
				$arr_search['sort']='ou_parent';
				break;
		}
		
		$arr_search['where']='';
		$arr_search['value']=array();
		/************查询条件*****************/
		if( element('flag_tree',$data_get) == 1)
		{
			$tree_id=$this->input->post('id');
			if( ! empty($tree_id) )
			{
				$arr_search['where'].=' AND ou_parent = ? ';
				$arr_search['value'][] =  fun_urldecode($tree_id);
			}
			else
			{
				$arr_search['where'].=' AND ou_parent = ? ';
				$arr_search['value'][] =  'base';
			}
		}
		
		if( $query )
		{
			if( ! $field_q ) $field_q="ou_code,ou_name";
			
			if( ! $field_s ) $field_s=$field_q;
			
			$arr_search['where'].=" AND CONCAT({$field_q}) like '%".$this->m_base->escape_like_str($query)."%'";
		}
		
		$arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);
		
		/************数据查询*****************/
		
		$arr_field_search=array(
			'ou_code',
			'ou_name',
			'ou_parent',
			'ou_status',
			'ou_level',
			'ou_class',
			'ou_tag',
			'ou_org',
		);
		
		if($query)
		{
			$arr_field_search = explode(',', $field_s);
		}
		
		$arr_field_search[]='ou_id';
		
		$arr_search['field']=implode(',', $arr_field_search);
		
		$arr_search['from']='sys_ou';
		
		$rs=$this->m_db->query($arr_search);
		
		/************json拼接****************/
		if (count($rs['content']) > 0)
		{
			foreach($rs['content'] as $k => $v)
			{
				$row_f='';
				foreach ($arr_field_search as $f) {
					
					switch ($f)
					{
						case 'ou_parent':
							
							$v['ou_parent_s']=$this->m_base->get_field_where('sys_ou','ou_name',"AND ou_id = '".element($f,$v)."'");
							$row_f.='"'.$f.'_s":"'.fun_urlencode($v['ou_parent_s']).'",';
							
							if( element('flag_tree',$data_get) )
							{
								if( element($f,$v) != 'base')
	        					$row_f.='"_parentId":"'.fun_urlencode(element($f,$v)).'",';
	        					
	        					$row_f.='"state":"closed","iconCls":"tree-folder",';
	        					
							}
	        				
							break;
						case 'ou_tag':
							$arr_tmp=explode(',', $v[$f]);
							
							$v[$f]='';
							if(count($arr_tmp) > 0)
							{
								foreach ($arr_tmp as $v1) {
									$v[$f].=element($v1, $GLOBALS['m_ou']['text'][$f]).',';
								}
							}
							
							$v[$f]=trim($v[$f],',');
							
							break;
						case 'ou_org':
							$row_f.='"ou_org_s":"'.fun_urlencode($this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id ='{$v[$f]}'")).'",';
							break;
						default:
							if(isset($GLOBALS['m_ou']['text'][$f]) && isset($GLOBALS['m_ou']['text'][$f][$v[$f]]) )
							$v[$f]=$GLOBALS['m_ou']['text'][$f][$v[$f]];
							
					}
					
					$row_f.='"'.$f.'":"'.fun_urlencode(element($f,$v)).'",';
					
				}
				
				$row_f=trim($row_f,',');
				
				if( $query )
				{
					$tmp_arr=explode(',', $field_q);
					
					$value_s='';
					foreach ($tmp_arr as $v1) {
						$value_s.=element($v1,$v).',';
					}
					
					$rows.='{"value":"'.trim($value_s,',').'",'
						   .'"data": {'.$row_f.'}},';
				
				}
				elseif($from == 'combobox')
				{
					$row_f.=',"id":"'.$v[$field_id].'","text":"'.$v[$field_text].'"';
					$rows.='{'.$row_f.'},';
				}
				else 
				{
					$rows.='{'.$row_f.'},';
				}
			}
			$rows=trim($rows,',');
		}
		
		//结束时间
		$time_end=time();
		$time=$time_end-$time_start;
		
		if( $query )
		{
			$json.='{"query": "'.$query.'","suggestions":['.$rows.']}';
		}
		elseif($from == 'combobox')
		{
			$json='['.$rows.']';
		}
		else 
		{
			$json.='{"total":"'.$rs['total'].'"'
				   .',"time":"'.$time.'"'
				   .',"title":"团队列表"'
				   .',"msg":"'.$msg.'"'
				   .',"rows":['.$rows.']}';
		}
		
		/************返回数据*****************/
		echo $json;
	}
	
	/**
	 * 
	 * 编辑
	 */
	public function edit()
	{
		$this->m_ou->load();
	}
	
	/**
	 * 树
	 */
	public function win_tree()
	{
		/************变量初始化****************/
		$data_out=array();//输出数组
		$arr_view=array();//视图数组
		$data_post=array();//输出数组
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		$btn=$this->input->post('btn');
		/************事件处理*****************/
		if($btn == 'save')
		{
			$arr_get=array();
				
			$arr_get['ou_id']=$this->input->post('ou_id');
			$arr_get['act']=STAT_ACT_EDIT;
			$arr_post=array();
			$arr_post['btn']='save';
			$arr_post['flag_more']=TRUE;
			$arr_post['content']['ou_parent']=$this->input->post('ou_parent');
			
			if( ! $arr_post['content']['ou_parent'])
			$arr_post['content']['ou_parent']='';
			
			$arr_rtn=$this->m_ou->load($arr_get,$arr_post);
			if( ! isset($arr_rtn['rtn']) )
			$arr_rtn['rtn'] = $arr_rtn['result'];
			
			echo json_encode($arr_rtn);
			exit;
		}
		/************模板赋值***********/
		$data_out['title']='团队树';
		$data_out['time']=time();
		if( ! empty(element('time', $data_get)) )
		$data_out['time']=element('time', $data_get);
		
		$data_out['flag_select']=element('flag_select', $data_get);
		$data_out['fun_select']=element('fun_select', $data_get);
		
		$data_out['fun_open']=element('fun_open', $data_get);
		$data_out['fun_open_id']=element('fun_open_id', $data_get);
		/************载入视图 ****************/
		$arr_view[]='proc_ou/ou/win_tree';
		$arr_view[]='proc_ou/ou/win_tree_js';
		$this->m_view->load_view($arr_view,$data_out);
	}
	
	/**
	 * 
	 * 导入
	 */
	public function import()
	{
		/************载入模型*****************/
		$this->load->model('base/m_excel');
		
		/************变量初始化****************/
		$arr_view = array();//视图数组
		$data_post= array();//$POST数组
		$data_get = array();//$GET 数组
		$data_out = array();//输出数组
		$data_db  = array();//数据库数据
		
		$data_save=array();//数据库保存数组
		$arr_search=array();
		$rtn=array();
		$rtn['rs']=TRUE;
		
		$time_start=time();
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		$id=element('id', $data_get);
		
		$row='';
		$msg_err = $this->input->post('msg_err');
		$num_import = $this->input->post('num_import');
		$row_num = $this->input->post('row_num');
		/************数据处理 *****************/
		
		if($row_num)
		{
			$path_xlsx=str_replace('\\', '/', APPPATH).'upload/'.$id.'.xlsx';
			//xlsx文件是否存在
			if( ! file_exists($path_xlsx) )
			exit;
			
			//读取列定义
			$reader = IOFactory::createReader('Excel2007'); 
			$PHPExcel = $reader->load($path_xlsx); 
			$sheet = $PHPExcel->getSheet(0);
			
			$check_empty=0;
			
			//@todo 导入列
			$col = array(
				'ou_name',
				'ou_class',
	    		'ou_level',
				'ou_org',
	    		'ou_parent',
	    		'ou_note',
	    	);
			
			while (TRUE)
			{
				$arr_get=array();
				$arr_post=array();
				$arr_post['btn']='save';
				$arr_post['flag_more']=TRUE;
				$check_empty=0;
				
				$col_num=0;
				foreach ($col as $v) {
					
					$value = $sheet->getCellByColumnAndRow($col_num, $row_num)->getValue();
					
					if(is_object($value))
					{
						 $value= $value->__toString();
					}
					
					$value = trim($value);
					
					if( empty($value) )
					{
						$check_empty++;
					}
					
					switch ($v) {
						case 'ou_parent':
							$arr_post['content']['ou_parent_s'] = $value;
							
							if($value)
							{
								$arr_search=array();
								$arr_search['field']='ou.ou_id';
								$arr_search['from']='sys_ou ou
													 LEFT JOIN sys_ou org ON
													 (org.ou_id = ou.ou_org)';
								$arr_search['where']=' AND ou.ou_status = ? AND ou.ou_name = ? AND org.ou_name = ? ';
								$arr_search['value'][]=OU_STATUS_RUN;
								$arr_search['value'][]=trim($value);
								$arr_search['value'][]=trim($arr_post['content']['ou_org']);

								$arr_search['rows']='5';
								$rs=$this->m_db->query($arr_search);
								if(count($rs['content']) != 1)
								{
									$msg_err.='第'.$row_num.'行,导入失败！错误为:<br/>上级团队存在多个匹配值！<br/>';
									continue 2;
								}
								else
								{
									$value = $rs['content'][0]['ou_id'];
								}
							}
							
						break;
						case 'ou_status':
							$value = array_search($value,$GLOBALS['m_ou']['text']['ou_status']);
						break;
						case 'ou_level':
							$value = array_search($value,$GLOBALS['m_ou']['text']['ou_level']);
						break;
						case 'ou_class':
							$value = array_search($value,$GLOBALS['m_ou']['text']['ou_class']);
						break;
					}
					
					$arr_post['content'][$v] = $value;
					$col_num++;
				}
				
				$arr_post['btn']='save';
				$arr_rtn=$this->m_ou->load($arr_get,$arr_post);
				
				if( ! element('rtn', $arr_rtn) )
				{
					$msg_err.='第'.$row_num.'行,导入失败！错误为:<br/>'.element('msg_err',$arr_rtn).'<br/>';
				}
				else 
				{
					$num_import++;
				}
				
				//读取完成
				if( $check_empty == count($col) )
				{
					@unlink($path_xlsx);
					$rtn['rs']=TRUE;
					$rtn['row_num']=$row_num;
					$rtn['num_import']=$num_import;
					$rtn['msg_err']=$msg_err;
					echo json_encode($rtn);
					exit;
				}
				
				//防止超时
				$time_end=time();
				
				if( $time_end-$time_start > 15 )
				{
			
					$rtn['rs']=FALSE;
					$rtn['row_num']=$row_num;
					$rtn['num_import']=$num_import;
					$rtn['msg_err']=$msg_err;
					echo json_encode($rtn);;
					exit;
				}
					
				$row_num++;
			}
			
			@unlink($path_xlsx);
			
			$rtn['rs']=TRUE;
			$rtn['row_num']=$row_num;
			$rtn['num_import']=$num_import;
			$rtn['msg_err']=$msg_err;
			
			echo json_encode($rtn);
			exit;
		}
		
		/************模板载入 *****************/
		$data_out['time']=time();
		$data_out['id']=$id;
		$data_out['url']=uri_string();
		$data_out['title']='团队';
		
		/************载入视图 ****************/
		$arr_view[]='base/fun/win_import';
		$arr_view[]='base/fun/win_import_js';
		$this->m_view->load_view($arr_view,$data_out);
	}
	
	/**
	 * 
	 * 批量操作
	 */
	public function fun_operate_more()
	{
		/************变量初始化****************/
		$arr_view = array();//视图数组
		$data_post= array();//$POST数组
		$data_get = array();//$GET 数组
		$data_out = array();//输出数组
		$data_db  = array();//数据库数据
		
		$data_save=array();//数据库保存数组
		$arr_search=array();
		$data_out['op_disable']=array();
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		
		$btn=$this->input->post('btn');
		$list=$this->input->post('list');
		$msg_err=$this->input->post('msg_err');
		
		$time_start=time();
		/************处理事件*****************/
		$list=explode(',', $list);
		if(count($list) > 0)
		{
			foreach ($list as $k => $v) {
					
				$arr_get=array();
				
				$arr_get['ou_id']=$v;
				$arr_get['act']=STAT_ACT_EDIT;
				$arr_post=array();
				$arr_post['btn']=$btn;
				$arr_post['flag_more']=TRUE;
				
				$arr_rtn=$this->m_ou->load($arr_get,$arr_post);
				if( ! isset($arr_rtn['rtn']) )
				$arr_rtn['rtn'] = $arr_rtn['result'];
				
				if( ! $arr_rtn['rtn'] )
				{
					$msg_err.='执行失败！错误为:<br/>'.$arr_rtn['msg_err'].'<br/>';
				}
					
				unset($list[$k]);
				
				//防止超时
				$time_end=time();
				
				if( $time_end-$time_start > 5 )
				{
			
					$rtn['rs']=FALSE;
					$rtn['list']=implode(',', $list);
					$rtn['msg_err']=$msg_err;
					echo json_encode($rtn);;
					exit;
				}
			}
		}
		
		$rtn['rs']=TRUE;
		$rtn['list']=array();
		$rtn['msg_err']=$msg_err;
			
		/************返回结果 *****************/
		echo json_encode($rtn);;
		exit;
		
	}
}
