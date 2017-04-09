<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Category extends CI_Controller
	{
		/**
		* 构造函数
		*/
		/*public function __construct()
		{
			parent::__construct();
			$this->load->model('category_model');
		}*/
		//查看栏目
		public function index()
		{
			$this->load->model('category_model');
			$data['category']=$this->category_model->check();
			$this->load->view('admin/cate.html',$data);
		}
		//添加栏目
		public function add_cate()
		{
			//激活调试模式
			//$this->output->enable_profiler(TRUE);
			$this->load->helper('form');
			$this->load->view('admin/add_cate.html');
		}
		//添加动作
		public function add()
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('cname','栏目名称','required|max_length[20]');
			$status=$this->form_validation->run('cate');
			if($status)
			{
				//echo '数据库操作';
				$data=array(
				'cname' =>$this->input->post('cname')
				);
				$this->load->model('category_model');
				$this->category_model->add($data);
				success('admin/category/index','添加成功');
			}else{
				$this->load->helper('form');
				$this->load->view('admin/add_cate.html');
			}
		}
		//编辑
		public function edit_cate()
		{
			$cid=$this->uri->segment(4);
			
			$this->load->model('category_model');
			$data['category']=$this->category_model->check_cate($cid);
			
			$this->load->helper('form');
			$this->load->view('admin/edit_cate.html',$data);
		}
		//编辑动作
		public function edit()
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('cname','栏目名称','required|max_length[20]');
			$status=$this->form_validation->run();
			if($status)
			{
				//echo '数据库操作';
				$this->load->model('category_model');
				$cid=$this->input->post('cid');
				$cname=$this->input->post('cname');
				$data=array(
					'cname'=>$cname
				);
				$data['category']=$this->category_model->update_cate($cid,$data);
				success('admin/category/index','修改成功');
			}else{
				$this->load->helper('form');
				$this->load->view('admin/edit_cate.html');
			}
		}
		/**
		* 删除栏目
		*/
		public function delete_cate()
		{
			$cid=$this->uri->segment(4);
			
			$this->load->model('category_model');
			$data['category']=$this->category_model->delete_cate($cid);	
			success('admin1/category/index','删除成功');
		}
	}






?>