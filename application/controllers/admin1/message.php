<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Message extends CI_Controller 
	{
		public function check_message()
		{
			//载入分页
		$this->load->library('pagination');
		$perPage=10;//偏移量
		//配置项设置
		$config['base_url']=site_url('admin1/message/check_message');
		$config['total_rows']=$this->db->count_all_results('message');
		$config['per_page']=$perPage;
		$config['uri_segment']=4;//手动设置片段
		$config['first_link']='第一页';
		$config['prev_link']='上一页';
		$config['next_link']='下一页';
		$config['last_link']='最后一页';
	
		
		$this->pagination->initialize($config);
		
		$data['links']=$this->pagination->create_links();
		//p($data);die;
		$offset=$this->uri->segment(4);
		$this->db->limit($perPage,$offset);
		
		$this->load->model('message_model');
		$data['message']=$this->message_model->checks_message();
		$this->load->view('admin1/check_message.html',$data);
		}
		
		//删除留言
		public function delete_message()
		{
			$sid=$this->uri->segment(4);
			
			$this->load->model('message_model');
			$data['message']=$this->message_model->delete_message($aid);	
			success('index1/message/check_message','删除成功');
			
		}
	}
	