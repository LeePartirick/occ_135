<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 开票回款计划
 * @author 朱明
 *
 */
class Bp extends CI_Controller {

	
	public function __construct()
    {
        parent::__construct();
        $this->load->model('proc_gfc/m_bp');
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
		
		/************事件处理*****************/
		if(element('gfc_org_jia', $data_get))
		$data_get['gfc_org_jia_s'] = $this->m_base->get_field_where('sys_org','o_name'," AND o_id = '{$data_get['gfc_org_jia']}'");
		
		/************模板赋值***********/
		$data_out['flag_select']=element('flag_select', $data_get);
		$data_out['fun_select']=element('fun_select', $data_get);
		
		$data_out['fun_open']=element('fun_open', $data_get);
		$data_out['fun_open_id']=element('fun_open_id', $data_get);
		
		$data_out['flag_bs']=element('flag_bs', $data_get);
		$data_out['flag_bill']=element('flag_bill', $data_get);
		
		$data_out['title']='开票回款计划索引';
		$data_out['time']=time();
		if( ! empty(element('time', $data_get)) )
		$data_out['time']=element('time', $data_get);
		
		$data_out['url']='proc_gfc-bp-index';
		
		$data_out['field_search_start']='gfc_finance_code,gfc_c,gfc_org_jia';
		
		if($data_out['flag_bs']) $data_out['field_search_start'].= ',bp_time_back_start,bp_time_back_end';
		if($data_out['flag_bill']) $data_out['field_search_start'].= ',bp_time_start,bp_time_end';
		
		$data_out['field_search_rule_default']='{"field":"gfc_finance_code","field_s":"财务编号","table":"","value":"'.element('gfc_finance_code',$data_get).'","rule":"like","group":"search","editor":"text"}';
		$data_out['field_search_rule']='
		{"id":"gfc_finance_code","text":"财务编号","rule":{"field":"gfc_finance_code","field_s":"财务编号","table":"","value":"'.element('gfc_finance_code',$data_get).'","rule":"like","group":"search","editor":"text"}}
		,{"id":"gfc_c","text":"项目负责人","rule":{"field":"gfc_c","field_s":"项目负责人","table":"","value":"'.element('gfc_c',$data_get).'","rule":"=","group":"search","editor":{
			"type":"combobox",
			"options":{
				"hasDownArrow":"",
				"panelHeight":"0",
				"start_fun":"load_c_search'.$data_out['time'].'()"
			}
		}}}
		,{"id":"gfc_org_jia","text":"甲方单位","rule":{"field":"gfc_org_jia","field_s":"甲方单位","table":"","value":"'.element('gfc_org_jia',$data_get).'","value_s":"'.element('gfc_org_jia_s',$data_get).'","rule":"in","group":"search","editor":{
        	"type":"combobox",
				"options":{
				"hasDownArrow":"",
				"panelHeight":"0",
				"start_fun":"load_org_search'.$data_out['time'].'()"
				}
        }}}
        ,{"id":"bp_time_start","text":"预计开票时间(>)","rule":{"field":"bp_time_start","field_s":"预计开票时间(>)","field_r":"bp_time","table":"","value":"'.element('bp_time_start',$data_get).'","rule":">=","group":"search","editor":{
			"type":"datebox",
			"options":{
			}
		}}}
		,{"id":"bp_time_end","text":"预计开票时间(<)","rule":{"field":"bp_time_start","field_s":"预计开票时间(<)","field_r":"bp_time","table":"","value":"'.element('bp_time_end',$data_get).'","rule":"<=","group":"search","editor":{
			"type":"datebox",
			"options":{
			}
		}}}
        ,{"id":"bp_time_back_start","text":"预计回款时间(>)","rule":{"field":"bp_time_back_start","field_s":"预计回款时间(>)","field_r":"bp_time_back","table":"","value":"'.element('bp_time_back_start',$data_get).'","rule":">=","group":"search","editor":{
			"type":"datebox",
			"options":{
			}
		}}}
		,{"id":"bp_time_back_end","text":"预计回款时间(<)","rule":{"field":"bp_time_back_end","field_s":"预计回款时间(<)","field_r":"bp_time_back","table":"","value":"'.element('bp_time_back_end',$data_get).'","rule":"<=","group":"search","editor":{
			"type":"datebox",
			"options":{
			}
		}}}
		';
		
		$data_out['field_search_value_dispaly']= array(
		);
		$data_out['field_search_value_dispaly']=json_encode($data_out['field_search_value_dispaly']);
		
		$data_out=$this->m_base->get_person_conf_index($data_out);
		
		/************载入视图 ****************/
		$arr_view[]='proc_gfc/bp/index';
		$arr_view[]='proc_gfc/bp/index_js';
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

		$this->load->model('proc_gfc/m_bp');
		
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
			$arr_search['sort']='bp_time';
			$arr_search['order']='desc';
		}

		$arr_search['where']='';
		$arr_search['value']=array();
		/************查询条件*****************/
		
		if( ! empty(element('flag_bs', $data_get)))
		{
			$arr_search['sort']=array('bp_sum_kp','bp_time');
			$arr_search['order']=array('asc','desc');
			
			$arr_search['where']=" AND (gfc_finance_code != '' AND gfc_finance_code IS NOT NULL) AND bp_sum_hk < bp_sum";
		}
		
		if( ! empty(element('flag_bill', $data_get)))
		{
			$arr_search['sort']=array('bp_sum_kp','bp_time');
			$arr_search['order']=array('asc','desc');
			
			$arr_search['where']=" AND (gfc_finance_code != '' AND gfc_finance_code IS NOT NULL) AND bp_sum_kp < bp_sum";
		}
		
		if( ! empty(element('search_gfc_id', $data_get)))
		{
			$arr_search['where']=" AND gfc_id = ?";
			$arr_search['value'][]=$data_get['search_gfc_id'];
		}

		if( $query )
		{
			if( ! $field_q ) $field_q="gfc_finance_code";

			if( ! $field_s ) $field_s=$field_q;

			$arr_search['where'].=" AND CONCAT({$field_q}) like '%".$this->m_base->escape_like_str($query)."%'";
		}

		$arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);
		/************数据查询*****************/
		$arr_field_search=array(
			'bp_time',
			'bp_time_back',
			'bp_type',
			'bp_sum',
			'bp_sum_kp',
			'bp_sum_hk',
			'bp_note',
			'bp.gfc_id',
			'gfc_name',
			'gfc_finance_code',
			'gfc_org_jia',
			'gfc_c',
		);

		if($query)
		{
			$arr_field_search = explode(',', $field_s);
		}
		
		$arr_field_search[]='bp_id';

		$arr_search['field']=implode(',', $arr_field_search);

		$arr_search['from']='pm_bill_plan bp
							 LEFT JOIN pm_given_financial_code gfc ON
							 (gfc.gfc_id = bp.gfc_id)';

		$rs=$this->m_db->query($arr_search);
		
		/************json拼接****************/

		if (count($rs['content']) > 0)
		{
			foreach($rs['content'] as $k => $v)
			{
				$row_f='';

				foreach ($arr_field_search as $f) {
					switch($f){
						case 'bp.gfc_id':
							$f = 'gfc_id';
							break;
						case 'gfc_org_jia':
							$row_f.='"'.$f.'_s":"'.fun_urlencode($this->m_base->get_field_where('sys_org','o_name'," AND o_id ='{$v[$f]}'")).'",';
							break;
						case 'gfc_c':
							$row_f.='"gfc_c_s":"'.fun_urlencode($this->m_base->get_c_show_by_cid($v[$f])).'",';
							break;
						default:
							if(isset($GLOBALS['m_bp']['text'][$f]) && isset($GLOBALS['m_bp']['text'][$f][$v[$f]]) )
								$v[$f]=$GLOBALS['m_bp']['text'][$f][$v[$f]];
					}

					$row_f.='"'.$f.'":"'.fun_urlencode(element($f,$v)).'",';
				}
				
				if(element('bp_time', $v))
				$v['bp_show'] = $v['bp_type'].','.$v['bp_sum'].','.$v['bp_time'];
				
				if(element('bp_time_back', $v))
				$v['bp_show'] = $v['bp_type'].','.$v['bp_sum'].','.$v['bp_time_back'];
				
				$row_f.='"bp_show":"'.$v['bp_show'].'",';
				
				$row_f=trim($row_f,',');

				if( $query )
				{
					$tmp_arr=explode(',', $field_q);

					$value_s='';
					foreach ($tmp_arr as $v1) {
						$value_s.=element($v1,$v).',';
					}
					
					$value_s.=','.$v['bp_show'];
					
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
				.',"title":"开票回款计划索引"'
				.',"msg":"'.$msg.'"'
				.',"rows":['.$rows.']}';
		}

		/************返回数据*****************/
		echo $json;
	}
	
	/**
	 * 计划执行情况
	 * json
	 */
	public function get_bp_final()
	{
		//判断是否ajax请求
		$is_ajax=$this->input->is_ajax_request();
		if( ! $is_ajax) exit;

		/************变量初始化****************/
		//开始时间
		$time_start=time();

		$arr_search=array();

		$rows = '';
		$json = '';
		$msg  = '';
		$rtn = array();

		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));

		$data_post = $this->input->post('content');
		/************查询条件*****************/
		
		$bp_id = element('bp_id', $data_post);
		
		if( ! $bp_id  )
		 exit;
		
		$id = element('id', $data_post);
		/************数据查询*****************/
		 
		$rtn['sum_bp_kp'] = $rtn['sum_bp_kp_no'] = 0;
		
//    	$rtn['sum_bp_kp'] += $this->m_base->get_field_where('pm_bill_plan','bp_sum_kp',
//    					"  AND bp_id != '{$bp_id}' ") ;
    	
    	$rtn['sum_bp_kp_no'] += $this->m_base->get_field_where('fm_bill','sum(bill_sum)',
    					" AND bp_id='{$bp_id}' AND ( ppo > 1 ) AND bill_id != '{$id}' ") ;
    	
		/************json拼接****************/

    	$json = json_encode($rtn);
    	
		//结束时间
		$time_end=time();
		$time=$time_end-$time_start;

		/************返回数据*****************/
		echo $json;
	}
	
	/**
	 * 
	 * 编辑
	 */
	public function edit()
	{
		$this->m_bp->load();
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
				'bp_time',
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
				$arr_rtn=$this->m_bp->load($arr_get,$arr_post);
				
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
		$data_out['title']='开票回款计划';

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
				
				$arr_rtn=$this->m_bp->load($arr_get,$arr_post);
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
