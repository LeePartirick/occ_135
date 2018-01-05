<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 回款
 * @author 朱明
 *
 */
class Bs_item extends CI_Controller {

	
	public function __construct()
    {
        parent::__construct();
        $this->load->model('proc_bs/m_bs');
        $this->load->model('proc_bs/m_proc_bs');
        $this->load->model('proc_gfc/m_gfc');
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
		
		$data_out['title']='回款明细索引';
		$data_out['time']=time();
		$data_out['url']='proc_bs-bs_item-index';
		
		$data_out['field_search_start']='bs_code,bs_org_owner,bsi_type,bs_company_out,bs_contact_manager,bs_time_start,bs_time_end,gfc_name,gfc_c,gfc_finance_code';
		$data_out['field_search_rule_default']='{"field":"bs_code","field_s":"编号","table":"fm_back_section","value":"","rule":"like","group":"search","editor":"text"}';
		$data_out['field_search_rule']='
		{"id":"bs_code","text":"编号","rule":{"field":"bs_code","field_s":"编号","table":"fm_back_section","value":"'.element('bs_code',$data_get).'","rule":"like","group":"search","editor":"text"}}
		,{"id":"bs_org_owner","text":"所属机构","rule":{"field":"bs_org_owner","field_s":"所属机构","table":"","value":"'.element('bs_org_owner',$data_get).'","rule":"in","group":"search",
		 "fun_end":"fun_end_ou_org_search'.$data_out['time'].'()",
		 "editor":{
			"type":"combotree",
			"options":{
				"valueField": "id",
				"textField": "text",
				"multiple":"true",
				"panelWidth":"300",
				"panelMaxHeight":"200",
				"panelHeight":"auto",
				"start_fun":"load_ou_org_search'.$data_out['time'].'()"
			}
		}}}
		,{"id":"bsi_type","text":"回款关联","rule":{"field":"bsi_type","field_s":"回款关联","table":"","value":"'.element('bsi_type',$data_get).'","rule":"in","group":"search","editor":{
			"type":"combotree",
			"options":{
			"valueField": "id",
			"textField": "text",
			"panelHeight":"auto",
			"multiple":"true",
			"data":['.get_json_for_arr($GLOBALS['m_bs']['text']['bsi_type']).']
			}
		}}}
		,{"id":"bs_company_out","text":"回款单位","rule":{"field":"bs_company_out","field_s":"回款单位","table":"","value":"'.element('bs_company_out',$data_get).'","rule":"in","group":"search","editor":{
        	"type":"combobox",
				"options":{
				"hasDownArrow":"",
				"panelHeight":"0",
				"start_fun":"load_org_search'.$data_out['time'].'()"
				}
        }}}
        ,{"id":"bs_contact_manager","text":"回款统计人","rule":{"field":"bs_contact_manager","field_s":"回款统计人","table":"","value":"'.element('bs_contact_manager',$data_get).'","rule":"=","group":"search","editor":{
			"type":"combobox",
			"options":{
				"hasDownArrow":"",
				"panelHeight":"0",
				"start_fun":"load_c_search'.$data_out['time'].'()"
			}
		}}}
		,{"id":"bsi_sum_start","text":"回款金额(>)","rule":{"field":"bsi_sum_start","field_s":"回款金额(>)","field_r":"bsi_sum","table":"","value":"'.element('bsi_sum_start',$data_get).'","rule":">=","group":"search","editor":{
			"type":"numberbox",
			"options":{
				"groupSeparator":",",
				"precision":"2"
			}
		}}}
		,{"id":"bsi_sum_end","text":"回款金额(<)","rule":{"field":"bsi_sum_end","field_s":"回款金额(<)","field_r":"bsi_sum","table":"","value":"'.element('bsi_sum_end',$data_get).'","rule":"<=","group":"search","editor":{
			"type":"numberbox",
			"options":{
				"groupSeparator":",",
				"precision":"2"
			}
		}}}
		 ,{"id":"bs_time_start","text":"回款时间(>)","rule":{"field":"bs_time_start","field_s":"回款时间(>)","field_r":"bs_time","table":"","value":"'.element('bs_time_start',$data_get).'","rule":">=","group":"search","editor":{
			"type":"datebox",
			"options":{
			}
		}}}
		,{"id":"bs_time_end","text":"回款时间(<)","rule":{"field":"bs_time_end","field_s":"回款时间(<)","field_r":"bs_time","table":"","value":"'.element('bs_time_end',$data_get).'","rule":"<=","group":"search","editor":{
			"type":"datebox",
			"options":{
			}
		}}}
		,{"id":"gfc_name","text":"项目全称","rule":{"field":"gfc_name","field_s":"项目全称","table":"","value":"'.element('gfc_name',$data_get).'","rule":"like","group":"search","editor":"text"}}
		,{"id":"gfc_org_jia","text":"甲方单位","rule":{"field":"gfc_org_jia","field_s":"甲方单位","table":"","value":"'.element('gfc_org_jia',$data_get).'","rule":"in","group":"search","editor":{
        	"type":"combobox",
				"options":{
				"hasDownArrow":"",
				"panelHeight":"0",
				"start_fun":"load_org_search'.$data_out['time'].'()"
				}
        }}}
		,{"id":"gfc_c","text":"项目负责人","rule":{"field":"gfc_c","field_s":"项目负责人","table":"","value":"'.element('gfc_c',$data_get).'","rule":"=","group":"search","editor":{
			"type":"combobox",
			"options":{
				"hasDownArrow":"",
				"panelHeight":"0",
				"start_fun":"load_gfc_c_search'.$data_out['time'].'()"
			}
		}}}
		,{"id":"gfc_ou_tj","text":"统计部门","rule":{"field":"gfc_ou_tj","field_r":"gfc_id","m_link":"gfc_id","m_link_content":"gfc_ou_tj","field_s":"统计部门","table":"","value":"'.element('gfc_ou_tj',$data_get).'","rule":"in","group":"search","editor":{
			"type":"combobox",
			"options":{
				"hasDownArrow":"",
				"panelHeight":"0",
				"start_fun":"load_gfc_ou_search'.$data_out['time'].'()"
			}
		}}}
		,{"id":"gfc_finance_code","text":"财务编号","rule":{"field":"gfc_finance_code","field_s":"财务编号","table":"","value":"'.element('gfc_finance_code',$data_get).'","rule":"like","group":"search","editor":"text"}}
		,{"id":"gfc_category_extra","text":"附加属性","rule":{"field":"gfc_category_extra","field_s":"附加属性","table":"","value":"'.element('gfc_category_extra',$data_get).'","rule":"in","group":"search","editor":{
        	"type":"combotree",
				"options":{
				"valueField": "id",
				"textField": "text",
				"panelHeight":"auto",
				"panelMaxHeight":"200",
				"multiple":"true",
				"data":['.get_json_for_arr($GLOBALS['m_gfc']['text']['gfc_category_extra']).']
				}
        }}}
		';

		$data_out['field_search_value_dispaly']= array(
			'bsi_type'=>$GLOBALS['m_bs']['text']['bsi_type'],
			'gfc_category_main'=>$GLOBALS['m_gfc']['text']['gfc_category_main'],
			'gfc_category_extra'=>$GLOBALS['m_gfc']['text']['gfc_category_extra'],
			'gfc_category_statistic'=>$GLOBALS['m_gfc']['text']['gfc_category_statistic'],
		);
		$data_out['field_search_value_dispaly']=json_encode($data_out['field_search_value_dispaly']);
		
		$data_out=$this->m_base->get_person_conf_index($data_out);
		
		/************载入视图 ****************/
		$arr_view[]='proc_bs/bs_item/index';
		$arr_view[]='proc_bs/bs_item/index_js';
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
		
		if( $from == 'combobox' )
		$arr_search['rows'] = 0;
		
		//排序
		$arr_search['order']=$this->input->post_get('order');
		$arr_search['sort']=$this->input->post_get('sort');
		
		if( empty($arr_search['sort']) )
		{
			$arr_search['sort']='bs_code';
			$arr_search['order']='desc';
		}
		
		$arr_search['where']='';
		$arr_search['value']=array();
		/************查询条件*****************/

		if( element('search_bp_id', $data_get))
		{
			$arr_search['where']=' AND bsi_link_id = ? AND bs.ppo = 0';
			$arr_search['value']= $data_get['search_bp_id'];
		}
		
		if( $query )
		{
			if( ! $field_q ) $field_q="bs_code,bs_sum";

			if( ! $field_s ) $field_s=$field_q;

			$arr_search['where'].=" AND CONCAT({$field_q}) like '%".$this->m_base->escape_like_str($query)."%'";
		}

		$arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);
		/************数据查询*****************/
		$arr_field_search=array(
			'bsi_sum',
			'bsi_type',
			'bs.bs_id',
			'bs_code',
			'bs_company_out',
			'bs_time',
			'bs_contact_manager',
			'bs_org_owner',
			'gfc_id',
			'gfc_name',
			'gfc_org_jia',
			'gfc_c',
			'gfc_sum',
			'gfc_finance_code',
			'gfc_ou',
			'gfc_category_main',
			'gfc_category_extra',
			'gfc_category_statistic',
			'gfc_category_subc',
			'gfc_time_node_sign',
		);
		
		if( element('search_bp_id', $data_get))
		{
			$arr_field_search=array(
				'bsi_sum',
				'bsi_type',
				'bs_code',
				'bs.bs_id',
				'bs_company_out',
				'bs_time',
			);
		}

		if($query)
		{
			$arr_field_search = explode(',', $field_s);
		}
		
		$arr_field_search[]='bsi_id';
		$arr_search['sum_all']=array('bsi_sum');
		$arr_search['field']=implode(',', $arr_field_search);
		
		$arr_search['from']='fm_bs_item bsi 
							 LEFT JOIN fm_back_section bs ON
							 (bs.bs_id = bsi.bs_id)
							 LEFT JOIN pm_given_financial_code gfc ON
							 (gfc.gfc_id =  bsi.bsi_gfc_id)';
		
		$rs=$this->m_db->query($arr_search);
		
		if( element('search_bp_id', $data_get))
		{
			
		}
		else
		{
			$arr_field_search[]='gfc_ou_tj';
		}
		/************json拼接****************/
		$rs_sum_page=array();
		if (count($rs['content']) > 0)
		{
			foreach($rs['content'] as $k => $v)
			{
				$row_f='';
				foreach ($arr_field_search as $f) {
					switch($f){
						case 'bsi_sum':
							if( ! element($f, $rs_sum_page)) $rs_sum_page[$f] = 0;
							$rs_sum_page[$f] += $v[$f];
							break;
						case 'gfc_ou_tj':
							
							$arr_search_link=array();
							$arr_search_link['rows']=0;
							$arr_search_link['field']='link_id,ou_name';
							$arr_search_link['from']='sys_link l
													  LEFT JOIN sys_ou ou ON
													  (ou.ou_id=l.link_id)';
							$arr_search_link['where']=" AND op_id = ? AND op_table = ? AND op_field = ? AND content = ?";
							$arr_search_link['value'][]=$v['gfc_id'];
							$arr_search_link['value'][]='pm_given_financial_code';
							$arr_search_link['value'][]='gfc_id';
							$arr_search_link['value'][]='gfc_ou_tj';
							$rs_link=$this->m_db->query($arr_search_link);
							
							$v['gfc_ou_tj']='';
							$v['gfc_ou_tj_s']='';
				
							if(count($rs_link['content'])>0)
							{
								foreach ( $rs_link['content'] as $v1 ) {
									$v['gfc_ou_tj'].=$v1['link_id'];
									$v['gfc_ou_tj_s'].=$v1['ou_name'].',';
			
								}
								$v['gfc_ou_tj']=trim($v['gfc_ou_tj'],',');
								$v['gfc_ou_tj_s']=trim($v['gfc_ou_tj_s'],',');
							}
							$row_f.='"gfc_ou_tj_s":"'.fun_urlencode($v['gfc_ou_tj_s']).'",';		
							
							break;
						case 'bs.bs_id':
							$f='bs_id';
						case 'bs_company_out':
						case 'bs_org_owner':
						case 'gfc_org_jia':
							$row_f.='"'.$f.'_s":"'.fun_urlencode($this->m_base->get_field_where('sys_org','o_name'," AND o_id ='{$v[$f]}'")).'",';
							break;
						case 'bs_contact_manager':
						case 'gfc_c':
							$row_f.='"'.$f.'_s":"'.fun_urlencode($this->m_base->get_c_show_by_cid($v[$f])).'",';
							break;
						case 'gfc_ou':
							$row_f.='"'.$f.'_s":"'.fun_urlencode($this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id ='{$v[$f]}'")).'",';
							break;
						case 'gfc_category_main':
						case 'gfc_category_extra':
						case 'gfc_category_statistic':
						case 'gfc_category_subc':
							if(isset($GLOBALS['m_gfc']['text'][$f]) && isset($GLOBALS['m_gfc']['text'][$f][$v[$f]]) )
								$v[$f]=$GLOBALS['m_gfc']['text'][$f][$v[$f]];
							break;
						default:
							if(isset($GLOBALS['m_bs']['text'][$f]) && isset($GLOBALS['m_bs']['text'][$f][$v[$f]]) )
								$v[$f]=$GLOBALS['m_bs']['text'][$f][$v[$f]];
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
		
		//页脚
		$footer='';
		
		//本页
		if(is_array($rs_sum_page) && count($rs_sum_page) >0)
		{
			$footer.='{';
			foreach ($arr_field_search as $v) {
				if(isset($rs_sum_page[$v]))
				$footer.='"'.$v.'":"'.fun_urlencode($rs_sum_page[$v]).'",';
			}
			$footer.='"foot_page":"1"';
			$footer.='},';
		}
		
		//总计
		if( is_array(element('sum_all',$arr_search) ) && count($arr_search['sum_all']) > 0 )
		{
			$footer.='{';
			foreach ($arr_field_search as $v) {
				if(isset($rs['sum_'.$v]))
					$footer.='"'.$v.'":"'.fun_urlencode($rs['sum_'.$v]).'",';
			}
			$footer.='"foot_all":"1"';
			$footer.='},';
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
				   .',"footer":['.trim($footer,',').']'
				   .',"title":"回款明细列表"'
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
		//$this->m_bs->load();
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
				'bs_time',
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
				$arr_rtn=$this->m_bs->load($arr_get,$arr_post);
				
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
		$data_out['title']='回款';
		
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
				
				$arr_get['bs_id']=$v;
				$arr_get['act']=STAT_ACT_EDIT;
				$arr_post=array();
				$arr_post['btn']=$btn;
				$arr_post['flag_more']=TRUE;
				$arr_post['content']=array();
				
				$arr_rtn=$this->m_bs->load($arr_get,$arr_post);
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
