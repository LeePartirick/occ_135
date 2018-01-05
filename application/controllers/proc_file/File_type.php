<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 文件属性管理
 * @author 李怡昕
 *
 */
class File_type extends CI_Controller {

	
	public function __construct()
    {
        parent::__construct();
        $this->load->model('proc_file/m_file_type');
        $this->load->model('proc_file/m_proc_file');
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
		
		$data_out['title']='文件属性索引';
		$data_out['time']=time();
		if( ! empty(element('time', $data_get)) )
		$data_out['time']=element('time', $data_get);
		
		$data_out['url']='proc_file-file_type-index';
		
		$data_out['field_search_start']='f_t_name,f_t_parent,f_t_proc,f_t_check,f_t_note';
		$data_out['field_search_rule_default']='{"field":"f_t_name","field_s":"属性名称","table":"sys_file_type","value":"","rule":"like","group":"search","editor":"text"}';
		$data_out['field_search_rule']='
		{"id":"f_t_name","text":"属性名称","rule":{"field":"f_t_name","field_s":"属性名称","table":"sys_file_type","value":"'.element('f_t_name',$data_get).'","rule":"like","group":"search","editor":"text"}},
		{"id":"f_t_proc","text":"适用子系统","rule":{"field":"f_t_proc","field_r":"f_t_id","m_link":"f_t_id","field_s":"适用子系统","table":"sys_file_type","value":"'.element('f_t_proc',$data_get).'","rule":"=","group":"search",
		 "editor":{
			"type":"combobox",
			"options":{
				"hasDownArrow":"",
				"panelHeight":"0",
				"start_fun":"load_f_t_proc_search'.$data_out['time'].'()"
			}
		}}},
		{"id":"f_t_check","text":"相关验证","rule":{"field":"f_t_check","field_s":"相关验证","table":"","value":"'.element('f_t_check',$data_get).'","rule":"in","group":"search","editor":{
        	"type":"combotree",
				"options":{
				"valueField": "id",
				"textField": "text",
				"panelHeight":"auto",
				"panelMaxHeight":"200",
				"panelWidth":"200",
				"multiple":"true",
				"data":['.get_json_for_arr($GLOBALS['m_file_type']['text']['f_t_check']).']
				}
        }}},
		{"id":"f_t_parent","text":"上级属性","rule":{"field":"f_t_parent","field_s":"上级属性","table":"sys_file_type","value":"'.element('f_t_parent',$data_get).'","rule":"=","group":"search",
		 "editor":{
			"type":"combobox",
			"options":{
				"hasDownArrow":"",
				"panelHeight":"0",
				"start_fun":"load_f_t_parent_search'.$data_out['time'].'()"
			}
		}}},
		{"id":"f_t_note","text":"备注","rule":{"field":"f_t_note","field_s":"备注","table":"sys_file_type","value":"'.element('f_t_note',$data_get).'","rule":"like","group":"search","editor":"text"}},
        ';
		
		$data_out['field_search_value_dispaly']= array(
		);
		$data_out['field_search_value_dispaly']=json_encode($data_out['field_search_value_dispaly']);
		
		$data_out=$this->m_base->get_person_conf_index($data_out);
		
		/************载入视图 ****************/
		$arr_view[]='proc_file/file_type/index';
		$arr_view[]='proc_file/file_type/index_js';
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
			$arr_search['sort']='f_t_sn';
			$arr_search['order']='asc';
		}

		$arr_search['where']='';
		$arr_search['value']=array();
		/************查询条件*****************/

		if( element('search_f_t_proc', $data_get) )
		{
			$arr_search['where'].=' AND f_t_id IN ( select op_id from sys_link where op_table = ? AND content = ? AND link_id = ? ) ';
			$arr_search['value'][] = 'sys_file_type';
			$arr_search['value'][] = 'f_t_proc';
			$arr_search['value'][] = element('search_f_t_proc', $data_get);
		}
		
		$arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);
		
		if( element('flag_tree',$data_get) == 1)
		{
			$tree_id=$this->input->post('id');
			if( ! empty($tree_id) )
			{
				$arr_search['where'].=' AND f_t_parent = ? ';
				$arr_search['value'][] =  fun_urldecode($tree_id);
			}
			else
			{
				$arr_search['where'].=' AND f_t_parent = ? ';
				$arr_search['value'][] =  'base';
			}
		}

		if( $query )
		{
			if( ! $field_q ) $field_q="f_t_name";

			if( ! $field_s ) $field_s=$field_q;

			$arr_search['where'].=" AND CONCAT({$field_q}) like '%".$this->m_base->escape_like_str($query)."%'";
		}

		$arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);
		/************数据查询*****************/
		$arr_field_search=array(
			'f_t_name',
			'f_t_parent',
			'f_t_check',
			'f_t_note'
		);

		if($query)
		{
			$arr_field_search = explode(',', $field_s);
		}
		
		$arr_field_search[]='f_t_id';

		$arr_search['field']=implode(',', $arr_field_search);

		$arr_search['from']='sys_file_type';

		$rs=$this->m_db->query($arr_search);

		$arr_field_search[]='f_t_proc';
		$arr_field_search[]='f_t_proc_s';
		/************json拼接****************/

		if (count($rs['content']) > 0)
		{
			foreach($rs['content'] as $k => $v)
			{
				$row_f='';

				$arr_search_link=array();
				$arr_search_link['rows']=0;
				$arr_search_link['field']='link_id,p_name,p_id';
				$arr_search_link['from']='sys_link l
										  LEFT JOIN sys_proc p ON
										  (p.p_id=l.link_id)';
				$arr_search_link['where']=" AND op_id = ? AND op_table = ? AND op_field = ? AND content = ?";
				$arr_search_link['value'][]=$v['f_t_id'];
				$arr_search_link['value'][]='sys_file_type';
				$arr_search_link['value'][]='f_t_id';
				$arr_search_link['value'][]='f_t_proc';
				$rs_link=$this->m_db->query($arr_search_link);

				$v['f_t_proc']='';
				$v['f_t_proc_s']='';

				if(count($rs_link['content'])>0)
				{
					foreach ( $rs_link['content'] as $v1 ) {
						$v['f_t_proc'].=$v1['link_id'];
						$v['f_t_proc_s'].=$v1['p_name'].',';
//						if( $v1['p_id'] )
//							$v['f_t_proc_s'].='['.$v1['p_id'].'],';
					}
					$v['f_t_proc']=trim($v['f_t_proc'],',');
					$v['f_t_proc_s']=trim($v['f_t_proc_s'],',');
				}

				foreach ($arr_field_search as $f) {
					switch($f){
						case 'f_t_parent':

							$v['f_t_parent_s']=$this->m_base->get_field_where('sys_file_type','f_t_name',"AND f_t_id = '".element($f,$v)."'");
							$row_f.='"'.$f.'_s":"'.fun_urlencode($v['f_t_parent_s']).'",';

							if( element('flag_tree',$data_get) )
							{
								if( element($f,$v) != 'base')
									$row_f.='"_parentId":"'.fun_urlencode(element($f,$v)).'",';

								$row_f.='"state":"closed","iconCls":"tree-folder",';

							}
							break;
						default:
							if(isset($GLOBALS['m_file_type']['text'][$f]) && isset($GLOBALS['m_file_type']['text'][$f][$v[$f]]) )
								$v[$f]=$GLOBALS['m_file_type']['text'][$f][$v[$f]];
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
				.',"title":"文件属性列表"'
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
		$this->m_file_type->load();
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
				'f_t_name',
				'f_t_parent',
				'f_t_note'
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
						case 'f_t_parent':
							$value=trim($value);
							$arr_post['content']['f_t_parent_s']=$value;
							$value=$this->m_base->get_field_where('sys_file_type','f_t_id'," AND f_t_name = '{$value}'");
							break;
					}
					
					$arr_post['content'][$v] = $value;
					$col_num++;
				}
				
				$arr_post['btn']='save';
				$arr_rtn=$this->m_file_type->load($arr_get,$arr_post);
				
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
		$data_out['title']='文件属性';

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
		$json_save=$this->input->post('json_save');
		
		$arr_save = array();
		
		if($json_save)
		$arr_save = json_decode($json_save,TRUE);
		
		$time_start=time();
		/************处理事件*****************/
		
		$list=explode(',', $list);
		
		if(count($list) > 0)
		{
			if( $btn == 'sort' )
			{
				//清空排序
				$this->m_file_type->clear_f_t_sn($list);
				
				$btn='save';
			}
		
			foreach ($list as $k => $v) {
					
				$arr_get=array();
				
				$arr_get['f_t_id']=$v;
				$arr_get['act']=STAT_ACT_EDIT;
				$arr_post=array();
				$arr_post['btn']=$btn;
				$arr_post['flag_more']=TRUE;
				$arr_post['content']=array();
				
				$arr_post= array_merge($arr_post,$arr_save);
				
				$arr_rtn=$this->m_file_type->load($arr_get,$arr_post);
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
					$rtn['json_save'] = $arr_save;
					echo json_encode($rtn);
					exit;
				}
			}
		}
		
		$rtn['rs']=TRUE;
		$rtn['list']=array();
		$rtn['msg_err']=$msg_err;
		$rtn['json_save'] = $arr_save;
			
		/************返回结果 *****************/
		echo json_encode($rtn);;
		exit;
		
	}

	/**
	 *
	 * 文件属性树
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

			$arr_get['f_t_id']=$this->input->post('f_t_id');

			$arr_get['act']=STAT_ACT_EDIT;
			$arr_post=array();
			$arr_post['btn']='save';
			$arr_post['flag_more']=TRUE;
			$arr_post['content']['f_t_parent']=$this->input->post('f_t_parent');
			
			if( ! $arr_post['content']['f_t_parent'])
			$arr_post['content']['f_t_parent']='';
			
			$arr_rtn=$this->m_file_type->load($arr_get,$arr_post);
			
			if( ! isset($arr_rtn['rtn']) )
				$arr_rtn['rtn'] = $arr_rtn['result'];

			echo json_encode($arr_rtn);
			exit;
		}
		/************模板赋值***********/
		$data_out['title']='文件属性树';
		$data_out['time']=time();
		if( ! empty(element('time', $data_get)) )
			$data_out['time']=element('time', $data_get);

		$data_out['flag_select']=element('flag_select', $data_get);
		$data_out['fun_select']=element('fun_select', $data_get);

		$data_out['fun_open']=element('fun_open', $data_get);
		$data_out['fun_open_id']=element('fun_open_id', $data_get);
		/************载入视图 ****************/
		$arr_view[]='proc_file/file_type/win_tree';
		$arr_view[]='proc_file/file_type/win_tree_js';
		$this->m_view->load_view($arr_view,$data_out);
	}
	
	/**
	 * index
	 */
	public function main()
	{
		/************变量初始化****************/
		$data_out=array();//输出数组
		$arr_view=array();//视图数组
		$data_post=array();//输出数组
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		/************事件处理*****************/
		
		/************模板赋值***********/
		$data_out['title']='文件属性管理';
		$data_out['time']=time();
		/************载入视图 ****************/
		$arr_view[]='proc_file/file_type/main';
		$arr_view[]='proc_file/file_type/main_js';
		$this->m_view->load_view($arr_view,$data_out);
	}
}
