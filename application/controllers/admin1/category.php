   <?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Category extends MY_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('categorys_model');
			
		}
		//查看栏目
		public function index(){
			$this->load->model('categorys_model');
			$data['category']=$this->categorys_model->check();
			//p($data);die;
			$this->load->view('admin1/check_cate.html',$data);
		}
		//添加栏目
		public function add_cate()
		{
			$this->load->helper('form');
			$this->load->view('admin1/add_cate.html');
		}
		//添加动作
		public function add()
		{
			//载入表单验证
			$this->load->library('form_validation');
			//设置规则
			$this->form_validation->set_rules('cname','栏目名称','required|max_length[20]');
			$status=$this->form_validation->run();
			if($status){
				//数据库操作
				$data=array(
				'cname' =>$this->input->post('cname')
				);
				$this->load->model('categorys_model');
				$this->categorys_model->add($data);
				success('admin1/category/index','添加成功');
			}else{
				$this->load->helper('form');
				$this->load->view('admin1/add_cate.html');
			}
		}
		//编辑栏目
		public function edit_cate()
		{
			$cid=$this->uri->segment(4);//片段
			
			$this->load->model('categorys_model');
			$data['category']=$this->categorys_model->check_cate($cid);
			//p($data);die;
			$this->load->helper('form');
			$this->load->view('admin1/edit_cate.html',$data);
		}
		//编辑动作
		public function edit()
		{
			//载入表单验证
			$this->load->library('form_validation');
			//设置规则
			$this->form_validation->set_rules('cname','栏目名称','required|max_length[20]');
			$status=$this->form_validation->run();
			if($status)
			{
				//数据库操作
				$this->load->model('categorys_model');
				$cid=$this->input->post('cid');
				$cname=$this->input->post('cname');
				$data=array(
					'cname'=>$cname
				);
				$data['category']=$this->categorys_model->update_cate($cid,$data);
				success('admin1/category/index','修改成功');
			}else{
				$this->load->helper('form');
				$this->load->view('admin1/add_cate.html');
			}
		}
		//删除栏目
		public function delete_cate()
		{
			$cid=$this->uri->segment(4);
			
			$this->load->model('categorys_model');
			$data['category']=$this->categorys_model->delete_cate($cid);	
			success('admin1/category/index','删除成功');
		}
		
	}
?>