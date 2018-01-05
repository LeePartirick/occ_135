<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 财务编号
 * @author 朱明
 *
 */
class Gfc extends CI_Controller {

	
	public function __construct()
    {
        parent::__construct();
        $this->load->model('proc_gfc/m_gfc');
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
		
		$data_out['search_gfc_finance_code']=element('search_gfc_finance_code', $data_get);
		
		$data_out['title']='财务编号索引';
		$data_out['time']=time();
		if( ! empty(element('time', $data_get)) )
		$data_out['time']=element('time', $data_get);
		
		$data_out['url']='proc_gfc-gfc-index';
		
		$data_out['field_search_start']='gfc_name,gfc_org,ppo,gfc_org_jia,gfc_c,gfc_c_tj,gfc_ou,gfc_ou_tj,gfc_finance_code,gfc_sum_start,gfc_sum_end,gfc_category_main,gfc_time_node_sign_start,gfc_time_node_sign_end';
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
		$arr_view[]='proc_gfc/gfc/index';
		$arr_view[]='proc_gfc/gfc/index_js';
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

		$arr_search['where']='';
		$arr_search['value']=array();
		/************查询条件*****************/
		
		if(element('search_gfc_finance_code', $data_get))
		{
			$arr_search['where']=" AND gfc_finance_code != '' AND gfc_finance_code IS NOT NULL";
		}
		
		if( $query )
		{
			if( ! $field_q ) $field_q="gfc_name,gfc_finance_code";

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
			'gfc_c_tj',
			'gfc_tax',
			'gfc_finance_code',
			'gfc_ou',
			'gfc_category_main',
			'gfc_category_extra',
			'gfc_category_statistic',
			'gfc_category_subc',
			'gfc_time_node_sign',
			'gfc_org',
			'gfc_note',
			'ppo'
		);

		if($query)
		{
			$arr_field_search = explode(',', $field_s);
		}
		
		$arr_field_search[]='gfc_id';

		$arr_search['field']=implode(',', $arr_field_search);

		$arr_search['from']='pm_given_financial_code';
		$arr_search['sum_all']=array('gfc_sum');
		$rs=$this->m_db->query($arr_search);
		
		$arr_field_search[]='gfc_ou_tj';
		/************json拼接****************/
		$rs_sum_page=array();
		if (count($rs['content']) > 0)
		{
			foreach($rs['content'] as $k => $v)
			{
				$row_f='';

				foreach ($arr_field_search as $f) {
					switch($f){
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
									$v['gfc_ou_tj'].=$v1['link_id'].',';
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
						case 'gfc_tax':
							$row_f.='"gfc_tax_s":"'.fun_urlencode($this->m_base->get_field_where('fm_tax_type','t_name'," AND t_id ='{$v[$f]}'")).'",';
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
						case 'gfc_sum':
							if( ! element($f, $rs_sum_page)) $rs_sum_page[$f] = 0;
							$rs_sum_page[$f] += $v[$f];
							break;
						default:
							if(isset($GLOBALS['m_gfc']['text'][$f]) && isset($GLOBALS['m_gfc']['text'][$f][$v[$f]]) )
								$v[$f]=$GLOBALS['m_gfc']['text'][$f][$v[$f]];
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
		else
		{
			$json.='{"total":"'.$rs['total'].'"'
				.',"time":"'.$time.'"'
				.',"footer":['.trim($footer,',').']'
				.',"title":"财务编号"'
				.',"msg":"'.$msg.'"'
				.',"rows":['.$rows.']}';
		}

		/************返回数据*****************/
		echo $json;
	}
	
	/**
	 * json
	 */
	public function get_json_cr_file()
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
		$cr_id = $this->input->post_get('cr_id');
		$gfc_id= $this->input->post_get('gfc_id');
		$gfc_category_contract= $this->input->post_get('gfc_category_contract');

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

		$arr_search['where']='';
		$arr_search['value']=array();
		/************查询条件*****************/

		/************数据查询*****************/
		$link_file_check='';
		$total = 0;
		
		//验证是否存在必须上传文件
		if( ! empty($cr_id) )
		{
			$arr_search=array();
			$arr_search['field']='cr_link_file';
			$arr_search['from']="pm_contract_review";
			$arr_search['where']= " AND cr_id IN ? AND cr_link_file IS NOT NULL AND cr_link_file != '' ";
			$arr_search['value'][] = explode(',', $cr_id);
			
			$rs=$this->m_db->query($arr_search);
			if(count($rs['content'])>0)
			{
				foreach ($rs['content'] as $v) {
					$link_file_check .= $v['cr_link_file'].','; 
				}
			}
		}
		
		if($gfc_category_contract != 1)
		{
			//检查上传合同
			$arr_search=array();
			$arr_search['field']='f_t_id';
			$arr_search['from']="sys_file_type";
			$arr_search['where']= "AND f_t_check = ? ";
			$arr_search['value'][] = F_T_CHECK_GFC_REVIEW;
			$rs=$this->m_db->query($arr_search);
			if(count($rs['content'])>0)
			{
				foreach ($rs['content'] as $v) {
					$link_file_check .= $v['f_t_id'].','; 
				}
			}
		}
		
		if( ! empty($link_file_check) )
		{
			$link_file_check = trim($link_file_check,',');
			
			$arr_tmp = explode(',', $link_file_check);
			$arr_search=array();
			$arr_search['field']='count(lt.link_id) sum,lt.link_id';
			$arr_search['from']="sys_link lf
								 LEFT JOIN sys_link lt ON
								 (lt.op_id = lf.link_id AND lt.content = 'f_type') ";
			$arr_search['where']= " AND lf.op_id = ? AND lf.content = 'link_file' AND lt.link_id IN ? GROUP BY lt.link_id";
			$arr_search['value'][] = $gfc_id;
			$arr_search['value'][] = $arr_tmp ;
			$rs=$this->m_db->query($arr_search);
			
			$arr_file_link=array();
			if(count($rs['content'])>0)
			{
				foreach ($rs['content'] as $v) {
					$arr_file_link[$v['link_id']] = $v['sum'];
				}
			}
			
			$arr_search=array();
			$arr_search['field']='f_t_id,f_t_name';
			$arr_search['from']="sys_file_type";
			$arr_search['where']= " AND f_t_id IN ?";
			$arr_search['value'][] = $arr_tmp;
			$arr_search['sort'] = 'db_time_create';
			$arr_search['order']='asc';
			$rs=$this->m_db->query($arr_search);
			
			if(count($rs['content'])>0)
			{
				$i=1;
				foreach ($rs['content'] as $v) {
					
					switch ($i%4) {
						case 1:
						$total++;
						$rows.='{'
							  .'"file1":"'.fun_urlencode($v['f_t_name']).'"'
							  .',"file1_sum":"'.element($v['f_t_id'], $arr_file_link).'"'
							  .',"file1_id":"'.$v['f_t_id'].'"';
							
						break;
						case 2:
						$rows.=',"file2":"'.fun_urlencode($v['f_t_name']).'"'
							  .',"file2_sum":"'.element($v['f_t_id'], $arr_file_link).'"'
							  .',"file2_id":"'.$v['f_t_id'].'"';
						break;
						case 3:
						$rows.=',"file3":"'.fun_urlencode($v['f_t_name']).'"'
							  .',"file3_sum":"'.element($v['f_t_id'], $arr_file_link).'"'
							  .',"file3_id":"'.$v['f_t_id'].'"';
						break;
						case 0:
						$rows.=',"file4":"'.fun_urlencode($v['f_t_name']).'"'
							  .',"file4_sum":"'.element($v['f_t_id'], $arr_file_link).'"'
							  .',"file3_id":"'.$v['f_t_id'].'"'
							  .'},';
						break;
						
					}

					$i++;
				}
				
				$rows=trim($rows,',');
				
				if(($i-1)%4!=0)
				{
					$rows.='}';
				}
			}
		}
		
		/************json拼接****************/

		//结束时间
		$time_end=time();
		$time=$time_end-$time_start;

		$json.='{"total":"'.$total.'"'
			.',"time":"'.$time.'"'
			.',"title":"评审关联文件"'
			.',"msg":"'.$msg.'"'
			.',"rows":['.$rows.']}';

		/************返回数据*****************/
		echo $json;
	}
	
	/**
	 * 流转税
	 * json
	 */
	public function get_json_tax()
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
			$arr_search['sort']='tax_sn';
			$arr_search['order']='asc';
		}

		$arr_search['where']='';
		$arr_search['value']=array();
		/************查询条件*****************/
		
		if( ! empty(element('search_budm_id', $data_get)))
		{
			$arr_search['where']=" AND budm_id = ?";
			$arr_search['value'][]=$data_get['search_budm_id'];
		}

		if( $query )
		{
			if( ! $field_q ) $field_q="bp_time";

			if( ! $field_s ) $field_s=$field_q;

			$arr_search['where'].=" AND CONCAT({$field_q}) like '%".$this->m_base->escape_like_str($query)."%'";
		}

		$arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);
		/************数据查询*****************/
		$arr_field_search=array(
			't.t_id',
			't_name',
			'tax_no_new',
			'tax_rate',
		);

		if($query)
		{
			$arr_field_search = explode(',', $field_s);
		}
		
		$arr_field_search[]='tax_id';

		$arr_search['field']=implode(',', $arr_field_search);

		$arr_search['from']='fm_bud_tax tax
							 LEFT JOIN fm_tax_type t ON
							 (t.t_id = tax.t_id )';

		$rs=$this->m_db->query($arr_search);

		/************json拼接****************/

		if (count($rs['content']) > 0)
		{
			foreach($rs['content'] as $k => $v)
			{
				$row_f='';

				foreach ($arr_field_search as $f) {
					switch($f){
						default:
							if(isset($GLOBALS['m_bp']['text'][$f]) && isset($GLOBALS['m_bp']['text'][$f][$v[$f]]) )
								$v[$f]=$GLOBALS['m_bp']['text'][$f][$v[$f]];
					}

					$row_f.='"'.$f.'":"'.(element($f,$v)).'",';
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
				.',"title":"流转税"'
				.',"msg":"'.$msg.'"'
				.',"rows":['.$rows.']}';
		}

		/************返回数据*****************/
		echo $json;
	}
	
	/**
	 * json
	 */
	public function get_json_return_file()
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
		$gfc_id= $this->input->post_get('gfc_id');

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

		$arr_search['where']='';
		$arr_search['value']=array();
		/************查询条件*****************/

		/************数据查询*****************/
		$link_file_check='';
		$total = 0;
		
		//检查上传合同
		$arr_search=array();
		$arr_search['field']='f_t_id';
		$arr_search['from']="sys_file_type";
		$arr_search['where']= "AND f_t_check = ? ";
		$arr_search['value'][] = F_T_CHECK_GFC_RETURN;
		$rs=$this->m_db->query($arr_search);
		if(count($rs['content'])>0)
		{
			foreach ($rs['content'] as $v) {
				$link_file_check .= $v['f_t_id'].','; 
			}
		}
		
		if( ! empty($link_file_check) )
		{
			$link_file_check = trim($link_file_check,',');
			
			$arr_tmp = explode(',', $link_file_check);
			$arr_search=array();
			$arr_search['field']='count(lt.link_id) sum,lt.link_id';
			$arr_search['from']="sys_link lf
								 LEFT JOIN sys_link lt ON
								 (lt.op_id = lf.link_id AND lt.content = 'f_type') ";
			$arr_search['where']= " AND lf.op_id = ? AND lf.content = 'link_file' AND lt.link_id IN ? GROUP BY lt.link_id";
			$arr_search['value'][] = $gfc_id;
			$arr_search['value'][] = $arr_tmp ;
			$rs=$this->m_db->query($arr_search);
			
			$arr_file_link=array();
			if(count($rs['content'])>0)
			{
				foreach ($rs['content'] as $v) {
					$arr_file_link[$v['link_id']] = $v['sum'];
				}
			}
			
			$arr_search=array();
			$arr_search['field']='f_t_id,f_t_name';
			$arr_search['from']="sys_file_type";
			$arr_search['where']= " AND f_t_id IN ?";
			$arr_search['value'][] = $arr_tmp;
			$arr_search['sort'] = 'db_time_create';
			$arr_search['order']='asc';
			$rs=$this->m_db->query($arr_search);
			
			if(count($rs['content'])>0)
			{
				$i=1;
				foreach ($rs['content'] as $v) {
					
					switch ($i%4) {
						case 1:
						$total++;
						$rows.='{'
							  .'"file1":"'.fun_urlencode($v['f_t_name']).'"'
							  .',"file1_sum":"'.element($v['f_t_id'], $arr_file_link).'"'
							  .',"file1_id":"'.$v['f_t_id'].'"';
							
						break;
						case 2:
						$rows.=',"file2":"'.fun_urlencode($v['f_t_name']).'"'
							  .',"file2_sum":"'.element($v['f_t_id'], $arr_file_link).'"'
							  .',"file2_id":"'.$v['f_t_id'].'"';
						break;
						case 3:
						$rows.=',"file3":"'.fun_urlencode($v['f_t_name']).'"'
							  .',"file3_sum":"'.element($v['f_t_id'], $arr_file_link).'"'
							  .',"file3_id":"'.$v['f_t_id'].'"';
						break;
						case 0:
						$rows.=',"file4":"'.fun_urlencode($v['f_t_name']).'"'
							  .',"file4_sum":"'.element($v['f_t_id'], $arr_file_link).'"'
							  .',"file3_id":"'.$v['f_t_id'].'"'
							  .'},';
						break;
						
					}

					$i++;
				}
				
				$rows=trim($rows,',');
				
				if(($i-1)%4!=0)
				{
					$rows.='}';
				}
			}
		}
		
		/************json拼接****************/

		//结束时间
		$time_end=time();
		$time=$time_end-$time_start;

		$json.='{"total":"'.$total.'"'
			.',"time":"'.$time.'"'
			.',"title":"归还关联文件"'
			.',"msg":"'.$msg.'"'
			.',"rows":['.$rows.']}';

		/************返回数据*****************/
		echo $json;
	}
	
	/**
	 * 开票回款计划
	 * json
	 */
	public function get_json_bp()
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
		
		if( ! empty(element('flag_bill', $data_get)))
		{
//			$arr_search['sort']=array('bp_sum_kp','bp_time');
//			$arr_search['order']=array('asc','desc');
		}
		
		if( ! empty(element('search_gfc_id', $data_get)))
		{
			$arr_search['where']=" AND gfc_id = ?";
			$arr_search['value'][]=$data_get['search_gfc_id'];
		}

		if( $query )
		{
			if( ! $field_q ) $field_q="bp_time";

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
		);

		if($query)
		{
			$arr_field_search = explode(',', $field_s);
		}
		
		$arr_field_search[]='bp_id';

		$arr_search['field']=implode(',', $arr_field_search);

		$arr_search['from']='pm_bill_plan';

		$rs=$this->m_db->query($arr_search);

		/************json拼接****************/

		if (count($rs['content']) > 0)
		{
			foreach($rs['content'] as $k => $v)
			{
				$row_f='';

				foreach ($arr_field_search as $f) {
					switch($f){
						case 'bp_id':
							$row_f.='"'.$f.'_s":"'.element($f,$v).'",';
							break;
						default:
							if(isset($GLOBALS['m_bp']['text'][$f]) && isset($GLOBALS['m_bp']['text'][$f][$v[$f]]) )
								$v[$f]=$GLOBALS['m_bp']['text'][$f][$v[$f]];
					}

					$row_f.='"'.$f.'":"'.fun_urlencode(element($f,$v)).'",';
				}
				
				$v['bp_show'] = $v['bp_time'].','.$v['bp_type'].','.$v['bp_sum'];
				$row_f.='"bp_show":"'.$v['bp_show'].'",';
				
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
				.',"title":"开票回款计划索引"'
				.',"msg":"'.$msg.'"'
				.',"rows":['.$rows.']}';
		}

		/************返回数据*****************/
		echo $json;
	}
	
	/**
	 * 预算执行情况
	 * json
	 */
	public function get_bud_final()
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
		
		$sub_id = element('sub_id', $data_post);
		$gfc_id = element('gfc_id', $data_post);
		
		if( ! $sub_id || ! $gfc_id )
		 exit;
		
		$id = element('id', $data_post);
		/************数据查询*****************/
		 
		$rtn['sum_final'] = $rtn['sum_final_no'] = 0;
    	$rtn['sum_bud'] = $this->m_base->get_field_where('fm_gfc_bud','gbud_sum',
    								" AND gfc_id='{$gfc_id}' AND gbud_sub='{$sub_id}'") ;
    	//非开票往来
    	$rtn['sum_final'] += $this->m_base->get_field_where('fm_loan','sum(loan_sum)',
    					" AND loan_gfc_id='{$gfc_id}' AND loan_sub='{$sub_id}' AND ( ppo = 0 ) AND loan_id != '{$id}' ") ;
    	
    	$rtn['sum_final_no'] += $this->m_base->get_field_where('fm_loan','sum(loan_sum)',
    					" AND loan_gfc_id='{$gfc_id}' AND loan_sub='{$sub_id}' AND ( ppo > 1 ) AND loan_id != '{$id}' ") ;
    	
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
		$this->m_gfc->load();
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
				$arr_rtn=$this->m_gfc->load($arr_get,$arr_post);
				
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
		$data_out['title']='财务编号';

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
				
				$arr_rtn=$this->m_gfc->load($arr_get,$arr_post);
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
