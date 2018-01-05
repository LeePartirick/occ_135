<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 财务编号开票回款
 * @author 朱明
 *
 */
class Gfc_bp extends CI_Controller {

	
	public function __construct()
    {
        parent::__construct();
        $this->load->model('proc_gfc/m_gfc_bp');
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
		
		/************模板赋值***********/
		$data_out['flag_select']=element('flag_select', $data_get);
		$data_out['fun_select']=element('fun_select', $data_get);
		
		$data_out['fun_open']=element('fun_open', $data_get);
		$data_out['fun_open_id']=element('fun_open_id', $data_get);
		
		$data_out['title']='财务编号开票回款索引';
		$data_out['time']=time();
		if( ! empty(element('time', $data_get)) )
		$data_out['time']=element('time', $data_get);
		
		$data_out['url']='proc_gfc-gfc_bp-index';
		
		$data_out['field_search_start']='gfc_name,gfc_org,gfc_org_jia,gfc_c,gfc_c_tj,gfc_ou,gfc_ou_tj,gfc_finance_code,gfc_sum_start,gfc_sum_end,gfc_category_main,gfc_time_node_sign_start,gfc_time_node_sign_end';
		$data_out['field_search_rule_default']='{"field":"gfc_name","field_s":"项目全称","table":"pm_given_financial_code","value":"","rule":"like","group":"search","editor":"text"}';
		$data_out['field_search_rule']='
		{"id":"gfc_name","text":"项目全称","rule":{"field":"gfc_name","field_s":"项目全称","table":"pm_given_financial_code","value":"'.element('gfc_name',$data_get).'","rule":"like","group":"search","editor":"text"}}
		,{"id":"gfc_org","text":"所属机构","rule":{"field":"gfc_org","field_s":"所属机构","table":"","value":"'.element('gfc_org',$data_get).'","rule":"in","group":"search",
		 "fun_end":"fun_end_gfc_org_search'.$data_out['time'].'()",
		 "editor":{
			"type":"combotree",
			"options":{
				"valueField": "id",
				"textField": "text",
				"multiple":"true",
				"panelWidth":"300",
				"panelMaxHeight":"200",
				"panelHeight":"auto",
				"start_fun":"load_gfc_org_search'.$data_out['time'].'()"
			}
		}}}
		,{"id":"ppo","text":"流程节点","rule":{"field":"ppo","field_s":"流程节点","table":"","value":"'.element('ppo',$data_get).'","rule":"in","group":"search","editor":{
			"type":"combotree",
			"options":{
			"valueField": "id",
			"textField": "text",
			"panelHeight":"auto",
			"multiple":"true",
			"data":['.get_json_for_arr($GLOBALS['m_gfc']['text']['ppo']).']
			}
		}}}
		,{"id":"gfc_org_jia","text":"甲方单位","rule":{"field":"gfc_org_jia","field_s":"甲方单位","table":"","value":"'.element('gfc_org_jia',$data_get).'","rule":"in","group":"search","editor":{
        	"type":"combobox",
				"options":{
				"hasDownArrow":"",
				"panelHeight":"0",
				"start_fun":"load_gfc_org_jia_search'.$data_out['time'].'()"
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
		,{"id":"gfc_c_tj","text":"项目统计人","rule":{"field":"gfc_c_tj","field_s":"项目统计人","table":"","value":"'.element('gfc_c_tj',$data_get).'","rule":"=","group":"search","editor":{
			"type":"combobox",
			"options":{
				"hasDownArrow":"",
				"panelHeight":"0",
				"start_fun":"load_gfc_c_search'.$data_out['time'].'()"
			}
		}}}
		,{"id":"gfc_ou","text":"部门","rule":{"field":"gfc_ou","field_s":"部门","table":"","value":"'.element('gfc_ou',$data_get).'","rule":"=","group":"search","editor":{
			"type":"combobox",
			"options":{
				"hasDownArrow":"",
				"panelHeight":"0",
				"start_fun":"load_gfc_ou_search'.$data_out['time'].'()"
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
		,{"id":"gfc_org","text":"所属机构","rule":{"field":"gfc_org","field_s":"所属机构","table":"","value":"'.element('gfc_org',$data_get).'","rule":"in","group":"search",
		 "fun_end":"fun_end_gfc_org_search'.$data_out['time'].'()",
		 "editor":{
			"type":"combotree",
			"options":{
				"valueField": "id",
				"textField": "text",
				"multiple":"true",
				"panelWidth":"300",
				"panelHeight":"auto",
				"start_fun":"load_gfc_org_search'.$data_out['time'].'()"
			}
		}}}
		,{"id":"gfc_finance_code","text":"财务编号","rule":{"field":"gfc_finance_code","field_s":"财务编号","table":"pm_given_financial_code","value":"'.element('gfc_finance_code',$data_get).'","rule":"like","group":"search","editor":"text"}}
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
		,{"id":"gfc_category_main","text":"项目属性","rule":{"field":"gfc_category_main","field_s":"项目属性","table":"","value":"'.element('gfc_category_main',$data_get).'","rule":"in","group":"search","editor":{
        	"type":"combotree",
				"options":{
				"valueField": "id",
				"textField": "text",
				"panelHeight":"auto",
				"multiple":"true",
				"data":['.get_json_for_arr($GLOBALS['m_gfc']['text']['gfc_category_main']).']
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
        ,{"id":"gfc_category_statistic","text":"附加属性II","rule":{"field":"gfc_category_extra","field_s":"附加属性II","table":"","value":"'.element('gfc_category_statistic',$data_get).'","rule":"in","group":"search","editor":{
        	"type":"combotree",
				"options":{
				"valueField": "id",
				"textField": "text",
				"panelHeight":"auto",
				"panelMaxHeight":"200",
				"panelWidth":"270",
				"multiple":"true",
				"data":['.get_json_for_arr($GLOBALS['m_gfc']['text']['gfc_category_statistic']).']
				}
        }}}
        ,{"id":"gfc_category_subc","text":"总分包类型","rule":{"field":"gfc_category_extra","field_s":"总分包类型","table":"","value":"'.element('gfc_category_subc',$data_get).'","rule":"in","group":"search","editor":{
        	"type":"combotree",
				"options":{
				"valueField": "id",
				"textField": "text",
				"panelHeight":"auto",
				"multiple":"true",
				"data":['.get_json_for_arr($GLOBALS['m_budm']['text']['gfc_category_subc']).']
				}
        }}}
        ,{"id":"gfc_time_node_sign_start","text":"统计时间(>)","rule":{"field":"gfc_time_node_sign_start","field_s":"统计时间(>)","field_r":"gfc_time_node_sign","table":"","value":"'.element('gfc_time_node_sign_start',$data_get).'","rule":">=","group":"search","editor":{
			"type":"datebox",
			"options":{
			}
		}}}
		,{"id":"gfc_time_node_sign_end","text":"统计时间(<)","rule":{"field":"gfc_time_node_sign_end","field_s":"统计时间(<)","field_r":"gfc_time_node_sign","table":"","value":"'.element('gfc_time_node_sign_end',$data_get).'","rule":"<=","group":"search","editor":{
			"type":"datebox",
			"options":{
			}
		}}}
		';
		
		$data_out['field_search_value_dispaly']= array(
			'ppo'=>$GLOBALS['m_gfc']['text']['ppo'],
			'gfc_category_main'=>$GLOBALS['m_gfc']['text']['gfc_category_main'],
			'gfc_category_extra'=>$GLOBALS['m_gfc']['text']['gfc_category_extra'],
			'gfc_category_statistic'=>$GLOBALS['m_gfc']['text']['gfc_category_statistic'],
			'gfc_category_subc'=>$GLOBALS['m_budm']['text']['gfc_category_subc'],
		);
		$data_out['field_search_value_dispaly']=json_encode($data_out['field_search_value_dispaly']);
		
		$data_out=$this->m_base->get_person_conf_index($data_out);
		
		/************载入视图 ****************/
		$arr_view[]='proc_gfc/gfc_bp/index';
		$arr_view[]='proc_gfc/gfc_bp/index_js';
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
			$arr_search['sort']='db_time_create';
			$arr_search['order']='desc';
		}
		
		switch ($arr_search['sort'])
		{
			case 'gfc_c_s':
				$arr_search['sort']='gfc_c';
				break;
			case 'gfc_org_s':
				$arr_search['sort']='gfc_org';
				break;
			case 'gfc_org_jia_s':
				$arr_search['sort']='gfc_org_jia';
				break;
			case 'gfc_ou':
				$arr_search['sort']='gfc_ou';
				break;
			case 'gfc_c_tj_s':
				$arr_search['sort']='gfc_c_tj';
				break;
		}

		$arr_search['where']='';
		$arr_search['value']=array();
		/************查询条件*****************/
		
		$time_node = $this->input->post_get('time_node');
		if( ! $time_node ) $time_node = date("Y-m");
		
		if( $query )
		{
			if( ! $field_q ) $field_q="gfc_name,gfc_code";

			if( ! $field_s ) $field_s=$field_q;

			$arr_search['where'].=" AND CONCAT({$field_q}) like '%".$this->m_base->escape_like_str($query)."%'";
		}
		
		$arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);
		/************数据查询*****************/
		$arr_field_search=array(
			'gfc_name',
			'gfc_org_jia',
			'gfc_c',
			'gfc_sum',
			'gfc_sum_kp',
			'gfc_sum_hk',
			'gfc_c_tj',
			'gfc_finance_code',
			'gfc_ou',
			'gfc_category_main',
			'gfc_category_extra',
			'gfc_category_statistic',
			'gfc_category_subc',
			'gfc_time_node_sign',
			'gfc_org',
			'gfc_note',
		);

		if($query)
		{
			$arr_field_search = explode(',', $field_s);
		}
		
		$arr_field_search[]='gfc_id';

		$arr_search['field']=implode(',', $arr_field_search);

		$arr_search['from']='pm_given_financial_code';

		$rs=$this->m_db->query($arr_search);
		
		$total = $rs['total'];
		
		$arr_gfc = array();
		if (count($rs['content']) > 0)
		{
			foreach($rs['content'] as $k => $v)
			{
				$arr_gfc[$v['gfc_id']] = $v;
			}
			
			$arr_search = array();

			$arr_search['field']='gfc_id
								  ,bp_sum
								  ,bp_time_back
								  ,bp_time
								  ,bp_sum_kp
								  ,bp_sum_hk';
	
			$arr_search['from']='pm_bill_plan';
			$arr_search['where']=' AND gfc_id IN ? ';
			$arr_search['value'][] = array_keys($arr_gfc);
			$rs=$this->m_db->query($arr_search);
			
			if (count($rs['content']) > 0)
			{
				foreach($rs['content'] as $k => $v)
				{
					if($v['bp_time'])
					{
						$bp_time = date("Y-m",strtotime($v['bp_time']));
						
						if( ! isset($arr_gfc[$v['gfc_id']]['sum_kp_plan_'.$bp_time]) )
						$arr_gfc[$v['gfc_id']]['sum_kp_plan_'.$bp_time] = 0;
						
						$arr_gfc[$v['gfc_id']]['sum_kp_plan_'.$bp_time] += $v['bp_sum'];
						
						if( ! isset($arr_gfc[$v['gfc_id']]['sum_kp_have_'.$bp_time]) )
						$arr_gfc[$v['gfc_id']]['sum_kp_have_'.$bp_time] = 0;
						
						$arr_gfc[$v['gfc_id']]['sum_kp_have_'.$bp_time] += $v['bp_sum_kp'];
						
						if( ! isset($arr_gfc[$v['gfc_id']]['sum_kp_now_'.$bp_time]) )
						$arr_gfc[$v['gfc_id']]['sum_kp_now_'.$bp_time] = 0;
						
						$arr_gfc[$v['gfc_id']]['sum_kp_now_'.$bp_time] += $v['bp_sum'] - $v['bp_sum_kp'];
					}
					
					if($v['bp_time_back'])
					{
						$bp_time = date("Y-m",strtotime($v['bp_time_back']));
						
						if( ! isset($arr_gfc[$v['gfc_id']]['sum_hk_plan_'.$bp_time]) )
						$arr_gfc[$v['gfc_id']]['sum_hk_plan_'.$bp_time] = 0;
						
						$arr_gfc[$v['gfc_id']]['sum_hk_plan_'.$bp_time] += $v['bp_sum'];
						
						if( ! isset($arr_gfc[$v['gfc_id']]['sum_hk_have_'.$bp_time]) )
						$arr_gfc[$v['gfc_id']]['sum_hk_have_'.$bp_time] = 0;
						
						$arr_gfc[$v['gfc_id']]['sum_hk_have_'.$bp_time] += $v['bp_sum_hk'];
						
						if( ! isset($arr_gfc[$v['gfc_id']]['sum_hk_now_'.$bp_time]) )
						$arr_gfc[$v['gfc_id']]['sum_hk_now_'.$bp_time] = 0;
						
						$arr_gfc[$v['gfc_id']]['sum_hk_now_'.$bp_time] += $v['bp_sum'] - $v['bp_sum_hk'];
						
					}
				}
			}
		}
		
		$time_node .= '-01';
		date("Y-m-d",strtotime("+1 month"))."<hr>"; 
		
		$arr_time = array();
		
		for($i=-3; $i<9; $i++)
		{
			$time_tmp = date("Y-m-d",strtotime($time_node.' '.$i."month")); 
			$time_tmp = date("Y-m",strtotime($time_tmp));
			
			$arr_field_search[] = 'sum_kp_now_'.$time_tmp;
			$arr_field_search[] = 'sum_hk_now_'.$time_tmp;
			$arr_field_search[] = 'sum_kp_plan_'.$time_tmp;
			$arr_field_search[] = 'sum_hk_plan_'.$time_tmp;
			$arr_field_search[] = 'sum_kp_have_'.$time_tmp;
			$arr_field_search[] = 'sum_hk_have_'.$time_tmp;
			
			$arr_time[] = $time_tmp;
		}
		
		$arr_field_search[] = 'gfc_sum_kp_wei';
		$arr_field_search[] = 'gfc_sum_hk_wei';
		
		$arr_field_search[] = 'gfc_sum_kp_lv';
		$arr_field_search[] = 'gfc_sum_hk_lv';
		
		$arr_field_search[] = 'gfc_plan_kp';
		$arr_field_search[] = 'gfc_plan_hk';
		/************json拼接****************/
		if (count($arr_gfc) > 0)
		{
			foreach($arr_gfc as $k => $v)
			{
				$row_f='';

				$arr_gfc_id[] = $v['gfc_id'];
				
				foreach ($arr_field_search as $f) {
					switch($f){
						case 'gfc_sum_kp_wei':
							$v[$f] = $v['gfc_sum'] - $v['gfc_sum_kp'];
							break;
						case 'gfc_sum_hk_wei':
							$v[$f] = $v['gfc_sum'] - $v['gfc_sum_hk'];
							break;
						case 'gfc_sum_kp_lv':
							$v[$f] = number_format($v['gfc_sum_kp']*100/$v['gfc_sum'],2);
							break;
						case 'gfc_sum_hk_lv':
							$v[$f] = number_format($v['gfc_sum_hk']*100/$v['gfc_sum'],2);
							break;
						case 'gfc_plan_kp':
							$v[$f] = '开票计划';
							break;
						case 'gfc_plan_hk':
							$v[$f] = '回款计划';
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
						case 'gfc_c':
							$row_f.='"gfc_c_s":"'.fun_urlencode($this->m_base->get_c_show_by_cid($v[$f])).'",';
							break;
						case 'gfc_org_jia':
							$row_f.='"gfc_org_jia_s":"'.fun_urlencode($this->m_base->get_field_where('sys_org','o_name'," AND o_id ='{$v[$f]}'")).'",';
							break;
						case 'gfc_org':
							$row_f.='"gfc_org_s":"'.fun_urlencode($this->m_base->get_field_where('sys_org','o_name'," AND o_id ='{$v[$f]}'")).'",';
							break;
						case 'gfc_c_tj':
							$row_f.='"gfc_c_tj_s":"'.fun_urlencode($this->m_base->get_c_show_by_cid($v[$f])).'",';
							break;
						case 'gfc_ou':
							$row_f.='"gfc_ou_s":"'.fun_urlencode($this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id ='{$v[$f]}'")).'",';
							break;
						case 'gfc_category_subc':
							$v[$f]=$GLOBALS['m_budm']['text'][$f][$v[$f]];
							break;
						default:
							if(isset($GLOBALS['m_gfc']['text'][$f]) && isset($GLOBALS['m_gfc']['text'][$f][$v[$f]]) )
								$v[$f]=$GLOBALS['m_gfc']['text'][$f][$v[$f]];
					}

					$row_f.='"'.$f.'":"'.fun_urlencode(element($f,$v)).'",';
					
					if(strstr($f, 'sum_kp_now') )
					{
						$tmp_time = str_replace('sum_kp_now_', '', $f);
						$row_f.='"gfc_sum_kp_plan_'.(array_search($tmp_time,$arr_time)+1).'":"'.fun_urlencode(element($f,$v)).'",';
					}
					
					if(strstr($f, 'sum_hk_now') )
					{
						$tmp_time =  str_replace('sum_hk_now_', '', $f);
						$row_f.='"gfc_sum_hk_plan_'.(array_search($tmp_time,$arr_time)+1).'":"'.fun_urlencode(element($f,$v)).'",';
					}
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
			$json.='{"total":"'.$total.'"'
				.',"time":"'.$time.'"'
				.',"title":"开票回款计划"'
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
		$this->m_gfc_bp->load();
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
				'gfc_name',
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
				$arr_rtn=$this->m_gfc_bp->load($arr_get,$arr_post);
				
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
		$data_out['title']='财务编号开票回款';

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
				
				$arr_get['gfc_id']=$v;
				$arr_get['act']=STAT_ACT_EDIT;
				$arr_post=array();
				$arr_post['btn']=$btn;
				$arr_post['flag_more']=TRUE;
				$arr_post['content']=array();
				
				$arr_post= array_merge($arr_post,$arr_save);
				
				$arr_rtn=$this->m_gfc_bp->load($arr_get,$arr_post);
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