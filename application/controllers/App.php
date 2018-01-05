<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {

	/**
	 * 接口
	 */
	public function index()
	{
		/************变量初始化****************/
		$data_out=array();//输出数组
		
		/************模板赋值***********/
		
		$data_out['url']='base/login/index.html';
		
		//获取session
		$a_login_id=$this->sess->userdata('a_login_id') ;
		if( ! empty($a_login_id) )
		{
			if($this->uri->segment(3, 0) === 'uri')
			{
				$data_out['url']=fun_urldecode($this->uri->segment(4, 0));
				$data_out['url'].='.html';
			}
			else 
			{
				$data_out['url']='base/main/index.html';
			}
		}
		/************载入视图 ****************/
		$this->load->view('app',$data_out);
	}
	
	/**
	 * 获取验证码
	 * 
	 */
	public function yzm()
	{
		$this->load->helper('captcha');//验证码
		
		$arr_yzm = array(
		    'img_path'  => './inc/img/yzm/',
		    'img_url'   => base_url().'./yzm/',
		    'font_path' => './inc/img/yzm/font/truetype.ttf',
		    'img_width' => 90,
		    'img_height'    => 38,
		    'expiration'    => 2,
		    'word_length'   => 4,
		    'font_size' => 16,
		    'pool'      => '0123456789',
		
		    // White background and border, black text and red grid
		    'colors'    => array(
		        'background' => array(255, 255, 255),
		        'border' => array(255, 255, 255),
		        'text' => array(0, 0, 0),
		        'grid' => array(100,149,237)
		    )
		);
		
		$yzm = create_captcha($arr_yzm);
		$yzm['time']=time();
		
		$sess_yzm=$this->sess->userdata('sess_yzm') ;
		
		if( empty($sess_yzm) )
		$sess_yzm = array();
		
		$sess_yzm[$yzm['time']] = $yzm['word'];
		
		if(count($sess_yzm) > 10 )
		{
			$arr_key=array_keys($sess_yzm);
			
			$i=0;
			while (count($sess_yzm) > 10)
			{
				unset($sess_yzm[$arr_key[$i]]);
				$i++;
			}
		}
		
		$this->sess->set_userdata('sess_yzm', $sess_yzm);
		
		echo json_encode($yzm);
	}
	
	/**
	 * 获取头像
	 * 
	 */
	public function get_photo()
	{
		$this->load->model('base/m_img');
		
		$c_img=get_cookie('img_id');
		if( ! empty($c_img) )
		$c_img= fun_urldecode($c_img);
		
		if( empty($c_img) )
		$c_img=$this->sess->userdata('c_img') ;
		
		$data_photo=$this->m_img->get_person_photo($c_img);
		
		// 清除原输出缓存，确保图片显示正常
		ob_clean();
		header("Content-type:image/png");
		header("Cache-control: cache, must-revalidate"); // cache产生时间不一致，用了cache-control就可以直接打开文件了
		echo $data_photo;
	}
	
	/**
	 * 后台任务
	 * 
	 */
	public function run_back()
	{
		$url=str_replace('app/run_back', '', uri_string());
		redirect($url);
	}
	
	/**
	 * 404
	 * 
	 */
	public function show_404()
	{
		//获取session
		$a_login_id=$this->sess->userdata('a_login_id') ;
		
		if( ! empty($a_login_id) )
		{
			redirect('base/main/show_404');
		}
		
		redirect('base/login/index.html');
	}
}
