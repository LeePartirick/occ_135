<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 * 管理
 * @author 朱明
 *
 */
class Oa_office extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->model('proc_office/m_oa_office');
		$this->load->model('proc_office/m_proc_office');
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

		$data_out['title']='信息系统索引';
		$data_out['time']=time();
		$data_out['url']='proc_office-oa_office-index';

		$data_out['field_search_start']='offi_name,offi_note,offi_person_start,offi_org,offi_org_default';
		$data_out['field_search_rule_default']='{"field":"offi_name","field_s":"系统名称","table":"oa_office","value":"","rule":"like","group":"search","editor":"text"}';
		$data_out['field_search_rule']='
		{"id":"offi_name","text":"系统名称","rule":{"field":"offi_name","field_s":"系统名称","table":"oa_office","value":"'.element('offi_name',$data_get).'","rule":"like","group":"search","editor":"text"}},
		{"id":"offi_note","text":"备注","rule":{"field":"offi_note","field_s":"备注","table":"oa_office","value":"'.element('offi_note',$data_get).'","rule":"like","group":"search","editor":"text"}},
		{"id":"offi_person_start","text":"系统开通人","rule":{"field":"offi_person_start","field_r":"offi_id","m_link":"offi_id","field_s":"系统开通人","table":"oa_office","value":"'.element('offi_person_start',$data_get).'","rule":"=","group":"search",
		 "editor":{
			"type":"combobox",
			"options":{
				"hasDownArrow":"",
				"panelHeight":"0",
				"start_fun":"load_offi_person_start_search'.$data_out['time'].'()"
			}
		}}},
		{"id":"offi_org","text":"使用机构","rule":{"field":"offi_org","field_s":"使用机构","table":"","value":"'.element('offi_org',$data_get).'","rule":"find_in_set","group":"search",
		 "fun_end":"fun_end_offi_org_search'.$data_out['time'].'()",
		 "editor":{
			"type":"combotree",
			"options":{
				"valueField": "id",
				"textField": "text",
				"multiple":"true",
				"panelWidth":"300",
				"panelHeight":"auto",
				"start_fun":"load_offi_org_search'.$data_out['time'].'()"
			}
		}}},
		{"id":"offi_org_default","text":"默认开启","rule":{"field":"offi_org_default","field_s":"默认开启","table":"","value":"'.element('offi_org_default',$data_get).'","rule":"find_in_set","group":"search",
		 "fun_end":"fun_end_offi_org_search'.$data_out['time'].'()",
		 "editor":{
			"type":"combotree",
			"options":{
				"valueField": "id",
				"textField": "text",
				"multiple":"true",
				"panelWidth":"300",
				"panelHeight":"auto",
				"start_fun":"load_offi_org_search'.$data_out['time'].'()"
			}
		}}}
		';

		$data_out['field_search_value_dispaly']= array(

		);
		$data_out['field_search_value_dispaly']=json_encode($data_out['field_search_value_dispaly']);

		$data_out=$this->m_base->get_person_conf_index($data_out);

		/************载入视图 ****************/
		$arr_view[]='proc_office/oa_office/index';
		$arr_view[]='proc_office/oa_office/index_js';
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
			$arr_search['sort']='offi_name';
			$arr_search['order']='asc';
		}

		$arr_search['where']='';
		$arr_search['value']=array();
		/************查询条件*****************/
		
		//使用机构
		if( element('search_org', $data_get) )
		{
			$arr_search['where'].=" AND find_in_set( ?,offi_org )";
			$arr_search['value'][]=$data_get['search_org'];
		}

		if( element('search_offi_id', $data_get) )
		{
			$arr_search['where'].=" OR (offi_id = ? )";
			$arr_search['value'][]=$data_get['search_offi_id'];
		}
		
		if( $query )
		{
			if( ! $field_q ) $field_q="offi_name";
			if( ! $field_s ) $field_s=$field_q;
			
			$arr_search['where'].=" AND CONCAT({$field_q}) like '%".$this->m_base->escape_like_str($query)."%'";
		}

		$arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);
		/************数据查询*****************/
		$arr_field_search=array(
			'offi_name',
			'offi_note',
			'offi_org',
			'offi_org_default',
		);
		
		if($query)
		{
			$arr_field_search = explode(',', $field_s);
		}
		
		$arr_field_search[]='offi_id';

		$arr_search['field']=implode(',', $arr_field_search);

		$arr_search['from']='oa_office';

		$rs=$this->m_db->query($arr_search);
		
		$arr_field_search[]='offi_person_start';
		$arr_field_search[]='offi_person_start_s';
		/************json拼接****************/

		if (count($rs['content']) > 0)
		{
			foreach($rs['content'] as $k => $v)
			{
				$row_f='';
				
				$arr_search_link=array();
				$arr_search_link['rows']=0;
				$arr_search_link['field']='link_id,c_name,c_login_id';
				$arr_search_link['from']='sys_link l
										  LEFT JOIN sys_contact c ON
										  (c.c_id=l.link_id)';
				$arr_search_link['where']=" AND op_id = ? AND op_table = ? AND op_field = ? AND content = ?";
				$arr_search_link['value'][]=$v['offi_id'];
				$arr_search_link['value'][]='oa_office';
				$arr_search_link['value'][]='offi_id';
				$arr_search_link['value'][]='offi_person_start';
				$rs_link=$this->m_db->query($arr_search_link);
				
				$v['offi_person_start']='';
				$v['offi_person_start_s']='';
				
				if(count($rs_link['content'])>0)
				{
					foreach ( $rs_link['content'] as $v1 ) {
						$v['offi_person_start'].=$v1['link_id'];
						$v['offi_person_start_s'].=$v1['c_name'];
						if( $v1['c_login_id'] )
						$v['offi_person_start_s'].='['.$v1['c_login_id'].'],';
					}
					$v['offi_person_start']=trim($v['offi_person_start'],',');
					$v['offi_person_start_s']=trim($v['offi_person_start_s'],',');
				}
				
				foreach ($arr_field_search as $f) {

					if(isset($GLOBALS['m_oa_office']['text'][$f]) && isset($GLOBALS['m_oa_office']['text'][$f][$v[$f]]) )
						$v[$f]=$GLOBALS['m_oa_office']['text'][$f][$v[$f]];
						
					//使用机构的多选
					switch($f){
						case 'offi_org':
							$arr_tmp=explode(',', $v[$f]);

							$v[$f]='';
							if(count($arr_tmp) > 0)
							{
								foreach ($arr_tmp as $v1) {
									//根据ou_id查询ou_name
									$v[$f].=$this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id ='$v1'").',';
								}
							}

							$v[$f]=trim($v[$f],',');
							$row_f.='"offi_org_s":"'.fun_urlencode($v[$f]).'",';
							break;

						case 'offi_org_default':
							$arr_tmp=explode(',', $v[$f]);

							$v[$f]='';
							if(count($arr_tmp) > 0)
							{
								foreach ($arr_tmp as $v1) {
									//根据ou_id查询ou_name
									$v[$f].=$this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id ='$v1'").',';
								}
							}

							$v[$f]=trim($v[$f],',');
							$row_f.='"offi_org_default":"'.fun_urlencode($v[$f]).'",';
							break;
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
				.',"title":"信息系统列表"'
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
		$this->m_oa_office->load();
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
				'offi_name',
				'offi_note',
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

//					switch ($v) {
//					}

					$arr_post['content'][$v] = $value;
					$col_num++;
				}

				$arr_post['btn']='save';
				$arr_rtn=$this->m_oa_office->load($arr_get,$arr_post);

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
		$data_out['title']='信息系统';

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

				$arr_get['offi_id']=$v;
				$arr_get['act']=STAT_ACT_EDIT;
				$arr_post=array();
				$arr_post['btn']=$btn;
				$arr_post['flag_more']=TRUE;

				$arr_rtn=$this->m_oa_office->load($arr_get,$arr_post);
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
