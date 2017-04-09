<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Head extends MY_Controller{
		//后台管理系统
		public function index()
		{
			
			$this->load->view('admin1/index.html');
			
		}
		public function change()
		{
			$this->load->view('admin1/change_password.html');
			
		}
		/**
		*修改动作
		*/
		public function change_password()
		{
			$this->load->model('admins_model');
			
			$username=$this->session->userdata('username');
			$userdata=$this->admins_model->check($username);
			//p($userdata);die;
			$password=$this->input->post('password');
			
			if(md5($password)!=$userdata[0]['password'])error('原始密码错误');
			
			$passwordf=$this->input->post('passwordf');
			$passwords=$this->input->post('passwords');
			
			if($passwordf != $passwords) error('两次密码不相同');
			
			
			$password=$this->input->post('passwordf');
			$uid=$this->session->userdata('uid');
			
			$data=array(
				'password'=>md5($password)
			);
			$this->admins_model->change($uid,$data);
			success('admin1/head/change','修改成功');
		}
		
	}
?>