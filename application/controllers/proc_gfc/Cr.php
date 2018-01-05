<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 合同评审项目
 * @author 朱明
 *
 */
class Cr extends CI_Controller {

	
	public function __construct()
    {
        parent::__construct();
        $this->load->model('proc_gfc/m_cr');
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
		
		$data_out['title']='合同评审项目索引';
		$data_out['time']=time();
		if( ! empty(element('time', $data_get)) )
		$data_out['time']=element('time', $data_get);
		
		$data_out['url']='proc_cr-cr-index';
		
		$data_out['field_search_start']='cr_name';
		$data_out['field_search_rule_default']='{"field":"cr_name","field_s":"评审内容","table":"pm_contract_review","value":"","rule":"like","group":"search","editor":"textbox"}';
		$data_out['field_search_rule']='
		{"id":"cr_name","text":"评审内容","rule":{"field":"cr_name","field_s":"评审内容","table":"pm_contract_review","value":"'.element('cr_name',$data_get).'","rule":"like","group":"textbox","editor":"datebox"}}
		';
		
		$data_out['field_search_value_dispaly']= array(
		);
		$data_out['field_search_value_dispaly']=json_encode($data_out['field_search_value_dispaly']);
		
		$data_out=$this->m_base->get_person_conf_index($data_out);
		
		/************载入视图 ****************/
		$arr_view[]='proc_gfc/cr/index';
		$arr_view[]='proc_gfc/cr/index_js';
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
			$arr_search['sort']='cr_sn';
			$arr_search['order']='asc';
		}

		$arr_search['where']='';
		$arr_search['value']=array();
		/************查询条件*****************/
		
		if( element('search_cr_ppo_min', $data_get) )
		{
			$arr_search['where']=' AND cr_ppo >= ? ';
			$arr_search['value'][] = $data_get['search_cr_ppo_min'];
		}
		
		if( element('search_cr_link_field', $data_get) )
		{
			$arr_search['where']=' AND cr_link_field = ? ';
			$arr_search['value'][] = $data_get['search_cr_link_field'];
		}
		
		if( element('search_cr_default', $data_get) )
		{
			$arr_search['where']=' AND FIND_IN_SET(?,cr_default) ';
			$arr_search['value'][] = $data_get['search_cr_default'];
		}

		if( $query )
		{
			if( ! $field_q ) $field_q="cr_name";

			if( ! $field_s ) $field_s=$field_q;

			$arr_search['where'].=" AND CONCAT({$field_q}) like '%".$this->m_base->escape_like_str($query)."%'";
		}

		$arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);
		/************数据查询*****************/
		$arr_field_search=array(
			'cr_name',
			'cr_sn',
			'cr_ppo',
			'cr_default',
			'cr_person_empty',
			'cr_pass_alter',
			'cr_note',
			'cr_link_field',
			'cr_link_file',
		);

		if($query)
		{
			$arr_field_search = explode(',', $field_s);
		}
		
		$arr_field_search[]='cr_id';

		$arr_search['field']=implode(',', $arr_field_search);

		$arr_search['from']='pm_contract_review';
		
		//查询评审阶段
		if( element('search_cr_ppo', $data_get) )
		{
			$arr_search['where'].=' GROUP BY cr_ppo';
			$arr_search['sort']='cr_ppo';
			$arr_search['order']='asc';
		}
		else
		{
			$arr_field_search[]='cr_person';
			
			if( element('search_gfc_category_main', $data_get) )
			{
				$arr_field_search[]='gfcc_id';
				$arr_field_search[]='gfcc_cr_id';
				$arr_field_search[]='gfcc_cr_id_s';
				$arr_field_search[]='gfcc_c_id';
				$arr_field_search[]='gfcc_c_id_s';
				$arr_field_search[]='gfcc_default';
				$arr_field_search[]='gfcc_ou';
				$arr_field_search[]='gfcc_ou_s';
			}
		}
		
		$rs=$this->m_db->query($arr_search);

		/************json拼接****************/

		if (count($rs['content']) > 0)
		{
			foreach($rs['content'] as $k => $v)
			{
				$row_f='';
				
				foreach ($arr_field_search as $f) {
					switch($f){
						case 'cr_link_file':
							
							$v['cr_link_file_s']='';
				
							if($v[$f])
							{
								$arr_tmp = explode(',', $v['cr_link_file']);
						
								$arr_search_link=array();
								$arr_search_link['field']='f_t_id,f_t_name';
								$arr_search_link['from']="sys_file_type";
								$arr_search_link['where']= ' AND f_t_id IN ? ';
								$arr_search_link['value'][] = $arr_tmp;
								
								$rs_link=$this->m_db->query($arr_search_link);
						
								foreach ( $rs_link['content'] as $v1 ) {
									$v['cr_link_file_s'].=$v1['f_t_name'].',';
			
								}
								$v['cr_link_file_s']=trim($v['cr_link_file_s'],',');
							}
							$row_f.='"cr_link_file_s":"'.fun_urlencode($v['cr_link_file_s']).'",';		
							break;
						case 'cr_link_field':
							
							break;
						case 'gfcc_id':
							$v['gfcc_id'] = get_guid();
							break;
						case 'gfcc_default':
							$v['gfcc_default'] =1;
							break;
						case 'gfcc_cr_id':
							$v['gfcc_cr_id'] = $v['cr_id'];
							$v['gfcc_cr_id_s'] = $v['cr_name'];
							break;
						case 'gfcc_c_id':
							$v['gfcc_c_id_s'] = $v['cr_person'];
							$v['gfcc_c_id'] = element('crp_c_id', $v);
							
							break;
						case 'cr_person':
							
							$arr_search_link=array();
							$arr_search_link['rows']=0;
							$arr_search_link['field']='crp_c_id,c_name,c_login_id,c_tel,ou_id,ou_name';
							$arr_search_link['from']='pm_cr_person crp
													  LEFT JOIN sys_contact c ON
													  (c.c_id=crp.crp_c_id)
													  LEFT JOIN sys_ou ou ON
													  (ou.ou_id = c.c_ou_bud)';
							$arr_search_link['where']=" AND cr_id = ? ";
							$arr_search_link['value'][]=$v['cr_id'];
							$arr_search_link['sort']='crp_sn';
							$arr_search_link['order']='asc';
							
							if(element('search_gfc_category_main', $data_get) && element('search_gfc_ou', $data_get) )
							{
								$arr_search_link['from'].='LEFT JOIN sys_link l ON
														   (l.op_id = crp.crp_id AND l.content = \'cr_gfc_ou\') ';
								$arr_search_link['where'] .=" AND FIND_IN_SET(?,cr_gfc_category_main)  ";
								$arr_search_link['value'][] = $data_get['search_gfc_category_main'];
								
								$arr_search_link['where'] .=" AND l.link_id IN ?  ";
								
								$this->m_table_op->load('sys_ou');
								$data_db['content_ou'] = $this->m_table_op->get($data_get['search_gfc_ou']);
								
								$arr_search_link['value'][] = explode(',', $data_db['content_ou']['ou_parent_path']);
								
								$arr_search_link['where'] .=" GROUP BY crp.crp_id";
								
							}
							
							$rs_link=$this->m_db->query($arr_search_link);
							
							$v['cr_person']='';
							
							if(count($rs_link['content'])>0)
							{
								foreach ( $rs_link['content'] as $v1 ) {
									$v['crp_c_id'] = $v1['crp_c_id'];
									$v['cr_person'].=$v1['c_name'];
									$v['gfcc_ou']=$v1['ou_id'];
									$v['gfcc_ou_s']=$v1['ou_name'];
									if( $v1['c_login_id'] )
									$v['cr_person'].='['.$v1['c_login_id'].'],';
									elseif( $v1['c_tel'] )
									$v['cr_person'].='['.$v1['c_tel'].'],';
									
									if(element('search_gfc_category_main', $data_get))
									{
										break;
									}
								}
								$v['cr_person']=trim($v['cr_person'],',');
							}
							
							break;
						case 'cr_default':
							$v[$f.'_s'] = '';
							if($v[$f])
							{
								$arr_tmp = explode(',', $v[$f]);
								
								foreach ($arr_tmp as $v1 ){
									$v[$f.'_s'] .= element($v1, $GLOBALS['m_cr']['text'][$f]).',';
								}
							
								$v[$f.'_s'] = trim($v[$f.'_s'],',');
							}
							$row_f.='"cr_default_s":"'.fun_urlencode($v['cr_default_s']).'",';	
							break;
						default:
							if(isset($GLOBALS['m_cr']['text'][$f]) && isset($GLOBALS['m_cr']['text'][$f][$v[$f]]) )
								$v[$f]=$GLOBALS['m_cr']['text'][$f][$v[$f]];
					}

					if(element('search_gfc_category_main', $data_get))
					{
						$row_f.='"'.$f.'":"'.(element($f,$v)).'",';
					}
					else 
					{
						$row_f.='"'.$f.'":"'.fun_urlencode(element($f,$v)).'",';
					}
				}
				$row_f=trim($row_f,',');

				if( element('search_gfc_category_main', $data_get)
				 && ! element('crp_c_id', $v)  
				 && element('search_cr_id', $data_get) != $v['cr_id'] )
				{
					continue;
				}
				
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
				.',"title":"合同评审项索引"'
				.',"msg":"'.$msg.'"'
				.',"rows":['.$rows.']}';
		}

		/************返回数据*****************/
		echo $json;
	}
	
	/**
	 * json
	 */
	public function get_json_crp()
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
			$arr_search['sort']='crp_sn';
			$arr_search['order']='asc';
		}

		$arr_search['where']='';
		$arr_search['value']=array();
		/************查询条件*****************/
		
		if( element('search_cr_id', $data_get) )
		{
			$arr_search['where']=' AND cr_id = ?';
			$arr_search['value'][]=$data_get['search_cr_id'];
		}
		
		$arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);

		if( $query )
		{
			if( ! $field_q ) $field_q="c_name,c_login_id";

			if( ! $field_s ) $field_s=$field_q;

			$arr_search['where'].=" AND CONCAT({$field_q}) like '%".$this->m_base->escape_like_str($query)."%'";
		}

		$arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);
		/************数据查询*****************/
		$arr_field_search=array(
			'c_name',
			'c_login_id',
			'c_tel',
			'ou_name',
			'crp_note'
		);

		if($query)
		{
			$arr_field_search = explode(',', $field_s);
		}
		
		$arr_field_search[]='c_id';

		$arr_search['field']=implode(',', $arr_field_search);

		$arr_search['from']='pm_cr_person crp
							 LEFT JOIN sys_contact c ON
							 (c.c_id = crp.crp_c_id)
							 LEFT JOIN sys_ou ou ON
							 (ou.ou_id = c.c_ou_bud)';
		
		if(element('search_gfc_category_main', $data_get) && element('search_gfc_ou', $data_get) )
		{
			$arr_search['from'].='LEFT JOIN sys_link l ON
									   (l.op_id = crp.crp_id AND l.content = \'cr_gfc_ou\') ';
			$arr_search['where'] .=" AND FIND_IN_SET(?,cr_gfc_category_main )  ";
			$arr_search['value'][] = $data_get['search_gfc_category_main'];
			
			$arr_search['where'] .=" AND l.link_id IN ?  ";
			
			$this->m_table_op->load('sys_ou');
			$data_db['content_ou'] = $this->m_table_op->get($data_get['search_gfc_ou']);
			
			$arr_search['value'][] = explode(',', $data_db['content_ou']['ou_parent_path']);
			
			$arr_search['where'] .=" GROUP BY crp.crp_id";
			
		}
		
		$rs=$this->m_db->query($arr_search);

		/************json拼接****************/

		if (count($rs['content']) > 0)
		{
			foreach($rs['content'] as $k => $v)
			{
				$row_f='';
				
				foreach ($arr_field_search as $f) {
					switch($f){
						case 'c_name':
							if($v['c_login_id']) $v[$f].='['.$v['c_login_id'].']';
							elseif($v['c_tel']) $v[$f].='['.$v['c_tel'].']';
							
							if($v['crp_note']) $v[$f].='('.$v['crp_note'].')';
							break;
						default:
							if(isset($GLOBALS['m_cr']['text'][$f]) && isset($GLOBALS['m_cr']['text'][$f][$v[$f]]) )
								$v[$f]=$GLOBALS['m_cr']['text'][$f][$v[$f]];
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
				.',"title":"合同评审人"'
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
		$this->m_cr->load();
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
				'cr_name',
				'cr_ppo',
				'cr_default',
				'cr_note',
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
						case 'cr_default':
							if( ! $value) $value = 0;
							break;
					}
					
					$arr_post['content'][$v] = $value;
					$col_num++;
				}
				
				$arr_post['btn']='save';
				$arr_rtn=$this->m_cr->load($arr_get,$arr_post);
				
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
		$data_out['title']='合同评审项';

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
		$cr_sn = $this->input->post('cr_sn');
		
		$arr_save = array();
		
		if($json_save)
		$arr_save = json_decode($json_save,TRUE);
		
		if( ! $cr_sn ) $cr_sn = 1;
		
		$time_start=time();
		/************处理事件*****************/
		
		$list=explode(',', $list);
		
		$sn = 1;
		
		if(count($list) > 0)
		{
			foreach ($list as $k => $v) {
					
				$arr_get=array();
				
				$arr_get['cr_id']=$v;
				$arr_get['act']=STAT_ACT_EDIT;
				$arr_post=array();
				$arr_post['btn']=$btn;
				$arr_post['flag_more']=TRUE;
				$arr_post['content']=array();
				
				if($btn == 'sort')
				{
					$arr_post['content']['cr_sn'] = $cr_sn;
				}
			
				$arr_post= array_merge($arr_post,$arr_save);
				
				$arr_rtn=$this->m_cr->load($arr_get,$arr_post);
				if( ! isset($arr_rtn['rtn']) )
				$arr_rtn['rtn'] = $arr_rtn['result'];
				
				if( ! $arr_rtn['rtn'] )
				{
					$msg_err.='执行失败！错误为:<br/>'.$arr_rtn['msg_err'].'<br/>';
				}
				elseif($btn == 'sort')
				{
					$cr_sn++;
				}
					
				unset($list[$k]);
				
				//防止超时
				$time_end=time();
				
				if( $time_end-$time_start > 5 )
				{
			
					$rtn['rs']=FALSE;
					$rtn['list']=implode(',', $list);
					$rtn['msg_err']=$msg_err;
					$rtn['cr_sn']=$cr_sn;
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
