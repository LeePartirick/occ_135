<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * excel操作类
 */
class M_excel extends CI_Model {
	
 	public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        
        $this->load->library('PHPExcel');
		$this->load->library('PHPExcel/Iofactory');
    }
    
	/**
     * 
     * 定义
     */
	public function m_define()
    {
    	
    }
    
	/**
     * 
     * 验证权限
     */
	public function check()
    {
    	
    }
    
	/**
     * 
     * 生成导入文件
     */
	public function create_import_file($path_xlsx,$conf)
    {
    	if( file_exists($path_xlsx) )
		unlink($path_xlsx);
		
    	$PHPExcel = new PHPExcel();
		
		$PHPExcel->getProperties()->setCreator(SITE_AUTHOR);
		$PHPExcel->getProperties()->setLastModifiedBy(SITE_AUTHOR);
		
		$PHPExcel->setActiveSheetIndex(0);
				
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
		
		$write = new PHPExcel_Writer_Excel2007($PHPExcel);
		$write->save($path_xlsx);
    }
    
	/**
     * 
     * 导入
     */
	public function import()
    {
    }
    
	/**
     * 
     * 导出
     */
	public function export()
    {
    }
    
}