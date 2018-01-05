<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 *  
    员工录用
 */
class M_hr extends CI_Model {
	
 	public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->m_define();
    }
    
	/**
     * 
     * 定义
     */
	public function m_define()
    {
    	//@todo 定义
    	if( defined('LOAD_M_HR') ) return;
    	define('LOAD_M_HR', 1);
    	
    	//define
    	
    	// 用工形式
    	define('HR_TYPE_WORK_SY', 1); // 试用期
		define('HR_TYPE_WORK_ZS', 2); // 正式人员
		define('HR_TYPE_WORK_SX', 3); // 实习生
		define('HR_TYPE_WORK_JX', 4); // 见习生
		define('HR_TYPE_WORK_QT', 5); // 其他
		define('HR_TYPE_WORK_LW', 6); // 劳务派遣
		define('HR_TYPE_WORK_WB', 7); // 外包人员
		
    	$GLOBALS['m_hr']['text']['hr_type_work']=array(
    		HR_TYPE_WORK_SY=>'试用期',
    		HR_TYPE_WORK_ZS=>'正式人员',
			HR_TYPE_WORK_WB=>'外包人员',
			HR_TYPE_WORK_QT=>'其他',
			HR_TYPE_WORK_SX=>'实习生',
			HR_TYPE_WORK_JX=>'见习生',
			HR_TYPE_WORK_LW=>'劳务派遣',
    	);
    	
    	$GLOBALS['m_hr_offer']['text']['offer_type_work']=array(
    		HR_TYPE_WORK_ZS=>'正式人员',
			HR_TYPE_WORK_WB=>'外包人员',
			HR_TYPE_WORK_QT=>'其他',
    	);
    	
    	define('HR_TYPE_ZZ', 1);// 在职
		define('HR_TYPE_QT', 2);// 其他
		define('HR_TYPE_LZ', 3);// 离职
		define('HR_TYPE_JX', 4);// 见习
		define('HR_TYPE_TX', 5);// 退休
		define('HR_TYPE_LW', 6);// 劳务派遣
		define('HR_TYPE_WB', 7);// 外包人员

    	$GLOBALS['m_hr']['text']['hr_type']=array(
    		HR_TYPE_ZZ => '在职人员',
			HR_TYPE_QT => '其他人员',
			HR_TYPE_LZ => '离职人员',
			HR_TYPE_JX => '见习人员',
			HR_TYPE_TX => '退休人员',
			HR_TYPE_LW => '劳务派遣',
			HR_TYPE_WB => '外包人员',
    	);
    	
    	//合同性质	
		define('CONT_TYPE_SXXY', 1);// 实习协议
		define('CONT_TYPE_JXXY', 2);// 见习协议
		define('CONT_TYPE_JZ', 3);// 兼职
		define('CONT_TYPE_ZZ', 4);// 转正
		define('CONT_TYPE_ZS', 5);// 正式
		define('CONT_TYPE_BG', 6);// 变更
		define('CONT_TYPE_LW', 7);// 劳务派遣
		$GLOBALS['m_hr']['text']['cont_type'] = array(
			CONT_TYPE_SXXY => '实习协议',
			CONT_TYPE_JXXY => '见习协议',
			CONT_TYPE_JZ => '兼职合同',
			CONT_TYPE_ZZ => '转正合同',
			CONT_TYPE_ZS => '正式合同',
			CONT_TYPE_BG => '变更合同',
			CONT_TYPE_LW => '劳务派遣',
		);
		
		//婚姻状况	
		define('C_HY_YH', 1);// 已婚
		define('C_HY_WH', 2);// 未婚
		define('C_HY_LY', 3);// 离异
		$GLOBALS['m_hr']['text']['c_hy'] = array(
			C_HY_YH => '未婚',
			C_HY_WH => '已婚',
			C_HY_LY => '离异',
		);

		//政治面貌
		define('C_ZZMM_T', 1);// 共青团员
		define('C_ZZMM_D', 2);// 共产党员
		define('C_ZZMM_Q', 3);// 群众
		define('C_ZZMM_QT', 4);// 其他党派
		
		$GLOBALS['m_hr']['text']['c_zzmm'] = array(
			C_ZZMM_T => '团员',
			C_ZZMM_D => '中共党员',
			C_ZZMM_Q => '群众',
			C_ZZMM_QT => '其他党派',
		);
		
		define('C_XW_XS', 1);// 学士
		define('C_XW_SS', 2);// 硕士
		define('C_XW_BS', 3);// 博士
		
		$GLOBALS['m_hr']['text']['c_xw'] = array(
			C_XW_BS => '博士',
			C_XW_SS => '硕士',
			C_XW_XS => '学士',
		);
		
		//学历
		define('C_XL_CZ', 1);// 初中
		define('C_XL_GZ', 2);// 高中
		define('C_XL_ZZ', 3);// 中专
		define('C_XL_ZK', 4);// 专科
		define('C_XL_BK', 5);// 本科
		define('C_XL_SSYJS', 6);// 硕士研究生
		define('C_XL_BSYJS', 7);// 博士研究生
		
		$GLOBALS['m_hr']['text']['c_xl'] = array(
				C_XL_CZ => '初中',
				C_XL_GZ => '高中',
				C_XL_ZZ => '中专',	
				C_XL_ZK => '大专',
				C_XL_BK => '本科',
				C_XL_SSYJS => '硕士研究生',
				C_XL_BSYJS => '博士研究生',
			);
			
		//社会保险
		define('HR_SHBX_5X1J', 1);// 五险一金
		define('HR_SHBX_3X1J', 2);// 三险一金
		define('HR_SHBX_3X', 3);// 三险
		define('HR_SHBX_W', 4);// 无需缴纳社保
		
		$GLOBALS['m_hr']['text']['hr_shbx'] = array(
			HR_SHBX_5X1J => '五险一金',
			HR_SHBX_3X1J => '三险一金',
			HR_SHBX_3X => '三险',	
			HR_SHBX_W => '无需缴纳社保',
		);
		
		//职称类别
		define('HR_ZCDJ_GCS', 1);// 工程师
		define('HR_ZCDJ_JJS', 2);// 经济师
		define('HR_ZCDJ_TJS', 3);// 统计师
		define('HR_ZCDJ_HJS', 4);// 会计师
		
		$GLOBALS['m_hr']['text']['hr_zclb'] = array(
			HR_ZCDJ_GCS => '工程师',
			HR_ZCDJ_JJS => '经济师',
			HR_ZCDJ_TJS => '统计师',	
			HR_ZCDJ_HJS => '会计师',
		);
		
		//职称等级
		define('HR_ZCDJ_L', 1);// 
		define('HR_ZCDJ_M', 2);// 
		define('HR_ZCDJ_H', 3);// 
		
		$GLOBALS['m_hr']['text']['hr_zcdj'] = array(
			HR_ZCDJ_L => '初级',
			HR_ZCDJ_M => '中级',
			HR_ZCDJ_H => '高级',	
		);
		
		//职务大类
		define('HR_ZW_1_GL', 1);// 
		define('HR_ZW_1_JS', 2);// 
		define('HR_ZW_1_XS', 3);// 
		
		$GLOBALS['m_hr']['text']['hr_zw_1'] = array(
			HR_ZW_1_GL => '管理',
			HR_ZW_1_JS => '技术',
			HR_ZW_1_XS => '销售',	
		);
		
		//职务中类
		define('HR_ZW_2_GL_GJ', 1);// 
		define('HR_ZW_2_GL_ZJ', 2);// 
		define('HR_ZW_2_GL_YB', 3);// 
		define('HR_ZW_2_GL_CJ', 4);// 
		define('HR_ZW_2_JS_SXGCS', 5);// 
		define('HR_ZW_2_JS_ZSGCS', 6);// 
		define('HR_ZW_2_JS_GJGCS', 7);// 
		define('HR_ZW_2_JS_GCS', 8);//
		define('HR_ZW_2_JS_ZLGCS', 9);//
		define('HR_ZW_2_JS_SXXM', 10);// 
		define('HR_ZW_2_JS_ZSXM', 11);// 
		define('HR_ZW_2_JS_GJXM', 12);// 
		define('HR_ZW_2_JS_XM', 13);//
		define('HR_ZW_2_JS_XMZG', 14);//
		define('HR_ZW_2_XS_GJ', 15);// 
		define('HR_ZW_2_XS_JL', 16);//
		define('HR_ZW_2_XS_XS', 17);//
		
		$GLOBALS['m_hr']['text']['hr_zw_2'] = array(
			HR_ZW_2_GL_GJ => '高级管理人员',
			HR_ZW_2_GL_ZJ => '中级管理人员',
			HR_ZW_2_GL_YB => '一般管理人员',	
			HR_ZW_2_GL_CJ => '初级管理人员',
			HR_ZW_2_JS_SXGCS => '首席工程师',
			HR_ZW_2_JS_ZSGCS => '资深工程师',	
			HR_ZW_2_JS_GJGCS => '高级工程师',
			HR_ZW_2_JS_GCS => '工程师',
			HR_ZW_2_JS_ZLGCS => '助理工程师',	
			HR_ZW_2_JS_SXXM => '首席项目经理',
			HR_ZW_2_JS_ZSXM => '资深项目经理',
			HR_ZW_2_JS_GJXM => '高级项目经理',	
			HR_ZW_2_JS_XM => '项目经理',
			HR_ZW_2_JS_XMZG => '项目主管',
			HR_ZW_2_XS_GJ => '高级销售经理',	
			HR_ZW_2_XS_JL => '销售经理',
			HR_ZW_2_XS_XS => '销售员',
		);
		
		//职务小类
		define('HR_ZW_3_GL_ZJ', 1);// 
		define('HR_ZW_3_GL_FZJ', 2);//
		define('HR_ZW_3_GL_ZJZL', 3);//
		define('HR_ZW_3_GL_JL', 4);// 
		define('HR_ZW_3_GL_FJL', 5);//
		define('HR_ZW_3_GL_JLZL', 6);//
		define('HR_ZW_3_GL_ZG', 7);//
		define('HR_ZW_3_GL_ZY', 8);//
		define('HR_ZW_3_GL_WY', 9);//
		define('HR_ZW_3_JS_1', 10);// 
		define('HR_ZW_3_JS_2', 11);//
		define('HR_ZW_3_JS_3', 12);//
		define('HR_ZW_3_JS_4', 13);// 
		define('HR_ZW_3_JS_5', 14);//
		define('HR_ZW_3_XS_GJ', 15);// 
		define('HR_ZW_3_XS_JL', 16);//
		define('HR_ZW_3_XS_XS', 17);//
		
		$GLOBALS['m_hr']['text']['hr_zw_3'] = array(
			HR_ZW_3_GL_ZJ => '总监',
			HR_ZW_3_GL_FZJ => '副总监',
			HR_ZW_3_GL_ZJZL => '总监助理',	
			HR_ZW_3_GL_JL => '经理',
			HR_ZW_3_GL_FJL => '副经理',
			HR_ZW_3_GL_JLZL => '经理助理',	
			HR_ZW_3_GL_ZG => '主管(片区经理)',
			HR_ZW_3_GL_ZY => '专员',
			HR_ZW_3_GL_WY => '文员',	
			HR_ZW_3_JS_1 => '一星',
			HR_ZW_3_JS_2 => '二星',
			HR_ZW_3_JS_3 => '三星',	
			HR_ZW_3_JS_4 => '四星',
			HR_ZW_3_JS_5 => '五星',
			HR_ZW_2_XS_GJ => '高级销售经理',	
			HR_ZW_2_XS_JL => '销售经理',
			HR_ZW_2_XS_XS => '销售员',
		);
		
		//职务小类
		define('C_BANK_TYPE_ZHAOSHANG', 1);// 
		define('C_BANK_TYPE_JIAOTONG', 2);//
		define('C_BANK_TYPE_JIANSHE', 3);//
		define('C_BANK_TYPE_SHEBAO', 4);//
		define('C_BANK_TYPE_GJJ', 5);//

		$GLOBALS['m_hr']['text']['c_bank_type'] = array(
			C_BANK_TYPE_ZHAOSHANG => '招商银行',
			C_BANK_TYPE_JIAOTONG => '交通银行',
			C_BANK_TYPE_JIANSHE => '建设银行',
            C_BANK_TYPE_SHEBAO => '社保账号',
            C_BANK_TYPE_GJJ => '公积金账号',
		);
		
		//居住地房屋性质
		define('C_JZDFW_CQ', 1);// 
		define('C_JZDFW_ZF', 2);//
		define('C_JZDFW_JF', 3);//
		
		$GLOBALS['m_hr']['text']['c_jzdfw'] = array(
			C_JZDFW_CQ => '产权房',
			C_JZDFW_ZF => '租房',
			C_JZDFW_JF => '借房',
		);
		
		//户籍
		define('C_HJ_SH', 1);// 
		define('C_HJ_NSH', 2);//
		
		$GLOBALS['m_hr']['text']['c_hj'] = array(
			C_HJ_SH => '上海户籍',
			C_HJ_NSH => '非上海户籍',
		);
		
		//户籍居住证
		define('C_HJJZZ_N', 1);// 
		define('C_HJJZZ_Y', 2);//
		
		$GLOBALS['m_hr']['text']['c_hjjzz'] = array(
			C_HJJZZ_N => '无',
			C_HJJZZ_Y => '人才引进居住证',
		);
		//有或无
		define('F_HAVE_N', 1);//
		define('F_HAVE_Y', 2);//

		$GLOBALS['m_hr']['text']['f_have'] = array(
			F_HAVE_N => '无',
			F_HAVE_Y => '有',
		);
		//信息审核
		define('HR_CHECK_N', 0);//
		define('HR_CHECK_Y', 1);//

		$GLOBALS['m_hr']['text']['hr_check'] = array(
			HR_CHECK_N => '未审核',
			HR_CHECK_Y => '已审核',
		);
    }
    
	/**
	 * 
	 * 获取预算部门
	 * @param $arr 包含c_ou_2,c_ou_3,c_ou_4的数组
	 */
	public function get_budou_from_ou($arr)
    {
    	$rtn = '';
    	$arr_search=array();
    		
		$arr_search['field']='ou_id';
		$arr_search['from']='sys_ou';
		$arr_search['where']=" AND ou_id in ? AND find_in_set('1',ou_tag) ";
		$arr_search['value'][] = array($arr['c_ou_2'],$arr['c_ou_3'],$arr['c_ou_4']);
		$arr_search['order'] = 'desc';
		$arr_search['sort'] = 'LENGTH(ou_parent_path)';
		$rs=$this->m_db->query($arr_search);
		
		if(count($rs['content'])>0)
		$rtn=$rs['content'][0]['ou_id'];
		
		return $rtn;
    }
    
	/**
	 * 
	 * 验证OFFER信息所有人是否已存在于联系人
	 * @param $arr 包含c_name,c_tel,c_email的数组
	 */
	public function get_cid_from_offer_info($arr)
    {
    	$rtn = array();
    	$arr_search=array();
    		
		$arr_search['field']='c.c_id,c.c_login_id,off.ppo,c.c_type';
		$arr_search['from']='sys_contact c
							 LEFT JOIN hr_offer off ON
							 (off.c_id = c.c_id AND off.ppo > 0 )';
		$arr_search['where']=" AND ( c_tel = ? ) ";
		$arr_search['value'][] = $arr['c_tel'];
		$arr_search['rows']=1;
		$rs=$this->m_db->query($arr_search);
		
		if(count($rs['content'])>0)
		{
			$rtn['c_id'] = $rs['content'][0]['c_id'];
			$rtn['c_login_id'] = $rs['content'][0]['c_login_id'];
			$rtn['ppo'] = $rs['content'][0]['ppo'];
			$rtn['c_type'] = $rs['content'][0]['c_type'];
			
			switch($rtn['c_type'])
			{
				case HR_TYPE_LZ:
				case HR_TYPE_TX:
					$rtn['c_type'] = '';
					break;
			}
		}
		
		return $rtn;
    }
    
}