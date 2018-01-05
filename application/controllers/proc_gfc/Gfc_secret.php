<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 标密申请
 * @author 朱明
 *
 */
class Gfc_secret extends CI_Controller {

	
	public function __construct()
    {
        parent::__construct();
        $this->load->model('proc_gfc/m_gfc_secret');
        $this->load->model('proc_gfc/m_proc_gfc');
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
		
	 	if( empty(element('ppo',$data_get)) ){
            
        	$data_get['ppo'] = '';
        	
        	foreach ($GLOBALS['m_gfc_secret']['text']['ppo'] as $k=>$v) {
        		if($k == 0) continue;
        		
        		$data_get['ppo'] .= $k.',';
        	}
        	
        	$data_get['ppo'] = trim($data_get['ppo'],',');
        }
		/************事件处理*****************/
		
		/************模板赋值***********/
		$data_out['flag_select']=element('flag_select', $data_get);
		$data_out['fun_select']=element('fun_select', $data_get);
		
		$data_out['fun_open']=element('fun_open', $data_get);
		$data_out['fun_open_id']=element('fun_open_id', $data_get);
		
		$data_out['title']='标密申请索引';
		$data_out['time']=time();
		if( ! empty(element('time', $data_get)) )
		$data_out['time']=element('time', $data_get);
		
		$data_out['url']='proc_gfc-gfc_secret-index';
		
		$data_out['field_search_start']='gfc_name,gfcs_name_tm,gfcs_category_secret,gfcs_c_check,ppo';
		$data_out['field_search_rule_default']='{"field":"gfc_name","field_s":"项目名称","table":"","value":"","rule":"like","group":"search","editor":"textbox"}';
		$data_out['field_search_rule']='
		{"id":"gfc_name","text":"项目名称","rule":{"field":"gfc_name","field_s":"项目名称","table":"","value":"'.element('gfc_name',$data_get).'","rule":"like","group":"search","editor":"textbox"}}
		,{"id":"gfcs_name_tm","text":"脱密名称","rule":{"field":"gfcs_name_tm","field_s":"脱密名称","table":"","value":"'.element('gfcs_name_tm',$data_get).'","rule":"like","group":"search","editor":"textbox"}}
		,{"id":"gfcs_category_secret","text":"密级","rule":{"field":"gfcs_category_secret","field_s":"密级","table":"","value":"'.element('gfcs_category_secret',$data_get).'","rule":"in","group":"search","editor":{
			"type":"combotree",
			"options":{
			"valueField": "id",
			"textField": "text",
			"panelHeight":"auto",
			"multiple":"true",
			"data":['.get_json_for_arr($GLOBALS['m_gfc']['text']['gfc_category_secret']).']
			}
		}}}
		,{"id":"gfcs_c_check","text":"审批人","rule":{"field":"gfcs_c_check","field_s":"审批人","table":"","value":"'.element('gfcs_c_check',$data_get).'","rule":"=","group":"search","editor":{
			"type":"combobox",
			"options":{
				"hasDownArrow":"",
				"panelHeight":"0",
				"start_fun":"load_gfcs_c_search'.$data_out['time'].'()"
			}
		}}}
		,{"id":"ppo","text":"流程节点","rule":{"field":"ppo","field_r":"gfcs.ppo","field_s":"流程节点","table":"","value":"'.element('ppo',$data_get).'","rule":"in","group":"search","editor":{
			"type":"combotree",
			"options":{
			"valueField": "id",
			"textField": "text",
			"panelHeight":"auto",
			"multiple":"true",
			"data":['.get_json_for_arr($GLOBALS['m_gfc_secret']['text']['ppo']).']
			}
		}}}
		';
		
		$data_out['field_search_value_dispaly']= array(
			'ppo'=>$GLOBALS['m_gfc_secret']['text']['ppo'],
			'gfcs_category_secret'=>$GLOBALS['m_gfc']['text']['gfc_category_secret']
		);
		$data_out['field_search_value_dispaly']=json_encode($data_out['field_search_value_dispaly']);
		
		$data_out=$this->m_base->get_person_conf_index($data_out);
		
		/************载入视图 ****************/
		$arr_view[]='proc_gfc/gfc_secret/index';
		$arr_view[]='proc_gfc/gfc_secret/index_js';
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
			$arr_search['sort']='gfcs.db_time_create';
			$arr_search['order']='desc';
		}

		$arr_search['where']='';
		$arr_search['value']=array();
		/************查询条件*****************/

		if( $query )
		{
			if( ! $field_q ) $field_q="gfc_name_tm";

			if( ! $field_s ) $field_s=$field_q;

			$arr_search['where'].=" AND CONCAT({$field_q}) like '%".$this->m_base->escape_like_str($query)."%'";
		}

		$arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);
		/************数据查询*****************/
		$arr_field_search=array(
			'gfcs_name_tm',
			'gfcs_category_secret',
			'gfcs_c_check',
			'gfcs.gfc_id',
			'gfcs.ppo',
			'gfc_name'
		);

		if($query)
		{
			$arr_field_search = explode(',', $field_s);
		}
		
		$arr_field_search[]='gfcs_id';

		$arr_search['field']=implode(',', $arr_field_search);

		$arr_search['from']='pm_gfc_secret gfcs
							 LEFT JOIN pm_given_financial_code gfc ON
							 (gfc.gfc_id = gfcs.gfc_id)';

		$rs=$this->m_db->query($arr_search);

		/************json拼接****************/

		if (count($rs['content']) > 0)
		{
			foreach($rs['content'] as $k => $v)
			{
				$row_f='';

				foreach ($arr_field_search as $f) {
					switch($f){
						case 'gfcs.ppo':
							$f = 'ppo';
							$v[$f]=$GLOBALS['m_gfc_secret']['text'][$f][$v[$f]];
							break;
						case 'gfcs_name_tm':
							if( empty($v[$f]) )
							$v[$f] = $v['gfc_name'];//$this->m_base->get_field_where('pm_given_financial_code','gfc_name'," AND gfc_id = '{$v['gfc_id']}'");
							break;
						case 'gfcs_category_secret':
							$v[$f]=$GLOBALS['m_gfc']['text']['gfc_category_secret'][$v[$f]];
							break;
						case 'gfcs_c_check':
							$row_f.='"gfcs_c_check_s":"'.fun_urlencode($this->m_base->get_c_show_by_cid($v[$f])).'",';
							break;
						default:
							if(isset($GLOBALS['m_gfc_secret']['text'][$f]) && isset($GLOBALS['m_gfc_secret']['text'][$f][$v[$f]]) )
								$v[$f]=$GLOBALS['m_gfc_secret']['text'][$f][$v[$f]];
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
		else
		{
			$json.='{"total":"'.$rs['total'].'"'
				.',"time":"'.$time.'"'
				.',"title":"标密申请索引"'
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
		$this->m_gfc_secret->load();
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
				'gfc_name_tm',
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
				$arr_rtn=$this->m_gfc_secret->load($arr_get,$arr_post);
				
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
		$data_out['title']='标密申请';

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
				
				$arr_get['bp_id']=$v;
				$arr_get['act']=STAT_ACT_EDIT;
				$arr_post=array();
				$arr_post['btn']=$btn;
				$arr_post['flag_more']=TRUE;
				$arr_post['content']=array();
				
				$arr_post= array_merge($arr_post,$arr_save);
				
				$arr_rtn=$this->m_gfc_secret->load($arr_get,$arr_post);
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
