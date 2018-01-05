<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 预算科目
 * @author 朱明
 *
 */
class Subject extends CI_Controller {

	
	public function __construct()
    {
        parent::__construct();
        $this->load->model('proc_bud/m_subject');
        $this->load->model('proc_bud/m_proc_bud');
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
		$data_out['title']='预算科目管理';
		$data_out['time']=time();
		/************载入视图 ****************/
		$arr_view[]='proc_bud/subject/main';
		$arr_view[]='proc_bud/subject/main_js';
		$this->m_view->load_view($arr_view,$data_out);
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
		
		$data_out['title']='预算科目索引';
		$data_out['time']=time();
		$data_out['url']='proc_bud-subject-index';
		
		$data_out['field_search_start']='sub_code,sub_name,sub_class,sub_type,sub_parent,sub_tag';
		$data_out['field_search_rule_default']='{"field":"sub_name","field_s":"科目名称","table":"fm_subject","value":"","rule":"like","group":"search","editor":"text"}';
		$data_out['field_search_rule']='
		{"id":"sub_code","text":"科目编号","rule":{"field":"sub_code","field_s":"科目编号","table":"fm_subject","value":"'.element('sub_code',$data_get).'","rule":"like","group":"search","editor":"text"}},
		{"id":"sub_name","text":"科目名称","rule":{"field":"sub_name","field_s":"科目名称","table":"fm_subject","value":"'.element('sub_name',$data_get).'","rule":"like","group":"search","editor":"text"}},
		{"id":"sub_parent","text":"上级科目","rule":{"field":"sub_parent","field_s":"上级科目","table":"fm_subject","value":"'.element('sub_parent',$data_get).'","rule":"like","group":"search",
		 "editor":{
			"type":"combobox",
			"options":{
				"hasDownArrow":"",
				"panelHeight":"0",
				"start_fun":"load_sub_parent_search'.$data_out['time'].'()"
			}
		}}},
		{"id":"sub_class","text":"科目分类","rule":{"field":"sub_class","field_s":"科目分类","table":"fm_subject","value":"'.element('sub_class',$data_get).'","rule":"find_in_set","group":"search","editor":{
        	"type":"combotree",
				"options":{
				"valueField": "id",
				"textField": "text",
				"panelHeight":"auto",
				"multiple":"true",
				"data":['.get_json_for_arr($GLOBALS['m_subject']['text']['sub_class']).']
				}
        }}},
        {"id":"sub_type","text":"科目属性","rule":{"field":"sub_type","field_s":"科目属性","table":"fm_subject","value":"'.element('sub_type',$data_get).'","rule":"find_in_set","group":"search","editor":{
        	"type":"combotree",
				"options":{
				"valueField": "id",
				"textField": "text",
				"panelHeight":"auto",
				"multiple":"true",
				"data":['.get_json_for_arr($GLOBALS['m_subject']['text']['sub_type']).']
				}
        }}},
        {"id":"sub_tag","text":"标签","rule":{"field":"sub_tag","field_s":"标签","table":"fm_subject","value":"'.element('sub_tag',$data_get).'","rule":"find_in_set","group":"search","editor":{
        	"type":"combotree",
				"options":{
				"valueField": "id",
				"textField": "text",
				"panelHeight":"auto",
				"multiple":"true",
				"data":['.get_json_for_arr($GLOBALS['m_subject']['text']['sub_tag']).'] 
				}
        }}},
		';

		$data_out['field_search_value_dispaly']= array(
			'sub_class'=>$GLOBALS['m_subject']['text']['sub_class'],
			'sub_type'=>$GLOBALS['m_subject']['text']['sub_type'],
		);
		$data_out['field_search_value_dispaly']=json_encode($data_out['field_search_value_dispaly']);
		
		$data_out=$this->m_base->get_person_conf_index($data_out);
		
		/************载入视图 ****************/
		$arr_view[]='proc_bud/subject/index';
		$arr_view[]='proc_bud/subject/index_js';
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
			$arr_search['sort']='sub_code';
			$arr_search['order']='asc';
		}
		
		$arr_search['where']='';
		$arr_search['value']=array();
		/************查询条件*****************/

		if( element('flag_tree',$data_get) == 1)
		{
			$tree_id=$this->input->post('id');
			if( ! empty($tree_id) )
			{
				$arr_search['where'].=' AND sub_parent = ? ';
				$arr_search['value'][] =  fun_urldecode($tree_id);
			}
			else
			{
				$arr_search['where'].=' AND sub_parent = ? ';
				$arr_search['value'][] =  'base';
			}
		}

		if( $query )
		{
			if( ! $field_q ) $field_q="sub_code,sub_name";

			if( ! $field_s ) $field_s=$field_q;

			$arr_search['where'].=" AND CONCAT({$field_q}) like '%".$this->m_base->escape_like_str($query)."%'";
		}

		$arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);
		/************数据查询*****************/
		$arr_field_search=array(
			'sub_code',
			'sub_name',
			'sub_class',
			'sub_type',
			'sub_parent',
			'sub_note',
			'sub_tag',

		);
		
		if($query)
		{
			$arr_field_search = explode(',', $field_s);
		}
		
		$arr_field_search[]='sub_id';

		$arr_search['field']=implode(',', $arr_field_search);
		
		$arr_search['from']='fm_subject';
		
		$rs=$this->m_db->query($arr_search);
		/************json拼接****************/

		if (count($rs['content']) > 0)
		{
			foreach($rs['content'] as $k => $v)
			{
				$row_f='';
				foreach ($arr_field_search as $f) {
					switch($f){
						case 'sub_parent':

							$v['sub_parent_s']=$this->m_base->get_field_where('fm_subject','sub_name',"AND sub_id = '".element($f,$v)."'");
							$row_f.='"'.$f.'_s":"'.fun_urlencode($v['sub_parent_s']).'",';

							if( element('flag_tree',$data_get) )
							{
								if( element($f,$v) != 'base')
									$row_f.='"_parentId":"'.fun_urlencode(element($f,$v)).'",';

								$row_f.='"state":"closed","iconCls":"tree-folder",';

							}
							break;
						case 'sub_tag':
							$arr_tmp=explode(',', $v[$f]);
							
							$v[$f]='';
							if(count($arr_tmp) > 0)
							{
								foreach ($arr_tmp as $v1) {
									$v[$f].=element($v1, $GLOBALS['m_subject']['text'][$f]).',';
								}
							}
							
							$v[$f]=trim($v[$f],',');
							
							break;
						default:
							if(isset($GLOBALS['m_subject']['text'][$f]) && isset($GLOBALS['m_subject']['text'][$f][$v[$f]]) )
								$v[$f]=$GLOBALS['m_subject']['text'][$f][$v[$f]];
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
				   .',"title":"预算科目列表"'
				   .',"msg":"'.$arr_search['page'].'"'
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
		$this->m_subject->load();
	}

	/**
	 * 科目树
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

			$arr_get['sub_id']=$this->input->post('sub_id');

			$arr_get['act']=STAT_ACT_EDIT;
			$arr_post=array();
			$arr_post['btn']='save';
			$arr_post['flag_more']=TRUE;
			$arr_post['content']['sub_parent']=$this->input->post('sub_parent');

			if( ! $arr_post['content']['sub_parent'])
			$arr_post['content']['sub_parent']='';
			
			$arr_rtn=$this->m_subject->load($arr_get,$arr_post);
			if( ! isset($arr_rtn['rtn']) )
				$arr_rtn['rtn'] = $arr_rtn['result'];

			echo json_encode($arr_rtn);
			exit;
		}
		/************模板赋值***********/
		$data_out['title']='科目树';
		$data_out['time']=time();
		if( ! empty(element('time', $data_get)) )
			$data_out['time']=element('time', $data_get);

		$data_out['flag_select']=element('flag_select', $data_get);
		$data_out['fun_select']=element('fun_select', $data_get);

		$data_out['fun_open']=element('fun_open', $data_get);
		$data_out['fun_open_id']=element('fun_open_id', $data_get);
		/************载入视图 ****************/
		$arr_view[]='proc_bud/subject/win_tree';
		$arr_view[]='proc_bud/subject/win_tree_js';
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
				'sub_name'
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
					}
					
					$arr_post['content'][$v] = $value;
					$col_num++;
				}
				
				$arr_post['btn']='save';
				$arr_rtn=$this->m_subject->load($arr_get,$arr_post);
				
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
				
				if( $time_end-$time_start > 5 )
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
		$data_out['title']='预算科目';
		
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
			foreach ($list as $k => $v) {
					
				$arr_get=array();
				
				$arr_get['sub_id']=$v;
				$arr_get['act']=STAT_ACT_EDIT;
				$arr_post=array();
				$arr_post['btn']=$btn;
				$arr_post['flag_more']=TRUE;
				$arr_post['content']=array();
				
				$arr_post= array_merge($arr_post,$arr_save);
				
				$arr_rtn=$this->m_subject->load($arr_get,$arr_post);
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
