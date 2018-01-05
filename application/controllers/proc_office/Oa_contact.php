<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 * 员工索引
 * @author 李怡昕
 *
 */
class Oa_contact extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->model('proc_office/m_proc_office');
		$this->load->model('proc_office/m_oa_contact');
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

		$data_out['title']='员工索引';
		$data_out['time']=time();
		$data_out['url']='proc_office-oa_contact-index';

		$data_out['field_search_start']='offa_code,c_name,c_login_id,c_job,c_ou_2,c_org';
		$data_out['field_search_rule_default']='{"field":"offa_code","field_s":"单据编号","table":"oa_office_apply","value":"","rule":"like","group":"search","editor":"text"}';
		$data_out['field_search_rule']='
		{"id":"offa_code","text":"单据编号","rule":{"field":"offa_code","field_s":"单据编号","table":"","value":"'.element('offa_code',$data_get).'","rule":"like","group":"search","editor":"text"}}
		,{"id":"c_name","text":"姓名","rule":{"field":"c_name","field_s":"姓名","table":"","value":"'.element('c_name',$data_get).'","rule":"like","group":"search","editor":"text"}}
		,{"id":"c_login_id","text":"关联账户","rule":{"field":"c_login_id","field_s":"关联账户","table":"","value":"'.element('c_login_id',$data_get).'","rule":"like","group":"search","editor":"text"}}
		,{"id":"c_job","text":"职位","rule":{"field":"c_job","field_s":"职位","table":"","value":"'.element('c_job',$data_get).'","rule":"=","group":"search","editor":{
			"type":"combobox",
			"options":{
				"hasDownArrow":"",
				"panelHeight":"0",
				"start_fun":"load_c_job_search'.$data_out['time'].'()"
			}
		}}}
		,{"id":"c_ou_2","text":"二级部门","rule":{"field":"c_ou_2","field_s":"二级部门","table":"","value":"'.element('c_ou_2',$data_get).'","rule":"=","group":"search","editor":{
			"type":"combobox",
			"options":{
				"hasDownArrow":"",
				"panelHeight":"0",
				"start_fun":"load_c_ou_search'.$data_out['time'].'()"
			}
		}}}
		,{"id":"c_org","text":"所属公司","rule":{"field":"c_org","field_s":"所属公司","table":"","value":"'.element('c_org',$data_get).'","rule":"in","group":"search",
		 "fun_end":"fun_end_c_org_search'.$data_out['time'].'()",
		 "editor":{
			"type":"combotree",
			"options":{
				"valueField": "id",
				"textField": "text",
				"multiple":"true",
				"panelWidth":"300",
				"panelHeight":"auto",
				"start_fun":"load_c_org_search'.$data_out['time'].'()"
			}
		}}}
		';

		$data_out['field_search_value_dispaly']= array(

		);
		$data_out['field_search_value_dispaly']=json_encode($data_out['field_search_value_dispaly']);

		$data_out=$this->m_base->get_person_conf_index($data_out);

		/************载入视图 ****************/
		$arr_view[]='proc_office/oa_contact/index';
		$arr_view[]='proc_office/oa_contact/index_js';
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
			$arr_search['sort']=array('c_name');
			$arr_search['order']=array('asc');
		}

		switch ($arr_search['sort'])
		{

		}

		$arr_search['where']='';
		$arr_search['value']=array();
		/************查询条件*****************/

		if( $query )
		{
			if( ! $field_q ) $field_q="hr_code";

			$arr_search['where'].=" AND CONCAT({$field_q}) like '%".$this->m_base->escape_like_str($query)."%'";
		}

		$arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);

		/************数据查询*****************/

		$arr_field_search=array(
			'c_name',
			'c_login_id',
			'c_job',
			'c_ou_2',
			'c_org',
		);

		$arr_field_search[]='c.c_id';

		$arr_search['field']=implode(',', $arr_field_search);

		$arr_search['from']='sys_contact c
							LEFT JOIN hr_info hr ON
							(hr.c_id = c.c_id)';

		$rs=$this->m_db->query($arr_search);
		/************json拼接****************/
		$show_by_rule=array();

		if (count($rs['content']) > 0)
		{
			foreach($rs['content'] as $k => $v)
			{
				$row_f='';
				foreach ($arr_field_search as $f) {

					switch ($f)
					{
						case 'c.c_id':
							$f = 'c_id';
							break;
						case 'c_job':
							$row_f.='"c_job_s":"'.fun_urlencode($this->m_base->get_field_where('hr_job','job_name'," AND job_id ='{$v[$f]}'")).'",';
							break;
						case 'c_ou_2':
							$row_f.='"c_ou_2_s":"'.fun_urlencode($this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id ='{$v[$f]}'")).'",';
							break;
						case 'c_org':
							$row_f.='"c_org_s":"'.fun_urlencode($this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id ='{$v[$f]}'")).'",';
							break;
						default:
							if(isset($GLOBALS['m_oa_contact']['text'][$f]) && isset($GLOBALS['m_oa_contact']['text'][$f][$v[$f]]) )
								$v[$f]=$GLOBALS['m_oa_contact']['text'][$f][$v[$f]];
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
				.',"title":"员工索引"'
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
		$this->m_oa_contact->load();
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
        $sheet_num  = $this->input->post('sheet_num');
        if( ! $sheet_num ) $sheet_num = 1;

        $rtn_data = array();
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
            $sheet = $PHPExcel->getSheet($sheet_num - 1);

            $check_empty=0;

            //@todo 导入列
            $col = array(
                'c_name',
                'c_login_id',
                'offai_offi_id',
                'offai_model',
                'offa_note'
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

                    	case 'c_login_id':
                            $arr_post['content']['offai_c_id']=$this->m_base->get_field_where('sys_contact','c_id'," AND c_login_id='{$value}'");
                            break;
                        case 'offai_offi_id':
                        	$arr_post['content']['offai_offi_id_s'] = $value;
                            $value=$this->m_base->get_field_where('oa_office','offi_id'," AND offi_name='{$value}'");
                            break;

                    }


                    $arr_post['content'][$v] = $value;
                    $col_num++;
                }
                
                $arr_post['btn']='save';
                
                $arr_rtn=$this->m_oa_offai->load($arr_get,$arr_post);

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
                    $rtn['sheet_num']=$sheet_num;
                    $rtn['rtn_data']=json_encode($rtn_data);
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
        $data_out['title']='信息系统';
        $data_out['c_id']=element('c_id',$data_get);
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

				$arr_get['offai_id']=$v;
				$arr_get['act']=STAT_ACT_EDIT;
				$arr_post=array();
				$arr_post['btn']=$btn;
				$arr_post['flag_more']=TRUE;
				$arr_post['content']=array();

				$arr_rtn=$this->m_oa_contact->load($arr_get,$arr_post);
				if( ! isset($arr_rtn['rtn']) )
					$arr_rtn['rtn'] = $arr_rtn['result'];

				if( ! $arr_rtn['rtn'] )
				{
					$msg_err.='执行失败！错误为:<br/>'.$arr_rtn['msg_err'].'<br/>';
				}

				unset($list[$k]);

				//防止超时
				$time_end=time();

				if( $time_end-$time_start > 15 )
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