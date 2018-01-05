<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 *  
    设备清单明细
 */
class M_eli extends CI_Model {
	
	//@todo 主表配置
	private $table_name='pm_eq_list_item';
	private $pk_id='eli_id';
	private $table_form;
	private $arr_table_form=array();
	private $title='设备清单明细';
	private $model_name = 'm_eli';
	private $url_conf = 'proc_gfc/eli/edit';
	private $proc_id = 'proc_gfc';
	
 	public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->m_define();
        
         //读取表结构
        $this->config->load('db_table/'.$this->table_name, FALSE,TRUE);
        $this->table_form=$this->config->item($this->table_name);
        
    }
    
	/**
     * 
     * 定义
     */
	public function m_define()
    {
    	//@todo 定义
    	if( defined('LOAD_M_ELI') ) return;
    	define('LOAD_M_ELI', 1);
    	
    	//define
    	
    	$this->load->model('proc_bud/m_subject');
    	
    	define('ELI_TYPE_EQ', 1); //设备
    	define('ELI_TYPE_LX', 2); //零星采购
    	define('ELI_TYPE_FB', 3); //分包
    	
//    	// 预算科目
//		DEFINE('ELI_SUB_SB_FDK', '41E78ACA7D76C01A724BCFFD06E74358');// 
//		DEFINE('ELI_SUB_SB_KDK', '04F334D6FAA7D754BB7985839E04E191');// 
//		DEFINE('ELI_SUB_FB_FDK', '0C546D42770118C0D4DEBC67C3330ED2');// 
//		DEFINE('ELI_SUB_FB_3', 'C0D282966D680C3A3750F3918B5DE73E');// 
//		DEFINE('ELI_SUB_FB_6', '43953B1348DDFA27FF550F741DD71FFD');// 
//		DEFINE('ELI_SUB_FB_11', '67ACA1D84D74D734E790720BF265A179');// 
//		DEFINE('ELI_SUB_FB_17', '95306429A5FEA186C970A2B4A135927D');// 
//		DEFINE('ELI_SUB_FB_LX', 'FAC469B102B2F318DCFA4A47A6C99D1A');// 
//		
//		$GLOBALS['m_eli']['text']['eli_sub'] = array(
//			ELI_SUB_SB_FDK => '非抵扣设备',
//			ELI_SUB_SB_KDK => '可抵扣设备',
//			ELI_SUB_FB_FDK => '非抵扣分包',
//			ELI_SUB_FB_3 => '3%可抵扣分包',
//			ELI_SUB_FB_6 => '6%可抵扣分包',
//			ELI_SUB_FB_11 => '11%可抵扣分包',
//			ELI_SUB_FB_17 => '17%可抵扣分包',
//			ELI_SUB_FB_LX => '零星采购',
//		);
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
    	$acl_list= $this->m_proc_gfc->get_acl();

    	$msg='';
    	/************权限验证*****************/

    	//如果有超级权限，TRUE
    	if( ($acl_list & pow(2,ACL_PROC_GFC_SUPER)) != 0 )
    	{
    		return TRUE;
    	}

    	$check_acl=FALSE;

    	if( ! $check_acl
    	 && ($acl_list & pow(2,ACL_PROC_GFC_USER)) != 0
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
    
	/**
     * 
     */
	public function get_code($data_save=array())
    {
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
    	$arr_link=array(
    	);
		
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
     * 生成导入xlsx
     */
	public function create_import_xlsx()
    {
    	$this->load->model('base/m_excel');
    	
    	$conf=array();
    	
    	//@todo 导入xlsx配置
    	$conf['field_edit']=array(
    		'pm_eq_list_item[eli_brand]',
			'pm_eq_list_item[eli_name]',
    		'pm_eq_list_item[eli_model]',
    		'pm_eq_list_item[eli_parameter]',
			'pm_eq_list_item[eli_count]',
    		'pm_eq_list_item[eli_sum]',
    		'pm_eq_list_item[eli_sum_total]',
    		'pm_eq_list_item[eli_maintenance]',
    		'pm_eq_list_item[eli_sub]',
    	);
    	
    	$conf['field_required']=array(
    		'pm_eq_list_item[eli_brand]',
			'pm_eq_list_item[eli_name]',
    		'pm_eq_list_item[eli_model]',
    		'pm_eq_list_item[eli_count]',
    		'pm_eq_list_item[eli_sum]',
    		'pm_eq_list_item[eli_maintenance]',
    		'pm_eq_list_item[eli_sub]',
    	);
    	
    	$conf['field_define']=array(
    	);
    	
    	$conf['table_form']=array(
			'pm_eq_list_item'=>$this->table_form,
    	);
    	
    	$path=str_replace('\\', '/', APPPATH).'models/'.$this->proc_id.'/'.$this->model_name.'.xlsx';
    	
    	if( file_exists($path) )
		unlink($path);
		
        //获取预算科目
		$arr_search=array();
		$arr_search['field']='sub_id,sub_name,sub_tag';
		$arr_search['from']="fm_subject";
		$arr_search['where']=' AND (FIND_IN_SET(?,sub_tag) OR FIND_IN_SET(?,sub_tag) OR FIND_IN_SET(?,sub_tag))';
		$arr_search['value'][]=SUB_TAG_SB;
		$arr_search['value'][]=SUB_TAG_FB;
		$arr_search['value'][]=SUB_TAG_LXCG;
		$arr_search['sort']=array("sub_code");
		$arr_search['order']=array('asc');
		
		$rs=$this->m_db->query($arr_search);
		
		$conf['field_define']['pm_eq_list_item[eli_sub]']=array();
		
		if(count($rs['content'])>0)
		{
			foreach ($rs['content'] as $v) {
				
				if($v['sub_tag'] == SUB_TAG_SB || strstr($v['sub_tag'],SUB_TAG_SB))
				{
					$conf['field_define']['pm_eq_list_item[eli_sub]'][SUB_TAG_SB][] = $v['sub_name'];
				}
				
				if($v['sub_tag'] == SUB_TAG_FB || strstr($v['sub_tag'],SUB_TAG_FB))
				{
					$conf['field_define']['pm_eq_list_item[eli_sub]'][SUB_TAG_FB][] = $v['sub_name'];
				}
				
				if($v['sub_tag'] == SUB_TAG_LXCG || strstr($v['sub_tag'],SUB_TAG_LXCG))
				{
					$conf['field_define']['pm_eq_list_item[eli_sub]'][SUB_TAG_LXCG][] = $v['sub_name'];
				}
			}
		}
		
    	$PHPExcel = new PHPExcel();
		
		$PHPExcel->getProperties()->setCreator(SITE_AUTHOR);
		$PHPExcel->getProperties()->setLastModifiedBy(SITE_AUTHOR);
		
		//设备采购
		$conf['table_form']['pm_eq_list_item']['fields']['eli_maintenance']['comment'] = '保修期-月';
		
		$PHPExcel->setActiveSheetIndex(0);
		$PHPExcel->getActiveSheet()->setTitle('设备采购');
				
		$arr_xlsx_col_define=array();
		
		if(count($conf['field_edit'])>0)
		{
			$col_num=0;
			
			foreach ($conf['field_edit'] as  $v) 
			{
				$col_s=IntToChr($col_num);
				$cell=$col_s.'1';
				
				$arr_field=split_table_field($v);
				
				$field_conf=$conf['table_form'][$arr_field['table']]['fields'][$arr_field['field']];
				
				//设置列宽
				$PHPExcel->getActiveSheet()->getColumnDimension($col_s)->setWidth(20);
				
				//设置文本
				$PHPExcel->getActiveSheet()->getStyle($cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				
				//标题加粗
				$PHPExcel->getActiveSheet()->getStyle($cell)->getFont()->setBold(true);
				
				//标题居中
				$PHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				//必填提醒
				if(in_array($v, $conf['field_required']))
				{
					$PHPExcel->getActiveSheet()->getStyle($cell)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
					$PHPExcel->getActiveSheet()->getComment($cell)->setAuthor(SITE_AUTHOR); 
					$PHPExcel->getActiveSheet()->getComment($cell )->getText()->createTextRun('必填');  //添加批注
				}
				
				//选项限制
				$field_define = element($v, $conf['field_define']);
				if($v == 'pm_eq_list_item[eli_sub]')
				{
					$field_define = element(SUB_TAG_SB, $field_define);
				}
				
		        if( ! empty($field_define) )
		        {
		        	 $PHPExcel->getActiveSheet()->getCell($col_s.'2')->getDataValidation()
		        	 		  -> setType(PHPExcel_Cell_DataValidation::TYPE_LIST)  
					          -> setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION)  
					          -> setAllowBlank(false)  
					          -> setShowInputMessage(true)  
					          -> setShowErrorMessage(true)  
					          -> setShowDropDown(true)  
					          -> setErrorTitle('输入的值有误')  
					          -> setError('您输入的值不在下拉框列表内.')  
					          -> setPromptTitle($field_conf['comment'])  
					          -> setFormula1('"'.implode(',', $field_define).'"');  
					          
		        	 $PHPExcel->getActiveSheet()->getComment($col_s.'2')->setAuthor(SITE_AUTHOR); 
					 $PHPExcel->getActiveSheet()->getComment($col_s.'2' )->getText()->createTextRun('选项限制');  //添加批注
					          
		        }
		        else
		        {
//		        	$PHPExcel->getActiveSheet()->getStyle($col_s.'2')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		        }
				
				$PHPExcel->getActiveSheet()->setCellValue($cell,$field_conf['comment']);
				
				$col_num++;
			}
		}
		
    	//零星采购
    	$conf['field_required']=array(
			'pm_eq_list_item[eli_brand]',
			'pm_eq_list_item[eli_name]',
    		'pm_eq_list_item[eli_model]',
    		'pm_eq_list_item[eli_sum_total]',
    		'pm_eq_list_item[eli_maintenance]',
    		'pm_eq_list_item[eli_maintenance_start]',
    		'pm_eq_list_item[eli_sub]',
    	);
		$conf['table_form']['pm_eq_list_item']['fields']['eli_maintenance']['comment'] = '保修期-月';
		
		$nWorkSheet = new PHPExcel_Worksheet($PHPExcel, '零星采购'); //创建一个工作表
        $PHPExcel->addSheet($nWorkSheet); //插入工作表
		$PHPExcel->setActiveSheetIndex(1);
				
		$arr_xlsx_col_define=array();
		
		if(count($conf['field_edit'])>0)
		{
			$col_num=0;
			
			foreach ($conf['field_edit'] as  $v) 
			{
				$col_s=IntToChr($col_num);
				$cell=$col_s.'1';
				
				$arr_field=split_table_field($v);
				
				$field_conf=$conf['table_form'][$arr_field['table']]['fields'][$arr_field['field']];
				
				//设置列宽
				$PHPExcel->getActiveSheet()->getColumnDimension($col_s)->setWidth(20);
				
				//设置文本
				$PHPExcel->getActiveSheet()->getStyle($cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				
				//标题加粗
				$PHPExcel->getActiveSheet()->getStyle($cell)->getFont()->setBold(true);
				
				//标题居中
				$PHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				//必填提醒
				if(in_array($v, $conf['field_required']))
				{
					$PHPExcel->getActiveSheet()->getStyle($cell)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
					$PHPExcel->getActiveSheet()->getComment($cell)->setAuthor(SITE_AUTHOR); 
					$PHPExcel->getActiveSheet()->getComment($cell )->getText()->createTextRun('必填');  //添加批注
				}
				
				if($arr_field['field'] == 'eli_sum_total')
				{
					$PHPExcel->getActiveSheet()->getStyle($cell)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
					$PHPExcel->getActiveSheet()->getComment($cell)->setAuthor(SITE_AUTHOR); 
					$PHPExcel->getActiveSheet()->getComment($cell )->getText()->createTextRun('必填,或填写数量及采购单价,导入后系统自动计算单位成本');  //添加批注
				}
				
				//选项限制
				$field_define = element($v, $conf['field_define']);
				
				if($v == 'pm_eq_list_item[eli_sub]')
				{
					$field_define = element(SUB_TAG_LXCG, $field_define);
				}
				
		        if( ! empty($field_define) )
		        {
		        	 $PHPExcel->getActiveSheet()->getCell($col_s.'2')->getDataValidation()
		        	 		  -> setType(PHPExcel_Cell_DataValidation::TYPE_LIST)  
					          -> setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION)  
					          -> setAllowBlank(false)  
					          -> setShowInputMessage(true)  
					          -> setShowErrorMessage(true)  
					          -> setShowDropDown(true)  
					          -> setErrorTitle('输入的值有误')  
					          -> setError('您输入的值不在下拉框列表内.')  
					          -> setPromptTitle($field_conf['comment'])  
					          -> setFormula1('"'.implode(',', $field_define).'"');  
					          
		        	 $PHPExcel->getActiveSheet()->getComment($col_s.'2')->setAuthor(SITE_AUTHOR); 
					 $PHPExcel->getActiveSheet()->getComment($col_s.'2' )->getText()->createTextRun('选项限制');  //添加批注
					          
		        }
		        else
		        {
//		        	$PHPExcel->getActiveSheet()->getStyle($col_s.'2')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		        }
				
				$PHPExcel->getActiveSheet()->setCellValue($cell,$field_conf['comment']);
				
				$col_num++;
			}
		}
		
    	//分包采购
    	$conf['field_edit']=array(
    		'pm_eq_list_item[eli_supply_org]',
			'pm_eq_list_item[eli_name]',
    		'pm_eq_list_item[eli_parameter]',
			'pm_eq_list_item[eli_count]',
    		'pm_eq_list_item[eli_sum]',
    		'pm_eq_list_item[eli_sum_total]',
    		'pm_eq_list_item[eli_maintenance]',
    		'pm_eq_list_item[eli_maintenance_start]',
    		'pm_eq_list_item[eli_sub]',
    	);
    	
    	$conf['field_required']=array(
    		'pm_eq_list_item[eli_supply_org]',
			'pm_eq_list_item[eli_name]',
    		'pm_eq_list_item[eli_count]',
    		'pm_eq_list_item[eli_sum]',
    		'pm_eq_list_item[eli_maintenance]',
    		'pm_eq_list_item[eli_maintenance_start]',
    		'pm_eq_list_item[eli_sub]',
    	);
    	$conf['table_form']['pm_eq_list_item']['fields']['eli_supply_org']['comment'] = '分包商';
    	$conf['table_form']['pm_eq_list_item']['fields']['eli_name']['comment'] = '分包名称';
    	$conf['table_form']['pm_eq_list_item']['fields']['eli_parameter']['comment'] = '服务大概描述';
		$conf['table_form']['pm_eq_list_item']['fields']['eli_maintenance']['comment'] = '服务期-月';
		
		$nWorkSheet = new PHPExcel_Worksheet($PHPExcel, '分包采购'); //创建一个工作表
        $PHPExcel->addSheet($nWorkSheet); //插入工作表
		$PHPExcel->setActiveSheetIndex(2);
				
		$arr_xlsx_col_define=array();
		
		if(count($conf['field_edit'])>0)
		{
			$col_num=0;
			
			foreach ($conf['field_edit'] as  $v) 
			{
				$col_s=IntToChr($col_num);
				$cell=$col_s.'1';
				
				$arr_field=split_table_field($v);
				
				$field_conf=$conf['table_form'][$arr_field['table']]['fields'][$arr_field['field']];
				
				//设置列宽
				$PHPExcel->getActiveSheet()->getColumnDimension($col_s)->setWidth(20);
				
				//设置文本
				$PHPExcel->getActiveSheet()->getStyle($cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				
				//标题加粗
				$PHPExcel->getActiveSheet()->getStyle($cell)->getFont()->setBold(true);
				
				//标题居中
				$PHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				//必填提醒
				if(in_array($v, $conf['field_required']))
				{
					$PHPExcel->getActiveSheet()->getStyle($cell)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
					$PHPExcel->getActiveSheet()->getComment($cell)->setAuthor(SITE_AUTHOR); 
					$PHPExcel->getActiveSheet()->getComment($cell )->getText()->createTextRun('必填');  //添加批注
				}
				
				//选项限制
				$field_define = element($v, $conf['field_define']);
				if($v == 'pm_eq_list_item[eli_sub]')
				{
					$field_define = element(SUB_TAG_FB, $field_define);
				}
				
		        if( ! empty($field_define) )
		        {
		        	 $PHPExcel->getActiveSheet()->getCell($col_s.'2')->getDataValidation()
		        	 		  -> setType(PHPExcel_Cell_DataValidation::TYPE_LIST)  
					          -> setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION)  
					          -> setAllowBlank(false)  
					          -> setShowInputMessage(true)  
					          -> setShowErrorMessage(true)  
					          -> setShowDropDown(true)  
					          -> setErrorTitle('输入的值有误')  
					          -> setError('您输入的值不在下拉框列表内.')  
					          -> setPromptTitle($field_conf['comment'])  
					          -> setFormula1('"'.implode(',', $field_define).'"');  
					          
		        	 $PHPExcel->getActiveSheet()->getComment($col_s.'2')->setAuthor(SITE_AUTHOR); 
					 $PHPExcel->getActiveSheet()->getComment($col_s.'2' )->getText()->createTextRun('选项限制');  //添加批注
					          
		        }
		        else
		        {
//		        	$PHPExcel->getActiveSheet()->getStyle($col_s.'2')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		        }
				
				$PHPExcel->getActiveSheet()->setCellValue($cell,$field_conf['comment']);
				
				$col_num++;
			}
		}
		
		$PHPExcel->setActiveSheetIndex(0);
		
		$write = new PHPExcel_Writer_Excel2007($PHPExcel);
		$write->save($path);
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
			'content[eli_sub]',
//			'content[eli_sub_s]',
			'content[eli_name]',
		
			'content[eli_type]',
		);
		
		//编辑数组
		$data_out['field_edit']=array(
			'content[db_time_update]',
		
			'content[eli_sub]',
//			'content[eli_sub_s]',

			'content[eli_eq_id]',
			'content[eli_name]',
			'content[eli_supply_org]',
			'content[eli_supply_org_s]',
			'content[eli_brand]',
			'content[eli_model]',
			'content[eli_unit]',
			'content[eli_description]',
			'content[eli_parameter]',
			
			'content[eli_sum]',
			'content[eli_count]',
		
			'content[eli_sum_total]',
			
			'content[eli_maintenance_s]',
			'content[eli_maintenance]',
			'content[eli_maintenance_start]',
		
			'content[eli_type_bill]',
			'content[eli_type_lxcg]',
			
			'content[eli_c_pr]',
		
			'content[eli_note]',
		
			'content[eli_gfc_id]',
			'content[eli_type]',
		);
		
		//只读数组
		$data_out['field_view']=array(
			'content[eli_gfc_id]',
			'content[eli_name_s]',
			'content[eli_supply_org_s_s]',
			'content[eli_parameter_s]',
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
								if( is_array($v) ) {
									$v = implode(',', $v);

									if(element($k,$data_db['content']))
										$data_db['content'][$k] = implode(',', $data_db['content'][$k]);
								}

								if( $v != element($k,$data_db['content']) )
								{
									switch ($k)
									{
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
						
						//非数据库页面调用
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
						
					}
					
				} catch (Exception $e) {
				}
			break;
		}
		/************工单信息*****************/

		/************权限验证*****************/
		//@todo 权限验证
		$acl_list= $this->m_proc_gfc->get_acl();

		$this->check_acl($data_db,$acl_list);
		
		/************显示配置*****************/
		//@todo 显示配置
		$title_field='-'.element('eli_name',$data_db['content']);
		
		switch ($data_get['act']) {
			case STAT_ACT_CREATE:
				$data_out['title']='创建'.$this->title;
				
				$data_out['op_disable'][]='btn_del';
				$data_out['op_disable'][]='btn_log';
				
				$data_out['op_disable'][]='btn_next';
				$data_out['op_disable'][]='btn_pnext';
				
				$data_out['op_disable'][]='btn_wl';
				$data_out['op_disable'][]='btn_im';
				
				//创建默认值
				$data_db['content']['eli_type'] = ELI_TYPE_EQ;
				
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
				
				
			break;
			case STAT_ACT_VIEW:
				$data_out['title']='查看'.$this->title.$title_field;
				
				$data_out['op_disable'][]='btn_save';
				$data_out['op_disable'][]='btn_del';
				$data_out['op_disable'][]='btn_person';
				$data_out['op_disable'][]='btn_import';
				
				$data_out['op_disable'][]='btn_next';
				$data_out['op_disable'][]='btn_pnext';
				
				$data_out['field_view']=array_unique(array_merge($data_out['field_view'],$data_out['field_edit']));
				
			break;
		}
		
		//@todo 节点权限显示隐藏
		if(element('flag_edit_more', $data_get))
		{
			$data_out['field_required']=array();
			
			$data_out['op_disable'][]='btn_log';
			$data_out['op_disable'][]='btn_del';
			
			$data_out['title'] = '批量编辑'.$this->title.'-请勾选要保存的字段';
		}
		
		switch(element('eli_type',$data_db['content']))
		{
			case ELI_TYPE_FB:
				$data_db['content']['eli_name_s'] = '分包名称';
				$data_db['content']['eli_supply_org_s_s'] = '分包商';
				$data_db['content']['eli_parameter_s'] = '服务大概描述';
				$data_db['content']['eli_maintenance_s'] = '服务器-月';
				
				$data_out['op_disable'][]='content[eli_brand]';
				$data_out['op_disable'][]='content[eli_model]';
				
				$data_out['field_required'] = array_values(array_unique(array_merge($data_out['field_required'],array(
				))));
				
				break;
				
			case ELI_TYPE_LX:
			//case ELI_TYPE_EQ:
			default:
				
				$data_out['field_required'] = array_values(array_unique(array_merge($data_out['field_required'],array(
				))));
				
				$data_db['content']['eli_name_s'] = '设备名称';
				$data_db['content']['eli_supply_org_s_s'] = '供应商';
				$data_db['content']['eli_parameter_s'] = '设备参数';
				$data_db['content']['eli_maintenance_s'] = '保修期-月';
				
		}
		
		
		/************事件处理*****************/

		if(in_array('btn_'.$btn,$data_out['op_disable']))
		{
			$rtn['result'] = FALSE;
			
			if($btn == 'del')
			$rtn['msg_err'] = '禁止删除！';
			
			$rtn['err'] = array();
				
			if( $flag_more )
			return $rtn;
					
			exit;
		}
		
		switch ($btn)
		{
			case 'save':
				
				$rtn=array();//结果
				$check_data=TRUE;
				
				/************数据验证*****************/
				//@todo 数据验证
				if($btn == 'save')
				{
					switch(element('eli_type',$data_post['content']))
					{
						case ELI_TYPE_FB:
							
							$data_out['field_required'] = array_values(array_unique(array_merge($data_out['field_required'],array(
//								'content[eli_supply_org]',
								'content[eli_supply_org_s]',
								'content[eli_sum]',
								'content[eli_count]',
								'content[eli_sum_total]',
								'content[eli_maintenance]',
								'content[eli_maintenance_start]',
							))));
							
							break;
						case ELI_TYPE_LX:
							
							$data_out['field_required'] = array_values(array_unique(array_merge($data_out['field_required'],array(
								'content[eli_brand]',
								'content[eli_model]',
								'content[eli_sum_total]',
							))));
							
							break;
							
						default: 
							$data_out['field_required'] = array_values(array_unique(array_merge($data_out['field_required'],array(
								'content[eli_brand]',
								'content[eli_model]',
								'content[eli_sum]',
								'content[eli_count]',
								'content[eli_sum_total]',
								'content[eli_maintenance]',
							))));
							
							break;
						
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
					
//					if( element('eli_type',$data_post['content']) != ELI_TYPE_LX 
//					 && element('eli_count',$data_post['content']) == 0 )
//					{
//						$rtn['err']['content[eli_count]']='数量不可为0 ！';
//						$check_data=FALSE;
//					} 
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
				
				if(element('fun_no_db', $data_get))
				{
					$rtn['rtn']=TRUE;
					
					if( $flag_more )
					{
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
				/************事件处理*****************/
				switch ($data_get['act']) {
					case STAT_ACT_CREATE:
						$rtn=$this->add($data_save['content']);
						
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
						
						$rtn=$this->update($data_save['content']);
						
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
		
		$data_out['fun_open']=element('fun_open', $data_get);
	    $data_out['fun_open_id']=element('fun_open_id', $data_get);
	    
	    $data_out['log']=json_encode(element('log', $data_out));
		
		$data_out['log_time']=$this->input->post('log_time');
		$data_out['log_a_login_id']=$this->input->post('log_a_login_id');
		$data_out['log_c_name']=$this->input->post('log_c_name');
		$data_out['log_act']=$this->input->post('log_act');
		$data_out['log_note']=$this->input->post('log_note');
	    
	    $data_out['db_time_create']=element('db_time_create', $data_db['content']);
	    $data_out['code']=element('gfc_code', $data_db['content']);
	    
	    $data_out['fun_no_db']=element('fun_no_db', $data_get);
	    $data_out['data_db_post'] = $this->input->post('data_db');
	    
	    $data_out['flag_edit_more']=element('flag_edit_more', $data_get);
	    
	    $data_out[$this->pk_id]=element($this->pk_id,$data_get);
	    $data_out['eli_type']=element('eli_type', $data_db['content']);
	    
	    $data_out['data']=array();
	    
		if( count($data_out['field_out'])>0)
		{
			foreach ($data_out['field_out'] as $k=>$v) {
				$arr_f = split_table_field($v);
				$data_out['data'][$v] = element($arr_f['field'], $data_db['content']);
			}
		}

		$data_out['data']=json_encode($data_out['data']);
		/************载入视图 *****************/
		$arr_view[]=$this->url_conf;
		$arr_view[]=$this->url_conf.'_js';
		
		$this->m_view->load_view($arr_view,$data_out);
	}
}