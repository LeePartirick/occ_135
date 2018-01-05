<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 员工信息维护
 * @author 朱明
 *
 */
class Hr_info extends CI_Controller {

	
	public function __construct()
    {
        parent::__construct();
        $this->load->model('proc_hr/m_proc_hr');
        $this->load->model('proc_hr/m_hr_info');
		$this->load->model('base/m_base');
		$this->load->model('proc_contact/m_contact');
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
		
		if( empty(element('hr_type',$data_get)) ){
            
        	$data_get['hr_type'] = '';
        	
        	foreach ($GLOBALS['m_hr']['text']['hr_type'] as $k=>$v) {
        		switch($k)
        		{
        			case HR_TYPE_LZ:
        			case HR_TYPE_TX:
        				continue 2;
        		}
        		
        		$data_get['hr_type'] .= $k.',';
        	}
        	
        	$data_get['hr_type'] = trim($data_get['hr_type'],',');
        }
		/************事件处理*****************/
		
		/************模板赋值***********/
		$data_out['flag_select']=element('flag_select', $data_get);
		$data_out['fun_select']=element('fun_select', $data_get);
		
		$data_out['fun_open']=element('fun_open', $data_get);
		$data_out['fun_open_id']=element('fun_open_id', $data_get);
		
		$data_out['flag_zz'] = element('flag_zz', $data_get);
		
		$data_out['title']='员工索引';
		$data_out['time']=time();
		$data_out['url']='proc_hr-hr_info-index';

		$data_out['field_search_start']='c_org,hr_code,c_name,c_tel,c_ou_2,hr_type_work,hr_info_finish,hr_type,hr_time_rz_start,hr_time_rz_end,c_tel_code,hr_check';
		$data_out['field_search_rule_default']='{"field":"c_name","field_s":"姓名","table":"","value":"","rule":"like","group":"search","editor":"text"}';
		$data_out['field_search_rule']='
		{"id":"hr_code","text":"工号","rule":{"field":"hr_code","field_s":"工号","table":"","value":"'.element('hr_code',$data_get).'","rule":"like","group":"search","editor":"text"}}
		,{"id":"c_org","text":"所属机构","rule":{"field":"c_org","field_s":"所属机构","table":"","value":"'.element('c_org',$data_get).'","rule":"in","group":"search",
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
		,{"id":"c_name","text":"姓名","rule":{"field":"c_name","field_s":"姓名","table":"","value":"'.element('c_name',$data_get).'","rule":"like","group":"search","editor":"text"}}
		,{"id":"c_tel","text":"手机","rule":{"field":"c_tel","field_s":"手机","table":"","value":"'.element('c_tel',$data_get).'","rule":"like","group":"search","editor":"text"}}
		,{"id":"c_tel_code","text":"短号","rule":{"field":"c_tel_code","field_s":"短号","table":"","value":"'.element('c_tel_code',$data_get).'","rule":"like","group":"search","editor":"text"}}
		,{"id":"c_email","text":"Email","rule":{"field":"c_email","field_s":"Email","table":"","value":"'.element('c_email',$data_get).'","rule":"like","group":"search","editor":"text"}}
		,{"id":"c_sex","text":"性别","rule":{"field":"c_sex","field_s":"性别","table":"","value":"'.element('c_sex',$data_get).'","rule":"in","group":"search","editor":{
        	"type":"combotree",
				"options":{
				"valueField": "id",
				"textField": "text",
				"panelHeight":"auto",
				"multiple":"true",
				"data":['.get_json_for_arr($GLOBALS['m_contact']['text']['c_sex']).']
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
		,{"id":"c_ou_3","text":"三级部门","rule":{"field":"c_ou_3","field_s":"三级部门","table":"","value":"'.element('c_ou_3',$data_get).'","rule":"=","group":"search","editor":{
			"type":"combobox",
			"options":{
				"hasDownArrow":"",
				"panelHeight":"0",
				"start_fun":"load_c_ou_search'.$data_out['time'].'()"
			}
		}}}
		,{"id":"c_ou_4","text":"四级部门","rule":{"field":"c_ou_4","field_s":"四级部门","table":"","value":"'.element('c_ou_4',$data_get).'","rule":"=","group":"search","editor":{
			"type":"combobox",
			"options":{
				"hasDownArrow":"",
				"panelHeight":"0",
				"start_fun":"load_c_ou_search'.$data_out['time'].'()"
			}
		}}}
		,{"id":"c_job","text":"职位","rule":{"field":"c_job","field_s":"职位","table":"","value":"'.element('c_job',$data_get).'","rule":"=","group":"search","editor":{
			"type":"combobox",
			"options":{
				"hasDownArrow":"",
				"panelHeight":"0",
				"start_fun":"load_c_job_search'.$data_out['time'].'()"
			}
		}}}
		,{"id":"hr_type_work","text":"用工形式","rule":{"field":"hr_type_work","field_s":"用工形式","table":"","value":"'.element('hr_type_work',$data_get).'","rule":"in","group":"search","editor":{
        	"type":"combotree",
				"options":{
				"valueField": "id",
				"textField": "text",
				"panelHeight":"auto",
				"multiple":"true",
				"data":['.get_json_for_arr($GLOBALS['m_hr']['text']['hr_type_work']).']
				}
        }}}
        ,{"id":"hr_info_finish","text":"是否补全","rule":{"field":"hr_info_finish","field_s":"是否补全","table":"","value":"'.element('hr_info_finish',$data_get).'","rule":"in","group":"search","editor":{
        	"type":"combotree",
				"options":{
				"valueField": "id",
				"textField": "text",
				"panelHeight":"auto",
				"multiple":"true",
				"data":['.get_json_for_arr($GLOBALS['m_base']['text']['base_yn']).']
				}
        }}}
		,{"id":"hr_check","text":"信息审核","rule":{"field":"hr_check","field_s":"信息审核","table":"","value":"'.element('hr_check',$data_get).'","rule":"in","group":"search","editor":{
        	"type":"combotree",
				"options":{
				"valueField": "id",
				"textField": "text",
				"panelHeight":"auto",
				"multiple":"true",
				"data":['.get_json_for_arr($GLOBALS['m_hr']['text']['hr_check']).']
				}
        }}}
		,{"id":"hr_type","text":"人员类别","rule":{"field":"hr_type","field_s":"人员类别","table":"","value":"'.element('hr_type',$data_get).'","rule":"in","group":"search","editor":{
        	"type":"combotree",
				"options":{
				"valueField": "id",
				"textField": "text",
				"panelHeight":"auto",
				"multiple":"true",
				"data":['.get_json_for_arr($GLOBALS['m_hr']['text']['hr_type']).']
				}
        }}},
        {"id":"hr_time_rz_start","text":"入职日期（始）","rule":{"field":"hr_time_rz_start","field_s":"入职日期（始）","field_r":"hr_time_rz","table":"","value":"'.element('hr_time_rz',$data_get).'","rule":">=","group":"search","editor":{
			"type":"datebox",
			"options":{
				"groupSeparator":",",
				"precision":"2"
			}
		}}},
		{"id":"hr_time_rz_end","text":"入职日期（终）","rule":{"field":"hr_time_rz_end","field_s":"入职日期（终）","field_r":"hr_time_rz","table":"","value":"'.element('hr_time_rz',$data_get).'","rule":"<=","group":"search","editor":{
			"type":"datebox",
			"options":{
				"groupSeparator":",",
				"precision":"2"
			}
		}}},
		{"id":"hr_time_zz_start","text":"转正日期（始）","rule":{"field":"hr_time_zz_start","field_s":"转正日期（始）","field_r":"hr_time_zz","table":"","value":"'.element('hr_time_zz',$data_get).'","rule":">=","group":"search","editor":{
			"type":"datebox",
			"options":{
				"groupSeparator":",",
				"precision":"2"
			}
		}}},
		{"id":"hr_time_zz_end","text":"转正日期（终）","rule":{"field":"hr_time_zz_end","field_s":"转正日期（终）","field_r":"hr_time_zz","table":"","value":"'.element('hr_time_zz',$data_get).'","rule":"<=","group":"search","editor":{
			"type":"datebox",
			"options":{
				"groupSeparator":",",
				"precision":"2"
			}
		}}}
		,{"id":"hr_tec","text":"技术方向","rule":{"field":"hr_tec","field_r":"c_id","m_link":"c_id","m_link_content":"hr_tec","field_s":"技术方向","table":"hr","value":"'.element('hr_tec',$data_get).'","rule":"in","group":"search",
		  "fun_end":"fun_end_hr_tec_search'.$data_out['time'].'()",
		  "editor":{
			"type":"combotree",
				"options":{
				"valueField": "id",
				"textField": "text",
				"panelHeight":"auto",
				"multiple":"true",
				"panelMaxHeight":"120",
       			"url":"proc_hr/hr_tec/get_json/from/combobox/field_id/tec_id/field_text/tec_name",
				}
        }}}
		';
		
		$data_out['field_search_value_dispaly']= array(
			'hr_type_work'=>$GLOBALS['m_hr']['text']['hr_type_work'],
			'hr_info_finish'=>$GLOBALS['m_base']['text']['base_yn'],
			'hr_type'=>$GLOBALS['m_hr']['text']['hr_type'],
			'c_sex'=>$GLOBALS['m_contact']['text']['c_sex'],
			'hr_check'=>$GLOBALS['m_hr']['text']['hr_check']
		);
		$data_out['field_search_value_dispaly']=json_encode($data_out['field_search_value_dispaly']);

		$data_out=$this->m_base->get_person_conf_index($data_out);
		
		/************载入视图 ****************/
		$arr_view[]='proc_hr/hr_info/index';
		$arr_view[]='proc_hr/hr_info/index_js';
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
			$arr_search['sort']='hr_code';
			$arr_search['order']='desc';
		}

		switch ($arr_search['sort'])
		{
			case 'hr_code':
				$arr_search['sort']=array('hr_code_pre','hr_code');
				$arr_search['order']=array($arr_search['order']);
				break;
			case 'c_ou_2_s':
				$arr_search['sort']='c_ou_2';
				break;
			case 'c_org_s':
				$arr_search['sort']='c_org';
				break;
			case 'c_job_s':
				$arr_search['sort']='c_job';
				break;
		}

		$arr_search['where']='';
		$arr_search['value']=array();
		/************查询条件*****************/

		$acl_list= $this->m_proc_hr->get_acl();

		if(($acl_list & pow(2,ACL_PROC_HR_VIEW_ALL )) == 0 )
		{
//			$arr_search['where'].=" AND (c_org = ? OR c_org = ? OR c_hr_org = ? OR c_hr_org = ?) ";
//			$arr_search['value'][] = $this->sess->userdata('c_org');
//			$arr_search['value'][] = $this->sess->userdata('c_hr_org');
//			$arr_search['value'][] = $this->sess->userdata('c_org');
//			$arr_search['value'][] = $this->sess->userdata('c_hr_org');
		}
		
		if(element('flag_zz', $data_get))
		{
			$arr_search['where'].=" AND (hr_type != ? AND hr_type != ?) ";
			$arr_search['value'][] = HR_TYPE_LZ;
			$arr_search['value'][] = HR_TYPE_TX;
		}

		if( $query )
		{
			if( ! $field_q ) $field_q="c_name,c_login_id";

			$arr_search['where'].=" AND CONCAT({$field_q}) like '%".$this->m_base->escape_like_str($query)."%'";
		}

		$arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);

		/************数据查询*****************/

		$arr_field_search=array(
			'hr_code_pre',
			'hr_code',
			'c_name',
			'c_login_id',
			'c_sex',
			'c_birthday',
			'c_code_person',
			'c_tel',
			'c_tel_2',
			'c_tel_code',
			'hr_time_rz',
			'hr_time_zz',
			'c_job',
			'c_ou_2',
			'c_ou_3',
			'c_ou_4',
			'hr_type_work',
			'hr_type',
			'c_org',
			'c_hr_org',
			'hr_info_finish',
			'hr_check',
		);

		$arr_field_search[]='hr.c_id';

		$arr_search['field']=implode(',', $arr_field_search);

		$arr_search['from']='hr_info hr
							 LEFT JOIN sys_contact c ON
							 (c.c_id = hr.c_id)';

		$rs=$this->m_db->query($arr_search);
		
		$arr_field_search[]='hr_tec';
		$arr_field_search[]='hr_tec_s';
		
		/************json拼接****************/
		$show_by_rule=array();

		if (count($rs['content']) > 0)
		{
			foreach($rs['content'] as $k => $v)
			{
				$v['c_age']='';
				if($v['c_birthday'])
				$v['c_age'] =date("Y")-date('Y', strtotime($v['c_birthday']));

				if( ! $v['c_tel'] )
				$v['c_tel'] = $v['c_tel_2'];

				$row_f='';
				$arr_search_link=array();
				$arr_search_link['rows']=0;
				$arr_search_link['field']='link_id,tec_name,tec_id';
				$arr_search_link['from']='sys_link l
										  LEFT JOIN hr_tec t ON
										  (t.tec_id=l.link_id)';
				$arr_search_link['where']=" AND op_id = ? AND op_table = ? AND op_field = ? AND content = ?";
				$arr_search_link['value'][]=$v['c_id'];
				$arr_search_link['value'][]='hr_info';
				$arr_search_link['value'][]='c_id';
				$arr_search_link['value'][]='hr_tec';
				$rs_link=$this->m_db->query($arr_search_link);

				$v['hr_tec']='';
				$v['hr_tec_s']='';

				if(count($rs_link['content'])>0)
				{
					foreach ( $rs_link['content'] as $v1 ) {
						$v['hr_tec'].=$v1['link_id'];
						$v['hr_tec_s'].=$v1['tec_name'].',';

					}
					$v['hr_tec']=trim($v['hr_tec'],',');
					$v['hr_tec_s']=trim($v['hr_tec_s'],',');
				}

				foreach ($arr_field_search as $f) {

					switch ($f)
					{
						case 'hr.c_id':
							$f = 'c_id';
							break;
						case 'hr_code':
							$v[$f] = $v[$f.'_pre'].$v[$f];
							break;
						case 'c_sex':
							$v[$f] = $GLOBALS['m_contact']['text']['c_sex'][$v[$f]];
							break;
						case 'c_birthday':
							$row_f.='"c_age":"'.fun_urlencode($v['c_age']).'",';
							break;
						case 'c_ou_2':
						case 'c_ou_3':
						case 'c_ou_4':
							$row_f.='"'.$f.'_s":"'.fun_urlencode($this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id ='{$v[$f]}'")).'",';
							break;
						case 'c_job':
							$row_f.='"c_job_s":"'.fun_urlencode($this->m_base->get_field_where('hr_job','job_name'," AND job_id ='{$v[$f]}'")).'",';
							break;
						case 'c_hr_org':
						case 'c_org':
							$row_f.='"'.$f.'_s":"'.fun_urlencode($this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id ='{$v[$f]}'")).'",';
							break;
						case 'hr_info_finish'://导入时默认为零无法读取
							if( $v[$f] != 0 )
                                $v[$f] = $GLOBALS['m_base']['text']['base_yn'][$v[$f]];
                            else
                                $v[$f]='否';
							break;
						case 'hr_check':
							$v[$f] = $GLOBALS['m_hr']['text']['hr_check'][$v[$f]];
							break;


						default:
							if(isset($GLOBALS['m_hr']['text'][$f]) && isset($GLOBALS['m_hr']['text'][$f][$v[$f]]) )
							$v[$f]=$GLOBALS['m_hr']['text'][$f][$v[$f]];
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
	 * 培训
	 */
    public function get_json_train()
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
            $arr_search['sort']='hr_code';
            $arr_search['order']='desc';
        }

        switch ($arr_search['sort'])
        {
            case 'hr_code':
                $arr_search['sort']=array('hr_code_pre','hr_code');
                $arr_search['order']=array($arr_search['order']);
                break;
            case 'c_ou_2_s':
                $arr_search['sort']='c_ou_2';
                break;
            case 'c_org_s':
                $arr_search['sort']='c_org';
                break;
            case 'c_job_s':
                $arr_search['sort']='c_job';
                break;
        }

        $arr_search['where']='';
        $arr_search['value']=array();
        /************查询条件*****************/

        $acl_list= $this->m_proc_hr->get_acl();

        if(($acl_list & pow(2,ACL_PROC_HR_VIEW_ALL )) == 0 )
        {
            $arr_search['where'].=" AND (c_org = ? OR c_hr_org = ?) ";
            $arr_search['value'][] = $this->sess->userdata('c_org');
            $arr_search['value'][] = $this->sess->userdata('c_hr_org');
        }

        if( $query )
        {
            if( ! $field_q ) $field_q="c_name";

            $arr_search['where'].=" AND CONCAT({$field_q}) like '%".$this->m_base->escape_like_str($query)."%'";
        }

        $arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);

        /************数据查询*****************/

        $arr_field_search=array(
            'hr_code_pre',
            'hr_code',
            'c.c_id',
            'c_name',
            'c_job',
            'c_ou_2',
            'c_ou_3',
            'c_ou_4',
            'c_ou_bud',
            'hr_zw_1',
            'hr_zw_2',
            'hr_zw_3',
            'hr_t_time_start',
         	'hr_t_time_end',
            'hr_t_name',
            'hr_t_org',
            'hr_t_ca_name',
            'hr_t_type_last',
            'hr_t_time_ca_end',
        	'hr_vacation'
        );

        $arr_search['field']=implode(',', $arr_field_search);


        $arr_search['from']='hr_train t
        					LEFT JOIN hr_info hr ON
        					(hr.c_id=t.c_id)
                            LEFT JOIN sys_contact c ON
                            (hr.c_id=c.c_id)';
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
                        case 'hr_code':
                            $v[$f] = $v[$f.'_pre'].$v[$f];
                            break;
                        case 'c_sex':
                            $v[$f] = $GLOBALS['m_contact']['text']['c_sex'][$v[$f]];
                            break;
                        case 'hr_t_type_last':
                            $v[$f] = $GLOBALS['m_base']['text']['base_yn'][$v[$f]];
                            break;
                        case 'c_birthday':
                            $row_f.='"c_age":"'.fun_urlencode($v['c_age']).'",';
                            break;
                        case 'c_ou_bud':
                        case 'c_ou_2':
                        case 'c_ou_3':
                        case 'c_ou_4':
                            $row_f.='"'.$f.'_s":"'.fun_urlencode($this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id ='{$v[$f]}'")).'",';
                            break;
                        case 'c_job':
                            $row_f.='"c_job_s":"'.fun_urlencode($this->m_base->get_field_where('hr_job','job_name'," AND job_id ='{$v[$f]}'")).'",';
                            break;
                        default:
                            if(isset($GLOBALS['m_hr']['text'][$f]) && isset($GLOBALS['m_hr']['text'][$f][$v[$f]]) )
                                $v[$f]=$GLOBALS['m_hr']['text'][$f][$v[$f]];
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
                .',"title":"员工培训索引"'
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
		$this->m_hr_info->load();
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
                'hr_code',
	            'c_name',
	    		'c_login_id',
	            'c_sex',
	            'c_birthday',
	            'c_mz',
	            'c_hy',
	            'c_zzmm',
	            'c_code_person',
	            'c_tel',
	            'c_phone',
	            'c_email',
	            'c_hj',
	            'c_addr_live',
	            'c_addr',
	            'c_time_graduate',
	            'c_school',
	            'c_zy',
	    		'c_xw',
	    		'c_bank_type',
	            'c_bank',
	    		'c_time_work',
	    		'c_org',
	    		'c_hr_org',
	            'c_ou_2',
	            'c_ou_3',
	            'c_ou_4',
	    		'c_job',
	    		'hr_zw_1',
	            'hr_zw_2',
	            'hr_zw_3',
	    		'hr_zcdj',
	            'hr_zclb',
	            'hr_time_ht',
	            'hr_time_htdq',
	            'hr_type_work',
	            'hr_type',
	            'hr_time_rz',
	            'hr_wage_set',
	            'hr_time_lz',
	            'hr_time_zz',
	    		'hr_shbx',
	    		'c_card_gjj',
	    		'c_card_sb',
	    		'hr_vacation',
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
                        case 'hr_code';
                        	$arr_tmp = explode('30', $value);
                        	
                        	if(count($arr_tmp) != 2)
                        	$arr_tmp = explode('-', $value);
                        	
                            if(count($arr_tmp) == 2)
                            {
                            	if(strstr($value, '30'))
                            	$arr_post['content'][$v.'_pre'] = $arr_tmp[0].'30';
                            	else
                            	$arr_post['content'][$v.'_pre'] = $arr_tmp[0].'-';
                            	
                            	$value = $arr_tmp[1];
                            }
                            else 
                            {
                            	$value = '';
                            }
                            break;
                         case 'c_login_id';
                         	$arr_get['c_id'] = $this->m_base->get_field_where('sys_contact','c_id'," AND c_login_id = '{$value}'");
                         	
                         	if( $arr_get['c_id'] 
                         	 && $this->m_base->get_field_where('hr_info','c_id'," AND c_id = '{$arr_get['c_id']}'"))
                         	{
                         		$arr_get['act'] = STAT_ACT_EDIT;
                         		$arr_post['flag_edit_more'] = 1;
                         	}
                         	
                         	break;
                         case 'c_org':
                         case 'c_hr_org':	
                            $arr_post['content'][$v.'_s']=$value;
                            $value=$this->m_base->get_field_where('sys_ou','ou_id'," AND ou_name='{$value}'");
                            break;
                         case 'c_ou_2':
                         case 'c_ou_3':	
                         case 'c_ou_4':
                            $arr_post['content'][$v.'_s']=$value;
                            $arr_tmp=$this->m_base->get_field_where('sys_ou','ou_id',
                            " AND ou_name='{$value}' AND ou_org = '{$arr_post['content']['c_org']}' AND find_in_set('2',ou_tag)"
                            ,array(),TRUE);
                            
                            if(count($arr_tmp) == 1) $value = current($arr_tmp);
                            else $value = '';
                            
                            break;
                        case 'c_code_person';
                        case 'c_bank';
                        case 'c_card_gjj';
                        case 'c_card_sb';
                            $value = sctonum($value);
                        	break;
                        case 'bs_time':
                        case 'c_birthday':
				        case 'c_time_graduate':
				    	case 'c_time_work':
				        case 'hr_time_ht':
				        case 'hr_time_htdq':
				        case 'hr_time_rz':
				        case 'hr_time_lz':
				        case 'hr_time_zz':
							$value = gmdate("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($value));   
							break;
                        case 'c_sex':
                            $value=array_search($value,$GLOBALS['m_contact']['text']['c_sex']);
                            break;
                        case 'c_hy':
                            $value=array_search($value,$GLOBALS['m_hr']['text']['c_hy']);
                            break;
                        case 'c_zzmm':
                            $value=array_search($value,$GLOBALS['m_hr']['text']['c_zzmm']);
                            break;
                        case 'hr_zw_1':
                            $value=array_search($value,$GLOBALS['m_hr']['text']['hr_zw_1']);
                            break;
                        case 'hr_zw_2':
                            $value=array_search($value,$GLOBALS['m_hr']['text']['hr_zw_2']);
                            break;
                        case 'hr_zw_3':
                            $value=array_search($value,$GLOBALS['m_hr']['text']['hr_zw_3']);
                            break;
                        case 'c_job':
                            $arr_post['content'][$v.'_s']=$value;
                            $value=$this->m_base->get_field_where('hr_job','job_id'," AND job_name='{$value}'");
                            break;
                        case 'hr_type':
                            $value=array_search($value,$GLOBALS['m_hr']['text']['hr_type']);
                            break;
                        case 'hr_type_work':
                            $value=array_search($value,$GLOBALS['m_hr']['text']['hr_type_work']);
                            break;
                        case 'c_bank_type':
                            $value=array_search($value,$GLOBALS['m_hr']['text']['c_bank_type']);
                            break;
                        case 'c_xw':
                            $value=array_search($value,$GLOBALS['m_hr']['text']['c_xw']);
                            break;
                        case 'hr_zcdj':
                            $value=array_search($value,$GLOBALS['m_hr']['text']['hr_zcdj']);
                            break;
                        case 'hr_zclb':
                            $value=array_search($value,$GLOBALS['m_hr']['text']['hr_zclb']);
                            break;
                        case 'hr_shbx':
                            $value=array_search($value,$GLOBALS['m_hr']['text']['hr_shbx']);
                            break;

					}

					$arr_post['content'][$v] = $value;
					$col_num++;
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
                
                if( element('flag_edit_more', $arr_get) == 1)
                {
                	$arr_post['content'] = array_filter($arr_post['content'] );
                	
                	if(count($arr_post['content']) > 0)
                	{
                		foreach ($arr_post['content'] as $k=>$v) {
                			$arr_post['content'][$k.'_check'] = 1;
                		}
                	}
                }
        
				$arr_post['btn']='save';
				$arr_rtn=$this->m_hr_info->load($arr_get,$arr_post);

				if( ! element('rtn', $arr_rtn) )
				{
					$msg_err.='第'.$row_num.'行,导入失败！错误为:<br/>'.element('msg_err',$arr_rtn).'<br/>';
				}
				else
				{
					$num_import++;
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
		$data_out['title']='员工信息';
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
				
				$arr_get['c_id']=$v;
				$arr_get['act']=STAT_ACT_EDIT;
				$arr_post=array();
				$arr_post['btn']=$btn;
				$arr_post['flag_more']=TRUE;
				$arr_post['content']=array();
				
				$arr_post= array_merge($arr_post,$arr_save);
				
				$arr_rtn=$this->m_hr_info->load($arr_get,$arr_post);
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
	
	/**
	 * 
	 * 工号重置
	 */
	public function fun_reload_hr_code()
	{
		//判断是否ajax请求
        $is_ajax=$this->input->is_ajax_request();
        if( ! $is_ajax) exit;
        
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
		$c_id = $this->input->get_post('c_id');
		$acl_list= $this->m_proc_hr->get_acl();
		$data_post['content'] = $this->input->get_post('content');
		/************处理事件*****************/
		
		if(  ($acl_list & pow(2,ACL_PROC_HR_INFO_CHECK )) == 0 || ! $c_id )
    	exit;
    	
    	$data_db['content'] = $this->m_hr_info->get($c_id);
    	
    	$this->m_table_op->load('sys_contact');
		$data_db['content_c'] =  $this->m_table_op->get($c_id);
    	
		$data_post['content'] = array_filter($data_post['content']);
    	$data_db['content']= array_merge($data_db['content_c'],$data_db['content'],$data_post['content']);
    	
    	$data_db = $this->m_hr_info->get_code($data_db);
    	
    	$rtn = array();
    	$rtn['hr_code_pre'] = $data_db['content']['hr_code_pre'];
    	$rtn['hr_code'] = $data_db['content']['hr_code'];
    	echo json_encode($rtn);
	}
}
