<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Login extends CI_Controller
	{
		/**
		* 登录默认方法
		*@return [type]  [description]
		*/
		public function index()
		{
			//载入验证码辅助函数
			$this->load->helper('captcha');
			$speed='sdsasafsfsdfddf451254512313213';
			$word='';
			for($i=0;$i<4;$i++){
				$word.=$speed[mt_rand(0,strlen($speed)-1)];
			}
			
			//配置
			$vals=array(
				'word'=>$word,
				'img_path' => './captcha/',
				'img_url' => base_url() . '/captcha/',
				'img_width'=>80,
				'img_height'=>25 ,
				'expiration'=>30//验证码保存时间
			
			);
			//创建验证码
			$cap=create_captcha($vals);
			if(!isset($_SESSION)){
				session_start();
			}
			$_SESSION['code']=$cap['word'];
			
			$data['captcha']=$cap['image'];
			//var_dump($_SESSION['code']);
			//p($cap);die;
			//var_dump($cap['word']);
			$this->load->view('admin1/login.html',$data);
		}
		/**
		*登录
		**/
		public function login_in()
		{
			$code=$this->input->post('captcha');
			if(!isset($_SESSION)){
				session_start();
			}
			if($code!=$_SESSION['code']) error('验证码错误');
			//var_dump($code);
			//var_dump($_SESSION['code']);exit();
			$username=$this->input->post('username');
			$this->load->model('admins_model');
			$userdata=$this->admins_model->check($username);
			//p($userdata);
			$password=$this->input->post('password');
			if(!$userdata||$userdata[0]['password']!=md5($password)) error ('用户名或密码不正确');
			$sessiondata=array(
				'username' =>$username,
				'uid' =>$userdata[0]['uid'],
				'logintime' =>time()
			);
			$this->session->set_userdata($sessiondata);
			//$data=$this->session->userdata('username');
			//p($data);
			success('admin1/head/index','登录成功');
			
		}
		/**
		*退出登录
		**/
		public function login_out()
		{
			$this->session->sess_destroy();
			success('admin1/login/index','退出成功');
			
		}
	}