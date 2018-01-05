<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 经费申请流程
 * @author 朱明
 *
 */
class Bl_ppo extends CI_Controller {

	
	public function __construct()
    {
        parent::__construct();
        $this->load->model('proc_bud/m_bl_ppo');
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
		
		$data_out['title']='经费流程索引';
		$data_out['time']=time();
		$data_out['url']='proc_bud-bl_ppo-index';
		
		$data_out['field_search_start']='blp_note';
		$data_out['field_search_rule_default']='{"field":"blp_note","field_s":"备注","table":"","value":"","rule":"like","group":"search","editor":"text"}';
		$data_out['field_search_rule']='
		{"id":"blp_note","text":"备注","rule":{"field":"blp_note","field_s":"备注","table":"","value":"'.element('blp_note',$data_get).'","rule":"like","group":"search","editor":"text"}},
		';

		$data_out['field_search_value_dispaly']= array(
		);
		$data_out['field_search_value_dispaly']=json_encode($data_out['field_search_value_dispaly']);
		
		$data_out=$this->m_base->get_person_conf_index($data_out);
		
		/************载入视图 ****************/
		$arr_view[]='proc_bud/bl_ppo/index';
		$arr_view[]='proc_bud/bl_ppo/index_js';
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
			$arr_search['sort']=array('blp_sub','blp_ppo','blp_ppo_num');
			$arr_search['order']=array('asc','asc','asc');
		}
		
		$arr_search['where']='';
		$arr_search['value']=array();
		/************查询条件*****************/
		
		if(element('search_blp_sub', $data_get))
		{
			$arr_search['where'] = ' AND blp_sub = ?';
			$arr_search['value'] = $data_get['search_blp_sub'];
		}
		
		if(element('search_blp_ppo', $data_get))
		{
			$arr_search['where'] = ' AND blp_ppo = ?';
			$arr_search['value'] = $data_get['search_blp_ppo'];
		}
		
		if( $query )
		{
			if( ! $field_q ) $field_q="blp_note";

			if( ! $field_s ) $field_s=$field_q;

			$arr_search['where'].=" AND CONCAT({$field_q}) like '%".$this->m_base->escape_like_str($query)."%'";
		}

		$arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);
		/************数据查询*****************/
		$arr_field_search=array(
			'blp_ppo',
			'blp_ppo_num',
			'blp_sum_start',
			'blp_sum_end',
			'blp_sub',
			'blp_note'
		);
		
		if($query)
		{
			$arr_field_search = explode(',', $field_s);
		}
		
		$arr_field_search[]='blp_id';

		$arr_search['field']=implode(',', $arr_field_search);
		
		$arr_search['from']='fm_bl_ppo';
		
		//查询阶段
		if( element('search_blp_ppo_num', $data_get) )
		{
			$arr_search['where'].=' GROUP BY blp_ppo_num';
			$arr_search['sort']='blp_ppo_num';
			$arr_search['order']='asc';
		}
		else 
		{
			$arr_field_search[] = 'blp_ou';
			$arr_field_search[] = 'blp_c';
		}
		
		$rs=$this->m_db->query($arr_search);
		
		/************json拼接****************/

		if (count($rs['content']) > 0)
		{
			foreach($rs['content'] as $k => $v)
			{
				if(  $v['blp_sum_end'] == 0)  $v['blp_sum_end'] = '';
				
				$row_f='';
				foreach ($arr_field_search as $f) {
					switch($f){
						case 'blp_ou':
							
							$arr_search_link=array();
							$arr_search_link['rows']=0;
							$arr_search_link['field']='link_id,ou_name';
							$arr_search_link['from']='sys_link l
													  LEFT JOIN sys_ou ou ON
													  (ou.ou_id=l.link_id)';
							$arr_search_link['where']=" AND op_id = ? AND op_table = ? AND op_field = ? AND content = ?";
							$arr_search_link['value'][]=$v['blp_id'];
							$arr_search_link['value'][]='fm_bl_ppo';
							$arr_search_link['value'][]='blp_id';
							$arr_search_link['value'][]='blp_ou';
							$rs_link=$this->m_db->query($arr_search_link);
							
							$v['blp_ou']='';
							$v['blp_ou_s']='';
				
							if(count($rs_link['content'])>0)
							{
								foreach ( $rs_link['content'] as $v1 ) {
									$v['blp_ou'].=$v1['link_id'].',';
									$v['blp_ou_s'].=$v1['ou_name'].',';
			
								}
								$v['blp_ou']=trim($v['blp_ou'],',');
								$v['blp_ou_s']=trim($v['blp_ou_s'],',');
							}
							$row_f.='"blp_ou_s":"'.fun_urlencode($v['blp_ou_s']).'",';		
							
							break;
						case 'blp_c':
							
							$arr_search_link=array();
							$arr_search_link['rows']=0;
							$arr_search_link['field']='link_id,c_name,c_login_id,c_tel';
							$arr_search_link['from']='sys_link l
													  LEFT JOIN sys_contact c ON
													  (c.c_id=l.link_id)';
							$arr_search_link['where']=" AND op_id = ? AND op_table = ? AND op_field = ? AND content = ?";
							$arr_search_link['value'][]=$v['blp_id'];
							$arr_search_link['value'][]='fm_bl_ppo';
							$arr_search_link['value'][]='blp_id';
							$arr_search_link['value'][]='blp_c';
							$rs_link=$this->m_db->query($arr_search_link);
							
							$v['blp_c']='';
							$v['blp_c_s']='';
				
							if(count($rs_link['content'])>0)
							{
								foreach ( $rs_link['content'] as $v1 ) {
									$v['blp_c'].=$v1['link_id'].',';
									$v['blp_c_s'].=$v1['c_name'].'['.$v1['c_login_id'].']';
								}
								$v['blp_c']=trim($v['blp_c'],',');
								$v['blp_c_s']=trim($v['blp_c_s'],',');
							}
							$row_f.='"blp_c_s":"'.fun_urlencode($v['blp_c_s']).'",';		
							
							break;
						case 'blp_sub':
							$v[$f.'_s'] = $this->m_base->get_field_where('fm_subject','sub_name'," AND sub_id = '{$v[$f]}'");
							$row_f.='"'.$f.'_s":"'.fun_urlencode($v[$f.'_s']).'",';
							break;
						default:
							if(isset($GLOBALS['m_bl_ppo']['text'][$f]) && isset($GLOBALS['m_bl_ppo']['text'][$f][$v[$f]]) )
								$v[$f]=$GLOBALS['m_bl_ppo']['text'][$f][$v[$f]];
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
				   .',"title":"经费流程"'
				   .',"msg":"'.$arr_search['page'].'"'
				   .',"rows":['.$rows.']}';
		}

		/************返回数据*****************/
		echo $json;
	}
	
	/**
	 * json 统计部门
	 */
	public function get_json_ou()
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
			$arr_search['sort']='blp_sub';
			$arr_search['order']='asc';
		}
		
		$arr_search['where']=' AND blp_ppo = ?';
		$arr_search['value']=array();
		$arr_search['value'][] = BLP_PPO_SH;
		/************查询条件*****************/
		
		if(element('search_sub', $data_get))
		{
			$arr_search['where'].= ' AND blp_sub = ?';
			$arr_search['value'][] = $data_get['search_sub'];
		}
		
		if(element('search_sum', $data_get))
		{
			$arr_search['where'].= ' AND blp_sum_start <= ? AND ( blp_sum_end >= ? OR blp_sum_end = 0)';
			$arr_search['value'][] = $data_get['search_sum'];
			$arr_search['value'][] = $data_get['search_sum'];
		}
		
		if( $query )
		{
			if( ! $field_q ) $field_q="blp_note";

			if( ! $field_s ) $field_s=$field_q;

			$arr_search['where'].=" AND CONCAT({$field_q}) like '%".$this->m_base->escape_like_str($query)."%'";
		}

		$arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);
		/************数据查询*****************/
		$arr_field_search=array(
			'ou_name',
			'ou_org'
		);
		
		if($query)
		{
			$arr_field_search = explode(',', $field_s);
		}
		
		$arr_field_search[] = 'link_id';

		$arr_search['field']=implode(',', $arr_field_search);
		
		$arr_search['from']='fm_bl_ppo blp 
							 LEFT JOIN sys_link l ON
							 ( l.op_id = blp.blp_id AND l.content = \'blp_ou\' )
							 LEFT JOIN sys_ou ou ON
							 ( ou.ou_id = l.link_id)';
		
		//查询阶段
		$arr_search['where'].=' GROUP BY l.link_id';
		
		$rs=$this->m_db->query($arr_search);
		/************json拼接****************/
		$check_ou_search = FALSE;
		
		if (count($rs['content']) > 0)
		{
			foreach($rs['content'] as $k => $v)
			{
				if( element('search_ou', $data_get) == $v['link_id'] )
				$check_ou_search = TRUE;
				
				$row_f='';
				foreach ($arr_field_search as $f) {
					switch($f){
						case 'ou_org':
							$v['ou_org_s'] = $this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id = '{$v[$f]}'");
						default:
							if(isset($GLOBALS['m_bl_ppo']['text'][$f]) && isset($GLOBALS['m_bl_ppo']['text'][$f][$v[$f]]) )
								$v[$f]=$GLOBALS['m_bl_ppo']['text'][$f][$v[$f]];
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
                    $row_f.=',"id":"'.$v[$field_id].'","text":"'.$v[$field_text].'-'.$v['ou_org_s'].'"';
                    $rows.='{'.$row_f.'},';
                }
				else
				{
					$rows.='{'.$row_f.'},';
				}
			}
			$rows=trim($rows,',');
		}
		
		if( ! $check_ou_search && element('search_ou', $data_get))
		{
			if($rows) $rows.=',';
			
			if($from == 'combobox')
            {
				$rows.='{"flag_read":"1","id":"'.$data_get['search_ou'].'","text":"'.$this->m_base->get_field_where('sys_ou ou LEFT JOIN sys_org o ON (o.o_id = ou.ou_org) ',"CONCAT(ou_name,'-',o_name)"," AND ou_id = '{$data_get['search_ou']}'").'"}';
            }
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
				   .',"title":"经费流程统计部门"'
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
		$this->m_bl_ppo->load();
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
				'blp_note'
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
				$arr_rtn=$this->m_bl_ppo->load($arr_get,$arr_post);
				
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
				
				$arr_get['blp_id']=$v;
				$arr_get['act']=STAT_ACT_EDIT;
				$arr_post=array();
				$arr_post['btn']=$btn;
				$arr_post['flag_more']=TRUE;
				$arr_post['content']=array();
				
				$arr_post= array_merge($arr_post,$arr_save);
				
				$arr_rtn=$this->m_bl_ppo->load($arr_get,$arr_post);
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
