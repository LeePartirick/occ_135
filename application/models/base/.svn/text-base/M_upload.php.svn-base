<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 文件上传类
 */
class M_upload extends CI_Model {
	
	private $_tokenPath ;            //令牌保存目录
	private $_filePath ;              //上传文件保存目录
	
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
    	if( defined('LOAD_M_UPLOAD') ) return;
    	
    	define('LOAD_M_UPLOAD', 1);
    	
    	//临时上传路径
    	define('PATH_UPLOAD', APPPATH.'upload/');
    	
    	$this->_tokenPath= APPPATH.'tmp/' ;
     	$this->_filePath= APPPATH.'upload/' ;
    }
    
	/**
	 * 获取令牌
	 */
	public function tk(){
	
		$file['name'] = $_GET['name'];                  //上传文件名称
		$file['size'] = $_GET['size'];                  //上传文件总大小
		$file['token'] = md5(json_encode($file['name'] . $file['size'].time()));
		//判断是否存在该令牌信息
		if(! file_exists($this->_tokenPath . $file['token'] . '.token')){
		
			$file['up_size'] = 0;                       //已上传文件大小
			$pathInfo = pathinfo($file['name']);
			$path = $this->_filePath ;
			//生成文件保存子目录
			if(! is_dir($path)){
				mkdir($path, 0700);
			}
			//上传文件保存目录
			$file['filePath'] = $path.$file['token'].'.'.$pathInfo['extension'];
			$file['modified'] = $_GET['modified'];      //上传文件的修改日期
			//保存令牌信息
			$this->setTokenInfo($file['token'], $file);
		}
		$result['token'] = $file['token'];
		$result['success'] = true;
		//$result['server'] = '';

		echo json_encode($result);
		exit;
	}
	
	
	/**
	 * 上传接口
	 */
	public function up(){
		if('html5' == $_GET['client']){
			$this->html5Upload();
		}
		elseif('form' == $_GET['client']){
			$this->flashUpload();
		}
		else {
			//错误
			exit;
		}

	}
	
	/**
	 * HTML5上传
	 */
	protected function html5Upload(){
		$token = $_GET['token'];
		$fileInfo = $this->getTokenInfo($token);
		
		if($fileInfo['size'] > $fileInfo['up_size']){
			//取得上传内容
			$data = file_get_contents('php://input', 'r');
			if(! empty($data)){
				//上传内容写入目标文件
				$fp = fopen($fileInfo['filePath'], 'a');
				flock($fp, LOCK_EX);
				fwrite($fp, $data);
				flock($fp, LOCK_UN);
				fclose($fp);
				//累积增加已上传文件大小
				$fileInfo['up_size'] += strlen($data);
				if($fileInfo['size'] > $fileInfo['up_size']){
					$this->setTokenInfo($token, $fileInfo);
				}
				else {
					//上传完成后删除令牌信息
					@unlink($this->_tokenPath . $token . '.token');
					
					$data_get= trim_array($this->uri->uri_to_assoc(4));
					
					$op_id=element('op_id', $data_get);
					$type=element('type', $data_get);
					
					switch ($type)
					{
						//xlsx导入
						case 'import':
							rename($fileInfo['filePath'], str_replace('\\', '/', APPPATH).'upload/'.$op_id.'.xlsx');
							break;
						//file 文件上传
						case 'upload':
							
							$data_save=array();
							$data_save['content']['f_v_id']=get_guid();
							$data_save['content']['f_size']=$fileInfo['size'];
							$data_save['content']['f_name']=$fileInfo['name'];
							
							$param = $this->input->get();
							
							$data_save['content']['f_note'] = element('f_note', $param);
							$data_save['content']['f_type'] = element('f_type', $param);
							$data_save['content']['f_secrecy'] = element('f_secrecy', $param);
							$data_save['content']['filePath']=$fileInfo['filePath'];
							
							$data_save['content']['op_id'] = element('op_id', $param);
							$data_save['content']['op_table'] = element('op_table', $param);
							$data_save['content']['op_field'] = element('op_field', $param);
							
							$data_save['content']['fun_m'] = element('fun_m', $param);
							$data_save['content']['fun_up'] = element('fun_up', $param);
							$data_save['content']['fun_ck'] = element('fun_ck', $param);
							$data_save['content']['proc'] = element('proc', $param);
							
							$result['json'] = $this->m_file->add_file_link($data_save['content']);
							
							break;
						//file 文件版本上传
						case 'verson':
							
							$data_save=array();
							$data_save['content']['f_v_id']=get_guid();
							$data_save['content']['f_size']=$fileInfo['size'];
//							$data_save['content']['f_name']=$fileInfo['name'];
							
							$param = $this->input->get();
							
							$data_save['content']['f_v_note'] = element('f_v_note', $param);
							$data_save['content']['filePath']=$fileInfo['filePath'];
							
							$data_save['content']['f_id'] = element('f_id', $param);
							
							$result['json'] = $this->m_file->add_file_verson($data_save['content']);
							
							break;
						default:
							@unlink($fileInfo['filePath']);
							break;
					}
				}
			}
		}
		$result['start'] = $fileInfo['up_size'];
		$result['success'] = true;
		
		echo json_encode($result);
		exit;
	}
	
	/**
	 * FLASH上传
	 */
	public function flashUpload(){
	
		//$result['start'] = $fileInfo['up_size'];
		$result['success'] = false;

		echo json_encode($result);
		exit;
	}
	
	/**
	 * 生成文件内容
	 */
	protected function setTokenInfo($token, $data){
		
		file_put_contents($this->_tokenPath . $token . '.token', json_encode($data));
	}

	/**
	 * 获取文件内容
	 */
	protected function getTokenInfo($token){
		$file = $this->_tokenPath . $token . '.token';
		if(file_exists($file)){
			return json_decode(file_get_contents($file), true);
		}
		return false;
	}
    
    
}