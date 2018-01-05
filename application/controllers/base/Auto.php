<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 * 自动补全方法
 * @author 朱明
 *
 */
class Auto extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
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
     * 账户
     */
    public function get_json_account()
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
            $arr_search['rows'] = 10;
        }

        //排序
        $arr_search['order']=$this->input->post_get('order');
        $arr_search['sort']=$this->input->post_get('sort');

        if( empty($arr_search['sort']) )
        {
            $arr_search['sort']='a_login_id';
            $arr_search['order']='asc';
        }

        $arr_search['where']='';
        $arr_search['value']=array();
        /************查询条件*****************/

        if( element('search_a_name_no', $data_get) )
        {
            $arr_search['where'].=" AND c.c_id is NULL";
        }

        if( $query )
        {
            if( ! $field_q ) $field_q="a_login_id";

            $arr_search['where'].=" AND CONCAT({$field_q}) like '%".$this->m_base->escape_like_str($query)."%'";
        }

        $arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);

        /************数据查询*****************/

        $arr_search['field']='a.a_id,a_login_id,a_name';
        $arr_field_search=explode(',', $arr_search['field']);

        $arr_search['from']='sys_account a
							 LEFT JOIN sys_contact c ON
							 (c.c_id = a.a_id)';

        $rs=$this->m_db->query($arr_search);
        /************json拼接****************/

        if (count($rs['content']) > 0)
        {
            foreach($rs['content'] as $k => $v)
            {
                $row_f='';
                foreach ($arr_field_search as $f) {

                    switch ($f)
                    {
                        case 'a.a_id':
                            $f = 'a_id';
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
                .',"title":"账户列表"'
                .',"msg":"'.$msg.'"'
                .',"rows":['.$rows.']}';
        }

        /************返回数据*****************/
        echo $json;
    }

    /**
     * 团队部门
     */
    public function get_json_ou()
    {
        //判断是否ajax请求
        $is_ajax=$this->input->is_ajax_request();
        if( ! $is_ajax) exit;

        $this->load->model('proc_ou/m_ou');
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

        //查询条件
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
            $arr_search['rows'] = 10;
        }

        //排序
        $arr_search['order']=$this->input->post_get('order');
        $arr_search['sort']=$this->input->post_get('sort');

        if( empty($arr_search['sort']) )
        {
            $arr_search['sort']=array("instr('{$this->sess->userdata('c_org')}',ou_org)",'ou_code');
            $arr_search['order']=array('desc');
        }

        $arr_search['where']='';
        $arr_search['value']=array();
        /************查询条件*****************/
        //初始查询条件
        $arr_search['where'].=' AND ou_status = ? AND ou_class = ? ';
        $arr_search['value'][]=OU_STATUS_RUN;
        $arr_search['value'][]=OU_CLASS_OU;

        if( element('flag_tree',$data_get) == 1)
        {
            $tree_id=$this->input->post('id');
            if( ! empty($tree_id) )
            {
                $arr_search['where'].=' AND ou_parent = ? ';
                $arr_search['value'][] =  fun_urldecode($tree_id);
            }
            else
            {
                $arr_search['where'].=' AND ou_parent = ? ';
                $arr_search['value'][] =  'base';
            }
        }

        if( $query )
        {
            if( ! $field_q ) $field_q="ou_name,o_name";

            $arr_search['where'].=" AND CONCAT({$field_q}) like '%".$this->m_base->escape_like_str($query)."%'";
        }
        $arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);

        /************数据查询*****************/

        $arr_field_search=array(
            'ou_id',
            'ou_code',
            'ou_name',
            'o_name'
        );

        $arr_search['field']=implode(',', $arr_field_search);

        $arr_search['from']='sys_ou ou
							 LEFT JOIN sys_org o ON
							 (o.o_id = ou.ou_org)';

        $rs=$this->m_db->query($arr_search);
        /************json拼接****************/
        if (count($rs['content']) > 0)
        {
            foreach($rs['content'] as $k => $v)
            {
                $row_f='';
                foreach ($arr_field_search as $f) {

                    switch ($f)
                    {
                        case 'ou_parent':

                            $v['ou_parent_s']=$this->m_base->get_field_where('sys_ou','ou_name',"AND ou_id = '".element($f,$v)."'");
                            $row_f.='"'.$f.'_s":"'.fun_urlencode($v['ou_parent_s']).'",';

                            if( element('flag_tree',$data_get) )
                            {
                                if( element($f,$v) != 'base')
                                    $row_f.='"_parentId":"'.fun_urlencode(element($f,$v)).'",';

                                $row_f.='"state":"closed","iconCls":"tree-folder",';

                            }

                            break;
                        case 'ou_tag':
                            $arr_tmp=explode(',', $v[$f]);

                            $v[$f]='';
                            if(count($arr_tmp) > 0)
                            {
                                foreach ($arr_tmp as $v1) {
                                    $v[$f].=element($v1, $GLOBALS['m_ou']['text'][$f]).',';
                                }
                            }

                            $v[$f]=trim($v[$f],',');

                            break;
//						case 'ou_org':
//							$row_f.='"ou_org_s":"'.fun_urlencode($this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id ='{$v[$f]}'")).'",';
//							break;
                        default:
                            if(isset($GLOBALS['m_ou']['text'][$f]) && isset($GLOBALS['m_ou']['text'][$f][$v[$f]]) )
                                $v[$f]=$GLOBALS['m_ou']['text'][$f][$v[$f]];

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
                .',"title":"团队列表"'
                .',"msg":"'.$msg.'"'
                .',"rows":['.$rows.']}';
        }

        /************返回数据*****************/
        echo $json;
    }

    /**
     * 分支机构
     */
    public function get_json_hr_org()
    {
        //判断是否ajax请求
        $is_ajax=$this->input->is_ajax_request();
        if( ! $is_ajax) exit;

        $this->load->model('proc_ou/m_ou');
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

        //查询条件
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
            $arr_search['rows'] = 10;
        }

        if( $from == 'combobox' )
            $arr_search['rows'] = 0;

        //排序
        $arr_search['order']=$this->input->post_get('order');
        $arr_search['sort']=$this->input->post_get('sort');

        if( empty($arr_search['sort']) )
        {
            $arr_search['sort']='ou_code';
            $arr_search['order']='asc';
        }

        $arr_search['where']='';
        $arr_search['value']=array();
        /************查询条件*****************/
        //初始查询条件
        $arr_search['where'].=' AND ou_status = ? AND ou_class = ? AND ou_level IN ?';
        $arr_search['value'][]=OU_STATUS_RUN;
        $arr_search['value'][]=OU_CLASS_OU;
        $arr_search['value'][]=array(OU_LEVEL_ORG,OU_LEVEL_CORG);

        if( element('flag_tree',$data_get) == 1)
        {
            $tree_id=$this->input->post('id');
            if( ! empty($tree_id) )
            {
                $arr_search['where'].=' AND ou_parent = ? ';
                $arr_search['value'][] =  fun_urldecode($tree_id);
            }
            else
            {
                $arr_search['where'].=' AND ou_parent = ? ';
                $arr_search['value'][] =  'base';
            }
        }

        if( $query )
        {
            if( ! $field_q ) $field_q="ou_code,ou_name";

            $arr_search['where'].=" AND CONCAT({$field_q}) like '%".$this->m_base->escape_like_str($query)."%'";
        }

        $arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);

        /************数据查询*****************/

        $arr_field_search=array(
            'ou_id',
            'ou_code',
            'ou_name',
        );

        $arr_search['field']=implode(',', $arr_field_search);

        $arr_search['from']='sys_ou';

        $rs=$this->m_db->query($arr_search);

        /************json拼接****************/
        if (count($rs['content']) > 0)
        {
            foreach($rs['content'] as $k => $v)
            {
                $row_f='';
                foreach ($arr_field_search as $f) {

                    switch ($f)
                    {
                        case 'ou_parent':

                            $v['ou_parent_s']=$this->m_base->get_field_where('sys_ou','ou_name',"AND ou_id = '".element($f,$v)."'");
                            $row_f.='"'.$f.'_s":"'.fun_urlencode($v['ou_parent_s']).'",';

                            if( element('flag_tree',$data_get) )
                            {
                                if( element($f,$v) != 'base')
                                    $row_f.='"_parentId":"'.fun_urlencode(element($f,$v)).'",';

                                $row_f.='"state":"closed","iconCls":"tree-folder",';

                            }

                            break;
                        case 'ou_tag':
                            $arr_tmp=explode(',', $v[$f]);

                            $v[$f]='';
                            if(count($arr_tmp) > 0)
                            {
                                foreach ($arr_tmp as $v1) {
                                    $v[$f].=element($v1, $GLOBALS['m_ou']['text'][$f]).',';
                                }
                            }

                            $v[$f]=trim($v[$f],',');

                            break;
                        case 'ou_org':
                            $row_f.='"ou_org_s":"'.fun_urlencode($this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id ='{$v[$f]}'")).'",';
                            break;
                        default:
                            if(isset($GLOBALS['m_ou']['text'][$f]) && isset($GLOBALS['m_ou']['text'][$f][$v[$f]]) )
                                $v[$f]=$GLOBALS['m_ou']['text'][$f][$v[$f]];

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
                .',"title":"分支机构"'
                .',"msg":"'.$msg.'"'
                .',"rows":['.$rows.']}';
        }

        /************返回数据*****************/
        echo $json;
    }

    /**
     * 机构列表
     */
    public function get_json_org()
    {
        //判断是否ajax请求
        $is_ajax=$this->input->is_ajax_request();
        if( ! $is_ajax) exit;

        $this->load->model('proc_org/m_org');
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

        //查询条件
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
            $arr_search['rows'] = 10;
        }

        //排序
        $arr_search['order']=$this->input->post_get('order');
        $arr_search['sort']=$this->input->post_get('sort');

        if( empty($arr_search['sort']) )
        {
            $arr_search['sort']='o_code';
            $arr_search['order']='desc';
        }

        $arr_search['where']='';
        $arr_search['value']=array();
        /************查询条件*****************/
        if( ! empty(element('search_o_status', $data_get)))
        {
            $arr_search['where']=" AND (o_status = ? )";
            $arr_search['value'][]=O_STATUS_YES;
        }

        //初始查询条件

        if( $query )
        {
            if( ! $field_q ) $field_q="o_code,o_name";

            $arr_search['where'].=" AND CONCAT({$field_q}) like '%".$this->m_base->escape_like_str($query)."%'";
        }

        $arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);

        /************数据查询*****************/
        $arr_field_search=array(
            'o_code',
            'o_id',
            'o_name',
            'o_id_standard',
        );

        $arr_search['field']=implode(',', $arr_field_search);

        $arr_search['from']='sys_org';

        $rs=$this->m_db->query($arr_search);
        /************json拼接****************/

        if (count($rs['content']) > 0)
        {
            foreach($rs['content'] as $k => $v)
            {
                $row_f='';
                foreach ($arr_field_search as $f) {

                    switch ($f)
                    {
                        case 'o_id_standard':

                            $v['o_id_standard_s']=$this->m_base->get_field_where('sys_org','o_name',"AND o_id = '".element($f,$v)."'");
                            $row_f.='"'.$f.'_s":"'.fun_urlencode($v['o_id_standard_s']).'",';

                            break;
                        default:
                            if(isset($GLOBALS['m_org']['text'][$f]) && isset($GLOBALS['m_org']['text'][$f][$v[$f]]) )
                                $v[$f]=$GLOBALS['m_org']['text'][$f][$v[$f]];
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
                .',"title":"机构列表"'
                .',"msg":"'.$msg.'"'
                .',"rows":['.$rows.']}';
        }

        /************返回数据*****************/
        echo $json;
    }

    /**
     * 联系人
     */
    public function get_json_contact()
    {
        //判断是否ajax请求
        $is_ajax=$this->input->is_ajax_request();
//		if( ! $is_ajax) exit;

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

        //查询方法
        $fun_p=element('fun_p',$data_get);
        $fun_m=element('fun_m',$data_get);
        $fun_f=element('fun_f',$data_get);

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
            $arr_search['rows'] = 10;
        }

        //排序
        $arr_search['order']=$this->input->post_get('order');
        $arr_search['sort']=$this->input->post_get('sort');

        if( empty($arr_search['sort']) )
        {
            $arr_search['sort']='c_login_id';
            $arr_search['order']='asc';
        }

        $arr_search['where']='';
        $arr_search['value']=array();
        /************查询条件*****************/
        if( ! empty(element('search_c_login_id', $data_get)))
        {
            $arr_search['where']=" AND (c_login_id != '' AND c_login_id IS NOT NULL)";
        }

        if( ! empty(element('search_c_org', $data_get)))
        {
            $arr_search['where']=" AND (c_org = ?)";
            $arr_search['value'][] = $data_get['search_c_org'];
        }

        if( $query )
        {
            if( ! $field_q ) $field_q="c_name,c_login_id";

            if( ! $field_s ) $field_s=$field_q;

            $arr_search['where'].=" AND (
											CONCAT({$field_q}) like '%".$this->m_base->escape_like_str($query)."%'
										OR c_tel like '%".$this->m_base->escape_like_str($query)."%'
										OR c_tel_code like '%".$this->m_base->escape_like_str($query)."%'
										)";
        }

        $arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);

        /************数据查询*****************/

        $arr_search['field']='c_id,c_login_id,c_name,c_tel,c_tel_code,c_org,c_ou_bud,c_phone';
        $arr_field_search=explode(',', $arr_search['field']);

        $arr_search['from']='sys_contact';

        if($fun_p && $fun_m && $fun_f)
        {
            $this->load->model($fun_p.'/'.$fun_m);
            $arr_search = $this->$fun_m->$fun_f($arr_search);
        }
        $rs=$this->m_db->query($arr_search);

        /************json拼接****************/

        $arr_field_search[]='c_show';

        if (count($rs['content']) > 0)
        {
            foreach($rs['content'] as $k => $v)
            {
                $row_f='';
                $v['c_show']=$v['c_name'];

                if( $v['c_login_id'] )
                    $v['c_show'].='['.$v['c_login_id'].']';
                elseif( $v['c_tel'] )
                    $v['c_show'].='['.$v['c_tel'].']';

                if( $v['c_ou_bud'])
                    $v['c_ou_bud_s']=$this->m_base->get_field_where('sys_ou','ou_name',"AND ou_id = '{$v['c_ou_bud']}'");

                foreach ($arr_field_search as $f) {
                    switch ( $f )
                    {
                        case 'c_ou_bud':
                            $row_f.='"'.$f.'_s":"'.fun_urlencode(element($f.'_s',$v)).'",';
                            break;
                    }
                    $row_f.='"'.$f.'":"'.fun_urlencode(element($f,$v)).'",';
                }
                $row_f=trim($row_f,',');

                if( $query )
                {
                    $tmp_arr=explode(',', $field_q);

                    $str = $v['c_name'];

                    if( $v['c_login_id'] )
                        $str.='['.$v['c_login_id'].']';

                    if( $v['c_tel'] )
                        $str.=','.$v['c_tel'];

                    if( $v['c_tel_code'] )
                        $str.=','.$v['c_tel_code'];

                    $rows.='{"value":"'.$str.'",'
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
                .',"title":"联系人列表"'
                .',"msg":"'.$msg.'"'
                .',"rows":['.$rows.']}';
        }

        /************返回数据*****************/
        echo $json;
    }

    /**
     * 子系统
     */
    public function get_json_proc()
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

        //分页
        $arr_search['page']=$this->input->post_get('page');
        $arr_search['rows']=$this->input->post_get('rows');

        if( empty($arr_search['rows']) )
        {
            $arr_search['rows'] = 10;
        }

        if( $from == 'combobox' )
            $arr_search['rows'] = 0;

        //排序
        $arr_search['order']=$this->input->post_get('order');
        $arr_search['sort']=$this->input->post_get('sort');

        if( empty($arr_search['sort']) )
        {
            $arr_search['sort']='p_id';
            $arr_search['order']='asc';
        }

        $arr_search['where']='';
        $arr_search['value']=array();
        /************查询条件*****************/

        if( $query )
        {
            if( ! $field_q ) $field_q="p_name,p_id";

            $arr_search['where'].=" AND CONCAT({$field_q}) like '%".$this->m_base->escape_like_str($query)."%'";
        }

        $arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);

        /************数据查询*****************/

        $arr_search['field']='p_id,p_name';
        $arr_field_search=explode(',', $arr_search['field']);

        $arr_search['from']='sys_proc';

        $rs=$this->m_db->query($arr_search);

        /************json拼接****************/
        if (count($rs['content']) > 0)
        {
            foreach($rs['content'] as $k => $v)
            {
                $row_f='';

                foreach ($arr_field_search as $f) {

                    $row_f.='"'.$f.'":"'.fun_urlencode(element($f,$v)).'",';
                }

                $row_f=trim($row_f,',');

                if( $query )
                {
                    $tmp_arr=explode(',',$field_q);

                    $str = $v['p_name'].'['.$v['p_id'].']';

                    $rows.='{"value":"'.$str.'",'
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
            $json.='{"query": "'.$query.'",
					 "suggestions":['.$rows.']}';
        }
        elseif($from == 'combobox')
        {
            $json='['.$rows.']';
        }
        else
        {
            $json.='{"total":"'.$rs['total'].'"'
                .',"time":"'.$time.'"'
                .',"title":"流程列表"'
                .',"msg":"'.$msg.'"'
                .',"rows":['.$rows.']}';
        }

        /************返回数据*****************/
        echo $json;
    }

    /**
     * 预算科目列表
     */
    public function get_json_sub()
    {
        //判断是否ajax请求
        $is_ajax=$this->input->is_ajax_request();
        if( ! $is_ajax) exit;

        $this->load->model('proc_bud/m_subject');
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

        //查询条件
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
            $arr_search['rows'] = 10;
        }

        //排序
        $arr_search['order']=$this->input->post_get('order');
        $arr_search['sort']=$this->input->post_get('sort');

        if( empty($arr_search['sort']) )
        {
            $arr_search['sort']='sub_code';
            $arr_search['order']='asc';
        }

        $arr_search['where']='';
        $arr_search['value']=array();
        /************查询条件*****************/
        if( ! empty(element('search_sub_tag', $data_get)))
        {
            $arr_search['where'].=" AND FIND_IN_SET ( ? ,sub_tag)";
            $arr_search['value'][]=$data_get['search_sub_tag'];
        }

        if( ! empty(element('search_sub_class', $data_get)))
        {
            $arr_search['where'].=" AND sub_class = ?";
            $arr_search['value'][]=$data_get['search_sub_class'];
        }

        //初始查询条件
        if( $query )
        {
            if( ! $field_q ) $field_q="sub_code,sub_name";

            if( ! $field_s ) $field_s=$field_q;

            $arr_search['where'].=" AND CONCAT({$field_q}) like '%".$this->m_base->escape_like_str($query)."%'";
        }

        $arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);

        /************数据查询*****************/
        $arr_field_search=array(
            'sub_code',
            'sub_id',
            'sub_name',
            'sub_tag'
        );

        $arr_search['field']=implode(',', $arr_field_search);

        $arr_search['from']='fm_subject sub';

        if( ! empty(element('search_gfc_id', $data_get)))
        {
            $budm_id = $this->m_base->get_field_where('pm_given_financial_code','gfc_budm_id'," AND gfc_id = '{$data_get['search_gfc_id']}'");
            $arr_search['from'].=' LEFT JOIN fm_bud_item budi ON
								   ( budi.budi_sub = sub.sub_id)';

            $arr_search['where'].=" AND budm_id = ? AND budi_sub_check = 1";
            $arr_search['value'][]=$budm_id;
        }

        $rs=$this->m_db->query($arr_search);
        /************json拼接****************/

        if (count($rs['content']) > 0)
        {
            foreach($rs['content'] as $k => $v)
            {
                $row_f='';
                foreach ($arr_field_search as $f) {

                    switch ($f)
                    {
                        default:
                            if(isset($GLOBALS['m_sub']['text'][$f]) && isset($GLOBALS['m_sub']['text'][$f][$v[$f]]) )
                                $v[$f]=$GLOBALS['m_sub']['text'][$f][$v[$f]];
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
                .',"title":"预算科目列表"'
                .',"msg":"'.$msg.'"'
                .',"rows":['.$rows.']}';
        }

        /************返回数据*****************/
        echo $json;
    }
    //财务编号
    public function get_json_gfc()
    {
        //判断是否ajax请求
        $is_ajax=$this->input->is_ajax_request();
        if( ! $is_ajax) exit;

        $this->load->model('proc_gfc/m_gfc');
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

        //查询条件
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
            $arr_search['rows'] = 10;
        }

        //排序
        $arr_search['order']=$this->input->post_get('order');
        $arr_search['sort']=$this->input->post_get('sort');

        if( empty($arr_search['sort']) )
        {
            $arr_search['sort']='gfc_finance_code';
            $arr_search['order']='asc';
        }

        $arr_search['where']='';
        $arr_search['value']=array();
        /************查询条件*****************/


        //初始查询条件
        if( $query )
        {
            if( ! $field_q ) $field_q="gfc_finance_code";

            if( ! $field_s ) $field_s=$field_q;

            $arr_search['where'].=" AND CONCAT({$field_q}) like '%".$this->m_base->escape_like_str($query)."%'";
        }
        $arr_search['where'].=" AND gfc_finance_code != '' AND gfc_finance_code IS NOT NULL";
        $arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);

        /************数据查询*****************/
        $arr_field_search=array(
            'gfc_finance_code',
            'gfc_name',
            'gfc_id',
            'gfc_sum',
            'gfc_finance_code',
            'gfc_org_jia',
            'gfc_c',
            'gfc_category_extra',
            'gfc_category_secret',
            'gfc_org',
        );

        $arr_search['field']=implode(',', $arr_field_search);

        $arr_search['from']='pm_given_financial_code';

        $rs=$this->m_db->query($arr_search);


        /************json拼接****************/
        $arr_field_search[]='gfc_ou_tj';
        if (count($rs['content']) > 0)
        {
            foreach($rs['content'] as $k => $v)
            {
                $row_f='';
                $arr_search=array();
                $arr_search['field']='ou_name';
                $arr_search['from']='sys_link l LEFT JOIN sys_ou ou ON (l.link_id=ou_id)';
                $arr_search['where']=" AND op_id=?";
                $arr_search['value'][]=$v['gfc_id'];
                $ou=$this->m_db->query($arr_search);
                if(count($ou['content'])>0){
                    $ou=current($ou['content']);
                }
                $v['gfc_ou_tj']=$ou['ou_name'];

                foreach ($arr_field_search as $f) {

                    switch ($f)
                    {
                        case 'gfc_c':
                            $v['gfc_c_s']=$this->m_base->get_field_where('sys_contact','c_name',"AND c_id = '".element($f,$v)."'");
                            $row_f.='"'.$f.'_s":"'.fun_urlencode($v['gfc_c_s']).'",';
                            break;
                        case 'gfc_org_jia':
                            $v['gfc_org_jia_s']=$this->m_base->get_field_where('sys_org','o_name',"AND o_id = '".element($f,$v)."'");
                            $row_f.='"'.$f.'_s":"'.fun_urlencode($v['gfc_org_jia_s']).'",';
                            break;
                        case 'gfc_org':
                            $v['gfc_org_s']=$this->m_base->get_field_where('sys_org','o_name',"AND o_id = '".element($f,$v)."'");
                            $row_f.='"'.$f.'_s":"'.fun_urlencode($v['gfc_org_s']).'",';
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
                .',"title":"财务编号"'
                .',"msg":"'.$msg.'"'
                .',"rows":['.$rows.']}';
        }

        /************返回数据*****************/
        echo $json;
    }
    //开户行
    public function get_json_bank()
    {
        //判断是否ajax请求
        $is_ajax=$this->input->is_ajax_request();

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

        //查询方法
        $fun_p=element('fun_p',$data_get);
        $fun_m=element('fun_m',$data_get);
        $fun_f=element('fun_f',$data_get);

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
            $arr_search['rows'] = 10;
        }

        //排序
        $arr_search['order']=$this->input->post_get('order');
        $arr_search['sort']=$this->input->post_get('sort');



        $arr_search['where']='';
        $arr_search['value']=array();
        /************查询条件*****************/
        if( ! empty(element('search_c_login_id', $data_get)))
        {
            $arr_search['where']=" AND (c_login_id != '' AND c_login_id IS NOT NULL)";
        }

        if( ! empty(element('search_c_org', $data_get)))
        {
            $arr_search['where']=" AND (o_id = ?)";
            $arr_search['value'][] = $data_get['search_c_org'];
        }


        $arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);

        /************数据查询*****************/

        $arr_search['field']='o_id,oacc_bank,oacc_id,oacc_account';
        $arr_field_search=explode(',', $arr_search['field']);

        $arr_search['from']='sys_org_account';

        if($fun_p && $fun_m && $fun_f)
        {
            $this->load->model($fun_p.'/'.$fun_m);
            $arr_search = $this->$fun_m->$fun_f($arr_search);
        }

        $rs=$this->m_db->query($arr_search);

        /************json拼接****************/

        $arr_field_search[]='oacc_show';

        if (count($rs['content']) > 0)
        {
            foreach($rs['content'] as $k => $v)
            {
                $row_f='';
                $v['oacc_show']=$v['oacc_bank'].','.$v['oacc_account'];

                foreach ($arr_field_search as $f) {

                    $row_f.='"'.$f.'":"'.fun_urlencode(element($f,$v)).'",';
                }
                $row_f=trim($row_f,',');

                if( $query )
                {
                    $tmp_arr=explode(',', $field_q);

                    $str = $v['c_name'];

                    if( $v['o_id'] )
                        $str.='['.$v['o_id'].']';

                    if( $v['oacc_id'] )
                        $str.=','.$v['oacc_id'];



                    $rows.='{"value":"'.$str.'",'
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
                .',"title":"开户行列表"'
                .',"msg":"'.$msg.'"'
                .',"rows":['.$rows.']}';
        }

        /************返回数据*****************/
        echo $json;
    }

    //财务编号
    public function get_json_eq()
    {
        //判断是否ajax请求
        $is_ajax=$this->input->is_ajax_request();
        if( ! $is_ajax) exit;

        $this->load->model('proc_eq/m_eq');
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

        //查询条件
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
            $arr_search['rows'] = 10;
        }

        //排序
        $arr_search['order']=$this->input->post_get('order');
        $arr_search['sort']=$this->input->post_get('sort');

        if( empty($arr_search['sort']) )
        {
            $arr_search['sort']='eq_name';
            $arr_search['order']='asc';
        }

        $arr_search['where']='';
        $arr_search['value']=array();
        /************查询条件*****************/


        //初始查询条件
        if( $query )
        {
            if( ! $field_q ) $field_q="eq_name";

            if( ! $field_s ) $field_s=$field_q;

            $arr_search['where'].=" AND CONCAT({$field_q}) like '%".$this->m_base->escape_like_str($query)."%'";
        }

        $arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);

        /************数据查询*****************/
        $arr_field_search=array(
            'eq_id',
            'eq_name',
            'eq_brand',
            'eq_model',
            'eq_sort',
            'eq_description',
            'eq_org',
            'eq_price',
        );

        $arr_search['field']=implode(',', $arr_field_search);

        $arr_search['from']='sm_equipment';

        $rs=$this->m_db->query($arr_search);


        /************json拼接****************/

        if (count($rs['content']) > 0)
        {
            foreach($rs['content'] as $k => $v)
            {
                $row_f='';


                foreach ($arr_field_search as $f) {

                    switch ($f)
                    {

                        default:
                            if(isset($GLOBALS['m_eq']['text'][$f]) && isset($GLOBALS['m_eq']['text'][$f][$v[$f]]) )
                                $v[$f]=$GLOBALS['m_eq']['text'][$f][$v[$f]];
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
                .',"title":"设备"'
                .',"msg":"'.$msg.'"'
                .',"rows":['.$rows.']}';
        }

        /************返回数据*****************/
        echo $json;
    }

    public function get_json_file()
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

        //查询条件
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
            $arr_search['rows'] = 10;
        }

        //排序
        $arr_search['order']=$this->input->post_get('order');
        $arr_search['sort']=$this->input->post_get('sort');

        if( empty($arr_search['sort']) )
        {
            $arr_search['sort']='doci_name';
            $arr_search['order']='asc';
        }

        $arr_search['where']='';
        $arr_search['value']=array();
        /************查询条件*****************/


        //初始查询条件
        if( $query )
        {
            if( ! $field_q ) $field_q="doci_name";

            if( ! $field_s ) $field_s=$field_q;

            $arr_search['where'].=" AND CONCAT({$field_q}) like '%".$this->m_base->escape_like_str($query)."%'";
        }

        $arr_search=$this->m_base->get_where_of_data_search($data_search,$arr_search);

        /************数据查询*****************/
        $arr_field_search=array(
            'doci_name',
            'doci_page_have',
        	'doci_page_now',
        	'doci_f_id',
            'doci_id',
            'doci_org',
        );

        $arr_search['field']=implode(',', $arr_field_search);

        $arr_search['from']='oa_doc_item';
        
        $rs=$this->m_db->query($arr_search);

        /************json拼接****************/

        if (count($rs['content']) > 0)
        {
            foreach($rs['content'] as $k => $v)
            {
                $row_f='';

                foreach ($arr_field_search as $f) {

                    switch ($f)
                    {
						case 'doci_org':
							$row_f.='"doci_org_s":"'.fun_urlencode($this->m_base->get_field_where('sys_ou','ou_name'," AND ou_id ='{$v[$f]}'")).'",';
							break;
						case 'doci_id':
							$row_f.='"doc_id":"'.fun_urlencode($this->m_base->get_field_where('oa_doc_item','doc_id'," AND doci_id ='{$v[$f]}'")).'",';
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
                .',"title":"文件"'
                .',"msg":"'.$msg.'"'
                .',"rows":['.$rows.']}';
        }

        /************返回数据*****************/
        echo $json;
    }
}

