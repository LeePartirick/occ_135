<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 方法
 * @author 朱明
 *
 */
class Fun extends CI_Controller {

	
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
	 * 查询条件个性化设置
	 *
	 */
	public function conf_person_search()
	{
		/************变量初始化****************/
		$arr_view = array();//视图数组
		$data_post= array();//$POST数组
		$data_get = array();//$GET 数组
		$data_out = array();//输出数组
		$data_db  = array();//数据库数据
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		
		/************事件处理****************/
		$url=$this->input->post('url');
		
		$a_login_id=$this->sess->userdata('a_login_id') ;
		
		$path=PATH_PERSON_CONF.'/search/'.$url;
		
		if( ! file_exists($path) )
		mkdir($path);
		
		$path.='/'.$a_login_id;
		
		$conf=array();
		$conf['search']=$this->input->post('search');
		
		write_file($path,json_encode($conf), 'w');
	}
	
	/**
	 * 索引列表个性化设置
	 *
	 */
	public function conf_person_index()
	{
		/************变量初始化****************/
		$arr_view = array();//视图数组
		$data_post= array();//$POST数组
		$data_get = array();//$GET 数组
		$data_out = array();//输出数组
		$data_db  = array();//数据库数据
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		
		/************事件处理****************/
		$url=$this->input->post('url');
		
		$a_login_id=$this->sess->userdata('a_login_id') ;
		
		$path=PATH_PERSON_CONF.'/index/'.$url;
		
		if( ! file_exists($path) )
		mkdir($path);
		
		$path.='/'.$a_login_id;
		
		$conf=array();
		
		$conf['columns']=$this->input->post('columns');
		$conf['frozenColumns']=$this->input->post('frozenColumns');
		$conf['sort']=$this->input->post('sort');
		$conf['order']=$this->input->post('order');
		$conf['no_page']=$this->input->post('no_page');
		
		write_file($path,json_encode($conf), 'w');
	}
	
	/**
	 * 创建个性化设置
	 *
	 */
	public function conf_person_create()
	{
		/************变量初始化****************/
		$arr_view = array();//视图数组
		$data_post= array();//$POST数组
		$data_get = array();//$GET 数组
		$data_out = array();//输出数组
		$data_db  = array();//数据库数据
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		
		/************模板赋值****************/
		$url=$this->input->post('url');
		
		$a_login_id=$this->sess->userdata('a_login_id') ;
		
		$path=PATH_PERSON_CONF.'/create/'.$url;
		
		if( ! file_exists($path) )
		mkdir($path);
		
		$path.='/'.$a_login_id;
		
		$conf=array();
		$conf['data']=$this->input->post('data');
		
		write_file($path,json_encode($conf), 'w');
		
		/************载入视图 ****************/
	}
	
	/**
	 * 
	 * 文件下载
	 */
	public function file_download()
	{
		$this->load->helper('download');
		/************变量初始化****************/
		$data_get = array();//$GET 数组
		$data_post = array();//$POST 数组
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		
		$folder = element('folder', $data_get);
		$name	= fun_urldecode(element('name', $data_get));
		$file	= fun_urldecode(element('file', $data_get));
		
		$path = '';
		
		switch ($folder) {
			//临时文件
			case 'tmp':
			$path = str_replace('\\', '/', APPPATH).'tmp/'.$file;
			print_R($path);
			break;
			//系统文件
			case 'sysfile':
			$path = str_replace('\\', '/', APPPATH).'sysfile/'.$file;
			break;
			//导入模板
			case 'import':
			$path = str_replace('\\', '/', APPPATH).'models/'.$file.'.xlsx';
			break;
			//文档文件
			case 'file':
			
			$this->m_table_op->load('sys_file_verson');
			
			$data_db['content']=$this->m_table_op->get($file);
			
			if( empty($data_db['content']['f_v_id']) )
			{
				$msg= '文件【'.$name.'】不存在！';
				
				redirect('base/main/show_err/msg/'.fun_urlencode($msg));
			}
			
			$path = $this->config->item('base_file_path').$data_db['content']['f_v_path'].'/'.$file;
			
			break;
		}
		/************事件处理*****************/
		if( ! file_exists($path))
		exit;
		
		$data_download=file_get_contents($path);
		if( $this->ua->browser()=='Spartan'
	     || $this->ua->is_browser('Internet Explorer') ) 
	    {
	    	$name=urlencode($name);
	    }
		force_download($name,$data_download);
		
		switch ($folder) {
			case 'tmp':
			@unlink($path);
			break;
		}
		exit;
	}
	
	/**
	 * 
	 * 索引导出
	 */
	public function fun_xlsx_export()
	{
		$this->load->model('base/m_excel');
		/************变量初始化****************/
		$arr_view = array();//视图数组
		$data_post= array();//$POST数组
		$data_get = array();//$GET 数组
		$data_out = array();//输出数组
		$data_db  = array();//数据库数据
		
		$data_save=array();//数据库保存数组
		$arr_search=array();
		$data_out['op_disable']=array();
		
		$rtn=array();
		$rtn['rs']=TRUE;
		
		$time_start=time();
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		
		$id=element('id', $data_get);
		
		$bt_param=$this->input->post('bt_param');
		if( ! $bt_param )$bt_param=array();
		
		$btn=$this->input->post('btn');
		
		$row     = $this->input->post('row');
		$col     = $this->input->post('col');
		$row_num = $this->input->post('row_num');
		/************事件处理 *****************/
		$col = element('col', $bt_param);
			
		//是否存在xlsx文件
		$path_xlsx=str_replace('\\', '/', APPPATH).'/tmp/'.$id.'.xlsx';
		if( ! file_exists($path_xlsx) )
		{
			//创建xlsx文件
			$PHPExcel = new PHPExcel();
			
			$PHPExcel->getProperties()->setCreator(SITE_AUTHOR);
			$PHPExcel->getProperties()->setLastModifiedBy(SITE_AUTHOR);
			
			$PHPExcel->setActiveSheetIndex(0);
			
			//生成标题
			if(is_array($col) && count($col) > 0)
			{
				$col_num=0;
				foreach ($col as $v) {
					//为单元格赋值
					$col_s=IntToChr($col_num);
					$cell=$col_s.'1';
					
					//设置列宽
					$v['width']=$v['width']/10;
					if( ! empty($v['width']) || $v['width'] < 20 )
					$v['width']=20;
					
					$PHPExcel->getActiveSheet()->getColumnDimension($col_s)->setWidth($v['width']);
					
					//设置文本
					$PHPExcel->getActiveSheet()->getStyle($cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
					
					//标题加粗
					$PHPExcel->getActiveSheet()->getStyle($cell)->getFont()->setBold(true);
					
					//标题居中
					$PHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					
					//边框
					$PHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
						
					$PHPExcel->getActiveSheet()->setCellValue($cell,$v['title']);
					
					$col_num++;
				}
			}
			
			$write = new PHPExcel_Writer_Excel2007($PHPExcel);
			$write->save($path_xlsx);
		}
		
		if( $btn == 'save' )
		{
			$row = json_decode($row,TRUE);
			
			$total = element('total', $bt_param);
			
			if(count($row)>0 && $row_num <= $total + 1)
			{
				$reader = IOFactory::createReader('Excel2007'); 
				$PHPExcel = $reader->load($path_xlsx); 
				$sheet = $PHPExcel->getSheet(0);
				
				$i=0;
				
				foreach ($row as $v) {
					
					$col_num=0;
					
					if(count($col)>0)
					{
						foreach ($col as $v_col) {
							
							$col_s=IntToChr($col_num);
							$cell=$col_s.$row_num;
							
							//设置文本
							$PHPExcel->getActiveSheet()->getStyle($cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
							
							//设置对齐
							if( element('align', $v_col) == 'center' )
							$PHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
							
							if( element('align', $v_col) == 'right' )
							$PHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							
							$PHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
							$PHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
							
							//自动换行
							$PHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setWrapText(TRUE);
							
							$value=fun_urldecode(element($v_col['field'], $v));
	//						$PHPExcel->getActiveSheet()->setCellValue($cell,$value);
							
							if(substr($value,0,4) == '<img')
							{
								$path_img=$this->m_base->getImgSrcFromStr($value);
								$path_img=current($path_img);
								
								if( ! file_exists($path_img) )
								$path_img=$this->config->item('base_www_path').$path_img;
								
								if(file_exists($path_img))
								{
								/*实例化插入图片类*/
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								
								/*设置图片路径 切记：只能是本地图片*/
								$objDrawing->setPath($path_img);
								
								/*设置图片高度*/
								$objDrawing->setHeight(160);
								
								/*设置图片要插入的单元格*/
								$objDrawing->setCoordinates($cell);
								
								/*设置图片所在单元格的格式*/
//								$objDrawing->setOffsetX(80);
//								$objDrawing->setRotation(20);
//								$objDrawing->getShadow()->setVisible(true);
//								$objDrawing->getShadow()->setDirection(50);
								$objDrawing->setWorksheet($PHPExcel->getActiveSheet());
								$PHPExcel->getActiveSheet()->getRowDimension($row_num)->setRowHeight(120);
								}
							}
							else 
							{
								$PHPExcel->getActiveSheet()->setCellValueExplicit($cell,$value,PHPExcel_Cell_DataType::TYPE_STRING);
							}
							
							$col_num++;
						}
					}
					
					unset($row[$i]);
					
					//防止超时
					$time_end=time();
					
					if( $time_end-$time_start > 15 )
					{
						$write = new PHPExcel_Writer_Excel2007($PHPExcel);
						$write->save($path_xlsx);
				
						$rtn['rs']=FALSE;
						$rtn['row_num']=$row_num;
						$rtn['row']=json_encode($row);
						echo json_encode($rtn);;
						exit;
					}
					
					$i++;
					$row_num++;
				}
				
				$rtn['row_num']=$row_num;
				$rtn['row']=json_encode($row);
				$write = new PHPExcel_Writer_Excel2007($PHPExcel);
				$write->save($path_xlsx);
			}
			else 
			{
				exit;
			}
			
			echo json_encode($rtn);
			exit;
		}
		
		/************模板赋值*****************/
		$data_out['time']=time();
		$data_out['id']=$id;
		$data_out['bt_param']=json_encode($bt_param);
		/************载入视图 *****************/
		$arr_view[]='base/fun/fun_xlsx_export';
		$arr_view[]='base/fun/fun_xlsx_export_js';
		 
		$this->m_view->load_view($arr_view,$data_out);
	}
	
	/**
	 * 
	 * 文件上传
	 */
	public function win_upload()
	{
		/************变量初始化****************/
		$arr_view = array();//视图数组
		$data_post= array();//$POST数组
		$data_get = array();//$GET 数组
		$data_out = array();//输出数组
		$data_db  = array();//数据库数据
		
		$data_save=array();//数据库保存数组
		$arr_search=array();
		
		/************变量赋值*****************/
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		
		$action = element('action', $data_get);
		$actions = array('tk', 'up', 'fd');
		
		/************事件处理*****************/
		//判断是否正确的请求
		if(in_array($action, $actions)){
			$this->load->model('base/m_upload');
			$this->m_upload->$action();
		}
		
		/************模板赋值*****************/
		$type=element('type', $data_get);
		$data_out['op_id']=$op_id=element('op_id', $data_get);
		$data_out['conf']=array();
		
		switch ($type)
		{
			//xlsx导入
			case 'import':
				$title=$this->input->post('title');
				$file=$this->input->post('file');
				$url_import=$this->input->post('url_import');
				
				$data_out['conf']['dragAndDropArea']='win_xlsx_import';
				
				$data_out['conf']['autoUploading']='true';
				$data_out['conf']['multipleFiles']='false';
				$data_out['conf']['maxSize']=5*1024*1024;
				$data_out['conf']['simLimit']=1;
				$data_out['conf']['extFilters']='".xlsx"';
				$data_out['conf']['onSelect']="
				";
				$data_out['conf']['onExtNameMismatch']="请使用下载的模板作为导入文件！";
				$data_out['conf']['onAddTask']="
					//添加引导步骤
					$('#win_xlsx_import').addClass('suiinfo');
					$('#win_xlsx_import').attr('data-intro','xlsx导入');
					$('#win_xlsx_import').attr('data-step',1);
			
					$('#btn_back_task').addClass('suiinfo');
					$('#btn_back_task').attr('data-intro','进入后台运行');
					$('#btn_back_task').attr('data-step',2);
					
					$.introJs().start();
					
					stream{$op_id}.config.simLimit='0';
					
					setTimeout(function(){
						//建立后台任务
						fun_load_back_task('btask_{$op_id}');
						
						$('.introjs-nextbutton').click();
						$('#win_xlsx_import').dialog('close');
					},500)
					
					setTimeout(function(){
						$('.introjs-skipbutton').click();
			
						$('.suiinfo').removeAttr('data-intro');
						$('.suiinfo').removeAttr('data-step');
			
					},1500)
				";
				$data_out['conf']['onUploadProgress']="
					var per=parseInt(file.percent/3)
					fun_load_back_task('btask_{$op_id}','【{$title}导入文件】上传中...',per)
				";
				$data_out['conf']['onCancel']="
				";
				$data_out['conf']['onComplete']="
					fun_load_back_task('btask_{$op_id}','【{$title}导入文件】读取中...',50);
					
					$('#p_main').append('<div id=\"btask_{$op_id}\"></div>');
					
					$('#btask_{$op_id}').panel({   
						fit:true,
						href:'{$url_import}/id/{$op_id}',
						method:'POST',
						queryParams:{
						}
					});
					
					stream{$op_id}.destroy();
					
					$('#up_{$op_id}').panel('destroy');
					$('#up_{$op_id}').remove();
				";
				$data_out['conf']['onQueueComplete']="
				
				";
				break;
			//文件上传
			case 'upload':
				$div=$this->input->post('div');
				
				$data_out['conf']['dragAndDropArea']=$div;
				
				$data_out['conf']['autoUploading']='false';
				$data_out['conf']['multipleFiles']='true';
				$data_out['conf']['maxSize']=100*1024*1024;
				$data_out['conf']['simLimit']=10;
				$data_out['conf']['extFilters']='';
				$data_out['conf']['onSelect']="
					
				";
				
				$data_out['conf']['onExtNameMismatch']="";
				$data_out['conf']['onAddTask']="
					var str = '<div id=\"bar_'+file.id+'\" style=\"width:100%\"><div class=\"bar_name\" style=\"font-size:12px;\"></div><div class=\"sui-progress progress-striped active\"><div style=\"width:0%;\" class=\"bar\"></div></div></div>'
					$('#{$div}').append(str);
					
					$('#bar_'+file.id+' .bar_name').html('<a style=\"color:#000\" href=\"javascript:void(0)\" onClick=\"cancel_file{$op_id}(\\'' + file.id + '\\');\">【取消】</a>'+file.name+'-'+$.filesize(file.size));
				";
				$data_out['conf']['onUploadProgress']="
					$('#bar_'+file.id+' .bar').width(file.percent+'%');
				";
				$data_out['conf']['onCancel']="
					$('#bar_'+file.id).remove();
				";
				$data_out['conf']['onComplete']="
					$('#bar_'+file.id+' .bar_name').append(' -上传完成!');
					setTimeout(function(){ $('#bar_'+file.id+'').remove() },2000);
					
				";
				$data_out['conf']['onQueueComplete']="
				
				";
				break;
			//版本上传
			case 'verson':
				$div=$this->input->post('div');
				
				$data_out['conf']['dragAndDropArea']=$div;
				
				$data_out['conf']['autoUploading']='false';
				$data_out['conf']['multipleFiles']='true';
				$data_out['conf']['maxSize']=100*1024*1024;
				$data_out['conf']['simLimit']=1;
				$data_out['conf']['extFilters']='';
				$data_out['conf']['onSelect']="
					
				";
				$data_out['conf']['onExtNameMismatch']="";
				$data_out['conf']['onAddTask']="
					var str = '<div id=\"bar_'+file.id+'\" style=\"width:100%\"><div class=\"bar_name\" style=\"font-size:12px;\"></div><div class=\"sui-progress progress-striped active\"><div style=\"width:0%;\" class=\"bar\"></div></div></div>'
					$('#{$div}').append(str);
					
					$('#bar_'+file.id+' .bar_name').html('<a style=\"color:#000\" href=\"javascript:void(0)\" onClick=\"cancel_file{$op_id}(\\'' + file.id + '\\');\">【取消】</a>'+file.name+'-'+$.filesize(file.size));
				";
				$data_out['conf']['onUploadProgress']="
					$('#bar_'+file.id+' .bar').width(file.percent+'%');
				";
				$data_out['conf']['onCancel']="
					$('#bar_'+file.id).remove();
				";
				$data_out['conf']['onComplete']="
					$('#bar_'+file.id+' .bar_name').append(' -上传完成!');
					setTimeout(function(){ $('#bar_'+file.id+'').remove() },2000);
				";
				$data_out['conf']['onQueueComplete']="
				
				";
				break;
		}
		$data_out['url']=current(explode('.html', current_url()));
		
		/************载入视图 *****************/
		$arr_view[]='base/fun/win_upload';
		$arr_view[]='base/fun/win_upload_js';
		 
		$this->m_view->load_view($arr_view,$data_out);
	}
	
	/**
	 * 图片截取
	 */
	public function load_win_photoclip()
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
		
		/************模板赋值*****************/
		$data_out['time']=time();
		
		$data_out['img_w']=$this->input->post('img_w');
		$data_out['img_h']=$this->input->post('img_h');
		$data_out['size']=$this->input->post('size');
		/************载入视图 *****************/
		 
		$arr_view[]='base/fun/win_photoclip';
		$arr_view[]='base/fun/win_photoclip_js';
		 
		$this->m_view->load_view($arr_view,$data_out);
	}
	
	/**
	 * 
	 * 获取手机信息
	 */
	public function get_info_of_tele_info()
	{
		$this->load->model('base/m_web_info');
		
		//手机
		$tele=$this->input->post('code');
		
		$info=$this->m_web_info->get_tele_info($tele);
		
		echo $info;
	}
	
	/**
	 * 
	 * 获取全国区域
	 */
	public function get_json_china_area()
	{
		$this->load->model('base/m_web_info');
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		
		$p_id=element('p_id', $data_get);
		if(strstr($p_id, ','))
		{
			exit;
		}
		
		$json=$this->m_web_info->get_china_area($p_id);
		
		echo $json;
	}
	
	/**
	 * 
	 * 获取全国区域
	 */
	public function show_img()
	{
		$this->load->model('base/m_img');
		
		$data_get= trim_array($this->uri->uri_to_assoc(4));
		
		if( empty( element('id', $data_get) ) || empty( element('date', $data_get) ))
		exit;
		
		$path=$this->config->item('base_img_path').$data_get['date'].'/'.$data_get['id'];
		
		if(file_exists($path))
    	$data_photo=file_get_contents($path);
    	else
    	$data_photo = file_get_contents($this->config->item('base_img_path').'img_err.png');
		
		// 清除原输出缓存，确保图片显示正常
		ob_clean();
		header("Content-type:image/png");
		header("Cache-control: cache, must-revalidate"); // cache产生时间不一致，用了cache-control就可以直接打开文件了
		echo $data_photo;
	}

}
