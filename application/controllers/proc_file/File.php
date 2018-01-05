<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 文档管理
 * @author 朱明
 *
 */
class File extends CI_Controller {

	
	public function __construct()
    {
        parent::__construct();
        $this->load->model('proc_file/m_file');
        $this->load->model('proc_file/m_proc_file');
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
		
		$data_out['title']='文件索引';
		$data_out['time']=time();
		if( ! empty(element('time', $data_get)) )
		$data_out['time']=element('time', $data_get);
		
		$data_out['url']='proc_file-file-index';
		
		$data_out['field_search_start']='f_name';
		$data_out['field_search_rule_default']='{"field":"f_name","field_s":"文件名","table":"sys_file","value":"","rule":"like","group":"search","editor":"text"}';
		$data_out['field_search_rule']='
		{"id":"f_name","text":"文件名","rule":{"field":"f_name","field_s":"文件名","table":"sys_file","value":"'.element('f_name',$data_get).'","rule":"like","group":"search","editor":"text"}}
		';
		
		$data_out['field_search_value_dispaly']= array(
		);
		$data_out['field_search_value_dispaly']=json_encode($data_out['field_search_value_dispaly']);
		
		$data_out=$this->m_base->get_person_conf_index($data_out);
		
		/************载入视图 ****************/
		$arr_view[]='proc_file/file/index';
		$arr_view[]='proc_file/file/index_js';
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

		if( element('link_op_id', $data_get) )
		{
			$arr_search['where'] = ' AND f_id IN ( 
										select link_id 
										FROM sys_link 
										WHERE op_id = ? 
											  AND op_table = ?
											  AND op_field = ?
									)';
			$arr_search['value'][] =  $data_get['link_op_id'];
			$arr_search['value'][] =  $data_get['link_op_table'];
			$arr_search['value'][] =  $data_get['link_op_field'];
		}

		if( $query )
		{
			if( ! $field_q ) $field_q="f_name";

			if( ! $field_s ) $field_s=$field_q;

			$arr_search['where'].=" AND CONCAT({$field_q}) like '%".$this->m_base->escape_like_str($query)."%'";
		}

		$arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);
		/************数据查询*****************/
		$arr_field_search=array(
			'f_name',
			'f_size',
			'f_v_sn',
			'f_secrecy',
			'db_time_create',
			'db_time_update',
			'db_person_create',
			'f_note',
		);

		if($query)
		{
			$arr_field_search = explode(',', $field_s);
		}
		
		$arr_field_search[]='f_id';

		$arr_search['field']=implode(',', $arr_field_search);

		$arr_search['from']='sys_file';

		$rs=$this->m_db->query($arr_search);

		$arr_field_search[]='f_type';
		$arr_field_search[]='f_type_s';
		/************json拼接****************/

		if (count($rs['content']) > 0)
		{
			foreach($rs['content'] as $k => $v)
			{
				$row_f='';
				
				foreach ($arr_field_search as $f) {
					switch($f){
						case 'f_name':
							
							$arr_tmp = get_arr_by_filename($v[$f]);
							$v[$f] = $arr_tmp['filename'];
							if(element($v['f_secrecy'], $GLOBALS['m_file']['text']['f_secrecy_all']))
							$v[$f] = '['.element($v['f_secrecy'], $GLOBALS['m_file']['text']['f_secrecy_all']).']'.$v[$f];
							
							$v[$f] .='-'.$v['f_v_sn'].'-'.date("Ymd",strtotime($v['db_time_update']));
							
							$v[$f] .= '.'.$arr_tmp['ext'];
							
							break;
						case 'db_person_create':
							$v[$f.'_s'] = $this->m_base->get_c_show_by_cid($v[$f]);
							$row_f.='"'.$f.'_s":"'.fun_urlencode($v[$f.'_s']).'",';
							break;
						case 'f_size':
							$v[$f] = byte_format($v[$f],2);
							break;
						case 'f_type':
							//获取文件属性
							$arr_search_link=array();
							$arr_search_link['rows']=0;
							$arr_search_link['field']='link_id,f_t_name';
							$arr_search_link['from']='sys_link l
													  LEFT JOIN sys_file_type f_t ON
													  (f_t.f_t_id = l.link_id)';
							$arr_search_link['where']=" AND op_id = ? AND op_table = ? AND op_field = ? AND content = ?";
							$arr_search_link['value'][]=$v['f_id'];
							$arr_search_link['value'][]='sys_file';
							$arr_search_link['value'][]='f_id';
							$arr_search_link['value'][]='f_type';
							$rs_link=$this->m_db->query($arr_search_link);
							$v['f_type']='';
							$v['f_type_s']='';
							
							if(count($rs_link['content'])>0)
							{
								foreach ( $rs_link['content'] as $v1 ) {
									$v['f_type']=$v1['link_id'].',';
									$v['f_type_s']=$v1['f_t_name'].',';
								}
							}
							break;
						default:
							if(isset($GLOBALS['m_file']['text'][$f]) && isset($GLOBALS['m_file']['text'][$f][$v[$f]]) )
								$v[$f]=$GLOBALS['m_file']['text'][$f][$v[$f]];
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
				.',"title":"文件列表"'
				.',"msg":"'.$msg.'"'
				.',"rows":['.$rows.']}';
		}

		/************返回数据*****************/
		echo $json;
	}
	
	/**
	 * json
	 */
	public function get_json_verson()
	{
		//判断是否ajax请求
		$is_ajax=$this->input->is_ajax_request();
		if( ! $is_ajax) exit;

		/************变量初始化****************/
		//开始时间
		$time_start=time();

		$arr_search=array();
		$data_search=array();
		$data_db=array();

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
		
		if(element('f_id', $data_get))
		{
			$arr_search['where']=' AND f_id = ? ';
			$arr_search['value'][]=$data_get['f_id'];
			
			$data_db['content']=$this->m_file->get($data_get['f_id']);
		}

		if( $query )
		{
			if( ! $field_q ) $field_q="f_name";

			if( ! $field_s ) $field_s=$field_q;

			$arr_search['where'].=" AND CONCAT({$field_q}) like '%".$this->m_base->escape_like_str($query)."%'";
		}

		$arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);
		/************数据查询*****************/
		$arr_field_search=array(
			'f_v_sn',
			'db_time_create',
			'db_person_create',
			'f_v_size',
			'f_v_note',
			'f_id',
		);

		if($query)
		{
			$arr_field_search = explode(',', $field_s);
		}
		
		$arr_field_search[]='f_v_id';

		$arr_search['field']=implode(',', $arr_field_search);

		$arr_search['from']='sys_file_verson';

		$rs=$this->m_db->query($arr_search);
		
		$arr_field_search[]='db_person_create_s';
		$arr_field_search[]='now';
		/************json拼接****************/

		if (count($rs['content']) > 0)
		{
			foreach($rs['content'] as $k => $v)
			{
				$row_f='';
				$v['db_person_create_s'] = $this->m_base->get_c_show_by_cid($v['db_person_create']);

				$v['now'] = '';
				
				if(element('f_id', $data_get))
				{
					if( element('f_v_sn', $data_db['content']) == $v['f_v_sn'] )
					$v['now'] = 1;
				}
				
				foreach ($arr_field_search as $f) {
					
					switch($f){
						default:
							if(isset($GLOBALS['m_file']['text'][$f]) && isset($GLOBALS['m_file']['text'][$f][$v[$f]]) )
								$v[$f]=$GLOBALS['m_file']['text'][$f][$v[$f]];
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
				.',"title":"文件版本列表"'
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
		$this->m_file->load();
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
				'f_name',
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
				$arr_rtn=$this->m_file->load($arr_get,$arr_post);
				
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
		$data_out['title']='文件';

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
				
				$arr_get['f_id']=$v;
				$arr_get['act']=STAT_ACT_EDIT;
				$arr_post=array();
				$arr_post['btn']=$btn;
				$arr_post['flag_more']=TRUE;
				$arr_post['content']=array();
				
				$arr_post= array_merge($arr_post,$arr_save);
				
				$arr_rtn=$this->m_file->load($arr_get,$arr_post);
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
					$rtn['json_save'] = $arr_save;
					echo json_encode($rtn);;
					exit;
				}
			}
		}
		
		$rtn['rs']=TRUE;
		$rtn['list']=array();
		$rtn['msg_err']=$msg_err;
		$rtn['json_save'] = $arr_save;
			
		/************返回结果 *****************/
		echo json_encode($rtn);;
		exit;
		
	}
	
	/**
	 * 
	 * 文件版本更新
	 */
	public function fun_update_verson()
	{
		/************变量初始化****************/
		$arr_view = array();//视图数组
		$data_post= array();//$POST数组
		$data_get = array();//$GET 数组
		$data_out = array();//输出数组
		$data_db  = array();//数据库数据
		
		$data_out['field_required']=array();
		$data_out['field_edit']=array();
		$data_out['field_view']=array();
		$data_out['op_disable']=array();
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		
		/************事件处理*****************/
		$data_save['content']['f_id']=$this->input->post('f_id');
		$data_save['content']['f_v_sn']=$this->input->post('f_v_sn');
		$data_save['content']['f_v_id']=$this->input->post('f_v_id');
		$data_save['content']['f_size']=$this->input->post('f_size');
		
		$this->m_file->update($data_save['content']);
		
		//操作日志
		$data_save['content_log']['op_id']=$data_save['content']['f_id'];
		$data_save['content_log']['log_act']=STAT_ACT_EDIT;
		$data_save['content_log']['log_url']=$this->url_conf.'/'.$this->pk_id.'/'.$data_save['content']['f_id'];
		$data_save['content_log']['log_content']=json_encode($arr_log_content);
		$data_save['content_log']['log_module']=$this->title;
		$data_save['content_log']['log_p_id']=$this->proc_id;
		$data_save['content_log']['log_note']='版本更新至-'.$data_save['f_v']['f_v_sn'];
		$this->m_log_operate->add($data_save['content_log']);
		
		/************返回结果 *****************/
	}
}
