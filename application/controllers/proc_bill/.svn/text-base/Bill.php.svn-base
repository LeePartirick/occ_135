<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 开票
 * @author 朱明
 *
 */
class Bill extends CI_Controller {

	
	public function __construct()
    {
        parent::__construct();
        $this->load->model('proc_bill/m_bill');
        $this->load->model('proc_bill/m_proc_bill');
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
		if(element('bill_org_customer', $data_get))
		$data_get['bill_org_customer_s'] = $this->m_base->get_field_where('sys_org','o_name'," AND o_id = '{$data_get['bill_org_customer']}'");
		
		/************模板赋值***********/
		$data_out['flag_select']=element('flag_select', $data_get);
		$data_out['fun_select']=element('fun_select', $data_get);
		
		$data_out['fun_open']=element('fun_open', $data_get);
		$data_out['fun_open_id']=element('fun_open_id', $data_get);
		
		$data_out['search_bill_ending_sum']=element('search_bill_ending_sum', $data_get);
		
		$data_out['title']='开票索引';
		$data_out['time']=time();
		$data_out['url']='proc_bill-bill-index';
		
		$data_out['field_search_start']='bill_code,bill_org_owner,ppo,bill_org_customer,bill_sum_start,bill_sum_end,bill_category,bill_contact_manager,gfc_finance_code,gfc_name';
		$data_out['field_search_rule_default']='{"field":"bill_code","field_s":"编号","table":"fm_bill","value":"","rule":"like","group":"search","editor":"text"}';
		$data_out['field_search_rule']='
		{"id":"bill_code","text":"编号","rule":{"field":"bill_code","field_s":"编号","table":"fm_bill","value":"'.element('bill_code',$data_get).'","rule":"like","group":"search","editor":"text"}}
		,{"id":"bill_org_owner","text":"所属机构","rule":{"field":"bill_org_owner","field_s":"所属机构","table":"","value":"'.element('gfc_org',$data_get).'","rule":"in","group":"search",
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
		,{"id":"ppo","text":"流程节点","rule":{"field":"ppo","field_s":"流程节点","table":"bill","value":"'.element('ppo',$data_get).'","rule":"in","group":"search","editor":{
			"type":"combotree",
			"options":{
			"valueField": "id",
			"textField": "text",
			"panelHeight":"auto",
			"multiple":"true",
			"data":['.get_json_for_arr($GLOBALS['m_bill']['text']['ppo']).']
			}
		}}}
		,{"id":"bill_org_customer","text":"客户名称","rule":{"field":"bill_org_customer","field_s":"客户名称","table":"","value":"'.element('bill_org_customer',$data_get).'","value_s":"'.element('bill_org_customer_s',$data_get).'","rule":"in","group":"search","editor":{
        	"type":"combobox",
				"options":{
				"hasDownArrow":"",
				"panelHeight":"0",
				"start_fun":"load_org_search'.$data_out['time'].'()"
				}
        }}}
        ,{"id":"bill_sum_start","text":"开票金额(>)","rule":{"field":"bill_sum_start","field_s":"开票金额(>)","field_r":"bill_sum","table":"","value":"'.element('bill_sum_start',$data_get).'","rule":">=","group":"search","editor":{
			"type":"numberbox",
			"options":{
				"groupSeparator":",",
				"precision":"2"
			}
		}}}
		,{"id":"bill_sum_end","text":"开票金额(<)","rule":{"field":"bill_sum_end","field_s":"开票金额(<)","field_r":"bill_sum","table":"","value":"'.element('bill_sum_end',$data_get).'","rule":"<=","group":"search","editor":{
			"type":"numberbox",
			"options":{
				"groupSeparator":",",
				"precision":"2"
			}
		}}}
		,{"id":"bill_category","text":"发票类型","rule":{"field":"bill_category","field_s":"发票类型","table":"","value":"'.element('bill_category',$data_get).'","rule":"in","group":"search",
		 "fun_end":"fun_end_bill_category_search'.$data_out['time'].'()",
		 "editor":{
			"type":"combotree",
			"options":{
				"valueField": "id",
				"textField": "text",
				"multiple":"true",
				"panelWidth":"300",
				"panelHeight":"auto",
				"start_fun":"load_bill_category_search'.$data_out['time'].'()"
			}
		}}}
		 ,{"id":"bill_time_node_kp_start","text":"开票时间(>)","rule":{"field":"bill_time_node_kp_start","field_s":"开票时间(>)","field_r":"bill_time_node_kp","table":"","value":"'.element('bill_time_node_kp',$data_get).'","rule":">=","group":"search","editor":{
			"type":"datebox",
			"options":{
			}
		}}}
		,{"id":"bill_time_node_kp_end","text":"开票时间(<)","rule":{"field":"bill_time_node_kp_end","field_s":"开票时间(<)","field_r":"bill_time_node_kp","table":"","value":"'.element('bill_time_node_kp',$data_get).'","rule":"<=","group":"search","editor":{
			"type":"datebox",
			"options":{
			}
		}}}
		 ,{"id":"bill_time_return_start","text":"预计回票时间(>)","rule":{"field":"bill_time_return_start","field_s":"开票时间(>)","field_r":"bill_time_node_kp","table":"","value":"'.element('bill_time_node_kp',$data_get).'","rule":">=","group":"search","editor":{
			"type":"datebox",
			"options":{
			}
		}}}
		,{"id":"bill_time_return_end","text":"预计回款时间(<)","rule":{"field":"bill_time_return_end","field_s":"开票时间(<)","field_r":"bill_time_node_kp","table":"","value":"'.element('bill_time_node_kp',$data_get).'","rule":"<=","group":"search","editor":{
			"type":"datebox",
			"options":{
			}
		}}}
		,{"id":"bill_contact_manager","text":"开票统计人","rule":{"field":"bill_contact_manager","field_s":"开票统计人","table":"","value":"'.element('bill_contact_manager',$data_get).'","rule":"=","group":"search","editor":{
			"type":"combobox",
			"options":{
				"hasDownArrow":"",
				"panelHeight":"0",
				"start_fun":"load_c_search'.$data_out['time'].'()"
			}
		}}}
		,{"id":"gfc_finance_code","text":"财务编号","rule":{"field":"gfc_finance_code","field_s":"财务编号","table":"gfc","value":"'.element('gfc_finance_code',$data_get).'","rule":"like","group":"search","editor":"text"}}
		,{"id":"gfc_name","text":"项目全称","rule":{"field":"gfc_name","field_s":"项目全称","table":"gfc","value":"'.element('gfc_name',$data_get).'","rule":"like","group":"search","editor":"text"}}
		,{"id":"gfc_sum_start","text":"合同总额(>)","rule":{"field":"gfc_sum_start","field_s":"合同总额(>)","field_r":"gfc_sum","table":"","value":"'.element('gfc_sum_start',$data_get).'","rule":">=","group":"search","editor":{
			"type":"numberbox",
			"options":{
				"groupSeparator":",",
				"precision":"2"
			}
		}}}
		,{"id":"gfc_sum_end","text":"合同总额(<)","rule":{"field":"gfc_sum_end","field_s":"合同总额(<)","field_r":"gfc_sum","table":"","value":"'.element('gfc_sum_end',$data_get).'","rule":"<=","group":"search","editor":{
			"type":"numberbox",
			"options":{
				"groupSeparator":",",
				"precision":"2"
			}
		}}}
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
        ,{"id":"gfc_ou_tj","text":"统计部门","rule":{"field":"gfc_ou_tj","field_r":"gfc_id","m_link":"gfc_id","m_link_content":"gfc_ou_tj","field_s":"统计部门","table":"gfc","value":"'.element('gfc_ou_tj',$data_get).'","rule":"in","group":"search","editor":{
			"type":"combobox",
			"options":{
				"hasDownArrow":"",
				"panelHeight":"0",
				"start_fun":"load_ou_search'.$data_out['time'].'()"
			}
		}}}';

		$data_out['field_search_value_dispaly']= array(
			'ppo'=>$GLOBALS['m_bill']['text']['ppo'],
			'gfc_category_main'=>$GLOBALS['m_gfc']['text']['gfc_category_main'],
			'gfc_category_extra'=>$GLOBALS['m_gfc']['text']['gfc_category_extra'],
			'gfc_category_statistic'=>$GLOBALS['m_gfc']['text']['gfc_category_statistic'],
			'gfc_category_subc'=>$GLOBALS['m_budm']['text']['gfc_category_subc'],
		);
		$data_out['field_search_value_dispaly']=json_encode($data_out['field_search_value_dispaly']);
		
		$data_out=$this->m_base->get_person_conf_index($data_out);
		
		/************载入视图 ****************/
		$arr_view[]='proc_bill/bill/index';
		$arr_view[]='proc_bill/bill/index_js';
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
			$arr_search['sort']='bill_code';
			$arr_search['order']='asc';
		}
		
		switch ($arr_search['sort'])
		{
			case 'bill_ending_sum':
				$arr_search['sort']='bill_sum_return';
				break;
			case 'bill_org_customer_s':
				$arr_search['sort']='bill_org_customer';
				break;
			case 'bill_contact_manager_s':
				$arr_search['sort']='bill_contact_manager';
				break;
			case 'bill_category_s':
				$arr_search['sort']='bill_category';
				break;
			case 'gfc_c_s':
				$arr_search['sort']='gfc_c';
				break;
			case 'gfc_org_s':
				$arr_search['sort']='gfc_org';
				break;
			case 'ppo':
				$arr_search['sort']='bill.ppo';
				break;
		}
		
		$arr_search['where']='';
		$arr_search['value']=array();
		/************查询条件*****************/
		
		if( element('search_bill_ending_sum', $data_get) )
		{
			$arr_search['where']='AND bill.ppo = 0 AND bill_sum_return != bill_sum ';
		}
		
		if( $query )
		{
			if( ! $field_q ) $field_q="bill_sum,bill_time_node_kp,gfc_finance_code,gfc_name";

			if( ! $field_s ) $field_s=$field_q;

			$arr_search['where'].=" AND CONCAT({$field_q}) like '%".$this->m_base->escape_like_str($query)."%'";
		}

		$arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);
		/************数据查询*****************/
		$arr_field_search=array(
			'bill_code',
			'bill_org_customer',
			'bill_sum',
			'bill_sum_return',
			'bill_category',
			'bill_time_node_kp',
			'bill_time_return',
			'bill_contact_manager',
			'bill.gfc_id',
			'bill.ppo',
			'gfc_name',
			'gfc_c',
			'gfc_finance_code',
			'gfc_sum',
			'gfc_category_extra',
			'gfc_org',
		);

		if($query)
		{
			$arr_field_search = explode(',', $field_s);
		}
		
		$arr_field_search[]='bill_id';
		
		$arr_search['field']=implode(',', $arr_field_search);
		
		$arr_search['from']='fm_bill bill
							 LEFT JOIN pm_given_financial_code gfc ON
							 (gfc.gfc_id = bill.gfc_id)';
		
		$arr_search['sum_all']=array('bill_sum');
		
		$rs=$this->m_db->query($arr_search);
		
		//获取应收账款合计
		$arr_search['sum_all'][] = 'bill_ending_sum';
		$rs['sum_bill_ending_sum'] = $this->m_base->get_field_where('fm_bill','sum(bill_sum - bill_sum_return)'," AND ppo = 0");
		
		if( in_array('bill.gfc_id', $arr_field_search) )
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
							
						case 'bill_sum_return':
							$v['bill_ending_sum'] = 0;
							if( $v['ppo'] == 0 )$v['bill_ending_sum'] = $v['bill_sum'] - $v['bill_sum_return'];
							$row_f.='"bill_ending_sum":"'.fun_urlencode($v['bill_ending_sum']).'",';
							
							if( ! element('bill_ending_sum', $rs_sum_page)) $rs_sum_page['bill_ending_sum'] = 0;
							$rs_sum_page['bill_ending_sum'] += $v['bill_ending_sum'];
							break;
						case 'bill_sum':	
							if( ! element($f, $rs_sum_page)) $rs_sum_page[$f] = 0;
							$rs_sum_page[$f] += $v[$f];
							break;
						case 'bill_category':
							$row_f.='"'.$f.'_s":"'.fun_urlencode($this->m_base->get_field_where('fm_invoice_type','it_name'," AND it_id ='{$v[$f]}'")).'",';
							break;
						case 'bill_org_customer':
						case 'gfc_org':
							$row_f.='"'.$f.'_s":"'.fun_urlencode($this->m_base->get_field_where('sys_org','o_name'," AND o_id ='{$v[$f]}'")).'",';
							break;
						case 'bill_contact_manager':
						case 'gfc_c':
							$row_f.='"'.$f.'_s":"'.fun_urlencode($this->m_base->get_c_show_by_cid($v[$f])).'",';
							break;
						case 'bill.gfc_id':
							$f = 'gfc_id';
							break;
						case 'bill.ppo':
							$f = 'ppo';
							$v[$f]=$GLOBALS['m_bill']['text'][$f][$v[$f]];
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
						case 'gfc_category_extra':
							$v[$f]=$GLOBALS['m_gfc']['text'][$f][$v[$f]];
							break;
						default:
							if(isset($GLOBALS['m_bill']['text'][$f]) && isset($GLOBALS['m_bill']['text'][$f][$v[$f]]) )
								$v[$f]=$GLOBALS['m_bill']['text'][$f][$v[$f]];
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
			foreach ($rs_sum_page as $k=>$v) {
				$footer.='"'.$k.'":"'.fun_urlencode($v).'",';
			}
			$footer.='"foot_page":"1"';
			$footer.='},';
		}
		
		//总计
		if( is_array(element('sum_all',$arr_search) ) && count($arr_search['sum_all']) > 0 )
		{
			$footer.='{';
			foreach ($arr_search['sum_all'] as $v) {
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
				   .',"title":"开票列表"'
				   .',"msg":"'.$msg.'"'
				   .',"rows":['.$rows.']}';
		}

		/************返回数据*****************/
		echo $json;
	}
	
	/**
	 * json
	 */
	public function get_json_link()
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
			$arr_search['sort']='bill_code';
			$arr_search['order']='asc';
		}
		
		$arr_search['where']='';
		$arr_search['value']=array();
		/************查询条件*****************/
		
		if( element('search_bill_id', $data_get) )
		{
			$arr_search['where']= ' AND bill_id = ? AND ( bsi.bsi_id IS NOT NULL)';
			$arr_search['value']= $data_get['search_bill_id'];
		}
		
		if( $query )
		{
			if( ! $field_q ) $field_q="bill_code";

			if( ! $field_s ) $field_s=$field_q;

			$arr_search['where'].=" AND CONCAT({$field_q}) like '%".$this->m_base->escape_like_str($query)."%'";
		}

		$arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);
		/************数据查询*****************/
		$arr_field_search=array(
			'bsi_sum',
			'bs.bs_id',
			'bs_time',
			'bs_code',
		);

		if($query)
		{
			$arr_field_search = explode(',', $field_s);
		}
		
		$arr_field_search[]='bill_id';
		
		$arr_search['field']=implode(',', $arr_field_search);
		
		$arr_search['from']='fm_bill bill
							 LEFT JOIN fm_bs_item bsi ON
							 (bsi.bsi_link_id = bill.bill_id AND bsi.ppo = 0)
							 LEFT JOIN fm_back_section bs ON
							 (bs.bs_id = bsi.bs_id)';
		
		$rs=$this->m_db->query($arr_search);
		
		/************json拼接****************/

		if (count($rs['content']) > 0)
		{
			foreach($rs['content'] as $k => $v)
			{
				$row_f='';
				foreach ($arr_field_search as $f) {
					switch($f){
						case 'bs_code':
							$f = 'l_code';
							$v[$f] = $v['bs_code'];
							$row_f.='"l_type":"'.fun_urlencode('回款').'",';
							break;
						case 'bsi_sum':
							$f = 'l_sum';
							$v[$f] = $v['bsi_sum'];
							break;
						case 'bs_time':
							$f = 'l_time';
							$v[$f] = $v['bs_time'];
							break;
						case 'bs.bs_id':
							$f = 'l_id';
							$v[$f] = $v['bs_id'];
							break;
						default:
							if(isset($GLOBALS['m_bill']['text'][$f]) && isset($GLOBALS['m_bill']['text'][$f][$v[$f]]) )
								$v[$f]=$GLOBALS['m_bill']['text'][$f][$v[$f]];
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
				   .',"title":"开票关联列表"'
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
		$this->m_bill->load();
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
				'bill_sum'
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
				$arr_rtn=$this->m_bill->load($arr_get,$arr_post);
				
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
		$data_out['title']='预算表';
		
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
				
				$arr_get['bill_id']=$v;
				$arr_get['act']=STAT_ACT_EDIT;
				$arr_post=array();
				$arr_post['btn']=$btn;
				$arr_post['flag_more']=TRUE;
				$arr_post['content']=array();
				
				$arr_rtn=$this->m_bill->load($arr_get,$arr_post);
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
