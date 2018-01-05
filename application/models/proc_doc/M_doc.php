<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 *
 模板
 */
class M_doc extends CI_Model {

	//@todo 主表配置
	private $table_name='oa_doc';//数据表
	private $pk_id='doc_id';//数据表主键
	private $table_form;
	private $arr_table_form=array();
	private $title='档案归档';//标题
	private $model_name = 'm_doc';//模型名称
	private $url_conf = 'proc_doc/doc/edit';//编辑页面
	private $proc_id = 'proc_doc';//节点

	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
		$this->m_define();
		
		//读取表结构
        $this->config->load('db_table/sys_contact', FALSE,TRUE);
        $this->arr_table_form['sys_contact']=$this->config->item('sys_contact');

		//读取表结构
		$this->config->load('db_table/'.$this->table_name, FALSE,TRUE);
		$this->table_form=$this->config->item($this->table_name);
		
		$this->load->model('proc_gfc/m_gfc');
		$this->load->model('proc_file/m_file');
	}

	/**
	 *
	 * 定义
	 */
	public function m_define()
	{
		//@todo 定义
		if( defined('LOAD_M_DOC') ) return;
		define('LOAD_M_DOC', 1);

		//define
		//档案密级
		define('DOC_SECRET_WORK', 1); // 工作
		define('DOC_SECRET_INNER', 2); // 内部

		$GLOBALS['m_doc']['text']['doc_secret']=array(
		DOC_SECRET_WORK=>'工作',
		DOC_SECRET_INNER=>'内部',
		);
		//档案限制
		define('DOC_LIMIT_LEVEL_PUBLIC', 1); // 工作
		define('DOC_LIMIT_LEVEL_RESTRICTED', 2); // 内部

		$GLOBALS['m_doc']['text']['doc_limit_level']=array(
		DOC_LIMIT_LEVEL_PUBLIC=>'公开',
		DOC_LIMIT_LEVEL_RESTRICTED=>'受限',
		);
		//项目状态
		define('DOC_PROJECT_TYPE_QIANQI', 1); // 前期
		define('DOC_PROJECT_TYPE_LIXINAG', 2); // 立项
		define('DOC_PROJECT_TYPE_SHISHI', 3); // 实施
		define('DOC_PROJECT_TYPE_BUMAN', 4); // 竣工未满一年
		define('DOC_PROJECT_TYPE_MAN', 5); // 竣工满一年

		$GLOBALS['m_doc']['text']['doc_project_type']=array(
		DOC_PROJECT_TYPE_QIANQI=>'前期',
		DOC_PROJECT_TYPE_LIXINAG=>'立项',
		DOC_PROJECT_TYPE_SHISHI=>'实施',
		DOC_PROJECT_TYPE_MAN=>'竣工满一年',
		DOC_PROJECT_TYPE_BUMAN=>'竣工未满一年',
		);
		//公司码
		define('DOC_COMPANY_CODE_SAFE', 1); // 安全公司
		define('DOC_COMPANY_CODE_TECH', 2); // 技术公司
		define('DOC_COMPANY_CODE_BRANCH', 3); // 分公司办事处
		define('DOC_COMPANY_CODE_GD', 4); // 股东及上级公司
		define('DOC_COMPANY_CODE_GOVERNMENT', 5); // 政府
		define('DOC_COMPANY_CODE_OTHER', 6); // 其他

		$GLOBALS['m_doc']['text']['doc_company_code']=array(
		DOC_COMPANY_CODE_SAFE=>'安全公司',
		DOC_COMPANY_CODE_TECH=>'技术公司',
		DOC_COMPANY_CODE_BRANCH=>'分公司办事处',
		DOC_COMPANY_CODE_GD=>'股东及上级部门',
		DOC_COMPANY_CODE_GOVERNMENT=>'政府',
		DOC_COMPANY_CODE_OTHER=>'其他',
		);
		//大类码
		define('DOC_BIG_CODE_PARTY', 'A'); // 党群工作类
		define('DOC_BIG_CODE_BASIS', 'B'); // 基础工作类
		define('DOC_BIG_CODE_CREDIT', 'C'); // 信用资料类
		define('DOC_BIG_CODE_DECISION', 'D'); // 决策监督类
		define('DOC_BIG_CODE_MANAGE', 'E'); // 管理文案类
		define('DOC_BIG_CODE_FINANCIAL', 'F'); // 财务工作类
		define('DOC_BIG_CODE_PERSONNEL', 'G'); // 人事工作类
		define('DOC_BIG_CODE_ADMIN', 'H'); // 行政工作类
		define('DOC_BIG_CODE_BUSINESS', 'I'); // 业务工作类
		define('DOC_BIG_CODE_BRANCH', 'J'); // 分支机构类
		define('DOC_BIG_CODE_OTHER', 'Z'); // 其他机构类

		$GLOBALS['m_doc']['text']['doc_big_code']=array(
		DOC_BIG_CODE_PARTY=>'A.党群工作类',
		DOC_BIG_CODE_BASIS=>'B.基础工作类',
		DOC_BIG_CODE_CREDIT=>'C.信用资料类',
		DOC_BIG_CODE_DECISION=>'D.决策监督类',
		DOC_BIG_CODE_MANAGE=>'E.管理文案类',
		DOC_BIG_CODE_FINANCIAL=>'F.财务工作类',
		DOC_BIG_CODE_PERSONNEL=>'G.人事工作类',
		DOC_BIG_CODE_ADMIN=>'H.行政工作类',
		DOC_BIG_CODE_BUSINESS=>'I.业务工作类',
		DOC_BIG_CODE_BRANCH=>'J.分支机构类',
		DOC_BIG_CODE_OTHER=>'Z.其他机构类',
		);

		define('DOC_MIDDLE_CODE_A00', 'A-00');//A党务工作
		define('DOC_MIDDLE_CODE_A01', 'A-01');//A工会工作
		define('DOC_MIDDLE_CODE_A02', 'A-02');//A共青团工作
		define('DOC_MIDDLE_CODE_A99', 'A-99');//A其他工作
		define('DOC_MIDDLE_CODE_B00', 'B-00');//B公司开办资料
		define('DOC_MIDDLE_CODE_B01', 'B-01');//B公司资质
		define('DOC_MIDDLE_CODE_B02', 'B-02');//B产品科研类
		define('DOC_MIDDLE_CODE_B03', 'B-03');//B宣传推介资料
		define('DOC_MIDDLE_CODE_B99', 'B-99');//B其他基础资料
		define('DOC_MIDDLE_CODE_C00', 'C-00');//C年检材料
		define('DOC_MIDDLE_CODE_C01', 'C-01');//C验资材料
		define('DOC_MIDDLE_CODE_C02', 'C-02');//C资信评估材料
		define('DOC_MIDDLE_CODE_C03', 'C-03');//C荣誉评估材料
		define('DOC_MIDDLE_CODE_C04', 'C-04');//C合作方评价材料
		define('DOC_MIDDLE_CODE_C99', 'C-99');//C其他信用材料
		define('DOC_MIDDLE_CODE_D00', 'D-00');//D投资融资材料
		define('DOC_MIDDLE_CODE_D01', 'D-01');//D董事会材料
		define('DOC_MIDDLE_CODE_D02', 'D-02');//D股东会材料
		define('DOC_MIDDLE_CODE_D03', 'D-03');//D监事会材料
		define('DOC_MIDDLE_CODE_D04', 'D-04');//D总经办材料
		define('DOC_MIDDLE_CODE_D05', 'D-05');//D审计工作材料
		define('DOC_MIDDLE_CODE_D99', 'D-99');//D其他决策监督材料
		define('DOC_MIDDLE_CODE_E00', 'E-00');//E各类管理制度
		define('DOC_MIDDLE_CODE_E01', 'E-01');//E往来文件
		define('DOC_MIDDLE_CODE_E02', 'E-02');//E往来通知
		define('DOC_MIDDLE_CODE_E03', 'E-03');//E临时性往来文件
		define('DOC_MIDDLE_CODE_E04', 'E-04');//E上级部门往来材料
		define('DOC_MIDDLE_CODE_E99', 'E-99');//E其他管理文案资料
		define('DOC_MIDDLE_CODE_F00', 'F-00');//F各种财务账户
		define('DOC_MIDDLE_CODE_F01', 'F-01');//F各种财务报表
		define('DOC_MIDDLE_CODE_F02', 'F-02');//F各种会计凭证
		define('DOC_MIDDLE_CODE_F03', 'F-03');//F各种税务工作资料
		define('DOC_MIDDLE_CODE_F99', 'F-99');//F其他有保存价值资料
		define('DOC_MIDDLE_CODE_G00', 'G-00');//G员工档案类
		define('DOC_MIDDLE_CODE_G01', 'G-01');//G薪酬福利类
		define('DOC_MIDDLE_CODE_G02', 'G-02');//G绩效考核类
		define('DOC_MIDDLE_CODE_G03', 'G-03');//G招聘培训类
		define('DOC_MIDDLE_CODE_G04', 'G-04');//G劳动人事类
		define('DOC_MIDDLE_CODE_G05', 'G-05');//G人事制度
		define('DOC_MIDDLE_CODE_G99', 'G-99');//G其他有保存价值的材料
		define('DOC_MIDDLE_CODE_H00', 'H-00');//H行政合同类
		define('DOC_MIDDLE_CODE_H01', 'H-01');//H工作记录类
		define('DOC_MIDDLE_CODE_H02', 'H-02');//H法务类
		define('DOC_MIDDLE_CODE_H99', 'H-99');//H其他有保存价值的材料
		define('DOC_MIDDLE_CODE_I00', 'I-00');//I技术（售前）工作档案
		define('DOC_MIDDLE_CODE_I01', 'I-01');//I项目工作档案
		define('DOC_MIDDLE_CODE_I02', 'I-02');//I供应商工作档案
		define('DOC_MIDDLE_CODE_I03', 'I-03');//I产品和渠道工作档案
		define('DOC_MIDDLE_CODE_I04', 'I-04');//I服务工作档案
		define('DOC_MIDDLE_CODE_I05', 'I-05');//I软件研发工作档案
		define('DOC_MIDDLE_CODE_I06', 'I-06');//I政策性工作档案
		define('DOC_MIDDLE_CODE_I99', 'I-99');//I其他有保存价值的材料
		define('DOC_MIDDLE_CODE_J00', 'J-00');//J杭州公司资料
		define('DOC_MIDDLE_CODE_J01', 'J-01');//J北京公司资料
		define('DOC_MIDDLE_CODE_J02', 'J-02');//J广州公司资料
		define('DOC_MIDDLE_CODE_J03', 'J-03');//J成都公司资料
		define('DOC_MIDDLE_CODE_J04', 'J-04');//J武汉公司资料
		define('DOC_MIDDLE_CODE_J05', 'J-05');//J南京公司资料
		define('DOC_MIDDLE_CODE_J99', 'J-99');//J其他有保存价值的材料
		define('DOC_MIDDLE_CODE_Z00', 'Z-00');//Z非本公司的资质档案
		define('DOC_MIDDLE_CODE_Z01', 'Z-01');//Z员工个人资质证书
		define('DOC_MIDDLE_CODE_Z02', 'Z-02');//Z员工个人培训证书
		define('DOC_MIDDLE_CODE_Z99', 'Z-99');//Z其他有保存价值的材料

		$GLOBALS['m_doc']['text']['doc_middle_code']=array
		(
		DOC_MIDDLE_CODE_A00=>'A党务工作',
		DOC_MIDDLE_CODE_A01=>'A工会工作',
		DOC_MIDDLE_CODE_A02=>'A共青团工作',
		DOC_MIDDLE_CODE_A99=>'A其他工作',
		DOC_MIDDLE_CODE_B00=>'B公司开办资料',
		DOC_MIDDLE_CODE_B01=>'B公司资质',
		DOC_MIDDLE_CODE_B02=>'B产品科研类',
		DOC_MIDDLE_CODE_B03=>'B宣传推介资料',
		DOC_MIDDLE_CODE_B99=>'B其他基础资料',
		DOC_MIDDLE_CODE_C00=>'C年检材料',
		DOC_MIDDLE_CODE_C01=>'C验资材料',
		DOC_MIDDLE_CODE_C02=>'C资信评估材料',
		DOC_MIDDLE_CODE_C03=>'C荣誉评估材料',
		DOC_MIDDLE_CODE_C04=>'C合作方评价材料',
		DOC_MIDDLE_CODE_C99=>'C其他信用材料',
		DOC_MIDDLE_CODE_D00=>'D投资融资材料',
		DOC_MIDDLE_CODE_D01=>'D董事会材料',
		DOC_MIDDLE_CODE_D02=>'D股东会材料',
		DOC_MIDDLE_CODE_D03=>'D监事会材料',
		DOC_MIDDLE_CODE_D04=>'D总经办材料',
		DOC_MIDDLE_CODE_D05=>'D审计工作材料',
		DOC_MIDDLE_CODE_D99=>'D其他决策监督材料',
		DOC_MIDDLE_CODE_E00=>'E各类管理制度',
		DOC_MIDDLE_CODE_E01=>'E往来文件',
		DOC_MIDDLE_CODE_E02=>'E往来通知',
		DOC_MIDDLE_CODE_E03=>'E临时性往来文件',
		DOC_MIDDLE_CODE_E04=>'E上级部门往来材料',
		DOC_MIDDLE_CODE_E99=>'E其他管理文案资料',
		DOC_MIDDLE_CODE_F00=>'F各种财务账户',
		DOC_MIDDLE_CODE_F01=>'F各种财务报表',
		DOC_MIDDLE_CODE_F02=>'F各种会计凭证',
		DOC_MIDDLE_CODE_F03=>'F各种税务工作资料',
		DOC_MIDDLE_CODE_F99=>'F其他有保存价值资料',
		DOC_MIDDLE_CODE_G00=>'G员工档案类',
		DOC_MIDDLE_CODE_G01=>'G薪酬福利类',
		DOC_MIDDLE_CODE_G02=>'G绩效考核类',
		DOC_MIDDLE_CODE_G03=>'G招聘培训类',
		DOC_MIDDLE_CODE_G04=>'G劳动人事类',
		DOC_MIDDLE_CODE_G05=>'G人事制度',
		DOC_MIDDLE_CODE_G99=>'G其他有保存价值的材料',
		DOC_MIDDLE_CODE_H00=>'H行政合同类',
		DOC_MIDDLE_CODE_H01=>'H工作记录类',
		DOC_MIDDLE_CODE_H02=>'H法务类',
		DOC_MIDDLE_CODE_H99=>'H其他有保存价值的材料',
		DOC_MIDDLE_CODE_I00=>'I技术（售前）工作档案',
		DOC_MIDDLE_CODE_I01=>'I项目工作档案',
		DOC_MIDDLE_CODE_I02=>'I供应商工作档案',
		DOC_MIDDLE_CODE_I03=>'I产品和渠道工作档案',
		DOC_MIDDLE_CODE_I04=>'I服务工作档案',
		DOC_MIDDLE_CODE_I05=>'I软件研发工作档案',
		DOC_MIDDLE_CODE_I06=>'I政策性工作档案',
		DOC_MIDDLE_CODE_I99=>'I其他有保存价值的材料',
		DOC_MIDDLE_CODE_J00=>'J杭州公司资料',
		DOC_MIDDLE_CODE_J01=>'J北京公司资料',
		DOC_MIDDLE_CODE_J02=>'J广州公司资料',
		DOC_MIDDLE_CODE_J03=>'J成都公司资料',
		DOC_MIDDLE_CODE_J04=>'J武汉公司资料',
		DOC_MIDDLE_CODE_J05=>'J南京公司资料',
		DOC_MIDDLE_CODE_J99=>'J其他有保存价值的材料',
		DOC_MIDDLE_CODE_Z00=>'Z非本公司的资质档案',
		DOC_MIDDLE_CODE_Z01=>'Z员工个人资质证书',
		DOC_MIDDLE_CODE_Z02=>'Z员工个人培训证书',
		DOC_MIDDLE_CODE_Z99=>'Z其他有保存价值的材料',
		);
		// 节点
		define('DOC_PPO_END', 0); // 流程结束
		define('DOC_PPO_START', 1); // 起始
		define('DOC_PPO_SH', 2); // 审核
		define('DOC_PPO_SP', 3); // 审批

		$GLOBALS['m_doc']['text']['ppo']=array(
		DOC_PPO_START=>'起始',
		DOC_PPO_SH=>'审核',
		DOC_PPO_SP=>'审批',
		DOC_PPO_END=>'流程结束',
		);
	}

	/**
	 *
	 * 权限验证
	 * @param $content
	 */
	public function check_acl( $data_db=array() ,$acl_list = NULL)
	{
		/************变量初始化****************/

		$data_get=trim_array($this->uri->uri_to_assoc(4));
		$act=element('act', $data_get);

		if( ! $acl_list )
		$acl_list= $this->m_proc_doc->get_acl();

		$msg='';
		/************权限验证*****************/

		//如果有超级权限，TRUE
		if( ($acl_list & pow(2,ACL_PROC_DOC_SUPER)) != 0 )
		{
			return TRUE;
		}

		$check_acl=FALSE;

		if( ! $check_acl
		&& ($acl_list & pow(2,ACL_PROC_DOC_USER)) != 0
		)
		{
			$check_acl=TRUE;
		}

		if( ! $check_acl )
		{
			if( ! $msg )
			$msg = '您没有【'.$this->title.'】的【操作】权限不可进行操作！' ;

			redirect('base/main/show_err/msg/'.fun_urlencode($msg));
		}
	}
	
	//档案码
 	public function get_code($data_save=array())
    {
        $where='';

        $pre='';
        
        $pre = $this->m_base->get_field_where('sys_ou','ou_org_pre'," AND ou_id ='{$data_save['content']['doc_org']}'");

//        switch (element('doc_org', $data_save['content']))
//        {
//            //成都
//            case '22B090894556F980B81361AA996ACF3B':
//                $pre='CD-';
//                break;
//            //北京
//            case '52D7478777D4BA42B3ECD05DCA53B7C9':
//            case '92F7520839C9108378883C6A90BEBFBE':
//                $pre='BJ-';
//                break;
//            //广州
//            case '95844F63647F4D89B7773198DDCE04C0':
//                $pre='GZ-';
//                break;
//            //杭州
//            case '9F8453E40A17EDDAA9EE72BB49C52E83':
//                $pre='HZ-';
//                break;
//            //上海
//            case 'B12F0862F53C9772369A4A990D7EA510':
//                $pre='SH-';
//                break;
//            default:
//
//        }

        $pre.='-'.$data_save['content']['doc_middle_code'].'-'.$data_save['content']['doc_small_code'];
        $where .= " AND doc_code LIKE  '{$pre}%'";

        $max_code=$this->m_db->get_m_value('oa_doc','doc_code',$where);
        $code=$pre.'-'.str_pad((intval(substr($max_code, (strlen($pre))))+1), 3, '0', STR_PAD_LEFT);

        return $code;
    }

	/**
	 *
	 * @param $id
	 */
	public function get($id)
	{
		/************模型载入*****************/

		/************变量初始化****************/
		$data_db=array();//数据库数组
		$arr_search=array();
		$rtn=array();//结果

		/************变量赋值*****************/
		$arr_search['field']='*';
		$arr_search['from']=$this->table_name;
		$arr_search['where']='AND '.$this->pk_id.' = ? ';
		$arr_search['value'][]=$id;
		$rs=$this->m_db->query($arr_search);

		if(count($rs['content'])>0)
		$rtn=current($rs['content']);

		/************返回数据*****************/
		return $rtn;
	}

	/**
	 *
	 * 创建
	 * @param $content
	 */
	public function add($content)
	{
		/************模型载入*****************/

		/************变量初始化****************/
		$data_save=array();//
		$rtn=array();//结果
		$rtn['rtn']=TRUE;
		/************变量赋值*****************/
		$data_save['content']=$content;

		if( empty(element($this->pk_id,$data_save['content'])) ) $data_save['content'][$this->pk_id]=get_guid();
		$data_save['content']['db_time_update']=date("Y-m-d H:i:s");
		$data_save['content']['db_time_create']=date("Y-m-d H:i:s");
		$data_save['content']['db_person_create']=$this->sess->userdata('c_id') ;
		/************数据处理*****************/

		$this->db->trans_begin();

		if($rtn['rtn'])
		$rtn=$this->m_db->insert($data_save['content'],$this->table_name);

		if( ! $rtn['rtn'] )
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
			$rtn['id']=$data_save['content'][$this->pk_id];
		}

		/************返回数据*****************/
		return $rtn;
	}

	/**
	 *
	 * 更新
	 * @param $content
	 */
	public function update($content)
	{
		/************模型载入*****************/

		/************变量初始化****************/
		$data_save=array();//
		$rtn=array();//结果
		$rtn['rtn']=TRUE;
		$where='';
		/************变量赋值*****************/
		$data_save['content']=$content;

		$data_save['content']['db_time_update']=date("Y-m-d H:i:s");
		$where=" 1=1 AND {$this->pk_id} = '{$data_save['content'][$this->pk_id]}'";

		/************数据处理*****************/
		$this->db->trans_begin();

		if($rtn['rtn'])
		$rtn=$this->m_db->update($this->table_name,$data_save['content'],$where);
		
		if( ! $rtn['rtn'] )
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
		}
		/************返回数据*****************/
		return $rtn;
	}

	/**
	 *
	 * 删除
	 * @param $content
	 */
	public function del($id)
	{
		/************模型载入*****************/

		/************变量初始化****************/
		$where=array();
		$rtn=array();//结果
		$rtn['rtn']=TRUE;
		/************变量赋值*****************/
		$where[$this->pk_id]=$id;

		/************数据处理*****************/

		//@todo 删除关联数据验证
		$arr_link=array();

		if(count($arr_link) > 0)
		{
			foreach ($arr_link as $v ) {
				$arr_tmp = explode('.', $v);
				$field=$this->m_base->get_field_where($arr_tmp[0],$arr_tmp[1]," AND {$arr_tmp[1]} = '{$id}' ");
				if($field)
				{
					$rtn['rtn'] = FALSE;
					$rtn['msg_err']=$rtn['err']['msg'] = '于【'.$arr_tmp[0].'】存在关联数据,不可删除!';
					return $rtn;
				}
			}
		}

		$this->db->trans_begin();

		if($rtn['rtn'])
		$rtn=$this->m_db->delete($this->table_name,$where);
		
		if($rtn['rtn'])
            $rtn=$this->m_db->delete('oa_doc_item',$where);
		

		if( ! $rtn['rtn'] )
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
			
			//取消工单信息
	        $this->m_work_list->cancel_wl($id,$this->model_name);
	        
	        //删除关联文件
	        $this->m_file->del_link_file($id,$this->table_name,$this->pk_id);
	        
	        //删除所有关联数据
			$this->m_link->del_all($id);
	        
		}

		/************返回数据*****************/
		return $rtn;
	}

	/**
	 *
	 * 生成导入xlsx
	 */
	public function create_import_xlsx()
	{
		$this->load->model('base/m_excel');

		$conf=array();

		//@todo 导入xlsx配置
		$conf['field_edit']=array(
			'oa_doc[doc_org]',
			'oa_doc[doc_sign_org]',
			'oa_doc[doc_gfc_id]',
			'oa_doc[doc_name]',
			'oa_doc[doc_efftime_start]',
			'oa_doc[doc_efftime_end]',
			'oa_doc[doc_original_code]',
			'oa_doc[doc_addtime]',
			'oa_doc[doc_sub_person]',
			'sys_contact[c_login_id]',
			'oa_doc[doc_keep_person]',
			'sys_contact[c_login_id]',
			'oa_doc[doc_protect_person]',
			'sys_contact[c_login_id]',
			'oa_doc[doc_alert_time]',
			'oa_doc[doc_alert_yn]',
			'oa_doc[doc_secret]',
			'oa_doc[doc_limit_level]',
			'oa_doc[doc_location]',
		);

		$conf['field_required']=array(
			'oa_doc[doc_org]',
			'oa_doc[doc_name]',
			'oa_doc[doc_sub_person]',
			'oa_doc[doc_keep_person]',
			'oa_doc[doc_protect_person]',
			'sys_contact[c_login_id]',
		);

		$conf['field_define']=array(
			'oa_doc[doc_secret]'=>$GLOBALS['m_doc']['text']['doc_secret'],
			'oa_doc[doc_limit_level]'=>$GLOBALS['m_doc']['text']['doc_limit_level'],
			'oa_doc[doc_alert_yn]'=>$GLOBALS['m_base']['text']['base_yn_0'],
		);

		$this->arr_table_form['sys_contact']['fields']['c_login_id']['comment']='账号';
		$conf['table_form']=array(
			'oa_doc'=>$this->table_form,
			'sys_contact'=>$this->arr_table_form['sys_contact']
		);

		$path=str_replace('\\', '/', APPPATH).'models/'.$this->proc_id.'/'.$this->model_name.'.xlsx';

    	$this->m_excel->create_import_file($path,$conf);
	}

	/**
	 *
	 * 载入编辑界面
	 * @param $content
	 */
	public function load($data_get=array(),$data_post=array())
	{
		/************变量初始化****************/
		$arr_view = array();//视图数组
		$data_out = array();//输出数组
		$data_db  = array();//数据库数据

		//@todo 必填只读配置
		//必填数组
		$data_out['field_required']=array(
            'content[doc_org]',
            'content[doc_name]',
            'content[doc_addtime]',
            'content[doc_sub_person_s]',
            'content[doc_sub_person]',
            'content[doc_keep_person_s]',
            'content[doc_keep_person]',
            'content[doc_protect_person_s]',
			'content[doc_protect_person]',
            'content[doc_secret]',
            'content[doc_limit_level]',
		);

		//编辑数组
		$data_out['field_edit']=array(
            'content[db_time_update]',
            'content[doc_org]',
            'content[doc_gfc_id_s]',
            'content[doc_gfc_id]',
            'content[doc_name]',
            'content[doc_sign_org_s]',
            'content[doc_sign_org]',
            'content[doc_efftime_start]',
            'content[doc_efftime_end]',
            'content[doc_addtime]',
            'content[doc_alert_time]',
			'content[doc_alert_yn]',
            'content[doc_sub_person_s]',
            'content[doc_sub_person]',
            'content[doc_keep_person_s]',
            'content[doc_keep_person]',
            'content[doc_protect_person_s]',
            'content[doc_protect_person]',
            'content[doc_original_code]',
            'content[doc_secret]',
            'content[doc_limit_level]',
			'content[doc_location]',
            'content[doc_key_word]',
            'content[doc_project_type]',
            'content[doc_note]',
            'content[doc_company_code]',
            'content[doc_big_code]',
            'content[doc_middle_code]',
            'content[doc_small_code]',
            'content[doc_location]',
            'content[doc_nominate]',
            'content[doc_return_time]',
			'content[doc_letter_have]',
			'content[doc_page_have]',
			'content[doc_info]'
		);

		//只读数组
		$data_out['field_view']=array(
			'content[doc_code]',
			'content[doc_project_type]',  
			
			'content[gfc_name]',
            'content[gfc_org_jia_s]',
            'content[gfc_c_s]',
            'content[gfc_finance_code]',
            'content[gfc_sum]',
            'content[gfc_category_extra]',
            'content[gfc_category_secret]',
		);
		
		$data_out['op_disable']=array();

		//输出数据数组
		$data_out['field_out']=array_unique(array_merge($data_out['field_view'],$data_out['field_edit']));

		/************变量赋值*****************/

		$flag_log=$this->input->post('flag_log');//日志标签

		if( empty($data_get) )
		$data_get= trim_array($this->uri->uri_to_assoc(4));

		if( ! isset($data_get['act']) )
		$data_get['act'] = STAT_ACT_CREATE;

		if( empty( element('btn', $data_post) ) )
		$data_post['btn']=$this->input->post('btn');//按钮
		
		if( empty( element('alert', $data_post) ) )
		$data_post['alert']=$this->input->post('alert');//按钮

		$btn=$data_post['btn'];

		if( empty( element('content', $data_post) ) )
		$data_post['content']=trim_array($this->input->post('content'));

		if( empty( element('wl', $data_post) ) )
		$data_post['wl']=trim_array($this->input->post('wl'));

		$flag_more=element('flag_more', $data_post);
		
		/************字段定义*****************/
		//@todo 字段定义
		$arr_field=array_unique(array_merge($data_out['field_edit'], $data_out['field_view']));

		$data_out['json_field_define']=array();
		$data_out['json_field_define']['doc_secret']=get_html_json_for_arr($GLOBALS['m_doc']['text']['doc_secret']);
		$data_out['json_field_define']['doc_project_type']=get_html_json_for_arr($GLOBALS['m_doc']['text']['doc_project_type']);
		$data_out['json_field_define']['doc_limit_level']=get_html_json_for_arr($GLOBALS['m_doc']['text']['doc_limit_level']);
		$data_out['json_field_define']['doc_company_code']=get_html_json_for_arr($GLOBALS['m_doc']['text']['doc_company_code']);
		$data_out['json_field_define']['doc_big_code']=get_html_json_for_arr($GLOBALS['m_doc']['text']['doc_big_code']);
		$data_out['json_field_define']['doc_middle_code']=get_html_json_for_arr($GLOBALS['m_doc']['text']['doc_middle_code']);

		/************数据读取*****************/
		$data_db['content']=array();
		$data_db['wl_list']=array();

		switch ($data_get['act']) {
			case STAT_ACT_EDIT:
			case STAT_ACT_VIEW:
				try {

					//日志读取
					if( ! empty($flag_log))
					{
						$data_get['act'] = STAT_ACT_VIEW;
						$data_out['op_disable'][]='btn_log';

						$log_content=json_decode($this->input->post('log_content'),TRUE);
						$data_old=element('old', $log_content);
						$data_db['content']=$data_old['content'];
						$data_change=element('new', $log_content);

						if( count(element('content',$data_change))>0)
						{
							foreach (element('content',$data_change) as $k=>$v)
							{
								if( $v != element($k,$data_db['content']) )
								{
									switch ($k)
									{
                                        case 'doc_info':

                                            $data_out['log']['content['.$k.']'] = $this->m_base->get_datatable_change('doci_id',$v,element($k,$data_db['content']));
                                            $data_db['content'][$k] =$v ;
                                            break;
                                        
										default:
											if( (element($k,$data_db['content']) || element($k,$data_db['content']) == '0' )
											&& isset($GLOBALS[$this->model_name]['text'][$k][$v]) )
											$data_db['content'][$k]=$GLOBALS[$this->model_name]['text'][$k][element($k,$data_db['content'])];

											$data_out['log']['content['.$k.']']='变更前:'.element($k,$data_db['content']);
											$data_db['content'][$k] =$v ;
									}
								}
							}
						}
					}
					else
					{
						//批量编辑
						if(  element('flag_edit_more', $data_get) )
						{
							$data_db['content'] = array();
							break;
						}

						//非数据库，页面调用
						if(  element('fun_no_db', $data_get) )
						{
							$data_db['content'] = json_decode(fun_urldecode($this->input->post('data_db')),TRUE);
							break;
						}

						$data_db['content'] = $this->get(element($this->pk_id,$data_get));

						if( empty($data_db['content'][$this->pk_id]) )
						{
							$msg= $this->title.'【'.element($this->pk_id,$data_get).'】不存在！';

							if($flag_more)
							{
								$rtn['result'] = FALSE;
								$rtn['msg_err'] = $msg;

								if( $flag_more )
								return $rtn;
							}

							redirect('base/main/show_err/msg/'.fun_urlencode($msg));
						}

						if( ! empty( element('doc_gfc_id',$data_db['content']) ) )
						{
							$this->load->model('m_gfc');
							$data_db['content_gfc']=$this->m_gfc->get($data_db['content']['doc_gfc_id']);
							
							$data_db['content']=array_merge($data_db['content_gfc'],$data_db['content']);
						}
					
						//工单信息读取
						$data_db['wl_list']=$this->m_work_list->get_wl_to_do(element($this->pk_id,$data_get),$this->model_name);

						if( count( $data_db['content'] ) ){
							foreach($data_db['content'] as $k=>$v){
								switch($k){
									case'doc_org':
										$data_db['content'][$k]=$v;
										break;
									case 'doc_sign_org':
									case 'gfc_org_jia':
										$data_db['content'][$k.'_s']=$this->m_base->get_field_where('sys_org','o_name'," AND o_id='{$v}'");

										break;
										
									case 'doc_sub_person':
									case 'doc_protect_person':
									case 'doc_keep_person':
									case 'gfc_c':
										$data_db['content'][$k.'_s']=$this->m_base->get_c_show_by_cid($v);
										break;
										
									case 'doc_gfc_id':
										$data_db['content'][$k.'_s']=element('gfc_finance_code', $data_db['content']);
										break;
										
									case 'gfc_category_extra':
									case 'gfc_category_secret':
										$data_db['content'][$k]=$GLOBALS['m_gfc']['text'][$k][$v];
										break;
								}
							}
						}

//						$data_out['icon']='icon-mute';
//						if(element('doc_alert_yn',$data_db['content']) == 1 )
//							$data_out['icon']='icon-prompt';
			
						//档案明细
						$arr_search=array();
						$arr_search['field']='doci_id,doci_page_have,doci_page_now,doci_name,doci_f_id';
						$arr_search['from']='oa_doc_item';
						$arr_search['where']=" AND doc_id=?";
						$arr_search['value'][]=$data_db['content']['doc_id'];
						$rs=$this->m_db->query($arr_search);
						
						$data_db['content']['doc_info']=json_encode($rs['content'],TRUE);
					}
				} catch (Exception $e) {
				}
				break;
		}
		/************工单信息*****************/

		//工单控件展示标记
		$data_out['flag_wl'] = FALSE;
		$data_out['pp_id']=$this->model_name;

		$data_out['ppo_btn_next']='通过';
		$data_out['ppo_btn_pnext']='退回';

		switch (element('ppo', $data_db['content'])) {
			case DOC_PPO_START:
				$data_out['ppo_btn_next']='提交';
				break;
		}

		if( $data_get['act'] == STAT_ACT_EDIT
		&& element('ppo', $data_db['content']) != 0 )
		{
			$data_out['flag_wl'] = TRUE;
		}

		$data_out=$this->m_work_list->get_wl_info($data_out,$data_db);

		/************权限验证*****************/
		//@todo 权限验证

		$acl_list= $this->m_proc_doc->get_acl();

		if( ! empty (element('acl_wl_yj', $data_out)) )
		$acl_list= $acl_list | $data_out['acl_wl_yj'];

		$this->check_acl($data_db,$acl_list);

		/************显示配置*****************/
		//@todo 显示配置
		$title_field='-'.element('doc_name',$data_db['content']);
		if( ! empty( element('doc_code',$data_db['content']) ) ){
			$title_field.='-'.element('doc_code',$data_db['content']);
		}
		
		switch ($data_get['act']) {
			case STAT_ACT_CREATE:
				$data_out['title']='创建'.$this->title;

				$data_out['op_disable'][]='btn_del';
				$data_out['op_disable'][]='btn_log';

				$data_out['op_disable'][]='btn_next';
				$data_out['op_disable'][]='btn_pnext';

				$data_out['op_disable'][]='btn_wl';
				$data_out['op_disable'][]='btn_im';
				$data_out['op_disable'][]='btn_file';

				//创建默认值
				$data_db['content']['ppo'] = DOC_PPO_START;
				$data_db['content']['doc_org']=$this->sess->userdata('c_org');
				$data_db['content']['doc_addtime']=date('Y-m-d');
				$data_db['content']['doc_secret']=DOC_SECRET_WORK;
				$data_db['content']['doc_limit_level']=DOC_LIMIT_LEVEL_PUBLIC;
				$data_db['content']['doc_sub_person']=$this->sess->userdata('c_id');
				$data_db['content']['doc_sub_person_s']=$this->sess->userdata('c_show');
                $data_db['content']['doc_middle_code']='';
                
                $data_out['icon']='icon-mute';

				//个性化配置
				$data_out['url_conf']=str_replace('/', '-', $this->url_conf);

				//创建个性化配置
				$path_conf_person=PATH_PERSON_CONF.'/create/'.$data_out['url_conf'].'/'.$this->sess->userdata('a_login_id');

				$conf_person=array();
				if(file_exists($path_conf_person))
				{
					$conf_person=json_decode(file_get_contents($path_conf_person),TRUE);
					$data_conf_person=json_decode(fun_urldecode(element('data', $conf_person)),TRUE);

					if(count($data_conf_person)>0)
					{
						foreach ($data_conf_person as $k=>$v) {
							$arr_f=split_table_field($k);
							$data_db[$arr_f['table']][$arr_f['field']]=$v;
						}
					}
				}

				//GET参数赋值
				if(count($data_out['field_edit'])>0)
				{
					foreach ($data_out['field_edit'] as $v) {
						$arr_tmp=split_table_field($v);
						if(element($arr_tmp['field'] ,$data_get))
						$data_db['content'][$arr_tmp['field']]=element($arr_tmp['field'] ,$data_get);
					}
				}

				break;
			case STAT_ACT_EDIT:
				$data_out['title']='编辑'.$this->title.$title_field;

				$data_out['op_disable'][]='btn_person';
				$data_out['op_disable'][]='btn_import';
				
				$data_out['field_view'][]='content[doc_org]';

				break;
			case STAT_ACT_VIEW:
				$data_out['title']='查看'.$this->title.$title_field;

				$data_out['op_disable'][]='btn_save';
				$data_out['op_disable'][]='btn_del';
				$data_out['op_disable'][]='btn_person';
				$data_out['op_disable'][]='btn_import';
				$data_out['op_disable'][]='btn_reload';

				$data_out['op_disable'][]='btn_next';
				$data_out['op_disable'][]='btn_pnext';

				$data_out['field_view']=array_unique(array_merge($data_out['field_view'],$data_out['field_edit']));

				break;
		}

		//@todo 节点权限显示隐藏
		if( element( 'ppo',$data_db['content']) == 1 )
		{
			$data_out['op_disable'][]='btn_pnext';
		}

		if( element( 'ppo',$data_db['content']) != 1 )
		{
			$data_out['op_disable'][]='btn_del';
		}

		//禁用项目信息
		if( empty(element('doc_gfc_id',$data_db['content'])) )
		{
			$data_out['op_disable'][]='title_gfc';
		}
		
		if( element('ppo',$data_db['content']) != DOC_PPO_SP
		 && element('ppo',$data_db['content']) != DOC_PPO_END)
		{
			$data_out['op_disable'][]='title_check';
		}

		if( element('ppo',$data_db['content'])==DOC_PPO_SP)
		{
			$data_out['field_required'][]='content[doc_company_code]';
			$data_out['field_required'][]='content[doc_big_code]';
			$data_out['field_required'][]='content[doc_middle_code]';
			$data_out['field_required'][]='content[doc_small_code]';
			$data_out['field_required'][]='content[doc_nominate]';
			$data_out['field_required'][]='content[doc_return_time]';
			
			$data_db['content']['doc_return_time']=date('Y-m-d');
		}
		
		if( $data_get['act'] == STAT_ACT_EDIT
		&& element( 'ppo',$data_db['content']) == 0
		&& ($acl_list & pow(2,ACL_PROC_DOC_SUPER) ) == 0 )
		{
			$data_out['op_disable'][]='btn_save';
			$data_out['op_disable'][]='btn_del';

			$data_out['op_disable'][]='btn_next';
			$data_out['op_disable'][]='btn_pnext';

			$data_out['op_disable'][]='btn_reload';
		}

		if(element('flag_edit_more', $data_get))
		{
			$data_out['field_required']=array();

			$data_out['op_disable'][]='btn_log';

			$data_out['title'] = '批量编辑'.$this->title.'-请勾选要保存的字段';
		}
		elseif( element( 'ppo',$data_db['content']) == DOC_PPO_END )
		{
			$data_out['field_view'] = array_unique(array_merge($data_out['field_view'],$data_out['field_edit']));
		}
		
		/************事件处理*****************/

		if(in_array('btn_'.$btn,$data_out['op_disable']))
		{
			$rtn['result'] = FALSE;

			switch($btn)
			{
				case 'next':
				case 'pnext':
					$rtn['msg_err'] = '禁止'.$data_out['ppo_btn_'.$btn].'！';
					break;
				case 'del':
					$rtn['msg_err'] = '禁止删除！';
					break;
			}

			$rtn['err'] = array();

			if( $flag_more )
			return $rtn;

			exit;
		}

		switch ($btn)
		{
			case 'save':
			case 'next':
			case 'pnext':
			case 'yj':

				$rtn=array();//结果
				$check_data=TRUE;
				$rtn['err'] = array();

				/************数据验证*****************/
				//@todo 数据验证
				if( $btn == 'yj'
				&& empty(element('person_yj' ,$data_post['content'])))
				{
					$rtn['err']['msg']='请选择移交人！';
					$check_data=FALSE;
				}

				if($btn == 'save' || $btn == 'next')
				{
					//验证是否提醒
					if( element('doc_alert_yn',$data_post['content']) != 0){
						$data_out['field_required'][]='content[doc_alert_time]';
					}
					
					//非项目，签发单位必填
					if( empty(element('doc_gfc_id',$data_post['content'] ) ) ){
						$data_out['field_required'][]='content[doc_sign_org]';
					}
					
					//必填验证
					if(count($data_out['field_required'])>0)
					{
						foreach ($data_out['field_required'] as $v) {

							$arr_tmp=split_table_field($v);

							if( ! is_array(element('content', $data_post))
							|| (
								empty(element($arr_tmp['field'],$data_post['content']))
								&& element($arr_tmp['field'],$data_post['content']) != '0'
								)
							)
							$data_post['content'][$arr_tmp['field']] = element($arr_tmp['field'],$data_db['content']);

							if( empty(element($arr_tmp['field'],$data_post['content']))
							&& element($arr_tmp['field'],$data_post['content']) != '0'
							)
							{
								$field_s='';
								if(isset($this->table_form['fields'][$arr_tmp['field']]))
									$field_s = $this->table_form['fields'][$arr_tmp['field']]['comment'];
								elseif(count($this->arr_table_form)>0)
								{
									foreach ($this->arr_table_form as $k=>$v1) {

										if(isset($v1['fields'][$arr_tmp['field']]))
										{
											$field_s = $v1['fields'][$arr_tmp['field']]['comment'];
											break;
										}
									}
								}

								$rtn['err']['content['.$arr_tmp['field'].']']='请输入'.$field_s.'！';
								$check_data=FALSE;
							}
						}
					}
					
					//档案信息
					$arr_doc = json_decode(element('doc_info',$data_post['content']),TRUE);
					if( count( $arr_doc ) == 0 ){
						$rtn['err']['content[doc_info]']='请输入档案信息！';
						$check_data=FALSE;
					}else{
						//验证件页数
						$letter = count($arr_doc);
						
						if( count($arr_doc) > 0)
						{
							$page=0;
							foreach( $arr_doc as $k=>$v)
							{
								$page=$page+$arr_doc[$k]['doci_page_have'];
							}
						}
						
						if( $data_post['content']['doc_page_have'] != $page 
						  && $data_post['content']['doc_letter_have'] != $letter 
						  && empty(element('doc_gfc_id',$data_post['content'])))
						{
							$rtn['err']['content[doc_page_have]']='请输入正确的件-页！';
							$rtn['err']['content[doc_letter_have]']='请输入正确的件-页！';
							$check_data=FALSE;
						}else{
							$data_post['content']['doc_page_have']=$page;
							$data_post['content']['doc_letter_have']=$letter;
						}
					}
				}

				if( ! $check_data)
				{
					$rtn['result']=FALSE;

					if( $flag_more )
					{
						$rtn['msg_err']='';
						foreach($rtn['err'] as $v )
						{
							$rtn['msg_err'].=$v.'<br/>';
						}

						return $rtn;
					}

					echo json_encode($rtn);
					exit;
				}

				/************数据处理*****************/
				$data_save['content']=$data_db['content'];

				if(count(element('content',$data_post))>0)
				{
					foreach ($data_post['content'] as $k=>$v) {

						if( element('flag_edit_more', $data_post)
						&& element($k.'_check', $data_post['content']) != 1 )
						continue;

						if( ! in_array('content['.$k.']',$data_out['field_view'])
						&& ! in_array('content['.$k.']',$data_out['op_disable'])
						&& in_array('content['.$k.']',$data_out['field_edit']) )
						$data_save['content'][$k]=$v;
					}
				}
				
				$data_save['content']['doc_page_now']=$data_save['content']['doc_page_have'];
				$data_save['content']['doc_letter_now']=$data_save['content']['doc_letter_have'];
				/************事件处理*****************/
				switch ($data_get['act']) {
					case STAT_ACT_CREATE:
						
						$rtn=$this->add($data_save['content']);
						
						//档案明细保存
						if( ! empty(element('doc_info',$data_save['content']) ) )
						{
							$arr_save=array(
                                'doc_id' => $rtn['id'],
								'doci_org'=>$data_save['content']['doc_org'],
							);

							$this->m_base->save_datatable('oa_doc_item',
							$data_save['content']['doc_info'],
                                '[]',
							$arr_save);
						}
			
						//创建我的工单
						$data_save['wl']['wl_id'] = $rtn['id'];
						$data_save['wl']['wl_type'] = WL_TYPE_I;
						$data_save['wl']['wl_code']=$data_save['content']['doc_name'];
						$data_save['wl']['wl_op_table']='oa_doc';
						$data_save['wl']['wl_op_field']='doc_id';
						$data_save['wl']['op_id']=$rtn['id'];
						$data_save['wl']['p_id']=$this->proc_id;
						$data_save['wl']['pp_id']=$this->model_name;
						$data_save['wl']['wl_proc']=$data_save['content']['ppo'];
						$data_save['wl']['wl_url']=$this->url_conf.'/act/2';
						$data_save['wl']['wl_note']='【'.$this->title.'】'
						.','.$data_save['content']['doc_sub_person_s']
						;
						$data_save['wl']['c_accept'][] = $this->sess->userdata('c_id');
						$data_save['wl']['c_accept'][] = $data_save['content']['doc_sub_person'];

						$this->m_work_list->add($data_save['wl']);

						$data_save['wl']['wl_id']=get_guid();
						$data_save['wl']['wl_type'] = 0 ;
						$data_save['wl']['wl_event']='补全、提交单据';
						$data_save['wl']['wl_proc'] = 1;
						$this->m_work_list->add($data_save['wl']);

						$rtn['wl_i'][] = $this->sess->userdata('c_id');
						$rtn['wl_accept'][] = $data_save['wl']['c_accept'];
						
						$rtn['wl_care']=array();
						$rtn['wl_end'] = array();

						$arr_log_content=array();
						$arr_log_content['new']['content']=$data_save['content'];
						$arr_log_content['old']['content'][$this->pk_id]=$rtn['id'];

						//操作日志
						$data_save['content_log']['op_id']=$rtn['id'];
						$data_save['content_log']['log_act']=$data_get['act'];
						$data_save['content_log']['log_url']=$this->url_conf.'/'.$this->pk_id.'/'.$rtn['id'];
						$data_save['content_log']['log_content']=json_encode($arr_log_content);
						$data_save['content_log']['log_module']=$this->title;
						$data_save['content_log']['log_p_id']=$this->proc_id;
						$this->m_log_operate->add($data_save['content_log']);

						break;
					case STAT_ACT_EDIT:
						
						//验证数据更新时间
						if($data_save['content']['db_time_update'] != $data_db['content']['db_time_update'])
						{
							$rtn['result']=FALSE;
							$rtn['err']['db_time_update']='后台数据刷新中，请重新操作！';
							echo json_encode($rtn);
							exit;
						}

						$data_save['content'][$this->pk_id]=element($this->pk_id,$data_get);

						//流程工单
						$ppo_btn_text = $data_out['ppo_btn_next'];
						if($btn == 'pnext')
						$ppo_btn_text = $data_out['ppo_btn_pnext'];

						//工单基本信息
						$data_save['wl']['wl_code']=$data_db['content']['doc_name'];
						$data_save['wl']['wl_op_table']='oa_doc';
						$data_save['wl']['wl_op_field']='doc_id';
						$data_save['wl']['op_id']=$data_save['content'][$this->pk_id];
						$data_save['wl']['p_id']=$this->proc_id;
						$data_save['wl']['pp_id']=$this->model_name;
						$data_save['wl']['wl_url']=$this->url_conf.'/act/2';
						$data_save['wl']['wl_proc']=$data_save['content']['ppo'];
						$data_save['wl']['wl_time_end']=date('Y-m-d H:i:s',strtotime('+30 day'));
						$data_save['wl']['c_accept'] = array();
						$data_save['wl']['wl_note']='【'.$this->title.'】'
						.','.$data_save['content']['doc_sub_person_s'];

						//工单流转
						switch (element('ppo',$data_db['content']))
						{
							case DOC_PPO_START:

								if($btn == 'next')
								{
									$data_save['content']['ppo'] = DOC_PPO_SH;

									$data_save['wl']['wl_event']='审核单据';

									//添加流程接收人
									$c_accept=$this->m_acl->get_acl_person($this->proc_id,ACL_PROC_DOC_AUDIT);

									if( count($c_accept) > 0)
	    							{
		    							$arr_v=array();
		    							$arr_v[]=$data_save['content']['doc_org'];
		    							$arr_v[]=$c_accept;
		    							$c_accept=$this->m_base->get_field_where('sys_contact','c_id'
		    							,"AND c_org = ? AND c_id IN ? ",$arr_v,1);
	    							}
	    							
	    							$data_save['wl']['c_accept']=$c_accept;

								}

								break;
							case DOC_PPO_SH:

								if($btn == 'next')
								{
									$data_save['content']['ppo'] = DOC_PPO_SP;

									$data_save['wl']['wl_event']='审批单据';

									//添加流程接收人
									$c_accept=$this->m_acl->get_acl_person($this->proc_id,ACL_PROC_DOC_APPROVAL);

									if( count($c_accept) > 0)
		    						{
			    						$arr_v=array();
			    						$arr_v[]=$data_save['content']['doc_org'];
			    						$arr_v[]=$c_accept;
			    						$c_accept=$this->m_base->get_field_where('sys_contact','c_id'
			    							,"AND c_org = ? AND c_id IN ? ",$arr_v,1);
		    						}
									
									$data_save['wl']['c_accept']=$c_accept;

								}
								elseif($btn == 'pnext')
								{
									$data_save['content']['ppo'] = DOC_PPO_START;

									$data_save['wl']['wl_event']='修改单据';
									$data_save['wl']['c_accept'][] = $data_db['content']['db_person_create'];
									$data_save['wl']['c_accept'][] = $data_save['content']['doc_sub_person'];
								}

								break;
							case DOC_PPO_SP:

								if($btn == 'next')
								{
									$data_save['content']['ppo'] = DOC_PPO_END;
									//档案码
									$data_save['content']['doc_code']=$this->get_code($data_save);
								}
								elseif($btn == 'pnext')
								{
									$data_save['content']['ppo'] = DOC_PPO_START;

									$data_save['wl']['wl_event']='修改单据';
									$data_save['wl']['c_accept'][] = $data_db['content']['db_person_create'];
									$data_save['wl']['c_accept'][] = $data_save['content']['doc_sub_person'];
								}

								break;

						}

						$rtn=$this->update($data_save['content']);

						//档案信息
						if( ! empty(element('doc_info',$data_save['content']) ) )
						{
							$arr_save=array(
                                'doc_id' => element('doc_id',$data_get),
								'doci_org'=>$data_save['content']['doc_org']
							);

							$this->m_base->save_datatable('oa_doc_item',
							$data_save['content']['doc_info'],
							$data_db['content']['doc_info'],
							$arr_save);
						}

						//工单日志
						if( $btn == 'yj' )
						{
							$data_save['content_log']['log_note']=
                                '【'.$this->sess->userdata('c_name').'['.$this->sess->userdata('a_login_id').']】'
                                .'于节点【'.$GLOBALS['m_doc']['text']['ppo'][$data_db['content']['ppo']].'】'
                                .',将【'.$this->title.'】移交于【'.$data_post['content']['person_yj_s'].'】';

                             $data_save['wl']['wl_type']=WL_TYPE_YJ;
                             $data_save['wl']['wl_event']=element('wl_list_to_do', $data_out);
                             $data_save['wl']['c_accept'][]=$data_post['content']['person_yj'];

						}
						elseif( $btn == 'next' || $btn == 'pnext' )
						{
							$data_save['content_log']['log_note']=
                                '于节点【'.$GLOBALS['m_doc']['text']['ppo'][$data_db['content']['ppo']].'】'.$ppo_btn_text
								.',流转至节点【'.$GLOBALS['m_doc']['text']['ppo'][$data_save['content']['ppo']].'】';
						}

						//工单更新
						switch ($btn)
						{
							case 'yj':
								$data_save['wl_have_do']['wl_result']=WL_RESULT_YJ;
							case 'next':
								$data_save['wl_have_do']['wl_result']=WL_RESULT_SUCCESS;
							case 'pnext':

								$wl_comment='';
								if( is_array(element('wl', $data_post) )
								&& ! empty(element('wl_comment', $data_post['wl'])) )
								$wl_comment = element('wl_comment', $data_post['wl']);

								//更新工单已完成
								$data_save['wl_have_do']=array();
								$data_save['wl_have_do']['wl_comment']=$wl_comment;
								$data_save['wl_have_do']['wl_log_note']=$data_save['content_log']['log_note'];
								$this->m_work_list->update_wl_have_do(element($this->pk_id,$data_get),$this->model_name,$data_save['wl_have_do']);

								//更新我的工单
								$data_save['wl_i']['wl_log_note']=$data_save['content_log']['log_note'];

								if($data_save['content']['ppo'] == DOC_PPO_END)
								{
									$data_save['wl_i']['wl_status']=WL_STATUS_FINISH;
									$data_save['wl_i']['wl_result']=WL_RESULT_SUCCESS;
									$data_save['wl_i']['wl_person_do'] = $this->sess->userdata('c_id');
									$data_save['wl_i']['wl_time_do'] = date('Y-m-d H:i:s');
								}

								$this->m_work_list->update_wl_i(element($this->pk_id,$data_get),$this->model_name,$data_save['wl_i']);

								$data_save['wl']['wl_proc'] = $data_save['content']['ppo'];
								$data_save['wl']['wl_comment_new'] =
                                    '<p>'.date("Y-m-d H:i:s").' '.$this->sess->userdata('c_name').'['.$this->sess->userdata('a_login_id').']</p>'
                                    .'<p>'.$data_save['content_log']['log_note'].'</p>';

                                if( ! empty($wl_comment) )
                                $data_save['wl']['wl_comment_new'] = '<p>'.$wl_comment.'</p>';

                                if($data_save['content']['ppo'] != DOC_PPO_END)
                                $this->m_work_list->add($data_save['wl']);

                                //获取工单关注人与所有人
                                $arr_wl_person = $this->m_work_list->get_wl_care_accept(element($this->pk_id,$data_get),$this->model_name);

                                $rtn['wl_end'] = array();
                                $rtn['wl_accept'] = $data_save['wl']['c_accept'];
                                $rtn['wl_accept'][] = $this->sess->userdata('c_id');
                                $rtn['wl_accept'][] = $data_db['content']['doc_sub_person'];

                                if( count( element('arr_wl_accept', $data_out)) > 0 )
                                $rtn['wl_accept'] = array_values(array_merge($rtn['wl_accept'],$data_out['arr_wl_accept']));

                                $rtn['wl_accept'] =array_unique($rtn['wl_accept']);

                                $rtn['wl_care'] = $arr_wl_person['care'];
                                $rtn['wl_i'] = $arr_wl_person['accept'];
                                $rtn['wl_op_id'] = element($this->pk_id,$data_get);
                                $rtn['wl_pp_id'] = $this->model_name;

                                if($data_save['content']['ppo'] == DOC_PPO_END)
                                $rtn['wl_end'] = $arr_wl_person['accept'];

                                break;
						}


						$arr_log_content=array();
						$arr_log_content['new']['content']=$data_save['content'];
						$arr_log_content['old']['content']=$data_db['content'];

						//操作日志
						$data_save['content_log']['op_id']=element($this->pk_id, $data_get);
						$data_save['content_log']['log_act']=$data_get['act'];
						$data_save['content_log']['log_url']=$this->url_conf.'/'.$this->pk_id.'/'.element($this->pk_id, $data_get);
						$data_save['content_log']['log_content']=json_encode($arr_log_content);
						$data_save['content_log']['log_module']=$this->title;
						$data_save['content_log']['log_p_id']=$this->proc_id;
						$this->m_log_operate->add($data_save['content_log']);

						$rtn['db_time_update'] = date("Y-m-d H:i:s");

						break;
				}

				if( $flag_more )
				return $rtn;

				echo json_encode($rtn);
				exit;
				break;
			case 'del':

				$rtn=$this->del(element($this->pk_id,$data_get));
				
				$arr_wl_person = $this->m_work_list->get_wl_care_accept(element($this->pk_id,$data_get),$this->model_name);
								
				$rtn['wl_end'] = array();
				
				if( count( element('arr_wl_accept', $data_out)) > 0 )
				$rtn['wl_accept'] =$data_out['arr_wl_accept'];
								
				$rtn['wl_accept'][] = $this->sess->userdata('c_id');
				$rtn['wl_accept'][] = $data_db['content']['doc_sub_person'];
				
				$rtn['wl_care'] = $arr_wl_person['care'];
				$rtn['wl_i'] = $arr_wl_person['accept'];
				$rtn['wl_op_id'] = element($this->pk_id,$data_get);
				$rtn['wl_pp_id'] = $this->model_name;

				if( element('rtn',$rtn) )
				{
					//操作日志
					$data_save['content_log']['op_id']=element($this->pk_id, $data_get);
					$arr_log_content=array();
					$arr_log_content['old']['content']=$data_db['content'];
					$data_save['content_log']['log_url']=$this->url_conf.'/'.$this->pk_id.'/'.element($this->pk_id, $data_get);
					$data_save['content_log']['log_act']=STAT_ACT_REMOVE;
					$data_save['content_log']['log_module']=$this->title;
					$data_save['content_log']['log_p_id']=$this->proc_id;
					$this->m_log_operate->add($data_save['content_log']);
				}

				if( $flag_more )
				return $rtn;

				echo json_encode($rtn);
				exit;
				break;
		}

		/************只读/必填****************/
		$data_out['field_required']=json_encode($data_out['field_required']);

		$data_out['field_edit']=array_values(array_diff($data_out['field_edit'],$data_out['field_view']));
		$data_out['field_edit']=json_encode($data_out['field_edit']);

		$data_out['field_view']=array_values($data_out['field_view']);
		$data_out['field_view']=json_encode($data_out['field_view']);

		$data_out['op_disable']=json_encode($data_out['op_disable']);

		/************模板赋值*****************/

		$data_out['act']=$data_get['act'];
		$data_out['url']=current_url();
		$data_out['time']=time();
		if( ! empty(element('time', $data_get)) )
		$data_out['time']=element('time', $data_get);

		$data_out['proc_id']=$this->proc_id;
		$data_out['fun_open']=element('fun_open', $data_get);
		$data_out['fun_open_id']=element('fun_open_id', $data_get);
		$data_out['flag_wl_win']=element('flag_wl_win', $data_get);

		$data_out['log']=json_encode(element('log', $data_out));

		$data_out['log_time']=$this->input->post('log_time');
		$data_out['log_a_login_id']=$this->input->post('log_a_login_id');
		$data_out['log_c_name']=$this->input->post('log_c_name');
		$data_out['log_act']=$this->input->post('log_act');
		$data_out['log_note']=$this->input->post('log_note');

		$data_out['db_time_create']=element('db_time_create', $data_db['content']);
		$data_out['code']=element('doc_code',$data_db['content']);
		if( element('doc_alert_yn',$data_db['content']) =='1'){
			$data_out['icon']='icon-prompt';
		}else{
			$data_out['icon']='icon-mute';
		}

		$data_out['ppo']=element('ppo', $data_db['content']);
		$data_out['ppo_name']=$GLOBALS['m_doc']['text']['ppo'][element('ppo', $data_db['content'])];

		$data_out['fun_no_db']=element('fun_no_db', $data_get);
		$data_out['data_db_post'] = $this->input->post('data_db');

		$data_out['flag_edit_more']=element('flag_edit_more', $data_get);

		$data_out[$this->pk_id]=element($this->pk_id,$data_get);

		if(element('doc_id',$data_get))
        $data_out['doc_id']=$data_get['doc_id'];
        
		$data_out['data']=array();

		if( count($data_out['field_out'])>0)
		{
			foreach ($data_out['field_out'] as $k=>$v) {
				$arr_f = split_table_field($v);
				$data_out['data'][$v] = element($arr_f['field'], $data_db['content'],'');
			}
		}

		$data_out['data']=json_encode($data_out['data']);
		/************载入视图 *****************/
		$arr_view[]=$this->url_conf;
		$arr_view[]=$this->url_conf.'_js';

		$this->m_view->load_view($arr_view,$data_out);
	}
    
}